<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterPost;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller 
{

    /**
     * 会員の新規登録
     */
    public function index()
    {
        return view('user.register');
    }

    public function register(UserRegisterPost $request)
    {
    
        // validate済みのデータの取得
        $datum = $request->validated();
        
        try {
             //Hash化したpasswordの追加
             $datum['password'] = Hash::make($datum['password']);
            $r = UserModel::create($datum);
        } catch(\Throwable $e) {
            // XXX 本当はログに書く等の処理をする。今回は一端「出力する」だけ
            echo $e->getMessage();
            exit;
        }

        // 会員登録成功
        $request->session()->flash('front.user_register_success', true);

        //
        return redirect('/');
    }
}