<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateDocumentRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'download']);

        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        })->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Document::with('category', 'user');

        if ($request->filled('search')) {
            $search = str_replace(['%', '_'], ['\%', '\_'], $request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author_creator', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if (!Auth::check() || !Auth::user()->isAdmin()) {
            $query->where('is_public', true);
        }

        $documents = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        $publicCount = Document::where('is_public', true)->count();
        $privateCount = Document::where('is_public', false)->count();
        $recentCount = Document::where('created_at', '>=', now()->subDays(7))->count();
        $totalSize = Document::sum('file_size');

        return view('documents.index', compact(
            'documents',
            'categories',
            'publicCount',
            'privateCount',
            'recentCount',
            'totalSize'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        return view('documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'author_creator'  => 'nullable|string|max:255',
            'category_id'     => 'nullable|exists:categories,id',
            'description'     => 'nullable|string',
            'document_type'   => 'nullable|string|in:book,file,record,thesis',
            'file'            => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,txt|max:51200',
            'cover_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'cover_base64'    => 'nullable|string',
            'rating'          => 'nullable|numeric|min:0|max:5',
            'is_public'       => 'boolean',
        ]);

        $file = $request->file('file');
        $filePath = $file->storeAs(
            'documents',
            time() . '_' . $file->getClientOriginalName(),
            'public'
        );

        $document = Document::create([
            'user_id'         => Auth::id(),
            'title'           => $request->title,
            'author_creator'  => $request->author_creator,
            'category_id'     => $request->category_id,
            'description'     => $request->description,
            'document_type'   => $request->document_type ?? 'record',
            'file_path'       => $filePath,
            'file_type'       => strtolower($file->getClientOriginalExtension()),
            'file_size'       => $file->getSize(),
            'cover_image'     => null,
            'rating'          => $request->input('rating', 0),
            'is_public'       => $request->boolean('is_public'),
            'published_at'    => now(),
        ]);

        $coverPath = $this->handleCoverGeneration($document, $request);

        if (!empty($coverPath)) {
            $document->update(['cover_image' => $coverPath]);
        }

        $typeLabel = ucfirst($request->document_type ?? 'record');

        return redirect()
            ->route('documents.index')
            ->with('success', "{$typeLabel} uploaded successfully.");
    }

    private function handleCoverGeneration(Document $document, Request $request): ?string
    {
        if ($request->hasFile('cover_image')) {
            $coverFile = $request->file('cover_image');
            return $coverFile->storeAs(
                'covers',
                'cover_' . $document->id . '_' . time() . '.' . $coverFile->getClientOriginalExtension(),
                'public'
            );
        }

        if ($request->filled('cover_base64')) {
            return $this->storeBase64Image($request->cover_base64, $document->id);
        }

        return $this->generateCover($document);
    }

    private function generateCover(Document $document): ?string
    {
        try {
            $fullPath = storage_path('app/public/' . $document->file_path);

            if (!file_exists($fullPath)) {
                Log::warning('File does not exist for cover generation: ' . $fullPath);
                return $this->generateTextCover($document);
            }

            if ($document->file_type === 'pdf') {
                $coverPath = $this->extractPdfCover($fullPath, $document->id);
                if (!empty($coverPath)) {
                    return $coverPath;
                }
            }

            if (in_array($document->file_type, ['jpg', 'jpeg', 'png'])) {
                return $this->createImageCover($fullPath, $document->id);
            }

            return $this->generateTextCover($document);

        } catch (\Exception $e) {
            Log::error('Cover generation failed: ' . $e->getMessage());
            return $this->generateTextCover($document);
        }
    }

    private function extractPdfCover(string $pdfPath, int $documentId): ?string
    {
        // -----------------------------------------------------------------
        // METHOD 1: Try Imagick
        // -----------------------------------------------------------------
        if (extension_loaded('imagick')) {
            try {
                $imagick = new \Imagick();
                $imagick->setResolution(150, 150);
                $imagick->readImage($pdfPath . '[0]');
                $imagick->setImageFormat('jpeg');
                $imagick->setImageCompressionQuality(85);
                $imagick->thumbnailImage(400, 560, true, true);

                $imageData = $imagick->getImageBlob();
                $filename = 'cover_' . $documentId . '_' . time() . '.jpg';
                $storagePath = 'covers/' . $filename;

                Storage::disk('public')->put($storagePath, $imageData);
                $imagick->clear();
                $imagick->destroy();

                Log::info('PDF cover extracted successfully using Imagick.');
                return $storagePath;
            } catch (\ImagickException $e) {
                if (strpos($e->getMessage(), 'not authorized') !== false) {
                    Log::error('COVER FIX: Imagick blocked PDF reading due to security policy. Open your ImageMagick "policy.xml" file and change: <policy domain="coder" rights="none" pattern="PDF" /> to <policy domain="coder" rights="read|write" pattern="PDF" />');
                } else {
                    Log::warning('Imagick failed to read PDF: ' . $e->getMessage());
                }
            } catch (\Exception $e) {
                Log::warning('Imagick PDF extraction error: ' . $e->getMessage());
            }
        } else {
            Log::warning('Imagick extension is NOT loaded in PHP.');
        }

        // -----------------------------------------------------------------
        // METHOD 2: Try Ghostscript (Best option for Windows/XAMPP/Laragon)
        // -----------------------------------------------------------------
        if (function_exists('exec')) {
            $gsCommand = 'gs';
            
            // Auto-detect common Ghostscript paths on Windows
            if (PHP_OS_FAMILY === 'Windows') {
                $possiblePaths = [
                    'C:\\Program Files\\gs\\gs10.03.1\\bin\\gswin64c.exe',
                    'C:\\Program Files\\gs\\gs10.02.1\\bin\\gswin64c.exe',
                    'C:\\Program Files\\gs\\gs10.01.2\\bin\\gswin64c.exe',
                    'C:\\Program Files\\gs\\gs9.56.1\\bin\\gswin64c.exe',
                ];
                foreach ($possiblePaths as $path) {
                    if (file_exists($path)) {
                        $gsCommand = '"' . $path . '"';
                        break;
                    }
                }
            }

            try {
                $filename = 'cover_' . $documentId . '_' . time() . '.jpg';
                $outputPath = storage_path('app/public/covers/' . $filename);

                if (!is_dir(dirname($outputPath))) {
                    mkdir(dirname($outputPath), 0755, true);
                }

                // Properly escape paths for Windows
                $safeOutputPath = str_replace('\\', '/', $outputPath);
                $safePdfPath = str_replace('\\', '/', $pdfPath);

                $command = "{$gsCommand} -dNOPAUSE -dBATCH -sDEVICE=jpeg -dFirstPage=1 -dLastPage=1 -sOutputFile=\"{$safeOutputPath}\" -dJPEGQ=85 -r150 \"{$safePdfPath}\" 2>&1";
                
                exec($command, $output, $returnCode);

                if ($returnCode === 0 && file_exists($outputPath)) {
                    Log::info('PDF cover extracted successfully using Ghostscript.');
                    return 'covers/' . $filename;
                } else {
                    Log::warning("Ghostscript exec failed (Code {$returnCode}).");
                    if (PHP_OS_FAMILY === 'Windows') {
                        Log::error('COVER FIX: Ghostscript is NOT installed on your PC. Download it from https://ghostscript.com/releases/gsdnld.html, install it, and restart your web server (Apache/Nginx).');
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Ghostscript execution error: ' . $e->getMessage());
            }
        } else {
            Log::warning('PHP exec() function is disabled. Cannot run Ghostscript.');
        }

        // -----------------------------------------------------------------
        // FALLBACK
        // -----------------------------------------------------------------
        Log::error('FALLING BACK TO TEXT COVER: Neither Imagick nor Ghostscript could extract the PDF first page.');
        return null;
    }

    private function createImageCover(string $imagePath, int $documentId): ?string
    {
        try {
            if (extension_loaded('gd')) {
                $sourceImage = null;
                $mimeType = mime_content_type($imagePath);

                if ($mimeType === 'image/jpeg') {
                    $sourceImage = imagecreatefromjpeg($imagePath);
                } elseif ($mimeType === 'image/png') {
                    $sourceImage = imagecreatefrompng($imagePath);
                }

                if ($sourceImage) {
                    $width = imagesx($sourceImage);
                    $height = imagesy($sourceImage);
                    $targetWidth = 400;
                    $targetHeight = 560;

                    $thumbnail = imagecreatetruecolor($targetWidth, $targetHeight);
                    $white = imagecolorallocate($thumbnail, 255, 255, 255);
                    imagefill($thumbnail, 0, 0, $white);

                    $ratio = $targetWidth / $targetHeight;
                    $sourceRatio = $width / $height;

                    if ($sourceRatio > $ratio) {
                        $cropHeight = $height;
                        $cropWidth = $height * $ratio;
                        $cropX = ($width - $cropWidth) / 2;
                        $cropY = 0;
                    } else {
                        $cropWidth = $width;
                        $cropHeight = $width / $ratio;
                        $cropX = 0;
                        $cropY = ($height - $cropHeight) / 2;
                    }

                    imagecopyresampled(
                        $thumbnail, $sourceImage,
                        0, 0, (int)$cropX, (int)$cropY,
                        $targetWidth, $targetHeight,
                        (int)$cropWidth, (int)$cropHeight
                    );

                    $filename = 'cover_' . $documentId . '_' . time() . '.jpg';
                    $storagePath = 'covers/' . $filename;
                    $tempPath = tempnam(sys_get_temp_dir(), 'cover_');

                    imagejpeg($thumbnail, $tempPath, 85);
                    Storage::disk('public')->put($storagePath, file_get_contents($tempPath));

                    imagedestroy($sourceImage);
                    imagedestroy($thumbnail);
                    unlink($tempPath);

                    return $storagePath;
                }
            }

            $filename = 'cover_' . $documentId . '_' . time() . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);
            $storagePath = 'covers/' . $filename;
            Storage::disk('public')->put($storagePath, file_get_contents($imagePath));

            return $storagePath;
        } catch (\Exception $e) {
            Log::error('Image cover creation failed: ' . $e->getMessage());
            return null;
        }
    }

    private function generateTextCover(Document $document): ?string
    {
        try {
            if (!extension_loaded('gd')) {
                return null;
            }

            $width = 400;
            $height = 560;
            $image = imagecreatetruecolor($width, $height);

            $colorSchemes = [
                'book'   => ['bg' => [25, 42, 86], 'accent' => [52, 152, 219], 'text' => [255, 255, 255]],
                'thesis' => ['bg' => [44, 62, 80], 'accent' => [46, 204, 113], 'text' => [255, 255, 255]],
                'file'   => ['bg' => [52, 73, 94], 'accent' => [241, 196, 15], 'text' => [255, 255, 255]],
                'record' => ['bg' => [142, 68, 173], 'accent' => [231, 76, 60], 'text' => [255, 255, 255]],
            ];

            $type = $document->document_type ?? 'record';
            $scheme = $colorSchemes[$type] ?? $colorSchemes['record'];

            $bgColor = imagecolorallocate($image, $scheme['bg'][0], $scheme['bg'][1], $scheme['bg'][2]);
            imagefill($image, 0, 0, $bgColor);

            for ($i = 0; $i < $height; $i++) {
                $alpha = (int)($i / $height * 40);
                $lineColor = imagecolorallocatealpha($image, 0, 0, 0, $alpha);
                imageline($image, 0, $i, $width, $i, $lineColor);
            }

            $accentColor = imagecolorallocate($image, $scheme['accent'][0], $scheme['accent'][1], $scheme['accent'][2]);
            imagefilledrectangle($image, 0, 0, $width, 8, $accentColor);
            imagefilledrectangle($image, 0, $height - 8, $width, $height, $accentColor);
            imagefilledrectangle($image, 30, 80, 34, $height - 80, $accentColor);

            $typeLabel = strtoupper($type);
            $badgeWidth = strlen($typeLabel) * 12 + 30;
            imagefilledrectangle($image, $width - $badgeWidth - 20, 20, $width - 20, 50, $accentColor);
            $badgeTextColor = imagecolorallocate($image, 255, 255, 255);
            imagestring($image, 3, $width - $badgeWidth - 5, 28, $typeLabel, $badgeTextColor);

            $iconY = 100;
            $iconColor = imagecolorallocatealpha($image, $scheme['accent'][0], $scheme['accent'][1], $scheme['accent'][2], 80);
            imagefilledrectangle($image, $width/2 - 40, $iconY, $width/2 + 40, $iconY + 80, $iconColor);

            $foldColor = imagecolorallocatealpha($image, $scheme['bg'][0], $scheme['bg'][1], $scheme['bg'][2], 100);
            imagefilledpolygon($image, [
                $width/2 + 10, $iconY,
                $width/2 + 40, $iconY,
                $width/2 + 40, $iconY + 30,
            ], $foldColor);

            $extColor = imagecolorallocate($image, 255, 255, 255);
            $extension = strtoupper($document->file_type ?? 'FILE');
            imagestring($image, 5, $width/2 - strlen($extension)*5, $iconY + 30, $extension, $extColor);

            $textColor = imagecolorallocate($image, $scheme['text'][0], $scheme['text'][1], $scheme['text'][2]);
            $title = $this->wrapText($image, 5, $document->title, $width - 80);
            $titleLines = explode("\n", $title);
            $titleY = 220;

            foreach ($titleLines as $line) {
                if ($titleY < 380) {
                    imagestring($image, 5, 50, $titleY, $line, $textColor);
                    $titleY += 25;
                }
            }

            $lineY = $titleY + 20;
            if ($lineY < 420) {
                $lineColor = imagecolorallocatealpha($image, $scheme['text'][0], $scheme['text'][1], $scheme['text'][2], 100);
                imageline($image, 50, $lineY, $width - 50, $lineY, $lineColor);
            }

            $authorY = $lineY + 30;
            if ($authorY < 470 && !empty($document->author_creator)) {
                $authorText = $this->wrapText($image, 3, $document->author_creator, $width - 80);
                $authorLines = explode("\n", $authorText);
                foreach ($authorLines as $line) {
                    if ($authorY < 480) {
                        $authorColor = imagecolorallocatealpha($image, $scheme['text'][0], $scheme['text'][1], $scheme['text'][2], 180);
                        imagestring($image, 3, 50, $authorY, $line, $authorColor);
                        $authorY += 20;
                    }
                }
            }

            $dateText = $document->published_at ? $document->published_at->format('M d, Y') : now()->format('M d, Y');
            $dateColor = imagecolorallocatealpha($image, $scheme['text'][0], $scheme['text'][1], $scheme['text'][2], 120);
            imagestring($image, 2, 50, $height - 40, $dateText, $dateColor);

            $filename = 'cover_' . $document->id . '_' . time() . '.jpg';
            $storagePath = 'covers/' . $filename;
            $tempPath = tempnam(sys_get_temp_dir(), 'cover_');

            imagejpeg($image, $tempPath, 90);
            Storage::disk('public')->put($storagePath, file_get_contents($tempPath));

            imagedestroy($image);
            unlink($tempPath);

            return $storagePath;

        } catch (\Exception $e) {
            Log::error('Text cover generation failed: ' . $e->getMessage());
            return null;
        }
    }

    private function wrapText($image, int $font, string $text, int $maxWidth): string
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = empty($currentLine) ? $word : $currentLine . ' ' . $word;
            $bbox = imagefontwidth($font) * strlen($testLine);

            if ($bbox > $maxWidth && !empty($currentLine)) {
                $lines[] = $currentLine;
                $currentLine = $word;
            } else {
                $currentLine = $testLine;
            }
        }

        if (!empty($currentLine)) {
            $lines[] = $currentLine;
        }

        return implode("\n", array_slice($lines, 0, 8));
    }

    private function storeBase64Image(string $base64String, int $documentId): ?string
    {
        try {
            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
                $imageData = substr($base64String, strpos($base64String, ',') + 1);
            } else {
                $imageData = $base64String;
            }

            $imageData = base64_decode($imageData);

            if ($imageData === false) {
                return null;
            }

            $filename = 'cover_' . $documentId . '_' . time() . '.jpg';
            $path = 'covers/' . $filename;

            if (!Storage::disk('public')->exists('covers')) {
                Storage::disk('public')->makeDirectory('covers');
            }

            Storage::disk('public')->put($path, $imageData);
            return $path;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function show(Document $document)
    {
        if (!$document->is_public && (!Auth::check() || !Auth::user()->isAdmin())) {
            abort(403);
        }
        return view('documents.show', compact('document'));
    }

    public function download(Document $document)
    {
        if (!$document->is_public && (!Auth::check() || !Auth::user()->isAdmin())) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download(
            $document->file_path,
            $document->title . '.' . $document->file_type
        );
    }

    public function destroy(Document $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
            Storage::disk('public')->delete($document->cover_image);
        }

        $document->delete();
        return back()->with('success', 'Document deleted successfully.');
    }

    public function manage(Request $request)
    {
        $query = Document::with('user', 'category');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author_creator', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('document_type', $request->input('type'));
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $sortField = $request->input('sort', 'created_at');
        $sortDir = $request->input('dir', 'desc');
        if (in_array($sortField, ['title', 'document_type', 'file_size', 'created_at', 'author_creator'])) {
            $query->orderBy($sortField, $sortDir === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $documents = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $typeCounts = Document::select('document_type', \DB::raw('count(*) as total'))
            ->groupBy('document_type')
            ->pluck('total', 'document_type');

        return view('documents.manage', compact('documents', 'categories', 'typeCounts'));
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $validated = $request->validated();
        $document->update($validated);

        if ($request->hasFile('cover_image')) {
            if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
                Storage::disk('public')->delete($document->cover_image);
            }
            $coverFile = $request->file('cover_image');
            $coverPath = $coverFile->storeAs('covers', 'cover_' . $document->id . '_' . time() . '.' . $coverFile->getClientOriginalExtension(), 'public');
            $document->update(['cover_image' => $coverPath]);
        } elseif ($request->filled('cover_base64')) {
            if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
                Storage::disk('public')->delete($document->cover_image);
            }
            $coverPath = $this->storeBase64Image($request->cover_base64, $document->id);
            if ($coverPath) {
                $document->update(['cover_image' => $coverPath]);
            }
        } elseif (empty($document->cover_image)) {
            $coverPath = $this->generateCover($document);
            if (!empty($coverPath)) {
                $document->update(['cover_image' => $coverPath]);
            }
        }

        return redirect()->route('documents.manage')->with('success', 'Document updated successfully.');
    }

    public function readInline(Document $document)
    {
        $document->increment('views');
        $content = null;
        $description = $document->description;
        $filePath = storage_path('app/public/' . $document->file_path);

        if (file_exists($filePath)) {
            $ext = strtolower($document->file_type);

            if ($ext === 'txt') {
                $content = nl2br(e(file_get_contents($filePath)));
            } elseif ($ext === 'pdf' && class_exists('\Smalot\PdfParser\Parser')) {
                try {
                    $parser = new \Smalot\PdfParser\Parser();
                    $pdf = $parser->parseFile($filePath);
                    $text = $pdf->getText();
                    if ($text) $content = nl2br(e(trim($text)));
                } catch (\Exception $e) { $content = null; }
            } elseif (in_array($ext, ['doc', 'docx']) && class_exists('\PhpOffice\PhpWord\IOFactory')) {
                try {
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
                    $text = [];
                    foreach ($phpWord->getSections() as $section) {
                        foreach ($section->getElements() as $element) {
                            if (method_exists($element, 'getText')) $text[] = $element->getText();
                        }
                    }
                    if (count($text) > 0) $content = nl2br(e(implode("\n", $text)));
                } catch (\Exception $e) { $content = null; }
            }
        }

        return response()->json([
            'content' => $content,
            'description' => $description,
            'pages' => $content ? 'Scrollable' : null,
        ]);
    }


    public function regenerateCover(Request $request, Document $document)
{
    $request->validate([
        'cover_base64' => 'required|string',
    ]);

    // Delete old cover if it exists
    if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
        Storage::disk('public')->delete($document->cover_image);
    }

    $coverPath = $this->storeBase64Image($request->cover_base64, $document->id);

    if ($coverPath) {
        $document->update(['cover_image' => $coverPath]);
        return response()->json(['success' => true, 'message' => 'Cover updated.']);
    }

    return response()->json(['success' => false, 'message' => 'Failed to process image.'], 500);
}
}