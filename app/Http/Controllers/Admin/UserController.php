<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function verification()
    {
        $owner = User::where('role_id', 2)->orderBy('status_id')->paginate(10);
        $ownerResource = UserResource::collection($owner)->additional(['status' => 'success']);

        return $ownerResource;
    }

    public function postVerification(Request $req)
    {
        if (!$req->id || !$req->status_id) {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }

        $owner = User::find($req->id);

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
    }
}
