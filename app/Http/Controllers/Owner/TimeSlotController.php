<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TimeSlot;
use App\Models\Price;

class TimeSlotController extends Controller
{
    public function getWithPrice(Request $req)
    {
        if ($req->has(['location_id', 'fieldtype_id'])) {

            $listTimeSlot = TimeSlot::all();

            $listTimeSlotWithPrice = $listTimeSlot->map(function ($timeSlot) use ($req) {
                return $timeSlot->getWithPrice($req->location_id, $req->fieldtype_id);
            });

            return response()->json([
                'status' => 'success',
                'data' => $listTimeSlotWithPrice
            ]);
        } else {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }
    }

    public function updatePriceByTimeSlot(Request $req)
    {
        if ($req->has(['location_id', 'fieldtype_id', 'list_timeslot_with_price'])) {

            try {
                foreach ($req->list_timeslot_with_price as $timeslot_with_price) {

                    $timeSlotId = $timeslot_with_price['timeslot_id'];
                    $priceValue = $timeslot_with_price['price'] ? (int)$timeslot_with_price['price'] : null;

                    // Check if $priceValue not is a number
                    if ($priceValue <= 0 && $priceValue !== null) {

                        return response()->json([
                            'status' => 'error',
                            'error' => 'Có một cột giá tiền nào đó mà bạn vừa chỉnh sửa không đúng. Vui lòng kiểm tra và chỉnh sửa lại!'
                        ]);
                    }

                    $price = Price::where('timeslot_id', $timeSlotId)
                        ->where('location_id', $req->location_id)
                        ->where('fieldtype_id', $req->fieldtype_id)
                        ->first();

                    if ($price) {

                        if ($priceValue && $priceValue != $price->value) {

                            $price->value = $timeslot_with_price['price'];
                            $price->save();
                        } elseif (!$priceValue) {

                            $price->delete();
                        }
                    } elseif ($priceValue) {

                        $price = Price::create([
                            'timeslot_id' => $timeSlotId,
                            'location_id' => $req->location_id,
                            'fieldtype_id' => $req->fieldtype_id,
                            'value' => $priceValue
                        ]);
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'msg' => 'Cập nhật khung giờ thành công',
                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'status' => 'error',
                    'data' => $e->getMessage()
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
