@extends('layout')

{{-- タイトル --}}
@section('title')(詳細画面)@endsection

{{-- メインコンテンツ --}}
@section('contets')


<h1>「買うもの」の登録</h1>
 @if (session('front.task_register_success') == true)
                買うものを登録しました！！<br>
            @endif
            @if (session('front.task_delete_success') == true)
                買うものを削除しました！！<br>
            @endif
            @if (session('front.task_completed_success') == true)
                買うものを完了にしました！！<br>
            @endif
            @if (session('front.task_completed_failure') == true)
                買うものの完了に失敗しました....<br>
            @endif
            @if ($errors->any())
                <div>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                </div>
            @endif
            <form action="/shopping_list/register" method="post">
                @csrf
                「買うもの」名:<input name="name" value="{{ old('name') }}"><br>
                <button>「買うもの」を登録する</button>
            </form>
 <h1>「買うもの」一覧</h1><br>
    
    
    <br>
        <hr>
        <menu label="リンク">
        <a href="/logout">ログアウト</a><br>
        </menu>
@endsection