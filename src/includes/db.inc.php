<?php
$arrConfig['conn'] = my_connect($arrConfig);

function my_connect($arrConfig)
{
    $conn = new mysqli($arrConfig['servername'], $arrConfig['username'], $arrConfig['password'], $arrConfig['dbname']); // Create connection
    if ($conn->connect_error) { // Check connection
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset('utf8');
    return $conn;
}

function my_escape_string($value) {
    // Aqui você pode usar a função adequada para o seu tipo de conexão
    // Exemplo usando mysqli
    global $arrConfig;  // Supondo que você tenha uma variável de conexão chamada $conn
    return mysqli_real_escape_string($arrConfig['conn'], $value);
}


function my_query($sql, $debug = 0)
{
    global $arrConfig;
    if ($debug) echo $sql;
    $result = $arrConfig['conn']->query($sql);

    if (isset($result->num_rows)) { // SELECT
        $arrRes = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $arrRes[] = $row;
            }
        }
        return $arrRes;
    } else if ($result === TRUE) { // INSERT, DELETE, UPDATE
        if ($last_id = $arrConfig['conn']->insert_id) {
            return $last_id;
        }
        return 1;
    }
    return 0;
}
