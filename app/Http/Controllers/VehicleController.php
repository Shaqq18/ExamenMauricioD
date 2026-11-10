<?php

namespace App\Http\Controllers;
use App\Models\Vehicle;

use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('vehicles.index', compact('vehicles'));
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|unique:vehicles|max:15',
            'brand' => 'required|max:50',
            'model' => 'required|max:80',
            'vehicle_type' => 'required|max:50',
            'color' => 'required|max:30',
            'capacity' => 'required|integer',
            'daily_rate' => 'required|numeric',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')
                         ->with('success', 'Vehicle created successfully.');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'plate_number' => 'required|unique:vehicles,plate_number,' . $vehicle->id . '|max:15',
            'brand' => 'required|max:50',
            'model' => 'required|max:80',
            'vehicle_type' => 'required|max:50',
            'color' => 'required|max:30',
            'capacity' => 'required|integer',
            'daily_rate' => 'required|numeric',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('vehicles.index')
                         ->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
                         ->with('success', 'Vehicle deleted successfully.');
    }

}
