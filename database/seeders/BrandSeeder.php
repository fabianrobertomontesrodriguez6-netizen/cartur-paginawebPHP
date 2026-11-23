<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name'        => 'Ford',
                'slug'        => 'ford',
                'country'     => 'Estados Unidos',
                'description' => 'Marca estadounidense fundada en 1903, sinónimo de robustez y tradición automotriz.',
            ],
            [
                'name'        => 'Lamborghini',
                'slug'        => 'lamborghini',
                'country'     => 'Italia',
                'description' => 'Fabricante italiano de superdeportivos fundado en 1963 en Sant\'Agata Bolognese.',
            ],
            [
                'name'        => 'BMW',
                'slug'        => 'bmw',
                'country'     => 'Alemania',
                'description' => 'Marca alemana reconocida por su equilibrio entre deportividad y lujo.',
            ],
            [
                'name'        => 'Ferrari',
                'slug'        => 'ferrari',
                'country'     => 'Italia',
                'description' => 'Legendario fabricante italiano de superdeportivos con sede en Maranello.',
            ],
            [
                'name'        => 'Aorus',
                'slug'        => 'aorus',
                'country'     => 'Internacional',
                'description' => 'Marca de alta performance con diseños de vanguardia y tecnología híbrida.',
            ],
            [
                'name'        => 'Mercedes-Benz',
                'slug'        => 'mercedes-benz',
                'country'     => 'Alemania',
                'description' => 'Marca alemana de lujo y referencia mundial en confort e innovación.',
            ],
            [
                'name'        => 'Audi',
                'slug'        => 'audi',
                'country'     => 'Alemania',
                'description' => 'Fabricante alemán que combina diseño sofisticado con tracción Quattro.',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['slug' => $brand['slug']], $brand);
        }
    }
}
