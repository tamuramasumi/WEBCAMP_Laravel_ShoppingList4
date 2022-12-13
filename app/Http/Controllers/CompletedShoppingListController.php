<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\completed_shopping_lists;

class CompletedShoppingListController extends Controller
{
    /**
     * 一覧用の Illuminate\Database\Eloquent\Builder インスタンスの取得
     */
    protected function getListBuilder()
    {
        return completed_shopping_lists::where('user_id', Auth::id())
                     ->orderBy('name')
                     ->orderBy('created_at');
    }

    /**
     *買うもの一覧
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
        return view('shopping_list.completed_shopping_list', ['list' => $list]);
    }

}