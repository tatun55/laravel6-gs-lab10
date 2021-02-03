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
    public function index(Request $request)
    {
        $books = Book::where('user_id', Auth::user()->id)
            ->orderBy('id', 'asc')
            ->withCount('comments');
        !empty($request->item_name) && $books = $books->where('item_name', 'like', '%' . $request->item_name . '%');
        !empty($request->alphabet_title) && $books = $books->where('item_name', 'like', '%' . $request->alphabet_title . '%');
        !empty($request->item_amount_from) && $books = $books->where('item_amount', '>=', $request->item_amount_from);
        !empty($request->item_amount_to) && $books = $books->where('item_amount', '<=', $request->item_amount_to);
        !empty($request->item_number_from) && $books = $books->where('item_number', '>=', $request->item_number_from);
        !empty($request->item_number_to) && $books = $books->where('item_number', '<=', $request->item_number_to);
        !empty($request->published_from) && $books = $books->whereDate('published', '>=', $request->published_from);
        !empty($request->published_to) && $books = $books->whereDate('published', '<=', $request->published_to);
        $books = $books->paginate(3);

        $book3minTotals = BookTotal::where('period', 3)->orderBy('created_at', 'desc')->limit(5)->get();
        $book5minTotals = BookTotal::where('period', 5)->orderBy('created_at', 'desc')->limit(5)->get();
        $book10minTotals = BookTotal::where('period', 10)->orderBy('created_at', 'desc')->limit(5)->get();

        return view('books', [
            'books' => $books,
            'book_3min_totals' => $book3minTotals,
            'book_5min_totals' => $book5minTotals,
            'book_10min_totals' => $book10minTotals,
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

    public function total()
    {
        return view('bookstotal');
    }
}
