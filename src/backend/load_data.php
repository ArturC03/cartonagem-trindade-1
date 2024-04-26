<?php
require '../includes/config.inc.php';

$sql = $_POST["sql"];
$offset = $_POST["offset"];
$data["sql"] = array();

$result = my_query($sql . " LIMIT $offset, 100;");
$offset += count($result);

foreach ($result as $row) {
    $data["sql"][] = $row;
}
$data["offset"] = $offset;
echo json_encode($data);
exit(0);