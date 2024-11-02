<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cities = City::with('country')->select('cities.*');
            return DataTables::of($cities)
                ->addColumn('actions', function ($city) {
                    return view('admin-panel.cities.partials.actions', compact('city'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    
        return view('admin-panel.cities.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin-panel.cities.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);

        City::create($request->all());

        return redirect()->route('cities.index')->with('success', 'City created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $countries = Country::all();
        return view('admin-panel.cities.edit', compact('city', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);

        $city->update($request->all());

        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
    }

    public function getCitiesByCountry(Request $request, $countryId)
    {
        $query = City::where('country_id', $countryId);
    
        if ($request->has('q') && $request->q != '') {
            $query->where('name', 'like', '%' . $request->q . '%');
        } else {
            // Return random cities if no search term is provided
            $query->inRandomOrder();
        }
    
        $cities = $query->paginate(30); // 30 items per page
        return response()->json($cities);
    }
}
