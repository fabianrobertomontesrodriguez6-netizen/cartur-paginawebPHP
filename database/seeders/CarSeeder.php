<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ===== FORD =====
            'ford' => [
                ['model' => 'Mustang GT 2026',          'year' => 2026, 'sale_price' =>  1850000, 'rental_price' => 4500, 'fuel_type' => 'Gasolina',    'transmission' => 'Manual 6 velocidades',  'horsepower' => 480, 'top_speed' => 250, 'description' => 'El icónico muscle car con motor V8 5.0L y diseño agresivo.'],
                ['model' => 'F-150 Raptor 2025',         'year' => 2025, 'sale_price' => 2200000, 'rental_price' => 5200, 'fuel_type' => 'Gasolina',    'transmission' => 'Automática 10 velocidades','horsepower' => 450, 'top_speed' => 220, 'description' => 'Pick-up todoterreno con motor V6 EcoBoost 3.5L de alto rendimiento.'],
                ['model' => 'Explorer ST 2026',          'year' => 2026, 'sale_price' => 1350000, 'rental_price' => 3800, 'fuel_type' => 'Gasolina',    'transmission' => 'Automática 10 velocidades','horsepower' => 400, 'top_speed' => 210, 'description' => 'SUV deportiva de 3 filas con motor V6 3.0L EcoBoost.'],
                ['model' => 'Bronco Wildtrak 2025',      'year' => 2025, 'sale_price' => 1580000, 'rental_price' => 4100, 'fuel_type' => 'Gasolina',    'transmission' => 'Automática 10 velocidades','horsepower' => 330, 'top_speed' => 180, 'description' => 'SUV todoterreno con tracción 4x4 y capacidad off-road extrema.'],
            ],
            // ===== LAMBORGHINI =====
            'lamborghini' => [
                ['model' => 'Huracán EVO 2025',          'year' => 2025, 'sale_price' => 9500000, 'rental_price' => 22000, 'fuel_type' => 'Gasolina',   'transmission' => 'Automática DCT 7 velocidades','horsepower' => 640, 'top_speed' => 325, 'description' => 'V10 aspirado con diseño italiano y manejo extremo en pista.'],
                ['model' => 'Revuelto 2026',             'year' => 2026, 'sale_price' => 14500000,'rental_price' => 35000, 'fuel_type' => 'Híbrido',     'transmission' => 'Automática DCT 8 velocidades','horsepower' => 1015,'top_speed' => 350, 'description' => 'Primer HPEV (V12 + híbrido) de la marca, sucesor del Aventador.'],
                ['model' => 'Urus Performante 2025',     'year' => 2025, 'sale_price' => 8800000, 'rental_price' => 20000, 'fuel_type' => 'Gasolina',    'transmission' => 'Automática 8 velocidades',  'horsepower' => 666, 'top_speed' => 305, 'description' => 'Super-SUV con motor V8 biturbo 4.0L y tracción integral.'],
                ['model' => 'Aventador SVJ 2026',        'year' => 2026, 'sale_price' => 17800000,'rental_price' => 42000, 'fuel_type' => 'Gasolina',    'transmission' => 'Automática ISR 7 velocidades','horsepower' => 770, 'top_speed' => 350, 'description' => 'V12 aspirado con aerodinámica ALA de última generación.'],
            ],
            // ===== BMW =====
            'bmw' => [
                ['model' => 'M3 Competition 2026',       'year' => 2026, 'sale_price' => 2850000, 'rental_price' => 6500, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática M Steptronic 8','horsepower' => 503, 'top_speed' => 290, 'description' => 'Sedán deportivo con motor 6 cilindros en línea 3.0L biturbo.'],
                ['model' => 'X5 M 2025',                 'year' => 2025, 'sale_price' => 3950000, 'rental_price' => 8800, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática M Steptronic 8','horsepower' => 617, 'top_speed' => 285, 'description' => 'SUV de alto rendimiento con motor V8 4.4L M TwinPower.'],
                ['model' => 'M5 CS 2026',                'year' => 2026, 'sale_price' => 5200000, 'rental_price' => 11500, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática M Steptronic 8','horsepower' => 627, 'top_speed' => 305, 'description' => 'Sedán ejecutivo más potente de BMW, V8 4.4L biturbo.'],
                ['model' => 'i8 Roadster 2025',          'year' => 2025, 'sale_price' => 4100000, 'rental_price' => 9200, 'fuel_type' => 'Híbrido enchufable','transmission' => 'Automática 6 velocidades','horsepower' => 369, 'top_speed' => 250, 'description' => 'Deportivo híbrido con motor 3 cilindros 1.5L y motor eléctrico.'],
            ],
            // ===== FERRARI =====
            'ferrari' => [
                ['model' => 'SF90 Stradale 2026',        'year' => 2026, 'sale_price' => 12500000,'rental_price' => 30000, 'fuel_type' => 'Híbrido',    'transmission' => 'Automática DCT 8 velocidades','horsepower' => 986, 'top_speed' => 340, 'description' => 'Híbrido enchufable V8 con 3 motores eléctricos, primer superdeportivo de la serie.'],
                ['model' => 'Roma 2025',                 'year' => 2025, 'sale_price' => 7800000, 'rental_price' => 18000, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática DCT 8 velocidades','horsepower' => 612, 'top_speed' => 320, 'description' => 'Gran turismo con motor V8 3.9L turbocomprimido y diseño elegante.'],
                ['model' => '296 GTB 2026',              'year' => 2026, 'sale_price' => 9200000, 'rental_price' => 22000, 'fuel_type' => 'Híbrido',      'transmission' => 'Automática DCT 8 velocidades','horsepower' => 819, 'top_speed' => 330, 'description' => 'V6 biturbo híbrido con 165 CV eléctricos adicionales.'],
                ['model' => 'F8 Tributo 2025',           'year' => 2025, 'sale_price' => 10500000,'rental_price' => 25000, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática DCT 7 velocidades','horsepower' => 710, 'top_speed' => 340, 'description' => 'V8 biturbo 3.9L con tributo al legendario F40.'],
            ],
            // ===== AORUS =====
            'aorus' => [
                ['model' => 'Aorus GT-X 2026',           'year' => 2026, 'sale_price' => 4800000, 'rental_price' => 10500, 'fuel_type' => 'Híbrido',    'transmission' => 'Automática DCT 8 velocidades','horsepower' => 720, 'top_speed' => 320, 'description' => 'Coupé híbrido de alta performance con tracción integral inteligente.'],
                ['model' => 'Aorus Stealth 2025',        'year' => 2025, 'sale_price' => 6200000, 'rental_price' => 14000, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática DCT 7 velocidades','horsepower' => 850, 'top_speed' => 345, 'description' => 'Hiperauto con diseño aerodinámico de fibra de carbono.'],
                ['model' => 'Aorus Volt EV 2026',         'year' => 2026, 'sale_price' => 5600000, 'rental_price' => 12500, 'fuel_type' => 'Eléctrico',    'transmission' => 'Automática 1 velocidad',     'horsepower' => 760, 'top_speed' => 305, 'description' => 'Superdeportivo 100% eléctrico con 0-100 km/h en 2.4 segundos.'],
                ['model' => 'Aorus Master X 2025',        'year' => 2025, 'sale_price' => 5400000, 'rental_price' => 12000, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática DCT 8 velocidades','horsepower' => 800, 'top_speed' => 335, 'description' => 'Sedán ejecutivo performance con motor V8 biturbo y sistema Aorus AI.'],
            ],
            // ===== MERCEDES-BENZ =====
            'mercedes-benz' => [
                ['model' => 'AMG GT 63 S 2026',          'year' => 2026, 'sale_price' => 6500000, 'rental_price' => 14500, 'fuel_type' => 'Gasolina',   'transmission' => 'Automática AMG SPEEDSHIFT 9','horsepower' => 630, 'top_speed' => 315, 'description' => 'Coupé deportivo con motor V8 4.0L biturbo firmado por AMG.'],
                ['model' => 'Clase S 580 2025',          'year' => 2025, 'sale_price' => 5800000, 'rental_price' => 13000, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática 9G-TRONIC',       'horsepower' => 496, 'top_speed' => 250, 'description' => 'Sedán de lujo con motor 6 en línea 3.0L Mild Hybrid.'],
                ['model' => 'G 63 AMG 2026',             'year' => 2026, 'sale_price' => 8200000, 'rental_price' => 19000, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática AMG SPEEDSHIFT 9','horsepower' => 585, 'top_speed' => 240, 'description' => 'Todoterreno de lujo con motor V8 4.0L biturbo AMG.'],
                ['model' => 'EQS 580 2025',              'year' => 2025, 'sale_price' => 6900000, 'rental_price' => 15500, 'fuel_type' => 'Eléctrico',    'transmission' => 'Automática 1 velocidad',     'horsepower' => 516, 'top_speed' => 210, 'description' => 'Sedán eléctrico buque insignia con autonomía de 700 km.'],
            ],
            // ===== AUDI =====
            'audi' => [
                ['model' => 'R8 V10 Performance 2026',   'year' => 2026, 'sale_price' => 6800000, 'rental_price' => 16000, 'fuel_type' => 'Gasolina',   'transmission' => 'Automática S tronic 7',     'horsepower' => 620, 'top_speed' => 330, 'description' => 'Último superdeportivo de Audi con motor V10 5.2L aspirado.'],
                ['model' => 'RS7 Sportback 2025',        'year' => 2025, 'sale_price' => 4900000, 'rental_price' => 11000, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática Tiptronic 8',     'horsepower' => 591, 'top_speed' => 305, 'description' => 'Gran turismo 4 puertas con motor V8 4.0L TFSI biturbo.'],
                ['model' => 'Q7 RS 2026',                'year' => 2026, 'sale_price' => 4600000, 'rental_price' => 10500, 'fuel_type' => 'Gasolina',     'transmission' => 'Automática Tiptronic 8',     'horsepower' => 591, 'top_speed' => 280, 'description' => 'SUV deportivo con tracción Quattro y motor V8 biturbo.'],
                ['model' => 'e-tron GT 2025',            'year' => 2025, 'sale_price' => 5500000, 'rental_price' => 12500, 'fuel_type' => 'Eléctrico',    'transmission' => 'Automática 2 velocidades',   'horsepower' => 522, 'top_speed' => 245, 'description' => 'Gran turismo eléctrico con tracción integral Quattro.'],
            ],
        ];

        foreach ($data as $slug => $cars) {
            $brand = Brand::where('slug', $slug)->first();
            if (! $brand) {
                continue;
            }

            foreach ($cars as $car) {
                // Genera el nombre del archivo de imagen.
                // Si el modelo empieza con el nombre de la marca (ej: "Aorus GT-X 2026"),
                // no duplicamos el prefijo de marca.
                $modelLower = strtolower(str_replace([' ', '.', '/'], '-', $car['model']));
                $brandPrefix = $slug . '-';
                if (str_starts_with($modelLower, $slug . '-')) {
                    $imageFile = $modelLower . '.png';
                } else {
                    $imageFile = $brandPrefix . $modelLower . '.png';
                }

                Car::updateOrCreate(
                    ['brand_id' => $brand->id, 'model' => $car['model']],
                    array_merge($car, [
                        'is_available' => true,
                        'image'        => 'images/cars/' . $imageFile,
                    ])
                );
            }
        }
    }
}
