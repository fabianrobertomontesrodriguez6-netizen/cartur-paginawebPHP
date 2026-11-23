#!/usr/bin/env php
<?php
/**
 * CarTur - Diagnóstico del entorno
 * Ejecuta con:  php diagnostico.php
 * Desde la carpeta raíz del proyecto (donde está artisan).
 */

echo "\n";
echo "============================================\n";
echo "  CarTur - Diagnóstico del entorno\n";
echo "============================================\n\n";

$errores = [];

// 1. Versión de PHP
echo "[1/8] Versión de PHP...\n";
if (defined('PHP_VERSION')) {
    echo "      PHP " . PHP_VERSION . "\n";
    if (version_compare(PHP_VERSION, '8.2.0', '<')) {
        $errores[] = "PHP 8.2+ requerido. Tienes " . PHP_VERSION;
        echo "      ❌ Necesitas PHP 8.2 o superior\n";
    } else {
        echo "      ✅ OK\n";
    }
}

// 2. Extensiones requeridas
echo "\n[2/8] Extensiones PHP requeridas...\n";
$requeridas = ['pdo_sqlite', 'mbstring', 'xml', 'ctype', 'json', 'tokenizer', 'fileinfo', 'curl'];
$faltan = [];
foreach ($requeridas as $ext) {
    if (extension_loaded($ext)) {
        echo "      ✅ $ext\n";
    } else {
        echo "      ❌ $ext (FALTA)\n";
        $faltan[] = $ext;
        $errores[] = "Falta extensión PHP: $ext";
    }
}

// 3. Composer y vendor/
echo "\n[3/8] Dependencias (vendor/)...\n";
if (!is_dir(__DIR__ . '/vendor')) {
    echo "      ❌ La carpeta vendor/ NO existe\n";
    $errores[] = "Falta ejecutar 'composer install'";
    echo "      → Ejecuta:  composer install\n";
} else {
    $count = count(glob(__DIR__ . '/vendor/*', GLOB_ONLYDIR));
    echo "      ✅ vendor/ existe ($count paquetes)\n";
}

// 4. Archivo .env
echo "\n[4/8] Archivo .env...\n";
if (!file_exists(__DIR__ . '/.env')) {
    echo "      ❌ .env NO existe\n";
    $errores[] = "Falta archivo .env. Ejecuta: cp .env.example .env && php artisan key:generate";
} else {
    echo "      ✅ .env existe\n";
    $env = file_get_contents(__DIR__ . '/.env');
    // APP_KEY
    if (preg_match('/^APP_KEY=(.*)$/m', $env, $m)) {
        $key = trim($m[1]);
        if (empty($key)) {
            echo "      ❌ APP_KEY está vacía\n";
            $errores[] = "APP_KEY vacía. Ejecuta: php artisan key:generate";
        } elseif (!str_starts_with($key, 'base64:')) {
            echo "      ⚠️  APP_KEY no tiene formato base64:\n";
            $errores[] = "APP_KEY inválida. Ejecuta: php artisan key:generate";
        } else {
            echo "      ✅ APP_KEY configurada\n";
        }
    } else {
        echo "      ❌ APP_KEY no encontrada en .env\n";
        $errores[] = "Falta APP_KEY en .env";
    }
    // APP_DEBUG
    if (preg_match('/^APP_DEBUG=(\w+)/m', $env, $m)) {
        echo "      " . ($m[1] === 'true' ? "✅" : "ℹ️") . " APP_DEBUG=" . $m[1] . "\n";
    }
}

// 5. Base de datos SQLite
echo "\n[5/8] Base de datos SQLite...\n";
$dbPath = __DIR__ . '/database/database.sqlite';
if (!file_exists($dbPath)) {
    echo "      ❌ database/database.sqlite NO existe\n";
    $errores[] = "Falta BD. Ejecuta: php artisan migrate --seed";
} else {
    $size = filesize($dbPath);
    echo "      ✅ database/database.sqlite existe ($size bytes)\n";
    if ($size < 1000) {
        echo "      ⚠️  La BD es muy pequeña, probablemente está vacía\n";
        $errores[] = "BD vacía. Ejecuta: php artisan migrate:fresh --seed";
    } else {
        try {
            $pdo = new PDO('sqlite:' . $dbPath);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $tablas = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
            echo "      Tablas: " . implode(', ', $tablas) . "\n";

            if (in_array('brands', $tablas)) {
                $n = $pdo->query("SELECT COUNT(*) FROM brands")->fetchColumn();
                echo "      ✅ brands: $n registros\n";
                if ($n == 0) $errores[] = "Tabla brands vacía. Ejecuta: php artisan migrate:fresh --seed";
            } else {
                echo "      ❌ Tabla 'brands' no existe\n";
                $errores[] = "Esquema BD incompleto. Ejecuta: php artisan migrate:fresh --seed";
            }

            if (in_array('cars', $tablas)) {
                $n = $pdo->query("SELECT COUNT(*) FROM cars")->fetchColumn();
                echo "      ✅ cars: $n registros\n";
                if ($n == 0) $errores[] = "Tabla cars vacía. Ejecuta: php artisan migrate:fresh --seed";
            }
        } catch (PDOException $e) {
            echo "      ❌ Error leyendo BD: " . $e->getMessage() . "\n";
            $errores[] = "BD corrupta: " . $e->getMessage();
        }
    }
}

// 6. Permisos de storage/
echo "\n[6/8] Permisos storage/ y bootstrap/cache/...\n";
$dirs = ['storage', 'storage/framework/views', 'storage/framework/sessions', 'storage/framework/cache', 'storage/logs', 'bootstrap/cache'];
foreach ($dirs as $d) {
    $full = __DIR__ . '/' . $d;
    if (!is_dir($full)) {
        @mkdir($full, 0775, true);
    }
    if (is_writable($full)) {
        echo "      ✅ $d (escribible)\n";
    } else {
        echo "      ❌ $d (NO escribible)\n";
        $errores[] = "Permiso denegado en $d. Ejecuta: chmod -R 755 storage bootstrap/cache";
    }
}

// 7. artisan
echo "\n[7/8] artisan...\n";
if (!file_exists(__DIR__ . '/artisan')) {
    echo "      ❌ artisan NO existe (¿ carpeta incorrecta ?)\n";
    $errores[] = "Estás ejecutando desde la carpeta equivocada";
} else {
    echo "      ✅ artisan existe\n";
}

// 8. Resumen
echo "\n[8/8] Resumen...\n";
if (empty($errores)) {
    echo "      🎉 TODO OK. Ejecuta:  php artisan serve\n";
    echo "      y abre http://127.0.0.1:8000\n";
} else {
    echo "      ❌ Hay " . count($errores) . " problema(s):\n";
    foreach ($errores as $i => $e) {
        echo "      " . ($i+1) . ". $e\n";
    }
    echo "\n      Comandos para resolver:\n";
    echo "        composer install\n";
    echo "        cp .env.example .env   (si falta .env)\n";
    echo "        php artisan key:generate   (si falta APP_KEY)\n";
    echo "        php artisan migrate:fresh --seed   (si BD está vacía)\n";
    echo "        chmod -R 755 storage bootstrap/cache   (si hay permisos)\n";
    echo "        php artisan serve\n";
}

echo "\n============================================\n\n";
