<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MarketplaceController extends Controller
{
    protected $categories = [
        'vehicles' => 'Vehicles',
        'home_garden' => 'Home & Garden',
        'electronics' => 'Electronics',
        'clothing' => 'Clothing & Accessories',
        'sports' => 'Sports & Recreation',
        'toys_games' => 'Toys & Games',
        'books' => 'Books & Media',
        'furniture' => 'Furniture',
        'music' => 'Music & Instruments',
        'other' => 'Other'
    ];

    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        $sort = $request->get('sort', 'latest');

        $listings = Listing::with('user')
            ->active()
            ->search($search)
            ->byCategory($category);

        // Apply sorting
        switch ($sort) {
            case 'price_low':
                $listings = $listings->orderBy('price', 'asc');
                break;
            case 'price_high':
                $listings = $listings->orderBy('price', 'desc');
                break;
            case 'oldest':
                $listings = $listings->orderBy('created_at', 'asc');
                break;
            default:
                $listings = $listings->orderBy('created_at', 'desc');
                break;
        }

        $listings = $listings->paginate(12)->appends($request->except('page'));

        // Get category counts for sidebar
        $categoryCounts = Listing::active()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        return view('marketplace.index', compact('listings', 'categoryCounts', 'search', 'category', 'sort'));
    }

    public function create()
    {
        return view('marketplace.create', [
            'categories' => $this->categories
        ]);
    }

   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'price' => 'required|numeric|min:0|max:999999.99',
        'category' => 'required|in:' . implode(',', array_keys($this->categories)),
        'condition' => 'required|in:new,like_new,good,fair,poor',
        'location' => 'nullable|string|max:255',
        'images' => 'nullable|array|max:5',
        'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:2048'
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $imagesPaths = [];
    if ($request->hasFile('images')) {
        // Create public uploads directory
        $uploadPath = public_path('uploads/marketplace');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        foreach ($request->file('images') as $image) {
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Move file to public directory
            $image->move($uploadPath, $filename);
            
            // Store the path relative to public directory
            $imagesPaths[] = 'uploads/marketplace/' . $filename;
        }
    }

    Listing::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'category' => $request->category,
        'condition' => $request->condition,
        'location' => $request->location,
        'images' => $imagesPaths,
        'status' => 'active'
    ]);

    return redirect()->route('marketplace.index')->with('success', 'Listing created successfully!');
}

    // Add a helper method to get image URLs consistently
    public function getImageUrl($imagePath)
    {
        if (!$imagePath) {
            return asset('images/default-marketplace.png');
        }
        
        // Check if file exists in storage
        if (Storage::disk('public')->exists($imagePath)) {
            return Storage::url($imagePath);
        }
        
        return asset('images/default-marketplace.png');
    }


    public function show(Listing $listing)
    {
        $listing->load('user');
        
        // Get related listings (same category, exclude current)
        $relatedListings = Listing::active()
            ->where('category', $listing->category)
            ->where('id', '!=', $listing->id)
            ->with('user')
            ->latest()
            ->take(4)
            ->get();

        return view('marketplace.show', compact('listing', 'relatedListings'));
    }

    public function edit(Listing $listing)
    {
        // Check if user owns the listing
        if ($listing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('marketplace.edit', [
            'listing' => $listing,
            'categories' => $this->categories
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        // Check if user owns the listing
        if ($listing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0|max:999999.99',
            'category' => 'required|in:' . implode(',', array_keys($this->categories)),
            'condition' => 'required|in:new,like_new,good,fair,poor',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:active,sold,inactive',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $imagesPaths = $listing->images ?? [];

        // Handle new image uploads
        if ($request->hasFile('images')) {
            // Delete old images if replacing
            if ($request->has('replace_images')) {
                foreach ($imagesPaths as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagesPaths = [];
            }

            // Add new images
            foreach ($request->file('images') as $image) {
                if (count($imagesPaths) < 5) {
                    $path = $image->store('marketplace', 'public');
                    $imagesPaths[] = $path;
                }
            }
        }

        $listing->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'condition' => $request->condition,
            'location' => $request->location,
            'status' => $request->status,
            'images' => $imagesPaths
        ]);

        return redirect()->route('marketplace.show', $listing)->with('success', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing)
{
    if ($listing->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Delete images from public directory
    if ($listing->images) {
        foreach ($listing->images as $imagePath) {
            $fullPath = public_path($imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }

    $listing->delete();

    return redirect()->route('marketplace.index')->with('success', 'Listing deleted successfully!');
}

    public function myListings()
    {
        $listings = Listing::where('user_id', auth()->id())
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('marketplace.my-listings', compact('listings'));
    }

    public function markAsSold(Listing $listing)
    {
        // Check if user owns the listing
        if ($listing->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $listing->update(['status' => 'sold']);

        return response()->json(['success' => true, 'message' => 'Listing marked as sold!']);
    }
    
}