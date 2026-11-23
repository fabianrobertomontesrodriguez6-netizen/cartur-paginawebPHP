# 📖 Guía de desarrollo — CarTur (Laravel 11)

Documento que explica **tarea por tarea** qué se hizo, en qué archivo y **por qué** se tomó cada decisión técnica.

---

## Tarea 1 — Configuración base del proyecto Laravel

**Archivos creados:**

- `composer.json`
- `.env.example`
- `.gitignore`
- `artisan`
- `bootstrap/app.php`
- `package.json`
- `vite.config.js`
- `phpunit.xml`

**Por qué:**

> Laravel 11 trae un `bootstrap/app.php` minimalista que centraliza la configuración de routing, middleware y excepciones. Lo dejé con las rutas web cargadas desde `routes/web.php` y el endpoint `/up` para chequeo de salud.  
> El `.env.example` define SQLite como base de datos por defecto (`DB_CONNECTION=sqlite`) porque así el usuario no tiene que instalar ni configurar MySQL para arrancar el proyecto en VSCode; sólo corre `php artisan migrate --seed` y listo.  
> El `composer.json` fija Laravel `^11.0` y PHP `^8.2` (requisito mínimo actual). Incluí `laravel/tinker` para depuración interactiva.

---

## Tarea 2 — Modelos de dominio: `Brand` y `Car`

**Archivos creados:**

- `app/Models/Brand.php`
- `app/Models/Car.php`

**Por qué:**

> El negocio tiene dos entidades centrales:
>
> - **Brand**: representa una marca (Ford, Lamborghini, etc.) con país de origen y descripción.
> - **Car**: representa un modelo específico de una marca, con año, precios,specs técnicas y disponibilidad.
>
> La relación es **1:N** (una marca tiene muchos autos), expresada en `Brand::cars()` (`HasMany`) y `Car::brand()` (`BelongsTo`).  
> En `Car` agregué dos **accessors** (`getFormattedSalePriceAttribute` y `getFormattedRentalPriceAttribute`) para que las vistas reciban el precio formateado en MXN sin lógica repetida en Blade.  
> Usé `$casts` para que `sale_price` y `rental_price` vengan como `decimal:2`, y `is_available` como `boolean` (esto evita errores cuando el valor llega como 0/1 desde la BD).

---

## Tarea 3 — Migraciones de base de datos

**Archivos creados:**

- `database/migrations/2025_01_01_000001_create_brands_table.php`
- `database/migrations/2025_01_01_000002_create_cars_table.php`
- `database/migrations/2025_01_01_000003_create_cache_table.php`
- `database/migrations/2025_01_01_000004_create_sessions_table.php`

**Por qué:**

> Las migraciones describen el esquema SQL de forma portable. `brands` y `cars` son las tablas del dominio; las de `cache` y `sessions` se incluyen porque el `.env` usa `database` como driver de cache y sesión, así el proyecto funciona 100% sin Redis.  
> `cars.brand_id` es **foreign key** con `cascadeOnDelete`, de modo que al borrar una marca se borran sus autos y no quedan registros huérfanos.  
> `cars.sale_price` es `decimal(12,2)` para soportar montos hasta 99,999,999,999.99 MXN (necesario porque hay Lamborghini y Ferrari que superan los 17 millones).

---

## Tarea 4 — Seeders con datos reales de marcas y modelos 2025-2026

**Archivos creados:**

- `database/seeders/BrandSeeder.php`
- `database/seeders/CarSeeder.php`
- `database/seeders/DatabaseSeeder.php`

**Por qué:**

> El usuario pidió **7 marcas**: Ford, Lamborghini, BMW, Ferrari, Aorus, Mercedes-Benz y "alguna otra". Añadí **Audi** como la marca adicional porque es una de las más representativas del segmento premium alemán.  
> `BrandSeeder` usa `updateOrCreate` por `slug` para que el seeder sea **idempotente** (se puede correr varias veces sin duplicar).  
> `CarSeeder` carga 4 modelos por marca (28 autos en total), cada uno con:
>
> - `model` (nombre comercial completo con el año)
> - `year` (2025 o 2026 según la temporada pedida)
> - `sale_price` en MXN con cifras realistas de mercado
> - `rental_price` por día, proporcional al precio del auto
> - Specs técnicas: `fuel_type`, `transmission`, `horsepower`, `top_speed`
> - `description` con datos reales del modelo (motor, configuración, etc.)
>
> Los precios y specs se basaron en información pública de cada marca para que el catálogo sea verosímil. **Aorus** no es una marca de autos real, así que inventé 4 modelos coherentes con el branding de alto performance (GT-X, Stealth, Volt EV, Master X).

---

## Tarea 5 — Controladores HTTP

**Archivos creados:**

- `app/Http/Controllers/Controller.php` (base abstracta)
- `app/Http/Controllers/LandingController.php`
- `app/Http/Controllers/CatalogController.php`

**Por qué:**

> **`LandingController::index`** envía a la vista de aterrizaje las estadísticas (total de marcas, total de autos) y 3 autos destacados aleatorios para una sección "Selección CarTur". El `inRandomOrder()` hace que cada recarga muestre autos distintos.  
> **`CatalogController::index`** recibe `?brand=slug` por query string y filtra los autos de esa marca. Carga todas las marcas con sus autos **eager-loaded** (`Brand::with(['cars' => ...])`) para evitar el problema N+1: si cargamos 7 marcas con 4 autos cada una, haríamos 8 queries en vez de 1+7. La marca por defecto es la primera alfabéticamente para que el catálogo nunca se vea vacío.  
> **`CatalogController::show`** usa **route-model-binding** (`Car $car`) para que Laravel resuelva el auto por ID automáticamente; esto ahorra escribir `Car::findOrFail($id)`.

---

## Tarea 6 — Rutas web

**Archivo creado:**

- `routes/web.php`

**Por qué:**

> Solo 3 rutas, todas con nombre para usar `route()` en Blade:
>
> | URL | Nombre | Controlador |
> |-----|--------|-------------|
> | `/` | `landing` | `LandingController::index` |
> | `/catalogo` | `catalog` | `CatalogController::index` |
> | `/catalogo/{car}` | `catalog.show` | `CatalogController::show` |
>
> Usar nombres de ruta (`route('catalog')`) en lugar de URLs hardcodeadas permite cambiar la URL sin tocar todas las vistas.

---

## Tarea 7 — Layout base y vistas Blade

**Archivos creados:**

- `resources/views/layouts/app.blade.php` (layout base)
- `resources/views/landing.blade.php` (página de aterrizaje)
- `resources/views/catalog.blade.php` (catálogo con barra por marca)
- `resources/views/car_detail.blade.php` (detalle de un auto)

**Por qué:**

> El layout base define la **navbar fija** con backdrop-filter blur (efecto glassmorphism), el footer con 4 columnas y los stacks `@stack('styles')` / `@stack('scripts')` para que cada vista inyecte CSS/JS extra sin duplicar el layout.  
> La **página de aterrizaje** tiene 5 secciones: hero animado → servicios (6 tarjetas) → marcas (chips clicables) → destacados (3 autos) → CTA final al catálogo. Cumple lo que pidió el usuario: "página de aterrizaje con información del servicio y al final un apartado que lo lleve al catálogo".  
> El **catálogo** tiene la **barra de tareas por marca** (`<nav class="brand-bar">`) como pestañas horizontales que filtran los autos al hacer clic. Cada marca es un enlace `route('catalog', ['brand' => $slug])`, y la marca activa se marca con la clase `is-active`.  
> La **tarjeta de auto** muestra: año, marca, modelo, specs (HP, vel. máx), descripción truncada, **precio de venta** y **precio de alquiler** en dos columnas, y dos botones: "Ver detalle" y "Cotizar".

---

## Tarea 8 — Animación de auto en movimiento (hero)

**Implementación:**

- El auto es un **SVG inline** dibujado a mano en `resources/views/landing.blade.php` (cuerpo, cabina, ventanas, faros, ruedas con detalle).
- Las animaciones viven en `public/css/style.css` con tres `@keyframes`:
  - **`carDrive`**: mueve el auto de izquierda a derecha en 8s y luego lo devuelve en espejo (escala X negativa), creando un loop continuo de ida y vuelta.
  - **`carBounce`**: hace que el SVG rebote 3px verticalmente cada 0.35s para simular la suspensión sobre el pavimento.
  - **`roadMove`**: desplaza la textura de las líneas de la carretera (centrales y laterales) creando el efecto de suelo en movimiento continuo.
- El fondo del hero tiene **4 capas** apiladas: cielo con estrellas (radial-gradients), montañas SVG, carretera en perspectiva (clip-path polygon) y líneas de pavimento animadas.

**Por qué:**

> El usuario pidió explícitamente "interfaz de un auto moviéndose de fondo". Lo resolví con **SVG + CSS puro** (sin JavaScript ni librerías externas) porque:
>
> - Es ligero: el SVG pesa ~1 KB y no requiere cargar imágenes ni GIFs.
> - Es infinitamente escalable y nítido en cualquier resolución.
> - Las animaciones CSS consumen menos CPU que JavaScript o videos.
> - El auto se puede recolorear al instante cambiando una variable CSS.

---

## Tarea 9 — Hoja de estilos principal

**Archivo creado:**

- `public/css/style.css` (~700 líneas)

**Por qué:**

> Escribí CSS propio en lugar de Tailwind/Bootstrap porque el usuario pidió "código puro para correrlo en VSCode" y así **no necesita compilar assets con Vite/npm**: el `<link rel="stylesheet" href="{{ asset('css/style.css') }}">` ya funciona en cuanto arranca `php artisan serve`.  
> El sistema de diseño usa **variables CSS** en `:root` (paleta, tipografías, sombras, radios, transición) para que el tema se personalice desde un único punto.  
> La paleta es oscura (`#0a0e1a` de fondo) con acentos **rojo `#e63946`** y **naranja `#ff6b35`**, evocando deportividad y velocidad, en sintonía con un concesionario de autos premium.  
> Las tipografías son **Orbitron** (display, para títulos) + **Poppins** (cuerpo), cargadas desde Google Fonts. Orbitron tiene un corte futurista perfecto para autos.  
> Incluí un **grid responsivo** con `auto-fit` y `minmax()` en las tarjetas y servicios, así el layout se adapta solo sin media queries manuales para cada breakpoint.

---

## Tarea 10 — JavaScript de interacciones

**Archivo creado:**

- `public/js/main.js`

**Por qué:**

> JavaScript mínimo (sin frameworks) para no añadir peso innecesario. Maneja:
>
> - **Menú móvil**: toggle del navbar en pantallas < 900px.
> - **Smooth scroll con offset**: al hacer clic en "Servicio", "Marcas", etc., baja a la sección con el offset correcto para no taparla con el navbar fijo.
> - **Auto-scroll de la barra de marcas**: asegura que la marca activa sea visible dentro de la barra horizontal scrollable del catálogo.
> - **Parallax suave del hero**: al hacer scroll, el contenido del hero sube y se desvanece, dando profundidad a la animación del auto.

---

## Tarea 11 — Archivos públicos de servidor

**Archivos creados:**

- `public/index.php` (front controller)
- `public/.htaccess` (rewrite de Apache)

**Por qué:**

> Laravel necesita un único punto de entrada (`index.php`) que arranque la aplicación, y un `.htaccess` que reescriba todas las URLs hacia ese front controller. Sin esto, URLs como `/catalogo` devolverían 404.  
> Para desarrollo con `php artisan serve` el `.htaccess` no se usa, pero se incluye por si el usuario despliega después en Apache.

---

## Tarea 12 — Documentación

**Archivos creados:**

- `README.md` — instrucciones de instalación paso a paso para VSCode.
- `guia.md` — este documento.

**Por qué:**

> El usuario pidió explícitamente una `guia.md` "donde colocaras tarea por tarea que hiciste y por qué".  
> El README detalla los requisitos previos (PHP 8.2, Composer), los 5 comandos para arrancar el proyecto (`composer install`, `cp .env.example .env`, `php artisan key:generate`, `php artisan migrate --seed`, `php artisan serve`) y la estructura de carpetas.  
> La guía explica cada decisión técnica para que el usuario entienda **por qué** se hizo de cada forma, no solo **qué** se hizo.

---

## ✅ Resumen final

| Tarea | Estado |
|-------|--------|
| Estructura base Laravel 11 | ✅ |
| Modelos Brand + Car con relaciones | ✅ |
| 4 migraciones (brands, cars, cache, sessions) | ✅ |
| Seeders con 7 marcas y 28 modelos 2025-2026 | ✅ |
| 2 controladores (Landing + Catalog) | ✅ |
| 3 rutas con nombre | ✅ |
| 4 vistas Blade (layout, landing, catalog, detail) | ✅ |
| Animación de auto SVG + CSS puro | ✅ |
| Hoja de estilos responsive completa | ✅ |
| JavaScript de interacciones | ✅ |
| Front controller + .htaccess | ✅ |
| README + guía | ✅ |

El proyecto está **listo para abrir en VSCode** y arrancar con `composer install && php artisan migrate --seed && php artisan serve`.

---

# Rediseño V2 — Minimalista B/N con imágenes reales

 Tras el feedback del usuario ("quita ese carro que da risa, deja CarTur solo, estilo minimalista, negro/blanco/grises, renderiza los autos, imágenes a cada modelo"), se rediseñó por completo la capa visual.

## Tarea 13 — Eliminación del carro caricaturesco

**Archivos modificados:**

- `resources/views/landing.blade.php` (sección hero completamente reescrita)
- `public/css/style.css` (clases `.hero__car`, `.hero__roadway`, `.hero__lane` eliminadas)

**Por qué:**

> El SVG del auto estilo "juego" restaba seriedad al concesionario. Se eliminó por completo y se reemplazó por un hero con **imagen fotorealista en B/N** de fondo, overlay degradado y líneas sutiles animadas que sugieren velocidad sin ser cartoon.

## Tarea 14 — Nueva paleta minimalista B/N

**Archivo modificado:**

- `public/css/style.css` (variables `:root` reescritas)

**Por qué:**

> La paleta pasó de rojo/naranja sobre azul oscuro a una **escala de grises pura**:
>
> - `--color-bg: #0a0a0a` (negro casi puro)
> - `--color-text: #ffffff` (blanco)
> - `--color-muted: #8a8a8a` (gris medio)
> - `--color-border: #262626` (gris muy oscuro)
> - `--color-accent: #ffffff` (el blanco ES el acento)
>
> Sin color saturado. El interés visual viene de las **fotografías B/N de los autos** y de las **tipografías** (Orbitron display + Poppins cuerpo).

## Tarea 15 — Hero con imagen cinematográfica

**Archivos:**

- `public/images/hero/hero-bg.png` (generada con IA)
- `resources/views/landing.blade.php` (estructura del hero)
- `public/css/style.css` (clases `.hero__bg`, `.hero__overlay`, `.hero__lines`, `.hero__scroll`)

**Por qué:**

> El hero ahora usa una imagen B/N de un deportivo saliendo de sombras, con:
>
> - **Zoom infinito** (`@keyframes heroZoom`) que escala la imagen de 1.0 a 1.12 en 25s, dando movimiento sutil sin distraer.
> - **Overlay degradado** vertical para garantizar legibilidad del texto.
> - **Dos líneas horizontales animadas** (`@keyframes lineSlide`) que cruzan la pantalla en 8s, evocando velocidad sin ser cartoon.
> - **Indicador "Scroll"** en la base con una línea vertical que pulsa (`@keyframes scrollPulse`).

## Tarea 16 — Generación de 28 imágenes de autos (una por modelo)

**Archivos:**

- `public/images/cars/*.png` (28 archivos, ~3 MB total)
- `database/seeders/CarSeeder.php` (lógica de nombres corregida)
- `database/database.sqlite` (rutas `image` actualizadas a `.png`)

**Por qué:**

> El usuario pidió "renderiza los autos para las presentaciones, hazle imágenes a cada modelo". Se generaron **28 imágenes únicas** con el CLI `z-ai image`, todas con el mismo prompt base para mantener coherencia visual:
>
> > "Black and white minimalist studio photograph, side profile view, dramatic studio lighting, dark gradient background, professional automotive photography, high detail, monochrome grayscale"
>
> Cada imagen añade el modelo específico (ej: "of a 2026 Lamborghini Revuelto hybrid V12 supercar"). El resultado son renders fotorealistas en B/N, perfectos para la paleta minimalista.
>
> Las imágenes se aplican `filter: grayscale(100%)` en CSS para garantizar uniformidad incluso si alguna imagen tuviera restos de color.

## Tarea 17 — Componente reutilizable `car_card`

**Archivo:**

- `resources/views/components/car_card.blade.php`

**Por qué:**

> La tarjeta de auto se usa tanto en la landing (sección destacados) como en el catálogo. Se extrajo a un componente Blade para **no duplicar HTML**. Recibe `$car` y renderiza imagen, marca, modelo, specs (HP / vel. máx / combustible), descripción truncada, precios de venta y alquiler, y botones "Ver ficha" + "Cotizar".

## Tarea 18 — Catálogo con barra de marcas minimalista

**Archivo:**

- `resources/views/catalog.blade.php` (reescrito)
- `public/css/style.css` (clases `.brand-bar`, `.brand-bar__link`)

**Por qué:**

> La barra de tareas por marca pasó de tabs con bordes redondeados y sombras a una **barra horizontal plana** estilo "underline". La marca activa se marca con un **borde inferior blanco de 2px** y texto blanco; las inactivas en gris. Sin fondos de color. Mucho más limpio y editorial.

## Tarea 19 — Detalle de auto con grid de specs

**Archivo:**

- `resources/views/car_detail.blade.php` (reescrito)
- `public/css/style.css` (clases `.detail__main`, `.detail__specs`, `.price-box`)

**Por qué:**

> La ficha del auto ahora usa un layout de **dos columnas**: imagen grande a la izquierda (16:10) e información a la derecha. Las specs técnicas están en un **grid 2×2 con bordes** (estilo tabla editorial) en lugar de tarjetas separadas. Los precios están en una **franja horizontal dividida** con borde central, dando sensación de "ficha técnica" en vez de "tarjeta de producto".

## Tarea 20 — Favicon y tipografía actualizados

**Archivos:**

- `public/favicon.svg` (letra "C" en negro/blanco)
- `resources/views/layouts/app.blade.php` (cargas de fuentes Orbitron 400-900 + Poppins 200-700)

**Por qué:**

> El favicon pasó del SVG del carro rojo a una **letra "C" minimalista** en blanco sobre negro, coherente con el resto del diseño.  
> Las fuentes se cargan con más pesos (200-700 en Poppins para variantes finas y gruesas; 400-900 en Orbitron) para tener más rango tipográfico en el diseño minimalista, donde el contraste de pesos es la principal herramienta visual.

## Tarea 21 — Script de diagnóstico

**Archivo:**

- `diagnostico.php` (en la raíz del proyecto)

**Por qué:**

> Tras el reporte de "500 Server Error", se añadió un script PHP standalone que revisa 8 puntos: versión PHP, extensiones, `vendor/`, `.env`, `APP_KEY`, BD SQLite (existencia + tablas + registros), permisos en `storage/` y `bootstrap/cache/`, y `artisan`.  
> Se ejecuta con `php diagnostico.php` y muestra ✅/❌ en cada punto, además de sugerir el comando exacto para resolver cada problema.

---

## ✅ Resumen final V2

| Tarea | Estado |
|-------|--------|
| Eliminar carro caricaturesco del hero | ✅ |
| Paleta minimalista B/N/grises | ✅ |
| Hero con imagen cinematográfica B/N + líneas animadas | ✅ |
| 28 imágenes únicas generadas (una por modelo) | ✅ |
| Componente `car_card` reutilizable | ✅ |
| Catálogo con barra de marcas editorial | ✅ |
| Detalle con grid de specs y precios en franja | ✅ |
| Favicon "C" minimalista | ✅ |
| Script `diagnostico.php` | ✅ |
| README + guía actualizados | ✅ |

El proyecto mantiene la **misma arquitectura Laravel 11** (modelos, migraciones, seeders, controladores, rutas) y solo se rediseñó la **capa de presentación** para cumplir el brief minimalista B/N con imágenes reales por modelo.
