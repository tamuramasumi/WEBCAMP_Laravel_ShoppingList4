@extends('admin.layout')

{{-- メインコンテンツ --}}
@section('contets')
        <title>ログイン機能付き買い物管理サービス　管理画面</title>
    </head>
    <body>
        <h1>管理画面 ログイン</h1>
        <form action="/admin/login" method="post">
            @csrf
            ログインID：<input name="login_id" value="{{ old('login_id') }}"><br>
            パスワード：<input  name="password" type="password"><br>
            <button>ログインする</button>
        </form> 
    </body>
</html>
        