@extends('layouts.app')

@section('title', $car->brand->name . ' ' . $car->model . ' — CarTur')

@section('content')

<section class="detail">
    <div class="container">
        <a href="{{ route('catalog', ['brand' => $car->brand->slug]) }}" class="back-link">← Volver al catálogo</a>

        <div class="detail__main">

            <div class="detail__image">
                <img src="{{ $car->image ? asset($car->image) : asset('images/hero/hero-bg.png') }}"
                     alt="{{ $car->brand->name }} {{ $car->model }}">
                <span class="detail__year">{{ $car->year }}</span>
            </div>

            <div class="detail__info">
                <span class="detail__brand">{{ $car->brand->name }} · {{ $car->brand->country }}</span>
                <h1 class="detail__title">{{ $car->model }}</h1>
                <p class="detail__desc">{{ $car->description }}</p>

                <div class="detail__specs">
                    <div class="spec">
                        <span class="spec__label">Potencia</span>
                        <span class="spec__value">{{ $car->horsepower }} HP</span>
                    </div>
                    <div class="spec">
                        <span class="spec__label">Vel. máxima</span>
                        <span class="spec__value">{{ $car->top_speed }} km/h</span>
                    </div>
                    <div class="spec">
                        <span class="spec__label">Combustible</span>
                        <span class="spec__value">{{ $car->fuel_type }}</span>
                    </div>
                    <div class="spec">
                        <span class="spec__label">Transmisión</span>
                        <span class="spec__value">{{ $car->transmission }}</span>
                    </div>
                </div>

                <div class="detail__prices">
                    <div class="price-box">
                        <span class="price__label">Precio de venta</span>
                        <span class="price__value">{{ $car->formatted_sale_price }}</span>
                        <span class="price__note">Incluye gestoría y entrega</span>
                    </div>
                    <div class="price-box">
                        <span class="price__label">Alquiler</span>
                        <span class="price__value">{{ $car->formatted_rental_price }}</span>
                        <span class="price__note">Seguro y kilometraje incluidos</span>
                    </div>
                </div>

                <div class="detail__actions">
                    <button class="btn btn--primary btn--lg js-contact" data-car="{{ $car->brand->name }} {{ $car->model }}">Solicitar cotización</button>
                    <button class="btn btn--ghost btn--lg js-test" data-car="{{ $car->brand->name }} {{ $car->model }}">Agendar prueba</button>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.js-contact, .js-test').forEach(btn => {
        btn.addEventListener('click', () => {
            const action = btn.classList.contains('js-test') ? 'prueba de manejo' : 'cotización';
            alert('Solicitud de ' + action + ':\n' + btn.dataset.car + '\n\nWhatsApp: +52 55 1234 5678');
        });
    });
</script>
@endpush
