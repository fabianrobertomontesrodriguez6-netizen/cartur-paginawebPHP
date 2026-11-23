@extends('layouts.app')

@section('title', 'Catálogo — CarTur')

@section('content')

<section class="catalog-header">
    <div class="container">
        <span class="section__eyebrow">Catálogo completo</span>
        <h1 class="catalog-header__title">Los 28 modelos.</h1>
        <p class="catalog-header__lead">
            Explora todos los autos 2025-2026 disponibles para venta y alquiler.
            Filtra por marca y consulta ficha técnica, precios e imágenes en alta resolución.
        </p>
    </div>
</section>

<section class="catalog">
    <div class="container">

        {{-- Barra de tareas por marca --}}
        <nav class="brand-bar" aria-label="Marcas">
            <ul class="brand-bar__list">
                @foreach ($brands as $brand)
                    <li>
                        <a href="{{ route('catalog', ['brand' => $brand->slug]) }}"
                           class="brand-bar__link {{ $selectedBrand && $selectedBrand->slug === $brand->slug ? 'is-active' : '' }}">
                            <span>{{ $brand->name }}</span>
                            <span class="brand-bar__count">{{ $brand->cars->count() }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        @if ($selectedBrand)
            <div class="brand-header">
                <div>
                    <h2 class="brand-header__title">{{ $selectedBrand->name }}</h2>
                    <p class="brand-header__country">{{ $selectedBrand->country }}</p>
                </div>
                <p class="brand-header__desc">{{ $selectedBrand->description }}</p>
            </div>

            <div class="cards__grid">
                @forelse ($cars as $car)
                    @include('components.car_card')
                @empty
                    <div class="empty-state">
                        <h3>No hay modelos disponibles para esta marca.</h3>
                        <p>Vuelve pronto, estamos actualizando el inventario.</p>
                    </div>
                @endforelse
            </div>
        @else
            <div class="empty-state">
                <h3>No se encontraron marcas.</h3>
                <p>Ejecuta <code>php artisan migrate:fresh --seed</code> para llenar la base de datos.</p>
            </div>
        @endif

    </div>
</section>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.js-contact').forEach(btn => {
        btn.addEventListener('click', () => {
            alert('Cotización: ' + btn.dataset.car + '\n\nTe contactaremos al WhatsApp: +52 55 1234 5678');
        });
    });
</script>
@endpush
