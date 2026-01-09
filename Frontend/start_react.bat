@echo off
echo ========================================
echo   Demarrage du Frontend React
echo ========================================
echo.

echo 1. Verification des dependances...
if not exist "node_modules" (
    echo Installation des dependances...
    npm install
    if %errorlevel% neq 0 (
        echo ERREUR: Impossible d'installer les dependances
        pause
        exit /b 1
    )
)

echo.
echo 2. Demarrage du serveur React...
echo Le serveur sera accessible sur: http://localhost:5173
echo Appuyez sur Ctrl+C pour arreter le serveur
echo.

npm run dev

pause
