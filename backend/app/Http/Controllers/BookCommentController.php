<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookComment;
use Illuminate\Http\Request;

class BookCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Book $book, Request $request)
    {
        $bookComment =  new BookComment;
        $bookComment->book_id = $book->id;
        $bookComment->body = $request->comment;
        $bookComment->save();

        return view('booksedit', [
            'book' => $book
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookComment  $bookComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookComment $bookComment)
    {
        $bookId = $bookComment->book_id;
        $bookComment->delete();
        return view('booksedit', [
            'book' => Book::find($bookId)
        ]);
    }
}
