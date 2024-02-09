@echo off

REM Get the path to the PHP executable
for /f "delims=" %%i in ('where php') do set PHP_PATH=%%i

REM Get the current hour
for /f "tokens=1 delims=:" %%a in ("%time%") do set CURRENT_HOUR=%%a

REM Create MINUTE task
schtasks /Create /SC MINUTE /TN "Agendamentos Minuto a Minuto" /TR "cmd /c start /B \"\" \"%PHP_PATH%\" \"C:\xampp\htdocs\cartonagem-trindade\scheduled.php\" MINUTE"

REM Create HOURLY task
schtasks /Create /SC HOURLY /TN "Agendamentos Horários" /TR "cmd /c start /B \"\" \"%PHP_PATH%\" \"C:\xampp\htdocs\cartonagem-trindade\scheduled.php\" HOURLY" /ST %CURRENT_HOUR%:01

REM Create DAILY task
schtasks /Create /SC DAILY /TN "Agendamentos Diários" /TR "cmd /c start /B \"\" \"%PHP_PATH%\" \"C:\xampp\htdocs\cartonagem-trindade\scheduled.php\" DAILY" /ST 00:01

REM Create WEEKLY task
schtasks /Create /SC WEEKLY /TN "Agendamentos Semanais" /TR "cmd /c start /B \"\" \"%PHP_PATH%\" \"C:\xampp\htdocs\cartonagem-trindade\scheduled.php\" WEEKLY" /ST 00:01

REM Create MONTHLY task
schtasks /Create /SC MONTHLY /TN "Agendamentos Mensais" /TR "cmd /c start /B \"\" \"%PHP_PATH%\" \"C:\xampp\htdocs\cartonagem-trindade\scheduled.php\" MONTHLY" /ST 00:01