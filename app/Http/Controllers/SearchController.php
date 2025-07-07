<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Audiobook;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('query');
        $limit = $request->query('limit', 5); // Default to 5 results if not provided

        if (!$query) {
            return response()->json(['message' => 'No search query provided'], 400);
        }

        // Search books
        $bookResults = Book::where('title', 'like', '%' . $query . '%')
            ->limit($limit)
            ->get();

        // Search audiobooks
        $audiobookResults = Audiobook::where('title', 'like', '%' . $query . '%')
            ->limit($limit)
            ->get();

        // Merge both results
        $results = $bookResults->map(function ($book) {
            return [
                'type' => 'book',
                'title' => $book->title,
                'author' => $book->author,
                'genres' => $book->genres,
                'imageurl' => $book->imageurl,
                'description' => $book->bookdesc,
                'url' => $book->bookurl,
                'bookid' => $book->id,
            ];
        })->merge(
            $audiobookResults->map(function ($audio) {
                return [
                    'type' => 'audiobook',
                    'title' => $audio->title,
                    'author' => $audio->author,
                    'genres' => $audio->genres,
                    'imageurl' => $audio->imageurl,
                    'description' => $audio->bookdesc,
                    'url' => $audio->audiolinks,
                    'bookid' => $audio->id,
                ];
            })
        );

        return response()->json($results->values());
    }
}
