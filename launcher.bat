@echo off
:: Verifica se o script está sendo executado como administrador
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Solicitando permissões de administrador...
    powershell -Command "Start-Process '%~f0' -Verb runAs"
    exit /b
)

set "ACTION=%1"

:: Remove o prefixo rs232monitor:// e barras extras
set "ACTION=%ACTION:rs232monitor://=%"
set "ACTION=%ACTION:/=%"
set "ACTION=%ACTION:"=%"

echo Ação recebida: "%ACTION%"

:: Nome do executável do programa
set "PROGRAM=RS232Monitorization.exe"

:: Função para verificar se o programa está em execução
:CHECK_RUNNING
tasklist /FI "IMAGENAME eq %PROGRAM%" 2>NUL | find /I /N "%PROGRAM%" > NUL
if "%ERRORLEVEL%"=="0" (
    set "RUNNING=1"
) else (
    set "RUNNING=0"
)
goto :EOF

:: Chama a função para verificar o estado atual do programa
call :CHECK_RUNNING

if "%ACTION%"=="start" (
    if "%RUNNING%"=="1" (
        echo O programa já está em execução.
    ) else (
        echo Iniciando o programa %PROGRAM% com privilégios de administrador...
        start "" "%~dp0%PROGRAM%"
        echo Programa iniciado com sucesso.
    )
) else if "%ACTION%"=="stop" (
    if "%RUNNING%"=="0" (
        echo O programa não está em execução.
    ) else (
        echo Encerrando o programa %PROGRAM% com privilégios de administrador...
        taskkill /F /IM %PROGRAM%
        echo Programa encerrado.
    )
) else if "%ACTION%"=="toggle" (
    if "%RUNNING%"=="1" (
        echo O programa está em execução. Encerrando com privilégios de administrador...
        taskkill /F /IM %PROGRAM%
        echo Programa encerrado.
    ) else (
        echo O programa não está em execução. Iniciando com privilégios de administrador...
        start "" "%~dp0%PROGRAM%"
        echo Programa iniciado com sucesso.
    )
) else (
    echo Ação desconhecida: "%ACTION%". Nenhuma ação realizada.
)

:: Pausa o script para visualizar as mensagens (timeout)
timeout /t 5 /nobreak > nul
