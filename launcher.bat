@echo off
set "ACTION=%1"

:: Remove o prefixo rs232monitor://
set "ACTION=%ACTION:rs232monitor://=%"

if "%ACTION%"=="start" (
        start "" "C:\xampp\htdocs\cartonagem-trindade-25\tools\RS232Monitorization2.1\RS232Monitorization.exe"
    ) else if "%ACTION%"=="stop" (
        taskkill /F /IM RS232Monitorization.exe
   