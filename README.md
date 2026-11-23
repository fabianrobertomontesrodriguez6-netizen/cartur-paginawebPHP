# CarTur — Concesionario 2025-2026

Proyecto **Laravel 11 + PHP 8.2** para un concesionario que vende y renta autos 2025-2026 de las marcas:
**Ford · Lamborghini · BMW · Ferrari · Aorus · Mercedes-Benz · Audi**

Diseño **minimalista** en **negro, blanco y escala de grises**, con **28 imágenes reales** generadas en B/N para cada modelo.

---

## ✅ Requisitos previos

| Herramienta | Versión mínima | Notas |
|-------------|----------------|-------|
| **PHP**     | 8.2            | Con extensiones: `pdo_sqlite`, `mbstring`, `xml`, `ctype`, `json`, `tokenizer`, `fileinfo`, `curl` |
| **Composer**| 2.x            | Gestor de dependencias de PHP |

Verifica:

```bash
php -v
composer -V
```

---

## 🚀 Instalación (paso a paso en VSCode)

1. **Abre la carpeta `cartur/` en VSCode** (`File → Open Folder`).

2. **Instala las dependencias de PHP**:

   ```bash
   composer install
   ```

3. **El archivo `.env` ya está creado** con `APP_KEY` generada y BD configurada.  
   No necesitas copiarlo ni ejecutar `key:generate`.

4. **(Opcional) La BD ya viene pre-llenada** con 7 marcas y 28 modelos con sus imágenes.  
   Si quieres regenerarla desde cero:

   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Arranca el servidor**:

   ```bash
   php artisan serve
   ```

   Abre <http://127.0.0.1:8000>.

---

## 🎨 Diseño

- **Paleta**: negro (`#0a0a0a`), blanco (`#ffffff`) y escala de grises.
- **Tipografía**: Orbitron (display) + Poppins (cuerpo).
- **Imágenes**: 28 renders fotorealistas en B/N, uno por modelo, en `public/images/cars/`.
- **Hero**: imagen cinematográfica B/N con overlay degradado, líneas sutiles animadas y zoom infinito.
- **Sin elementos caricaturescos**: el diseño es serio y profesional.

---

## 🗂️ Estructura del proyecto

```
cartur/
├── app/
│   ├── Http/Controllers/         # LandingController, CatalogController
│   └── Models/                   # Brand, Car
├── database/
│   ├── database.sqlite           # BD pre-llenada (7 marcas + 28 autos)
│   ├── migrations/
│   └── seeders/                  # BrandSeeder, CarSeeder
├── public/
│   ├── css/style.css             # Estilo minimalista B/N
│   ├── images/
│   │   ├── cars/                 # 28 imágenes PNG en B/N (una por modelo)
│   │   └── hero/hero-bg.png      # Imagen de fondo del hero
│   └── js/main.js
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── landing.blade.php
│   ├── catalog.blade.php
│   ├── car_detail.blade.php
│   └── components/car_card.blade.php
├── .env                          # Ya configurado con APP_KEY
├── diagnostico.php               # Script de diagnóstico
├── guia.md                       # Documentación tarea por tarea
└── README.md
```

---

## 🧯 Solución de problemas (500 Server Error)

Si ves **"500 Server Error"**, ejecuta el diagnóstico:

```bash
php diagnostico.php
```

Te dirá ✅ o ❌ en cada punto. Las causas más comunes:

1. **Falta `composer install`** → la carpeta `vendor/` no existe.
2. **Falta `.env`** → crea con `cp .env.example .env && php artisan key:generate`.
3. **BD vacía** → ejecuta `php artisan migrate:fresh --seed` (¡importante el `--seed`!).
4. **Permisos** en Linux/macOS → `chmod -R 755 storage bootstrap/cache`.
5. **Falta extensión PHP** → revisa con `php -m` que `pdo_sqlite` esté cargada.

Para ver el error exacto:

```bash
tail -50 storage/logs/laravel.log
```

Y asegúrate de que en `.env` tienes `APP_DEBUG=true`.

---

## 🔧 Comandos útiles

| Comando | Acción |
|---------|--------|
| `php artisan serve` | Servidor en http://127.0.0.1:8000 |
| `php artisan migrate:fresh --seed` | Regenera BD con datos |
| `php artisan tinker` | Consola interactiva |
| `php artisan route:list` | Lista las rutas |
| `php diagnostico.php` | Diagnóstico del entorno |

---

## 📞 Soporte

Proyecto entregado como código puro para VSCode.
- PHP: <https://www.php.net/manual/es/install.php>
- Composer: <https://getcomposer.org/download/>
