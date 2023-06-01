<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Field;

class FieldController extends Controller
{
    public function fieldByTypeAndLocation(Request $req)
    {
        if ($req->has(['type_id', 'location_id'])) {

            $listField = Field::where('type_id', $req->type_id)
                ->where('location_id', $req->location_id)
                ->where('status_id', 1)
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $listField
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
