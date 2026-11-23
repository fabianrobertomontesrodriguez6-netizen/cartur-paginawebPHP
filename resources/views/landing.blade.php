@extends('layouts.app')

@section('title', 'CarTur — Concesionario 2025-2026')

@section('content')

{{-- ====== HERO MINIMALISTA ====== --}}
<section class="hero">
    {{-- Fondo: imagen B&W de auto deportivo --}}
    <div class="hero__bg"></div>
    <div class="hero__overlay"></div>

    {{-- Líneas sutiles animadas (efecto velocidad minimalista) --}}
    <div class="hero__lines"></div>

    <div class="hero__content">
        <span class="hero__eyebrow">Temporada 2025 — 2026</span>
        <h1 class="hero__title">CarTur</h1>
        <p class="hero__subtitle">
            Venta y alquiler de los automóviles más exclusivos del mundo.
            Una colección curada de siete marcas legendarias, temporada 2025-2026.
        </p>
        <div class="hero__actions">
            <a href="{{ route('catalog') }}" class="btn btn--primary btn--lg">Ver catálogo</a>
            <a href="#servicio" class="btn btn--ghost btn--lg">Conoce el servicio</a>
        </div>
    </div>

    <div class="hero__scroll">Scroll</div>
</section>

{{-- ====== SERVICIO ====== --}}
<section id="servicio" class="section">
    <div class="container">
        <div class="section__head">
            <span class="section__eyebrow">Servicio</span>
            <h2 class="section__title">Compra, renta o cambia tu auto.</h2>
            <p class="section__lead">
                Tres formas de acceder a la flota CarTur. Asesoría personalizada,
                financiamiento a tu medida y entregas en toda la ciudad.
            </p>
        </div>

        <div class="services__grid">
            <article class="service-card">
                <div class="service-card__num">01</div>
                <h3 class="service-card__title">Venta de autos nuevos</h3>
                <p class="service-card__desc">Adquiere tu auto 2025-2026 con financiamiento a tu medida. Atención personalizada, gestoría incluida y entrega inmediata.</p>
            </article>
            <article class="service-card">
                <div class="service-card__num">02</div>
                <h3 class="service-card__title">Alquiler flexible</h3>
                <p class="service-card__desc">Renta por día, semana o mes. Tarifas claras, seguro incluido y kilometraje flexible para cada necesidad.</p>
            </article>
            <article class="service-card">
                <div class="service-card__num">03</div>
                <h3 class="service-card__title">Garantía total</h3>
                <p class="service-card__desc">Todos nuestros autos cuentan con garantía de agencia y póliza de cobertura amplia durante todo el periodo de renta.</p>
            </article>
            <article class="service-card">
                <div class="service-card__num">04</div>
                <h3 class="service-card__title">Entrega exprés</h3>
                <p class="service-card__desc">Entregamos en agencia o donde nos indiques en un máximo de 48 horas después de la firma del contrato.</p>
            </article>
            <article class="service-card">
                <div class="service-card__num">05</div>
                <h3 class="service-card__title">Mantenimiento</h3>
                <p class="service-card__desc">Taller certificado por cada marca. Mantenimiento preventivo y correctivo con refacciones 100% originales.</p>
            </article>
            <article class="service-card">
                <div class="service-card__num">06</div>
                <h3 class="service-card__title">Trade-in</h3>
                <p class="service-card__desc">Entrega tu auto actual como parte de pago. Tasación gratuita en el mismo día y precio justo de mercado.</p>
            </article>
        </div>
    </div>
</section>

{{-- ====== MARCAS ====== --}}
<section id="marcas" class="section section--alt">
    <div class="container">
        <div class="section__head">
            <span class="section__eyebrow">Marcas</span>
            <h2 class="section__title">Siete casas automotrices, una colección.</h2>
            <p class="section__lead">Somos distribuidores autorizados de las marcas más reconocidas del mundo.</p>
        </div>

        <div class="brands__grid">
            @foreach (\App\Models\Brand::orderBy('name')->get() as $brand)
                <a href="{{ route('catalog', ['brand' => $brand->slug]) }}" class="brand-chip">
                    <div>
                        <div class="brand-chip__name">{{ $brand->name }}</div>
                        <div class="brand-chip__country">{{ $brand->country }}</div>
                    </div>
                    <div class="brand-chip__arrow">→</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ====== DESTACADOS ====== --}}
@if ($featured->count())
<section class="section">
    <div class="container">
        <div class="section__head">
            <span class="section__eyebrow">Selección</span>
            <h2 class="section__title">Tres piezas destacadas.</h2>
        </div>

        <div class="cards__grid">
            @foreach ($featured as $car)
                @include('components.car_card')
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ====== CTA FINAL ====== --}}
<section class="section section--alt">
    <div class="container" style="text-align:center;">
        <div class="section__head section__head--center">
            <span class="section__eyebrow">Catálogo</span>
            <h2 class="section__title">Explora los 28 modelos.</h2>
            <p class="section__lead">Cada auto con ficha técnica completa, precios de venta y alquiler, e imágenes en alta resolución.</p>
            <a href="{{ route('catalog') }}" class="btn btn--primary btn--lg" style="margin-top:24px;">Ir al catálogo →</a>
        </div>
    </div>
</section>

@endsection
