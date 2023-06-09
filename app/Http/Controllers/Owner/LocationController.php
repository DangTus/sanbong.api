<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Models\Location;
use App\Models\LocationStatus;

class LocationController extends Controller
{
    public function allStatus()
    {
        $listLocationStatus = LocationStatus::all();

        return response()->json([
            'status' => 'success',
            'data' => $listLocationStatus
        ]);
    }

    public function locationByOwner(Request $request)
    {
        if (!$request->has(['owner_id'])) {

            return response()->json([
                'status' => 'error',
                'data' => null,
                'error' => 'Missing parameter passed!'
            ]);
        }

        $location = Location::where('owner_id', $request->owner_id)->first();

        if ($location) {

            return response()->json([
                'status' => 'success',
                'data' => $location
            ]);
        } else {

            return response()->json([
                'status' => 'failed',
                'message' => 'Cannot find location'
            ]);
        }
    }

    public function updateLocation(Request $req)
    {
        if ($req->has(['location_id', 'name', 'description', 'time_open', 'time_close', 'ward_id', 'address', 'status_id']) && $req->hasFile('images')) {

            // Find location by location_id
            $location = Location::where('id', $req->location_id)->first();

            // Delete image old
            $listImageName = json_decode($location->image);
            foreach ($listImageName as $imageName) {
                $imagePath = public_path('/imgs/location') . '/' . $imageName;

                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // Set image new
            $listImage = [];
            foreach ($req->file('images') as $index => $image) {

                $name = 'location-' . str()->slug($location->name) . '-' .  ($index + 1) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/imgs/location');

                $image->move($destinationPath, $name);

                array_push($listImage, $name);
            }
            $listImageStr = json_encode($listImage);

            // Update location
            $location->name = $req->name;
            $location->description = $req->description;
            $location->image = $listImageStr;
            $location->time_open = $req->time_open;
            $location->time_close = $req->time_close;
            $location->ward_id = $req->ward_id;
            $location->address = $req->address;
            $location->link_map = $req->input('link_map');
            $location->status_id = $req->status_id;

            $location->save();

            // return json to client
            return response()->json([
                'status' => 'success',
                'msg' => 'Cập nhật thông tin địa điểm thành công!'
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
