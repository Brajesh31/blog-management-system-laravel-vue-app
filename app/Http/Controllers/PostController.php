<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request; // Ensure this is the correct Request class
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Requests\StorePostRequest;// Use our Form Request for validation
use Illuminate\Support\Facades\Log; // Import the Log facade
use Illuminate\Support\Str; // For generating slugs


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query()->with('user', 'tags')->latest();

        //-- Search Login -- 
        if ( $search = $request->input('search') ) {
            $query->where( function ($q) use ($search) {
                $q->where('title','like', "%{$search}%")
                    ->orWhere('content','like', "%{$search}%")
                    //optionally search by username
                    ->orWhereHas('user', function($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
                
            });
        }


        //-- Visibility Filter --- 
        if ( !Auth::check() ) {
            //Guests only see published posts
            $query->where('visibility', 'published');
        } else {
            //Logged-in users see published posts and their own non-published posts
            $query->where(function ($q) {
                $q->where('visibility', 'published')
                    ->orWhere('user_id', Auth::id());
            });
        }

        $posts = $query->paginate(10)->withQueryString(); //Keep the search query in pagination

        //pass data to the Inertia Component
        return inertia('Posts/Index', [// Adjust component path as needed
            'posts' => $posts,
            'filters' => $request->only(['search']), // Pass filters back to the view
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Optionally pass tags or other data needed for the form
        return  Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //1. Get validated Data
        // Laravel automatically validates using StorePostRequest before this method runs.
         // If validation fails, the user is redirected back with errors automatically.

        $validated = $request->validated();

         // --- Server-side check: Content required only if publishing ---
        // Even though the frontend tries to validate, double-check here.
        if ($validated['visibility'] === 'published' && (empty($validated['content']) || $validated['content'] === '<p></p>')) {
            return back()
               ->withErrors(['content' => 'Post content cannot be empty when publishing.'])
               ->withInput();
       }
       // --- End server-side content check ---

        // 2. Handle Optional Image Upload
        $imagePath = null;// Default to null if no image uploaded

        if ( $request->hasFile('image') ) {

             // Store the image in 'public/uploads/posts' directory.
            // The 'public' disk visibility needs to be configured in config/filesystems.php
            // Make sure you've run `php artisan storage:link`
            try {
                $imagePath = $request->file('image')->store('uploads/posts', 'public');
            } catch (\Exception $e) {
                // Handle potential storage errors (disk full, permissions, etc.)
                // Log::error('Image upload failed: ' . $e->getMessage());
                Log::error('Image upload failed for user ' . Auth::id() . ': ' . $e->getMessage());

                 // Redirect back with a specific error message
                return back()
                    ->withInput() //keep the user's input
                    ->with('error', 'Failed to upload the image. Please try again or contact support.');
            }
         
        }

        // 3. Generate Unique Slug
        // Create a URL-friendly version of the title
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;

        //check if a post with this slug already exists
        while ( Post::where('slug', $slug)->exists() ) {
             // If it exists, append a counter and check again
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // 4. Create the Post in the Database

        try {
            $post = Post::create([
                'user_id' => Auth::id(), // Get ID of the currently logged-in user
                'title' => $validated['title'],
                'content' => $validated['content'] ?? '', // Tiptap content (HTML)
                'image' => $imagePath,              // Path to the stored image (or null)
                'slug' => $slug,
                'visibility' => $validated['visibility'],
                // <-- Use the validated visibility directly
                // Add other default fields if necessary (e.g., published_at if visibility is published)
                // 'published_at' => $validated['visibility'] === 'published' ? now() : null,
            ]);

            // --- Optional: Handle Tags ---
             // if (!empty($validated['tags'])) {
             //     $tagIds = $this->findOrCreateTags($validated['tags']); // Implement this helper method
             //     $post->tags()->sync($tagIds); // Sync tags with the post
             // }


        } catch (\Exception $e) {
            // Handle potential database errors (e.g., unique constraint violation)
            Log::error('Post creation failed: ' . $e->getMessage());

            // Redirect back with a specific error message
            return back()
                ->withInput() //keep the user's input
                ->with('error', 'Failed to create the post due to a server error. Please try again.');
        }

        // 5. Redirect User After Success
        // You can redirect to the newly created post's page (if you have one)
        // or back to the dashboard/feed.
        // return redirect()->route('posts.show', $post->slug) // Redirect to the post view
        $successMessage = $post->visibility === 'draft'
        ? 'Post saved as draft successfully!'
        : 'Post published successfully!';

        return redirect()->route('dashboard') // Or redirect to the dashboard
        ->with('success',  $successMessage); // Flash a success message


         // --- Optional Helper for Tag Handling ---
        /*
        private function findOrCreateTags(array $tagNames): array
        {
            $tags = [];
            foreach ($tagNames as $tagName) {
                $cleanName = trim(strtolower($tagName));
                if (!empty($cleanName)) {
                    $tag = Tag::firstOrCreate(
                        ['name' => $cleanName],
                        ['slug' => Str::slug($cleanName)] // Also generate slug for tag
                    );
                    $tags[] = $tag->id;
                }
            }
            return $tags;
        }
        */

        // You would also add other methods like show, edit, update, destroy here later

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
