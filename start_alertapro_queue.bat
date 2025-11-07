@echo off
title 🚀 AlertaPro - Queue Worker en ejecución
color 0A
echo ===============================================
echo   INICIANDO SERVICIO DE COLAS DE ALERTAPRO
echo   Fecha: %date% - Hora: %time%
echo ===============================================

cd /d C:\xampp\htdocs\alertapro

REM Limpia caché y optimiza antes de iniciar el worker
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear

echo 🚀 Iniciando worker de colas...
start /min cmd /c "php artisan queue:work --queue=default --tries=3"

echo 🟢 Worker ejecutándose en segundo plano.
echo Puedes cerrar esta ventana.
pause >nul
