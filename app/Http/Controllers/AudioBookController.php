<?php

namespace App\Http\Controllers;

use App\Models\Audiobook;
use Illuminate\Http\Request;

class AudiobookController extends Controller
{
    // Fetch all audiobooks or filter by genres
    public function audiobooksByGenre(Request $request, $genre = null)
{
    if (!$genre) {
        $books = Audiobook::all()->map(function ($book) {
            $book->audiolinks = $this->sanitizeLinks($book->audiolinks);
            return $book;
        });
        return response()->json($books, 200, [], JSON_UNESCAPED_SLASHES);
    }

    $books = Audiobook::where('genres', 'LIKE', '%' . $genre . '%')->get();

    if ($books->isEmpty()) {
        return response()->json(['message' => 'Books not found'], 404);
    }

    $books = $books->map(function ($book) {
        $book->audiolinks = $this->sanitizeLinks($book->audiolinks);
        return $book;
    });

    return response()->json($books, 200, [], JSON_UNESCAPED_SLASHES);
}

private function sanitizeLinks($linksString)
{
    return array_map(function ($link) {
        return trim($link, " \t\n\r\0\x0B\"\\");
    }, explode(',', $linksString));
}
}
