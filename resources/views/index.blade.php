@extends('layout')

{{-- メインコンテンツ --}}
@section('contets')
        <h1>ログイン</h1>
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        @if (session('front.user_register_success') == true)
            ユーザを登録しました！！<br>
        @endif
        <form action="/login" method="post">
            @csrf
            email：<input name="email" value="{{ old('email') }}"><br>
            パスワード：<input  name="password" type="password"><br>
            <button>ログイン</button>
        </form>
        <a href="/user/register">会員登録</a>
@endsection