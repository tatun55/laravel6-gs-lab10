<!-- resources/views/books.blade.php -->
@extends('layouts.app') @section('content')
<!-- Bootstrapの定形コード… -->
<div class="card-body">
    <div class="card-title">
        本のタイトル
    </div>

    <!-- バリデーションエラーの表示に使用-->
    @include('common.errors')
    <!-- バリデーションエラーの表示に使用-->

    <!-- 本のタイトル -->
    <form enctype="multipart/form-data" action="{{ url('books') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="book" class="col-sm-3 control-label">Book</label>
                <input type="text" name="item_name" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label for="alphabet_title" class="col-sm-3 control-label">English</label>
                <input type="text" name="alphabet_title" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label for="amount" class="col-sm-3 control-label">金額</label>
                <input type="text" name="item_amount" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="number" class="col-sm-3 control-label">数</label>
                <input type="text" name="item_number" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label for="published" class="col-sm-3 control-label">公開日</label>
                <input type="date" name="published" class="form-control">
            </div>
        </div>

        <!-- file 追加 -->
        <div class="form-row mb-3">
            <div class="col-sm-6"> <label>画像</label>
                <input type="file" name="item_img">
            </div>
        </div>

        <!-- 本 登録ボタン -->
        <div class="form-row">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </form>
</div>

<!-- 検索フォーム -->
<div class="card-body">
    <div class="card-title">
        ​検索フォーム
    </div>
    ​
    <form action="{{ url('books') }}" method="get" class="form-horizontal">
        {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-md-6">
                ​<label for="book" class="col-sm-3 control-label">Book</label> ​
                <input type="text" name="item_name" class="form-control">
            </div>

            <div class="form-group col-md-6">
                ​<label for="alphabet_title" class="col-sm-3 control-label">English</label> ​
                <input type="text" name="alphabet_title" class="form-control"> ​
            </div>
            <div class="form-group col-md-6">
                ​<label for="amount" class="col-sm-3 control-label">金額</label>
                <div class="d-flex align-items-center">
                    ​<input type="text" name="item_amount_from" class="form-control"> ​　〜　　 ​
                    <input type="text" name="item_amount_to" class="form-control">
                </div>
            </div>
            <div class="form-group col-md-6">
                ​<label for="number" class="col-sm-3 control-label">数</label>
                <div class="d-flex align-items-center">
                    ​<input type="text" name="item_number_from" class="form-control"> ​　〜　　 ​
                    <input type="text" name="item_number_to" class="form-control">
                </div>
            </div>
            <div class="form-group col-md-6">
                ​<label for="published" class="col-sm-3 control-label">公開日</label>
                <div class="d-flex align-items-center">
                    ​<input type="date" name="published_from" class="form-control"> ​　〜　　 ​
                    <input type="date" name="published_to" class="form-control"> ​
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-offset-3 col-sm-6">
                ​<button type="submit" class="btn btn-primary">​検索</button>
            </div>
        </div>
    </form>
</div>
<!-- 検索フォーム -->

<!-- Book: 既に登録されてる本のリスト -->
<!-- 現在の本 -->
@if (count($books) > 0)
<div class="card-body">
    <div class="card-body">
        <table class="table table-striped task-table">
            <!-- テーブルヘッダ -->
            <thead>
                <th>本一覧</th>
                <th>&nbsp;</th>
            </thead>
            <!-- テーブル本体 -->
            <tbody>
                @foreach ($books as $book)
                <tr>
                    <!-- 本タイトル -->
                    <td class="table-text">
                        <div>{{ $book->item_name }}</div>
                        <div>英語: {{ $book->alphabet_title }}</div>
                        <div> <img src="upload/{{$book->item_img}}" width="100"></div>
                        <div>合計金額 : {{ $book->total_price }}</div>
                        <div>公開日 : {{ $book->published->format('Y年m月d日') }}</div>
                        <div>コメント数 : {{ $book->comments_count }}</div>
                    </td>

                    <!-- 本: 更新ボタン -->
                    <td>
                        <a class="btn btn-primary" href="{{ url('books/'. $book->id . '/edit') }}">更新</a>
                    </td>

                    <!-- 本: 削除ボタン -->
                    <td>
                        <form action="{{ url('books/'.$book->id) }}" method="POST">
                            {{ csrf_field() }} {{ method_field('DELETE') }}

                            <button type="submit" class="btn btn-danger">
                                削除
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-md-4 offset-md-4">
            {{ $books->appends(request()->input())->links()}}
        </div>
    </div>

</div>
@endif

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">直近</th>
            <th scope="col">1分前</th>
            <th scope="col">2分前</th>
            <th scope="col">3分前</th>
            <th scope="col">4分前</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <th scope="row">3 min</th>
            @foreach ($book_3min_totals as $book_3min_total)
            <td>{{$book_3min_total->amount}}</td>
            @endforeach
        </tr>
        <tr>
            <th scope="row">5 min</th>
            @foreach ($book_5min_totals as $book_5min_total)
            <td>{{$book_5min_total->amount}}</td>
            @endforeach
        </tr>
        <tr>
            <th scope="row">10 min</th>
            @foreach ($book_10min_totals as $book_10min_total)
            <td>{{$book_10min_total->amount}}</td>
            @endforeach
        </tr>
    </tbody>
</table>


@endsection