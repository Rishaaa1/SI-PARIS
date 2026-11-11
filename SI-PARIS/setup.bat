@echo off
echo ==========================================
echo  SETUP SI-PARIS
echo  Pastikan MySQL di XAMPP sudah START dulu!
echo ==========================================
pause
php artisan migrate:fresh --seed --force
php artisan storage:link
php artisan optimize:clear
echo.
echo Selesai. Menjalankan server di http://127.0.0.1:8000
php artisan serve
