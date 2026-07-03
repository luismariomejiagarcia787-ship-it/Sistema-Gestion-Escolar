#!/bin/bash
echo "======================================================"
echo "   Sistema de Gestión Escolar - Instalación"
echo "======================================================"

# 1. Dependencias PHP
echo ""
echo "[1/7] Instalando dependencias PHP..."
composer install --no-interaction --prefer-dist

# 2. Copiar .env
echo ""
echo "[2/7] Configurando archivo .env..."
cp .env.example .env

# 3. Clave de aplicación
echo ""
echo "[3/7] Generando clave de aplicación..."
php artisan key:generate

# 4. Instrucciones de BD
echo ""
echo "[4/7] ⚠️  Configura tu base de datos en .env:"
echo "       DB_DATABASE=sistema_escolar"
echo "       DB_USERNAME=root"
echo "       DB_PASSWORD=tu_password"
echo ""
read -p "Presiona ENTER cuando hayas configurado el .env..."

# 5. Migraciones y seeders
echo ""
echo "[5/7] Ejecutando migraciones y seeders..."
php artisan migrate --seed

# 6. Storage link
echo ""
echo "[6/7] Creando enlace de storage..."
php artisan storage:link

# 7. Assets
echo ""
echo "[7/7] Instalando y compilando assets..."
npm install && npm run build

echo ""
echo "======================================================"
echo "  ✅ Instalación completada!"
echo "======================================================"
echo ""
echo "  Ejecuta: php artisan serve"
echo "  Abre:    http://localhost:8000"
echo ""
echo "  Credenciales:"
echo "  Admin:      admin@colegio.com / 12345678"
echo "  Profesor:   profesor@colegio.com / 12345678"
echo "  Estudiante: estudiante@colegio.com / 12345678"
echo ""
