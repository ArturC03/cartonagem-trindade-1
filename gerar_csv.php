<?php
// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifique se há sensores selecionados no campo "sensores"
    if (isset($_POST["sensores"]) && is_array($_POST["sensores"])) {
        // Conexão com o banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "plantdb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Atualize a tabela 'sensors' com os valores corretos
        $sensoresSelecionados = $_POST["sensores"];
            $horaselecionada= $_POST["horaSelecionada"];
            $sensoresConvertidos = array();
            foreach ($sensoresSelecionados as $sensor) {
                // Pega os dois primeiros caracteres
                $doisPrimeiros = substr($sensor, 0, 2);
                // Pega os dois últimos caracteres e converte de hexadecimal para decimal
                $doisUltimosHex = substr($sensor, -2);
                $doisUltimosDecimal = hexdec($doisUltimosHex);
                // Concatena os dois primeiros e os dois últimos
                $sensorConvertido = $doisPrimeiros . str_pad($doisUltimosDecimal, 2, '0', STR_PAD_LEFT);
                $sensoresConvertidos[] = $sensorConvertido;
            }
        // Defina o campo 'gerar' para 0 para todos os sensores
        $sql1="UPDATE hora SET hora_geracao = '$horaselecionada' where id_hora=1";
        $conn->query($sql1);
        $sqlReset = "UPDATE location SET gerar = 0";
        $conn->query($sqlReset);

        // Defina o campo 'gerar' para 1 apenas para os sensores selecionados
        foreach ($sensoresConvertidos as $sensor) {
            $sqlUpdate = "UPDATE location SET gerar = 1 WHERE id_sensor = '$sensor'";
            $conn->query($sqlUpdate);
        }
        $conn->close();

        // Redirecione para a página anterior ou outra página de confirmação
        header("Location:csvtimes.php"); // Substitua 'index.php' pela página desejada
        exit();
    }
}
?>