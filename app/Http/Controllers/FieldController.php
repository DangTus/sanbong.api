<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Field;

class FieldController extends Controller
{
    public function getByTypeAndLocation(Request $req)
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

    public function getByLocation(Request $req)
    {
        if ($req->has(['location_id'])) {

            $listField = Field::where('location_id', $req->location_id)
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

    public function getById(Request $req)
    {
        if ($req->has(['field_id'])) {

            $field = Field::where('id', $req->field_id)
                ->where('status_id', '1')
                ->first();

            if ($field) {

                return response()->json([
                    'status' => 'success',
                    'data' => $field
                ]);
            } else {

                return response()->json([
                    'status' => 'error',
                    'data' => null,
                    'error' => 'Cannot find field'
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

    public function create(Request $req)
    {
        if ($req->has(['name', 'type_id', 'location_id'])) {

            $field = Field::create([
                'name' => $req->name,
                'description' => $req->input('description'),
                'type_id' => $req->type_id,
                'location_id' => $req->location_id
            ]);

            if ($field) {

                return response()->json([
                    'status' => 'success',
                    'msg' => 'Tạo mới sân thành công!'
                ]);
            } else {

                return response()->json([
                    'status' => 'error',
                    'error' => 'Cannot create field'
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

    public function update(Request $req)
    {
        if ($req->has(['field_id', 'name', 'status_id'])) {

            try {

                $field = Field::where('id', $req->field_id)->firstOrFail();
                $field->name = $req->name;
                $field->description = $req->input('description');
                $field->status_id = $req->status_id;
                $field->save();

                return response()->json([
                    'status' => 'success',
                    'msg' => 'Cập nhật thông tin sân thành công'
                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'status' => 'error',
                    'error' => 'Cannot update field. Because ' . $e
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

    public function delete(Request $req)
    {
        if ($req->has(['field_id'])) {
            try {

                $field = Field::where('id', $req->field_id)->firstOrFail();
                $field->delete();

                return response()->json([
                    'status' => 'success',
                    'msg' => 'Xóa sân thành công!'
                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'status' => 'error',
                    'data' => null,
                    'error' => 'Cannot delete field. Because ' . $e
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
