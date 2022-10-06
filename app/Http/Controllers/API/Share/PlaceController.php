<?php

namespace App\Http\Controllers\API\Share;
use App\Http\Controllers\Controller;

use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;

class PlaceController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProvinces(Request $request)
    {
        $provinces = Province::get();

        return $this->successResponse(
            $provinces,
            null,
            200
        );
    }
    public function getDistricts(Request $request, $id)
    {
        $provinces = Province::find($id);
        if(!$provinces)
        return $this->errorResponse(
            "Tỉnh/Thành phố không tồn tại",
            403
        );

        $districts = $provinces->districts;

        return $this->successResponse(
            $districts,
            null,
            200
        );
    }
    public function getWards(Request $request, $id)
    {
        $districts = District::find($id);
        if(!$districts)
        return $this->errorResponse(
            "Quận/Huyện không tồn tại",
            403
        );

        $wards = $districts->wards;

        return $this->successResponse(
            $wards,
            null,
            200
        );
    }
}
