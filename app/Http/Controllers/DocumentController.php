<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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

        // ─── Store the main file ───
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

        // ─── Handle cover image: priority is manual upload, then base64 auto-generated ───
        $coverPath = null;

        // 1) Manual cover file uploaded
        if ($request->hasFile('cover_image')) {
            $coverFile = $request->file('cover_image');
            $coverPath = $coverFile->storeAs(
                'covers',
                'cover_' . $document->id . '_' . time() . '.' . $coverFile->getClientOriginalExtension(),
                'public'
            );
        }
        // 2) Base64 auto-generated cover (from PDF first page or image preview)
        elseif ($request->filled('cover_base64')) {
            $coverPath = $this->storeBase64Image($request->cover_base64, $document->id);
        }

        if ($coverPath) {
            $document->update(['cover_image' => $coverPath]);
        }

        $typeLabel = ucfirst($request->document_type ?? 'record');

        return redirect()
            ->route('documents.index')
            ->with('success', "{$typeLabel} uploaded successfully.");
    }

    /**
     * Decode a base64 data URI and save it as a JPEG file on disk.
     * Returns the storage path or null on failure.
     */
    private function storeBase64Image(string $base64String, int $documentId): ?string
    {
        try {
            // Strip the data URI prefix (e.g. "data:image/jpeg;base64,")
            $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $base64String);
            $imageData = base64_decode($imageData);

            if ($imageData === false) {
                return null;
            }

            $filename = 'cover_' . $documentId . '_' . time() . '.jpg';
            $path = 'covers/' . $filename;

            Storage::disk('public')->put($path, $imageData);

            return $path;
        } catch (\Exception $e) {
            \Log::warning('Failed to store base64 cover image for document ' . $documentId . ': ' . $e->getMessage());
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
        // Delete the main file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Delete the cover image from storage
        if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
            Storage::disk('public')->delete($document->cover_image);
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    /**
 * Manage all documents — admin table view.
 */
public function manage(Request $request)
{
    $query = Document::with('user', 'category');

    // Search
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('author_creator', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    // Filter by type
    if ($request->filled('type')) {
        $query->where('document_type', $request->input('type'));
    }

    // Filter by category
    if ($request->filled('category')) {
        $query->where('category_id', $request->input('category'));
    }

    // Sort
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
}