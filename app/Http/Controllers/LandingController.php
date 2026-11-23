<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Muestra la página de aterrizaje con información del servicio.
     */
    public function index()
    {
        $totalBrands = Brand::count();
        $totalCars   = Car::count();
        $featured    = Car::with('brand')
            ->where('is_available', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('landing', [
            'totalBrands' => $totalBrands,
            'totalCars'   => $totalCars,
            'featured'    => $featured,
        ]);
    }
}
