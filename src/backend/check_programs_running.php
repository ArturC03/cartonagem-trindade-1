<?php
@session_start();
require "../includes/config.inc.php";

$res = my_query("SELECT value FROM site_settings WHERE name LIKE 'running_check_time' ORDER BY last_edited_at DESC");
$checkTime = $res[0]['value'];

// Pegar os minutos e segundos do string 
sscanf($checkTime, "%d:%d", $minutos, $segundos);

// Converter para segundos
$totalSegundos = ($minutos * 60) + $segundos;
$checkTime = $totalSegundos;

header('Content-Type: application/json');

// Verifica se um processo está em execução 
function isProcessRunning($processName) {
    $output = shell_exec("tasklist /FI \"IMAGENAME eq $processName\" 2>&1");
    return stripos($output, $processName) !== false;
}

// Verifica se a porta COM3 está ocupada
function isCOM3Occupied() {
    // Execute the command to check the status of COM3
    $output = shell_exec("mode COM3 2>&1");
    $expectedOutput = "Device COM3 is not currently available.";
    if(strcmp(trim($output), trim($expectedOutput)) === 0 ) {
        return true; 
    }

    return false;
}
// Checar MySQL do XAMPP
$mysqlRunning = isProcessRunning("mysqld.exe");  // MySQL do XAMPP
$com3Occupied = isCOM3Occupied(); // Porta COM3

// Retorna um JSON com o status
echo json_encode([
    "mysql" => $mysqlRunning ? "running" : "stopped",
    "com3" => $com3Occupied ? "occupied" : "free",
    "checkTime" => $checkTime
]);
?>