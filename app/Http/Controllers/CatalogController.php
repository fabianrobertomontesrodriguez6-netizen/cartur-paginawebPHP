<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Muestra el catálogo de autos agrupado por marca.
     * Si se recibe ?brand=slug se filtra por esa marca.
     */
    public function index(Request $request)
    {
        $brands = Brand::with(['cars' => function ($q) {
            $q->orderBy('year', 'desc')->orderBy('model');
        }])->ordered()->get();

        $selectedSlug = $request->query('brand', $brands->first()->slug ?? null);

        $selectedBrand = $brands->firstWhere('slug', $selectedSlug);

        // Si se solicitó una marca concreta, sólo mostramos sus autos en el panel principal
        if ($selectedBrand) {
            $cars = $selectedBrand->cars;
        } else {
            $cars = collect();
        }

        return view('catalog', [
            'brands'        => $brands,
            'selectedBrand' => $selectedBrand,
            'cars'          => $cars,
        ]);
    }

    /**
     * Muestra el detalle de un auto en concreto.
     */
    public function show(Car $car)
    {
        $car->load('brand');

        return view('car_detail', [
            'car' => $car,
        ]);
    }
}
