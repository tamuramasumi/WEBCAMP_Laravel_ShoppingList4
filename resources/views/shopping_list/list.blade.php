@extends('layout')

{{-- タイトル --}}
@section('title')(詳細画面)@endsection

{{-- メインコンテンツ --}}
@section('contets')


<h1>「買うもの」の登録</h1>
 @if (session('front.shopping_list_register_success') == true)
                買うものを登録しました！！<br>
            @endif
            @if (session('front.shopping_list_delete_success') == true)
                買うものを削除しました！！<br>
            @endif
            @if (session('front.shopping_list_completed_success') == true)
                買うものを完了にしました！！<br>
            @endif
            @if (session('front.shopping_list_completed_failure') == true)
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
 <h1>「買うもの」一覧</h1>
               <table border="1">
        <tr>
            <th>登録日
            <th>「買うもの」名
        <tr>
            <td>2022/12/31
            <td>豚肉
            <td><form action="./top.html"><button>削除</button></form>
            <td><form action="./top.html"><button>完了</button></form>
        <tr>
            <td>2022/12/31
            <td>イカ
           <td><form action="./top.html"><button>削除</button></form>
            <td><form action="./top.html"><button>完了</button></form>
        <tr>
            <td>2023/02/01
            <td>エビ
           <td><form action="./top.html"><button>削除</button></form>
            <td><form action="./top.html"><button>完了</button></form>
        <tr>
            <td>2023/02/15
            <td>うずらの卵
            <td><form action="./top.html"><button>削除</button></form>
            <td><form action="./top.html"><button>完了</button></form>
        </table>
        <!-- ページネーション -->
        現在 1 ページ目<br>
        <a href="./top.html">最初のページ(未実装)</a> / 
        <a href="./top.html">前に戻る(未実装)</a> / 
        <a href="./top.html">次に進む(未実装)</a>
        <br>
        <hr>
        <menu label="リンク">
        <a href="./index.html">ログアウト(未実装)</a><br>
        </menu>
    </body>
</html>