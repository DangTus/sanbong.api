<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Booking;

class BookingController extends Controller
{
    public function getByLocation(Request $req)
    {
        if (!$req->has(['location_id'])) {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }

        try {

            $listBooking = Booking::with('field')
                ->whereHas('field', function ($query) use ($req) {
                    $query->where('location_id', $req->location_id);
                })
                ->orderBy('status_id')
                ->orderBy('date_book')
                ->orderBy('timeslot_id');

            if ($req->date_book) {

                try {

                    Carbon::createFromFormat('Y-m-d', $req->date_book);
                    $listBooking->where('date_book', $req->date_book);
                } catch (\Exception $e) {

                    return response()->json([
                        'status' => 'error',
                        'error' => 'Ngày phải đúng định dạng Y-m-d'
                    ]);
                }
            }
            if ($req->status_id) {
                $listBooking->where('status_id', $req->status_id);
            }
            if ($req->field_id) {
                $listBooking->where('field_id', $req->field_id);
            }

            $listBooking = $listBooking->get();

            return response()->json([
                'status' => 'success',
                'data' => $listBooking
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getById(Request $req)
    {
        if ($req->has(['booking_id'])) {

            try {

                $booking = Booking::where('id', $req->booking_id)->first();

                return response()->json([
                    'status' => 'success',
                    'data' => $booking
                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'status' => 'error',
                    'error' => $e->getMessage()
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

    public function update(Request $request)
    {
        if (!$request->has('booking_id', 'status_id')) {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }

        try {

            $booking = Booking::where('id', $request->booking_id)->first();

            if (!$booking) {

                return response()->json([
                    'status' => 'error',
                    'error' => 'Booking not found'
                ]);
            }

            $isUpdate = false;
            $message = '';
            $log = $booking->log . Carbon::now()->format('H:i:s d-m-Y');
            $datetimeBooking = Carbon::createFromFormat('Y-m-d H:i:s', $booking->date_book . ' ' . $booking->timeSlot->time_start);

            if ($request->status_id == 2 && $booking->status_id == 1) {

                if ($datetimeBooking->isFuture()) {

                    $isUpdate = true;
                    $message = 'Duyệt đơn thành công!';
                    $log .= ': Booking has been approved;';
                }
            } elseif ($request->status_id == 3 && ($booking->status_id == 1 || $booking->status_id == 2)) {

                $isUpdate = true;
                $message = 'Hủy đơn thành công!';
                $log .= ': Booking has been canceled;';
            } elseif ($request->status_id == 4) {

                if ($booking->status_id == 2 || ($booking->status_id == 1 && $datetimeBooking->isPast())) {

                    $isUpdate = true;
                    $message = 'Xác nhận thanh toán thành công!';
                    $log .= ': Booking has been paid;';
                }
            }

            if ($isUpdate) {

                $booking->status_id = $request->status_id;
                $booking->log = $log;
                $booking->save();

                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                ]);
            } else {

                return response()->json([
                    'status' => 'error',
                    'error' => 'Bạn không thể thực hiện hành động với đơn đặt sân này!',
                ]);
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }
}
