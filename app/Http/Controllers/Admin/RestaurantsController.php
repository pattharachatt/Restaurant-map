<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Day;
use App\Models\Restaurant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyShopRequest;
use App\Http\Requests\StoreRestaurantsRequest;
use App\Http\Requests\MassDestroyRestaurantsRequest;
use App\Http\Requests\UpdateRestaurantsRequest;

class RestaurantsController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        $categories = Category::all()->pluck('name', 'id');
        $days = Day::all();

        return view('admin.restaurants.create', compact('categories', 'days'));
    }

    public function store(StoreRestaurantsRequest $request)
    {
        $restaurants = Restaurant::create($request->all());
        $restaurants->categories()->sync($request->input('categories', []));
            $hours = collect($request->input('from_hours'))->mapWithKeys(function($value, $id) use ($request) {
            return $value ? [ 
                    $id => [
                        'from_hours'    => $value, 
                        'from_minutes'  => $request->input('from_minutes.'.$id), 
                        'to_hours'      => $request->input('to_hours.'.$id),
                        'to_minutes'    => $request->input('to_minutes.'.$id)
                    ]
                ] 
                : [];
        });
        $restaurants->days()->sync($hours);

        return redirect()->route('admin.restaurants.index');
    }


    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return back();
    }

    public function massDestroy(MassDestroyRestaurantsRequest $request)
    {
        Restaurant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function show(Restaurant $restaurant)
    {
        $days = Day::all();
        $restaurant->load('categories', 'created_by');

        return view('admin.restaurants.show', compact('restaurant', 'days'));
    }

    public function edit(Restaurant $restaurant)
    {
        $categories = Category::all()->pluck('name', 'id');
        $days = Day::all();

        $restaurant->load('categories', 'created_by', 'days');

        return view('admin.restaurants.edit', compact('categories', 'restaurant', 'days'));
    }

    public function update(UpdateRestaurantsRequest $request, Restaurant $restaurant)
    {
        if(!$request->active){
            $request->merge([
                'active' => 0
            ]);
        }
        $restaurant->update($request->all());
        $restaurant->categories()->sync($request->input('categories', []));

        $hours = collect($request->input('from_hours'))->mapWithKeys(function($value, $id) use ($request) {
            return $value ? [ 
                    $id => [
                        'from_hours'    => $value, 
                        'from_minutes'  => $request->input('from_minutes.'.$id), 
                        'to_hours'      => $request->input('to_hours.'.$id),
                        'to_minutes'    => $request->input('to_minutes.'.$id)
                    ]
                ] 
                : [];
        });
        $restaurant->days()->sync($hours);

        return redirect()->route('admin.restaurants.index');
    }
}
