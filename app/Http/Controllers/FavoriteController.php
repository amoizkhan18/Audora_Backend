<?php
namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Book;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // Save a book as favorite
    public function saveFavorite(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id',
            'device_id' => 'required|string',
        ]);

        // Check if the favorite already exists
        $existingFavorite = Favorite::where('book_id', $validatedData['book_id'])
                                    ->where('device_id', $validatedData['device_id'])
                                    ->first();

        if ($existingFavorite) {
            return response()->json(['success' => false, 'message' => 'This book is already in your favorites.'], 409);
        }

        // Attempt to save the favorite
        try {
            $favorite = Favorite::create([
                'book_id' => $validatedData['book_id'],
                'device_id' => $validatedData['device_id'],
            ]);

            return response()->json(['success' => true, 'message' => 'Book added to favorites'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to add book to favorites'], 500);
        }
    }

    // Retrieve all favorite books for a device
    public function getFavorites(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'device_id' => 'required|string',
        ]);

        // Attempt to retrieve the favorites
        try {
            $favorites = Favorite::where('device_id', $validatedData['device_id'])
                                ->with('book') // Load the related book data
                                ->get();

            // Check if any favorites were found
            if ($favorites->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No favorites found for this device.'], 404);
            }

            return response()->json($favorites, 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to retrieve favorites'], 500);
        }
    }
}
