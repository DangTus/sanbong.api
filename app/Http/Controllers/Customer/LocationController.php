<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use App\Models\Location;
use App\Models\Field;
use App\Models\Price;
use App\Models\Booking;

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

            $location = Location::where('id', $req->location_id)->where('status_id', 1)->first();

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

    public function bookField(Request $req)
    {
        $reqParams = ['timeslot_id', 'field_id', 'customer_id', 'customer_name', 'phone_number', 'date_book', 'price'];

        if ($req->has($reqParams)) {

            $validator = Validator::make($req->all(), [
                'customer_name' => 'required',
                'phone_number' => 'required',
                'date_book' => 'required | date_format:Y-m-d',
            ], [
                'customer_name.required' => 'Vui lòng nhập tên',
                'phone_number.required' => 'Vui lòng nhập số điện thoại',
                'date_book.required' => 'Vui lòng chọn ngày đặt',
                'date_book.date_format' => 'Ngày đặt phải có định dạng Y-m-d'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => 'error_validate',
                    'data' => null,
                    'error' => $validator->errors()
                ]);
            }

            $book = Booking::where('timeslot_id', $req->timeslot_id)
                ->where('field_id', $req->field_id)
                ->where('date_book', $req->date_book)
                ->first();

            if ($book) {

                return response()->json([
                    'status' => 'error',
                    'error' => 'Đơn hàng đã được đặt trước đó!'
                ]);
            } else {

                $note = $req->input('note');
                $log = Carbon::now()->addHours(7)->format('H:i:s d-m-Y') . ': Booking has been created;';

                $bookNew = Booking::create([
                    'timeslot_id' => $req->timeslot_id,
                    'field_id' => $req->field_id,
                    'customer_id' => $req->customer_id,
                    'customer_name' => $req->customer_name,
                    'phone_number' => $req->phone_number,
                    'date_book' => $req->date_book,
                    'price' => $req->price,
                    'note' => $note,
                    'log' => $log
                ]);

                if ($bookNew) {

                    return response()->json([
                        'status' => 'success',
                        'msg' => 'Đơn hàng đã được đặt thành công!'
                    ]);
                } else {

                    return response()->json([
                        'status' => 'error',
                        'error' => 'Có lỗi trong lúc đặt hàng. Vui lòng thử lại sau!'
                    ]);
                }
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
