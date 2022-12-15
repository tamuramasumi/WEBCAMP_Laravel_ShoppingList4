<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingListPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\shopping_lists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\completed_shopping_lists;


use Symfony\Component\HttpFoundation\StreamedResponse;

class ShoppingListController extends Controller
{
    /**
     * 一覧用の Illuminate\Database\Eloquent\Builder インスタンスの取得
     */
    protected function getListBuilder()
    {
        return shopping_lists::where('user_id', Auth::id())
                      ->orderBy('name')
                     ->orderBy('updated_at')
                     ->orderBy('created_at');
    }

    /**
     * 「買うもの」一覧ページ を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function list()
    {
        // 1Page辺りの表示アイテム数を設定
        $per_page = 3;

        // 一覧の取得
        $list = $this->getListBuilder()
                     ->paginate($per_page);
/*
$sql = $this->getListBuilder()
            ->toSql();
//echo "<pre>\n"; var_dump($sql, $list); exit;
var_dump($sql);
*/
        //
        return view('shopping_list.list', ['list' => $list]);
    }

    /**
     * 買うもの新規登録
    */
    public function register(ShoppingListPostRequest $request)
    {
        // validate済みのデータの取得
        $datum = $request->validated();
        //
        //$user = Auth::user();
        //$id = Auth::id();
        //var_dump($datum, $user, $id); exit;

        // user_id の追加
        $datum['user_id'] = Auth::id();

        // テーブルへのINSERT
        try {
            $r = shopping_lists::create($datum);
        } catch(\Throwable $e) {
            // XXX 本当はログに書く等の処理をする。今回は一端「出力する」だけ
            echo $e->getMessage();
            exit;
        }

        // 買うもの登録成功
        $request->session()->flash('front.shopping_list', true);

        //
        return redirect('/shopping_list/list');
    }
    /**
     * 「単一のタスク」Modelの取得
    */
    protected function getshopping_lists($shopping_list_id)
    {
        // shopping_list_idのレコードを取得する
        $task = shopping_lists::find($shopping_list_id);
        if ($task === null) {
            return null;
        }
        
        if ($task->user_id !== Auth::id()) {
            return null;
        }
        //
        return $task;
    }

    /**
     * 「単一のタスク」の表示
    */
    protected function singleTaskRender($shopping_list_id, $template_name)
    {
        // shopping_list_idのレコードを取得する
        $task = $this->getshopping_lists($shopping_list_id);
        if ($task === null) {
            return redirect('/shopping_list/list');
        }

        // テンプレートに「取得したレコード」の情報を渡す
        return view($template_name, ['shopping_list' => $task]);
    }
    
    /**
     * 削除ボタン
    */ 
    public function delete(Request $request, $shopping_list_id)
    {
        // shopping_idのレコードを取得する
        $task = $this->getshopping_lits($shopping_list_id);

        // 買うものを削除する
        if ($task !== null) {
            $task->delete();
            $request->session()->flash('front.completed_shopping_list_delete', true);
        }

        // 一覧に遷移する
        return redirect('/shopping_list/list');
    }

    /**
     * 完了ボタン
    */
    public function complete(Request $request, $shopping_list_id)
    {

        try {
            // トランザクション開始
            DB::beginTransaction();
            // shopping_listのレコードを取得する
            $task = $this->getshopping_lists($shopping_list_id);
            echo '01';
            if ($task === null) {
            // shopping_listが不正なのでトランザクション終了
                throw new \Exception('');
            }
            echo '02';
            // tasks側を削除する
            $task->delete();
//var_dump($task->toArray()); exit;

            // completed_shopping_lists側にinsertする
            $dask_datum = $task->toArray();
            echo'03';
            unset($dask_datum['created_at']);
            echo'04';
            unset($dask_datum['updated_at']);
            echo'05';
            $r = completed_shopping_lists::create($dask_datum);
            echo'06';
            if ($r === null) {
                // insertで失敗したのでトランザクション終了
                throw new \Exception('');
            }
//echo '処理成功'; exit;

            // トランザクション終了
            DB::commit();
            // 完了メッセージ出力
            $request->session()->flash('front.completed_shopping_list_success', true);
        } catch(\Throwable $e) {
            
            echo "error";
            echo $e;
            exit;
//var_dump($e->getMessage()); exit;
            // トランザクション異常終了
            DB::rollBack();
            // 完了失敗メッセージ出力
            $request->session()->flash('front.completed_shopping_list_failure', true);
        }

        // 一覧に遷移する
        return redirect('/shopping_list/list');
    }

}