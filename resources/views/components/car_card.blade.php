@php
    $imagePath = $car->image ? asset($car->image) : asset('images/hero/hero-bg.png');
@endphp

<article class="car-card">
    <div class="car-card__image">
        <img src="{{ $imagePath }}" alt="{{ $car->brand->name }} {{ $car->model }}" loading="lazy">
        <span class="car-card__year">{{ $car->year }}</span>
        <span class="car-card__status {{ $car->is_available ? 'is-available' : 'is-rented' }}">
            {{ $car->is_available ? 'Disponible' : 'Reservado' }}
        </span>
    </div>

    <div class="car-card__body">
        <span class="car-card__brand">{{ $car->brand->name }}</span>
        <h3 class="car-card__title">{{ $car->model }}</h3>

        <div class="car-card__specs">
            <span><strong>{{ $car->horsepower }}</strong>HP</span>
            <span><strong>{{ $car->top_speed }}</strong>km/h</span>
            <span><strong>{{ $car->fuel_type }}</strong></span>
        </div>

        <p class="car-card__desc">{{ Str::limit($car->description, 90) }}</p>

        <div class="car-card__prices">
            <div>
                <span class="price__label">Venta</span>
                <span class="price__value">{{ $car->formatted_sale_price }}</span>
            </div>
            <div>
                <span class="price__label">Alquiler</span>
                <span class="price__value">{{ $car->formatted_rental_price }}</span>
            </div>
        </div>

        <div class="car-card__actions">
            <a href="{{ route('catalog.show', $car) }}" class="btn btn--ghost btn--sm">Ver ficha</a>
            <button class="btn btn--primary btn--sm js-contact" data-car="{{ $car->brand->name }} {{ $car->model }}">Cotizar</button>
        </div>
    </div>
</article>
