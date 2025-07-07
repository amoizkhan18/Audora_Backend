<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\NewBook;
use Illuminate\Http\Request;

class BookController extends Controller
{
       public function show(Request $request, $id = null)
    {
        if (!$id) {
            // Fetch all books
            $books = Book::all();
            return response()->json($books);
        } else {
            // Fetch a single book by ID
            $book = Book::find($id);
            if (!$book) {
                return response()->json(['message' => 'Book not found'], 404);
            }
            return response()->json($book);
        }
    }


    public function showgenres(Request $request, $genres = null)
    {
        if (!$genres) {
            // Fetch all books
            $books = Book::all();
            return response()->json($books);
        } else {
            // Fetch books by genres
            $books = Book::where('Genres', 'LIKE', '%' . $genres . '%')->get();
            if ($books->isEmpty()) {
                return response()->json(['message' => 'Books not found'], 404);
            }
            return response()->json($books);
        }
    }

       public function searchBooks($search = null)
    {
        if ($search) {
            // Search logic for both tables
            $bookResults = Book::where('title', 'like', '%' . $search . '%')->get();
            $newBookResults = NewBook::where('title', 'like', '%' . $search . '%')->get();
    
            // Merging and returning the results
            $mergedResults = $bookResults->merge($newBookResults);
    
            if ($mergedResults->isEmpty()) {
                return response()->json(['message' => 'No results found for "' . $search . '"']);
            }
    
            return response()->json($mergedResults);
        } else {
            return response()->json(['message' => 'No search query provided']);
        }
    }

}
