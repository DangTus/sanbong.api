<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FieldType;

class HomeController extends Controller
{
    public function fieldType()
    {
        $fieldType = FieldType::all();

        return response()->json([
            'status' => 'success',
            'data' => $fieldType
        ]);
    }
}
