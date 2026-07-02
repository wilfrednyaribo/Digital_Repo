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
            ->paginate(100);

        $categories = Category::orderBy('name')->get();

        return view('public.reader-portal', compact('documents', 'categories'));
    }

    /*
    |------------------------------------------------------------------
    | SEARCH — AJAX live search across ALL documents
    |------------------------------------------------------------------
    | Called by the shelf search input via JS debounce.
    | Searches the entire database, not just the current page.
    | Returns rendered card HTML + count as JSON.
    */
    public function searchPortal(Request $request)
    {
        $q = trim($request->input('q', ''));

        // Don't search for empty or too-short queries
        if (strlen($q) < 2) {
            return response()->json([
                'html'  => '',
                'count' => 0,
            ]);
        }

        $documents = Document::with('category')
            ->where(function ($query) use ($q) {
                $query->where('title', 'LIKE', "%{$q}%")
                      ->orWhere('author_creator', 'LIKE', "%{$q}%")
                      ->orWhere('description', 'LIKE', "%{$q}%");
            })
            ->orderByDesc('created_at')
            ->limit(200)
            ->get();

        // Render just the card HTML using the shared partial
        $html = view('public.partials.book-cards', compact('documents'))->render();

        return response()->json([
            'html'  => $html,
            'count' => $documents->count(),
        ]);
    }

    /*
    |------------------------------------------------------------------
    | REPORTS — Publications & Reports browsing (/reports)
    |------------------------------------------------------------------
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
            ->paginate(100);

        $categories = Category::orderBy('name')->get();

        return view('public.reports', compact('documents', 'categories'));
    }

    /*
    |------------------------------------------------------------------
    | READ INLINE — Extract text for in-browser reading
    |------------------------------------------------------------------
    */
    public function readInline(Document $document)
    {
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

        if ($ext === 'txt') {
            $raw = file_get_contents($filePath);
            $content = $this->formatPlainText($raw);
        }
        elseif ($ext === 'pdf' && class_exists('\Smalot\PdfParser\Parser')) {
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($filePath);
                $text = $pdf->getText();
                if (trim($text)) {
                    $content = $this->formatPlainText($text);
                }
            } catch (\Exception $e) {
                $content = null;
            }
        }
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
    | FORMAT PLAIN TEXT
    |------------------------------------------------------------------
    */
    private function formatPlainText(string $text): string
    {
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $blocks = preg_split('/\n\s*\n/', trim($text));

        $html = '';
        foreach ($blocks as $block) {
            $block = trim($block);
            if ($block === '') continue;

            $isHeading = (
                strlen($block) < 80 &&
                preg_match('/^[A-Z]/', $block) &&
                !preg_match('/[.!?]$/', $block) &&
                substr_count($block, ' ') < 8
            );

            if ($isHeading) {
                $html .= '<h2>' . e($block) . "</h2>\n";
            } else {
                $flowed = preg_replace('/\n/', ' ', $block);
                $html .= '<p>' . e($flowed) . "</p>\n";
            }
        }

        return $html;
    }
}