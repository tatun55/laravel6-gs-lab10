@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
    @include('common.errors')
    <form action="{{ url('books/' . $book->id ) }}" method="POST">

        @method('put')

        <!-- item_name -->
        <div class="form-group">
           <label for="item_name">Title</label>
           <input type="text" id="item_name" name="item_name" class="form-control" value="{{$book->item_name}}">
        </div>
        <!--/ item_name -->

        <!-- alphabet_title -->
        <div class="form-group">
           <label for="alphabet_title">AlphabetTitle</label>
           <input type="text" id="alphabet_title" name="alphabet_title" class="form-control" value="{{$book->alphabet_title}}">
        </div>
        <!--/ alphabet_title -->

        <!-- item_number -->
        <div class="form-group">
           <label for="isbn">ISBN</label>
        <input type="text" id="isbn" name="isbn" class="form-control" value="{{$book->isbn}}">
        </div>
        <!--/ item_number -->

        <!-- item_number -->
        <div class="form-group">
           <label for="item_number">Number</label>
        <input type="text" id="item_number" name="item_number" class="form-control" value="{{$book->item_number}}">
        </div>
        <!--/ item_number -->

        <!-- item_amount -->
        <div class="form-group">
           <label for="item_amount">Amount</label>
        <input type="text" id="item_amount" name="item_amount" class="form-control" value="{{$book->item_amount}}">
        </div>
        <!--/ item_amount -->

        <!-- published -->
        <div class="form-group">
           <label for="published">published</label>
            <input type="date" id="published" name="published" class="form-control" value="{{$book->published->format('Y-m-d')}}"/>
        </div>
        <!--/ published -->

        <!-- Saveボタン/Backボタン -->
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link pull-right" href="{{ url('/') }}">
                Back
            </a>
        </div>
        <!--/ Saveボタン/Backボタン -->

         <!-- id値を送信 -->
         <input type="hidden" name="id" value="{{$book->id}}">
         <!--/ id値を送信 -->

         <!-- CSRF -->
         {{ csrf_field() }}
         <!--/ CSRF -->

    </form>

    <!-- comments -->
    <table class="table table-striped task-table mt-4">
        <thead>
            <th>コメント一覧</th>
            <th>&nbsp;</th>
        </thead>
        <tbody>
            @foreach ($book->comments as $comment)
                <tr>
                    <td class="table-text">
                        <div>{{ $comment->body }}</div>
                    </td>
                    <td>
                        <form action="{{ url('bookComments/' . $comment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                削除
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form action="{{ url('books/' . $book->id . '/bookComments' ) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="comment">新規コメント</label>
            <input type="text" id="comment" name="comment" class="form-control"/>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">コメント投稿</button>
            <a class="btn btn-link" href="{{ url('/') }}">
                Back
            </a>
        </div>
    </form>
    <!--/ comments -->

    </div>
</div>
@endsection
