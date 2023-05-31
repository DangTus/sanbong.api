<?php

namespace App\Http\Controllers;

use App\Http\Resources\WardResource;
use Illuminate\Http\Request;

use App\Models\Province;
use App\Models\District;
use App\Models\Ward;

class AddressController extends Controller
{
    public function allProvince()
    {
        $listProvince = Province::orderBy('priority')->get();

        return response()->json([
            'status' => 'success',
            'data' => $listProvince
        ]);
    }

    public function districtByProvince(Request $req)
    {
        if ($req->province_id) {
            $listDistrict = District::where('province_id', $req->province_id)->get();

            return response()->json([
                'status' => 'success',
                'data' => $listDistrict
            ]);
        } else {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }
    }

    public function wardByDistrict(Request $req)
    {
        if ($req->district_id) {
            $listWard = Ward::where('district_id', $req->district_id)->get();

            return response()->json([
                'status' => 'success',
                'data' => $listWard
            ]);
        } else {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }
    }

    public function wardByID(Request $req)
    {
        if ($req->ward_id) {

            $ward = Ward::where('id', $req->ward_id)->first();

            return $ward;
        } else {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }
    }
}
