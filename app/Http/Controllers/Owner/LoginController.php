<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class LoginController extends Controller
{
    public function test()
    {
        return response()->json([
            'data' => 'Tus'
        ]);
    }

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required | email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Vui lòng nhập đúng email của bạn',
            'password.required' => 'Vui lòng nhập password',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'error_validate',
                'data' => null,
                'error' => $validator->errors()
            ]);
        }

        $owner = User::where('email', $req->email)->where('password', $req->password)->where('role_id', 2)->first();

        if ($owner) {
            if ($owner->status_id == 3) {

                return response()->json([
                    'status' => 'error',
                    'data' => null,
                    'error' => 'Tài khoản của bạn đã bị khóa!'
                ]);
            } else {

                return response()->json([
                    'status' => 'success',
                    'data' => $owner
                ]);
            }
        } else {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Tài khoản hoặc mật khẩu của bạn không đúng!'
            ]);
        }
    }
}
