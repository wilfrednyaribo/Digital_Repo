<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{
    /*
    |------------------------------------------------------------------
    | READER PORTAL — Main landing page (/)
    |------------------------------------------------------------------
    | Shows all books in the reading-shelf layout.
    | No auth required. No download buttons.
    */
    public function readerPortal(Request $request)
    {
        $documents = Document::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('author_creator', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
                });
            })
            ->when($request->category, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->type, function ($query, $type) {
                $query->where('document_type', $type);
            })
            ->when($request->sort === 'oldest', function ($query) {
                $query->orderBy('created_at', 'asc');
            })
            ->when($request->sort === 'title', function ($query) {
                $query->orderBy('title', 'asc');
            })
            ->when($request->sort === 'popular', function ($query) {
                $query->orderByDesc('views');
            })
            ->when(!$request->sort || $request->sort === 'newest', function ($query) {
                $query->orderByDesc('created_at');
            })
            ->paginate(24);

        $categories = Category::orderBy('name')->get();

        return view('public.reader-portal', compact('documents', 'categories'));
    }

    /*
    |------------------------------------------------------------------
    | REPORTS — Publications & Reports browsing (/reports)
    |------------------------------------------------------------------
    | Shows only publication/report type documents.
    | No auth required.
    */
    public function reports(Request $request)
    {
        $documents = Document::with('category')
            ->where('document_type', 'file')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('author_creator', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
                });
            })
            ->when($request->category, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->sort === 'oldest', function ($query) {
                $query->orderBy('created_at', 'asc');
            })
            ->when($request->sort === 'title', function ($query) {
                $query->orderBy('title', 'asc');
            })
            ->when($request->sort === 'popular', function ($query) {
                $query->orderByDesc('views');
            })
            ->when(!$request->sort || $request->sort === 'newest', function ($query) {
                $query->orderByDesc('created_at');
            })
            ->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('public.reports', compact('documents', 'categories'));
    }

    /*
    |------------------------------------------------------------------
    | READ INLINE — Extract text for in-browser reading
    |------------------------------------------------------------------
    | Called via AJAX from the reader overlay.
    | Returns JSON with extracted text content.
    */
    public function readInline(Document $document)
    {
        // Increment view count
        $document->increment('views');

        $content = null;
        $description = $document->description;
        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            return response()->json([
                'content'    => null,
                'description' => $description,
                'pages'      => null,
                'error'      => 'File not found on disk.',
            ], 404);
        }

        $ext = strtolower($document->file_type);

        // Plain text files — read directly
        if ($ext === 'txt') {
            $raw = file_get_contents($filePath);
            $content = $this->formatPlainText($raw);
        }

        // PDF files — extract text via Smalot\PdfParser
        elseif ($ext === 'pdf' && class_exists('\Smalot\PdfParser\Parser')) {
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($filePath);
                $text = $pdf->getText();

                if (trim($text)) {
                    $content = $this->formatPlainText($text);
                }
            } catch (\Exception $e) {
                // Silently fail — reader will show fallback message
                $content = null;
            }
        }

        // DOCX files — extract text via PhpOffice\PhpWord
        elseif (in_array($ext, ['doc', 'docx']) && class_exists('\PhpOffice\PhpWord\IOFactory')) {
            try {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
                $paragraphs = [];

                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text = $element->getText();
                            if (trim($text)) {
                                $paragraphs[] = trim($text);
                            }
                        }
                    }
                }

                if (count($paragraphs) > 0) {
                    $content = $this->formatPlainText(implode("\n\n", $paragraphs));
                }
            } catch (\Exception $e) {
                $content = null;
            }
        }

        return response()->json([
            'content'    => $content,
            'description' => $description,
            'pages'      => $content ? 'Scrollable' : null,
        ]);
    }

    /*
    |------------------------------------------------------------------
    | FORMAT PLAIN TEXT — Convert raw text to HTML paragraphs
    |------------------------------------------------------------------
    */
    private function formatPlainText(string $text): string
    {
        // Normalize line endings
        $text = str_replace(["\r\n", "\r"], "\n", $text);

        // Split into paragraphs (double newline = paragraph break)
        $blocks = preg_split('/\n\s*\n/', trim($text));

        $html = '';
        foreach ($blocks as $block) {
            $block = trim($block);
            if ($block === '') {
                continue;
            }

            // Detect if block looks like a heading (short, possibly all caps, no period at end)
            $isHeading = (
                strlen($block) < 80 &&
                preg_match('/^[A-Z]/', $block) &&
                !preg_match('/[.!?]$/', $block) &&
                substr_count($block, ' ') < 8
            );

            if ($isHeading) {
                $html .= '<h2>' . e($block) . "</h2>\n";
            } else {
                // Convert single newlines within a block to spaces (re-flow text)
                $flowed = preg_replace('/\n/', ' ', $block);
                $html .= '<p>' . e($flowed) . "</p>\n";
            }
        }

        return $html;
    }
}