<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Field;
use App\Models\Price;

class FieldController extends Controller
{
    public function getField(Request $req)
    {
        $listField = Field::where('status_id', 1);

        if ($req->location_id) {

            $listField = $listField->where('location_id', $req->location_id);
        } elseif ($req->ward_id) {

            $listField = $listField->whereHas('location.ward', function ($query) use ($req) {
                $query->where('id', $req->ward_id);
            });
        }

        if ($req->type_id) {

            $listField = $listField->where('type_id', $req->type_id);
        }

        $listField = $listField->paginate(3);

        return $listField;
    }

    public function getFieldByID(Request $req)
    {
        if ($req->has(['field_id'])) {

            $field = Field::where('id', $req->field_id)->first()->toArrayDetail();

            return response()->json([
                'status' => 'success',
                'data' => $field
            ]);
        } else {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }
    }

    public function getTimeSlotByField(Request $req)
    {
        if ($req->has(['date', 'field_id'])) {

            $dateString = $req->date;
            $fieldID = $req->field_id;
            $field = Field::select('id', 'type_id', 'location_id')->where('id', $fieldID)->first();

            try {

                $dateBook = Carbon::createFromFormat('Y-m-d', $dateString)->format('Y-m-d');
            } catch (\Exception $e) {

                return response()->json([
                    'status' => 'error',
                    'error' => 'Ngay sai'
                ]);
            }

            $listTimeSlot = Price::where('fieldtype_id', $field->type_id)->where('location_id', $field->location_id)->get();

            $listTimeSlotNew = $listTimeSlot->map(function ($timeSlot) use ($field, $dateBook) {
                return $timeSlot->getStatus($field->id, $dateBook);
            });

            return response()->json([
                'status' => 'success',
                'data' => $listTimeSlotNew
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
