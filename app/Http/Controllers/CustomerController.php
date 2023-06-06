<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use App\Models\User;

class CustomerController extends Controller
{
    public function getById(Request $request)
    {
        if ($request->has(['customer_id'])) {

            try {

                $customer = User::where('id', $request->customer_id)
                    ->where('role_id', 1)
                    ->where('status_id', 2)
                    ->first();

                if ($customer) {

                    return response()->json([
                        'status' => 'success',
                        'data' => $customer
                    ]);
                } else {

                    return response()->json([
                        'status' => 'error',
                        'message' => 'Cannot find customer!'
                    ]);
                }
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
        try {

            if (!$request->has(['customer_id'])) {

                return response()->json([
                    'status' => 'error',
                    'data' => null,
                    'error' => 'Missing parameter passed!'
                ]);
            }

            // Get customer information
            $customer = User::where('id', $request->customer_id)
                ->where('role_id', 1)
                ->where('status_id', 2)
                ->first();

            if (!$customer) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Cannot find customer!'
                ]);
            }

            // validate
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'dob' => 'required | date_format:Y-m-d',
                'phone_number' => 'required|regex:/^[0-9]{10,15}$/',
                'ward_id' => 'required',
                'status_id' => 'required'
            ], [
                'name.required' => 'Tên không được để trống',
                'dob.required' => 'Ngày sinh không được để trống',
                'dob.date_format' => 'Ngày sinh phải đúng định dạng Y-m-d',
                'phone_number.required' => 'Số điện thoại không được để trống',
                'phone_number.regex' => 'Vui lòng nhập đúng số điện thoại của bạn',
                'ward_id.required' => 'Vui lòng chọn Phường/Xã',
                'status_id.required' => 'Vui lòng chọn trạng thái cho tài khoản của bạn'
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => 'error_validate',
                    'data' => null,
                    'error' => $validator->errors()
                ]);
            }

            // Update image
            if ($request->hasFile('image')) {

                // Delete old image
                $imagePath = public_path('/imgs/user') . '/' . $customer->image;
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }

                // Add new image to filesystem
                $imageFile = $request->file('image');
                $imageName = 'user-' . str()->slug($customer->name) . '-' . time() . '.' . $imageFile->getClientOriginalExtension();
                $destinationPath = public_path('/imgs/user');
                $imageFile->move($destinationPath, $imageName);

                $customer->image = $imageName;
            } else {

                $customer->image = null;
            }

            // Update data
            $customer->name = $request->name;
            $customer->dob = $request->dob;
            $customer->phone_number = $request->phone_number;
            $customer->ward_id = $request->ward_id;
            $customer->address = $request->input('address');
            $customer->status_id = $request->status_id;
            $customer->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin tài khoản thành công'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }
}
