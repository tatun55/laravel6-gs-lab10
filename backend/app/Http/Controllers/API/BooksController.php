<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Book;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('created_at', 'asc')->get();
        return response()->json($books);
    }
}
