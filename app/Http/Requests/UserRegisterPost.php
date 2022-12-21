<?php
declare(strict_types=1);
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User as UserModel;

class UserRegisterPost extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:128'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:254'],
            'password' => ['required', 'max:72'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }
}
