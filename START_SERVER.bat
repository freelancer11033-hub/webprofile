@echo off
title Portfolio Admin Server
color 0A

echo.
echo ================================================
echo    PORTFOLIO ADMIN SERVER
echo ================================================
echo.
echo Starting PHP development server...
echo.
echo Admin Panel will be available at:
echo.
echo    http://localhost:8000/admin/
echo.
echo Website will be available at:
echo.
echo    http://localhost:8000/
echo.
echo ================================================
echo.
echo Press CTRL+C to stop the server
echo.
echo ================================================
echo.

cd /d "%~dp0"
php -S localhost:8000

pause
