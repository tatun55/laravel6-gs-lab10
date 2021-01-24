<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <div class="card-title">
            本のタイトル
        </div>

        <!-- バリデーションエラーの表示に使用-->
    	@include('common.errors')
        <!-- バリデーションエラーの表示に使用-->

        <!-- 本のタイトル -->
        <form  enctype="multipart/form-data" action="{{ url('books') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="book" class="col-sm-3 control-label">Book</label>
                    <input type="text" name="item_name" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label for="alphabet_title" class="col-sm-3 control-label">英語タイトル</label>
                    <input type="text" name="alphabet_title" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label for="isbn" class="col-sm-3 control-label">ISBN</label>
                    <input type="text" name="isbn" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label for="amount" class="col-sm-3 control-label">金額</label>
                    <input type="text" name="item_amount" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="number" class="col-sm-3 control-label">数</label>
                    <input type="text" name="item_number" class="form-control">
                </div>

                  <div class="form-group col-md-6">
                    <label for="published" class="col-sm-3 control-label">公開日</label>
                    <input type="date" name="published" class="form-control">
                </div>

                <!-- <div class="form-group col-md-6">
                    <label for="aaa" class="col-sm-3 control-label">あああ</label>
                    <input type="text" name="aaa" class="form-control">
                </div> -->
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
                                    <div>{{ $book->alphabet_title }}</div>
                                    <div>ISBN10 : {{ $book->isbn }}</div>
                                    <div>ISBN13 : {{ $book->isbn13 }}</div>
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
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

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
                    {{ $books->links()}}
                </div>
           </div>

        </div>
    @endif



@endsection
