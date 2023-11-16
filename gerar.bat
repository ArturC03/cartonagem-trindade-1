@echo off
setlocal enabledelayedexpansion

:: Configurações do banco de dados
set "host=localhost"
set "user=root"
set "password="
set "database=plantdb"

:: Nome do arquivo CSV
set "nome_arquivo=dados_sensores.csv"

:: Consulta SQL para obter os dados dos sensores com "gerar" igual a 1
set "consulta_sql=SELECT * FROM sensors WHERE gerar = 1"

:: Conexão ao banco de dados e geração do arquivo CSV
mysql -h !host! -u !user! -p!password! -D !database! -e "!consulta_sql!" -B -r -N > "!nome_arquivo!"

:: Verifique se o arquivo CSV foi gerado corretamente
if exist "!nome_arquivo!" (
    echo Arquivo CSV gerado com sucesso.
) else (
    echo Falha ao gerar o arquivo CSV.
)

