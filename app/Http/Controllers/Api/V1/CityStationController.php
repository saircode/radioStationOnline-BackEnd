<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CityStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\V1\CityStationResource;

class CityStationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citiesStations = CityStationResource::collection(CityStation::latest()->get());
        return response($citiesStations , 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|unique:city_stations|max:255',
            'url_live_audio' => 'required|unique:city_stations|url',
        ]);
         

        if ($validated->fails()) {
            return response ( [
                'status_code'=> 422,
                'message'=> $validated->errors()
            ] ,  422);
        }

        $cityStation=new CityStation($request->all());
        $cityStation->save();

        return response([
            'status_code'=> 201,
            'message'=> 'Successful registration'
        ] , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cityStation = CityStation::find($id);

        if(!$cityStation) return response([
            'status_code'=>404,
            'message'=> 'Not found'
        ] , 404);

        $cityStation = new CityStationResource($cityStation);
        return response( $cityStation , 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CityStation $cityStation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CityStation $cityStation)
    {
        //
    }
}
