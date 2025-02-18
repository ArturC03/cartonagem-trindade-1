@echo off

set "pasta_destino=C:\xampp\htdocs"

:: Define o caminho para o arquivo executável
::set "executavel=%~dp0Novo.exe"

:: Define o nome da pasta que será extraída do executável
set "nome_pasta=cartonagem-trindade"

:: Oculta a pasta de destino usando o comando "attrib"
attrib +h "%pasta_destino%\%nome_pasta%"

::node index.js
:: Define o caminho para o executável do NetBeans
::set "netbeans_path=C:\Program Files\NetBeans 8.2\bin\netbeans64.exe"

:: Define o caminho para o arquivo Java a ser aberto
set "java_file=C:\xampp\htdocs\ProjetoCartonagemV1\RS232-monitorization1.1\src\rs232\monitorization\RS232Monitorization.java"

:: Define o caminho para o executável do XAMPP
set "xampp_path=C:\xampp\xampp-control.exe"

:: Define a URL do localhost
set "localhost_url=http://localhost/cartonagem-trindade"

:: Inicia o XAMPP
if exist "%xampp_path%" (
    start "" "%xampp_path%"
) else (
    echo XAMPP não encontrado no caminho especificado.
    timeout /t 5 >nul
)

:: Aguarda 5 segundos para o servidor iniciar completamente
timeout /t 5 >nul

:: Abre o navegador com a URL do localhost
start "" "%localhost_url%"

if exist "%java_file%" (
    "C:\Program Files (x86)\Java\jdk1.8.0_281\bin\java" -jar "C:\xampp\htdocs\ProjetoCartonagemV1\RS232-monitorization1.1\dist\RS232-monitorization.jar"
) else (
    echo RS232-Monitorization não encontrado no caminho especificado.
    timeout /t 5 >nul
)

exit