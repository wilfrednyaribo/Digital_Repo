<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * JSON: List all categories (for dropdowns/API).
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return response()->json($categories);
    }

    /**
     * Full manage page with stats, search, sort, pagination.
     */
    public function manage(Request $request)
    {
        $query = Category::withCount('documents');

        // Search — name, description, and slug
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
            });
        }

        // Status filter
        if ($request->get('status') === 'with_docs') {
            $query->having('documents_count', '>', 0);
        } elseif ($request->get('status') === 'empty') {
            $query->having('documents_count', '=', 0);
        }

        // Sorting — must match the <select> values in the Blade template
        switch ($request->get('sort', 'created_at')) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'docs_count':
                $query->orderBy('documents_count', 'desc');
                break;
            case 'docs_count_asc':
                $query->orderBy('documents_count', 'asc');
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $categories = $query->paginate(12)->withQueryString();

        // Stats — separate queries so page filters don't skew the numbers
        $allCategories   = Category::withCount('documents')->get();
        $withDocsCount   = $allCategories->where('documents_count', '>', 0)->count();
        $emptyCount      = $allCategories->where('documents_count', '=', 0)->count();
        $totalDocsInCats = Document::whereNotNull('category_id')->count();

        return view('categories.manage', compact(
            'categories',
            'withDocsCount',
            'emptyCount',
            'totalDocsInCats'
        ));
    }

    /**
     * JSON: Show a single category.
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * JSON: Store a new category (for inline creation / API).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|min:2|max:100|unique:categories,name',
            'description' => 'nullable|string|max:255',
        ]);

        $category = Category::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'id'   => $category->id,
            'name' => $category->name,
        ], 201);
    }

    /**
     * JSON: Update a category (for inline editing / API).
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|min:2|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:255',
        ]);

        $category->update([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'id'   => $category->id,
            'name' => $category->name,
        ]);
    }

    /**
     * Web: Delete a single category (from the manage page form).
     */
    public function destroy(Category $category)
    {
        // Unassign documents instead of blocking
        Document::where('category_id', $category->id)->update(['category_id' => null]);

        $category->delete();

        return redirect()->route('categories.manage')
            ->with('success', 'Category "' . $category->name . '" deleted successfully.');
    }

    /**
     * Web: Bulk delete selected categories.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = array_filter(explode(',', $request->get('ids', '')));

        if (empty($ids)) {
            return redirect()->route('categories.manage')
                ->with('error', 'No categories selected.');
        }

        // Unassign documents first to avoid FK errors
        Document::whereIn('category_id', $ids)->update(['category_id' => null]);

        $deleted = Category::whereIn('id', $ids)->delete();

        return redirect()->route('categories.manage')
            ->with('success', $deleted . ' categor' . ($deleted === 1 ? 'y' : 'ies') . ' deleted successfully.');
    }
}