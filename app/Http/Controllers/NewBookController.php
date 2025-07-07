<?php

namespace App\Http\Controllers;

use App\Models\NewBook;
use App\Models\Book;
use App\Models\Audiobook; 
use Illuminate\Http\Request;

class NewBookController extends Controller
{
    // Fetch all books or a single book by ID
    public function newshow(Request $request, $bookid = null)
    {
        if (!$bookid) {
            $books = NewBook::all();
            return response()->json($books, 200, [], JSON_UNESCAPED_SLASHES);
        }

        $book = NewBook::where('bookid', $bookid)->first();
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book, 200, [], JSON_UNESCAPED_SLASHES);
    }

    // Fetch all books or filter by genres
    public function newshowgenres(Request $request, $genres = null)
    {
        if (!$genres) {
            $books = NewBook::all();
            return response()->json($books, 200, [], JSON_UNESCAPED_SLASHES);
        }

        $books = NewBook::where('Genres', 'LIKE', '%' . $genres . '%')->get();
        if ($books->isEmpty()) {
            return response()->json(['message' => 'Books not found'], 404);
        }
        return response()->json($books, 200, [], JSON_UNESCAPED_SLASHES);
    }
     public function searchByName($name = null)
    {
        if ($name) {
            $bookResults = Book::where('title', 'like', '%' . $name . '%')->get();
            $newBookResults = NewBook::where('title', 'like', '%' . $name . '%')->get();
            $audiobookResults = Audiobook::where('title', 'like', '%' . $name . '%')->get();

            $mergedResults = $bookResults->merge($newBookResults)->merge($audiobookResults);

            if ($mergedResults->isEmpty()) {
                return response()->json(['message' => 'No results found for "' . $name . '"']);
            }

            return response()->json($mergedResults);
        } else {
            return response()->json(['message' => 'No search query provided']);
        }
    }
}
