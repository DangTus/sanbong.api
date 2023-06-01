<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Location;
use App\Models\Field;
use App\Models\Price;

class LocationController extends Controller
{
    public function locationByWard(Request $req)
    {
        $listLocation = Location::query();

        if ($req->ward_id) {

            $listLocation = $listLocation->where('ward_id', $req->ward_id);
        }

        $listLocation = $listLocation->where('status_id', 1)->paginate(3);

        return $listLocation;
    }

    public function locationByID(Request $req)
    {
        if ($req->location_id) {

            $location = Location::where('id', $req->location_id)->where('status_id', 1)->get();

            return response()->json([
                'status' => 'success',
                'data' => $location
            ]);
        } else {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }
    }

    public function timeSlot(Request $req)
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
                    'error' => 'Date format should be Y-m-d'
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
