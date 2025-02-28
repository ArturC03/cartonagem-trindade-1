<?php
// include '../includes/config.inc.php';
// // Recebe o nome do programa a ser iniciado
// if (isset($_GET['program'])) {
//     $program = $_GET['program'];

//     if ($program === 'mysql') {
//         // Iniciar o MySQL
//         $output = exec("C:\xampp\mysql\bin\mysqld.exe"); // Comando para iniciar a db

//         if ($output) {
//             echo json_encode(["success" => true]);
//         } else {
//             echo json_encode(["success" => false]);
//         }
//     } elseif ($program === 'com3') {
//         // Tente ocupar a porta COM3
//         global $arrConfig;
//         $output = exec($arrConfig['sensorProgramPath']); // Comando para ler os dados dos sensores
//         if ($output) {
//             echo json_encode(["success" => true]);
//         } else {
//             echo json_encode(["success" => false]);
//         }
//     } else {
//         echo json_encode(["success" => false]);
//     }
// }
?>
