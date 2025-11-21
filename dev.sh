#!/bin/bash
# Script para ejecutar servidor de desarrollo de Laravel + Vite

echo "🚀 Iniciando servidor de desarrollo..."
echo ""
echo "Para detener los servidores, presiona Ctrl+C"
echo ""

# Ejecutar en paralelo
npm run dev &
php artisan serve

# Esperar a que ambos procesos terminen
wait
