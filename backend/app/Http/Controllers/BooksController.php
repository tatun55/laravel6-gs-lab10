<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//使うClassを宣言:自分で追加
use App\Book;   //Bookモデルを使えるようにする
use App\Http\Requests\BookRequest;
use Validator;  //バリデーションを使えるようにする
use Auth;       //認証モデルを使用する
use Carbon\Carbon;

class BooksController extends Controller
{
    // //コンストラクタ(このクラスが呼ばれたら最初に処理をする)
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    //本ダッシュボード表示
    public function index()
    {
        $booksQ1 = Book::where('item_name', 'like', '%99%')->get();
        $booksQ2 = Book::whereYear('published', 2020)->whereMonth('published', 1)->get();

        echo 'Q1';
        foreach ($booksQ1 as $book) {
            dump([
                'ID' => $book->id,
                'タイトル' => $book->item_name,
                '数量' => $book->item_number,
                '金額' => $book->item_amount,
                '公開日' => $book->published->format('Y-m-d'),
            ]);
        }
        echo 'Q2';
        foreach ($booksQ2 as $book) {
            dump([
                'ID' => $book->id,
                'タイトル' => $book->item_name,
                '数量' => $book->item_number,
                '金額' => $book->item_amount,
                '公開日' => $book->published->format('Y-m-d'),
            ]);
        }
        exit;

        $books = Book::where('user_id', Auth::user()->id)
            ->orderBy('id', 'asc')
            ->withCount('comments')
            ->paginate(3);
        return view('books', [
            'books' => $books
        ]);
    }

    //更新画面
    public function edit($book_id)
    {
        $books = Book::where('user_id', Auth::user()->id)->findOrFail($book_id);
        // $books = Book::where('user_id', Auth::user()->id)->find($book_id);
        return view('booksedit', [
            'book' => $books
        ]);
    }

    //更新
    public function update(BookRequest $request)
    {
        $books = Book::find($request->id);
        $books->fill($request->all());
        $books->user_id = Auth::user()->id;
        $books->save();
        return redirect('/');
    }

    //登録
    public function store(BookRequest $request)
    {
        //file 取得
        $file = $request->file('item_img'); //file が空かチェック
        if (!empty($file)) {
            //ファイル名を取得
            $filename = $file->getClientOriginalName();
            //AWSの場合どちらかになる事がある”../upload/” or “./upload/”
            $move = $file->move('./upload/', $filename); //public/upload/...
        } else {
            $filename = "";
        }

        // 本作成処理...
        $books = new Book;
        $books->fill($request->all());
        $books->user_id = Auth::user()->id;
        $books->item_img = $filename;
        $books->save();

        return redirect('/');
    }

    //削除処理
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/');
    }
}
