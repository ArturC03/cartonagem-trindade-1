<?php
    include('config.inc.php');

    $year = date('Y');
    $month = date('m');

    $dbnames = array();
    $dates_db = array();

    $result = my_query("SHOW DATABASES LIKE '".$arrConfig['dbname']."_%';");

    foreach ($result as $row) {
        $dbnames[] = $row['Database ('.$arrConfig['dbname'].'_%)'];
        $dates_db[] = DateTime::createFromFormat('!Y-m-d' ,str_replace('_', '-', str_replace($arrConfig['dbname'] . '_', '', $row['Database ('.$arrConfig['dbname'].'_%)'])).'-01');   
    }

    if ($dates_db == NULL) {
        $result = my_query("SELECT MIN(date) AS 'date' FROM ". $arrConfig['dbname'] .".sensors;");

        foreach ($result as $row) {
            $dates_db[] = DateTime::createFromFormat('!Y-m-d' , $row["date"]);
        }
    }

    $last_db = max($dates_db);

    $m = $last_db->format('m');
    $y = $last_db->format('Y');

    while ($year == $last_db->format('Y') && $month < $last_db->format('m') || $y < $year) {
        
        $new_dbname= $arrConfig['dbname'] . "_" . $y."_" . $m;
        if(my_query("CREATE DATABASE IF NOT EXISTS $new_dbname;") == TRUE){
            my_query("
            select concat('create table
            $new_dbname.',TABLE_NAME,' like ".$arrConfig['dbname'].".',TABLE_NAME,'; insert into
            $new_dbname.',TABLE_NAME,';')
            from information_schema.tables where table_schema = '".$arrConfig['dbname']."';
            ");

            my_query("INSERT INTO $new_dbname.location select * from ". $arrConfig['dbname'] .".location;");
            my_query("INSERT INTO $new_dbname.users select * from ". $arrConfig['dbname'] .".users;");
            my_query("INSERT INTO $new_dbname.sensors SELECT * from ". $arrConfig['dbname'] .".sensors where date <= '".$y."-".$m."-". cal_days_in_month(CAL_GREGORIAN, $m, $y) ."';");
            my_query("DELETE from ". $arrConfig['dbname'] .".sensors where date <= '".$y."-".$m."-".cal_days_in_month(CAL_GREGORIAN, $m, $y)."';");
        }

        if ($m == 12) {
            $m = 0;
            $y++;
        }
        $m++;
    }
?>