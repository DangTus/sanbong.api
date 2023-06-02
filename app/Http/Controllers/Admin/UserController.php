<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function verification()
    {
        $owner = User::where('role_id', 2)->orderBy('status_id')->paginate(10);

        return $owner;
    }

    public function postVerification(Request $req)
    {
        if ($req->has(['owner_id', 'status_id'])) {

            $owner = User::where('id', $req->owner_id)->first();

            if ($owner->status_id == 1 && $owner->role_id == 2) {

                $owner->status_id = $req->status_id;
                $owner->save();

                if ($req->status_id == 2) {
                    $msg = 'Duyệt hồ sơ chủ sân bóng dùng thành công';
                } elseif ($req->status_id == 3) {
                    $msg = 'Từ chối hồ sơ chủ sân bóng thành công';
                }

                return response()->json([
                    'status' => 'success',
                    'data' => null,
                    'msg' => $msg
                ]);
            } else {

                return response()->json([
                    'status' => 'error',
                    'data' => null,
                    'error' => 'You cannot take action with this account'
                ]);
            }
        } else {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }
    }
}
