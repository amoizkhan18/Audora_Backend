<?php

namespace App\Http\Controllers;

use App\Models\Hard;
use Illuminate\Http\Request;

class HardController extends Controller
{
       public function show(Request $request, $id = null)
    {
        if (!$id) {
            // Fetch all books
            $books = Hard::all();
            return response()->json($books);
        } else {
            // Fetch a single book by ID
            $book = Hard::find($id);
            if (!$book) {
                return response()->json(['message' => 'Book not found'], 404);
            }
            return response()->json($book);
        }
    }


}
