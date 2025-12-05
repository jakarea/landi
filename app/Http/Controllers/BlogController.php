<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index(Request $request)
    {
        $query = Blog::with('author')->published()->latest('published_at');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $blogs = $query->paginate(9);
        
        // Get all unique categories for filter
        $categories = Blog::published()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('blog.index', compact('blogs', 'categories'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $blog = Blog::with('author')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Get related blogs (same category or recent)
        $relatedBlogs = Blog::with('author')
            ->published()
            ->where('id', '!=', $blog->id)
            ->when($blog->category, function($query) use ($blog) {
                return $query->where('category', $blog->category);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('blog', 'relatedBlogs'));
    }
}
