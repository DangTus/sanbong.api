<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Location;

class LocationController extends Controller
{
    public function getByWard(Request $req)
    {
        if ($req->has(['ward_id'])) {

            $listLocation = Location::where('ward_id', $req->ward_id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $listLocation
            ]);
        } else {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }
    }
}
