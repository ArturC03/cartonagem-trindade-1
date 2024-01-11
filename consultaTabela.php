<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

    $ids=$_POST['ids'];
    $sensores= "(";
    foreach($ids as $id){
        $sensores= $sensores. "'".$id."',";
    }
    $sensores= substr($sensores, 0, -1);
    $sensores= $sensores.")";

    $dataMinima= $_POST["mindate"];
    $dataMaxima= $_POST["maxdate"];
    
    $horaMinima= $_POST["mintime"];
    $horaMaxima= $_POST["maxtime"];
    
    $timestamp= strtotime($dataMaxima);
    $timestamp2= strtotime($dataMinima);
    
    $dataMinima= date("y-m-d", $timestamp2);
    $dataMaxima= date("y-m-d", $timestamp);
    
    $comprimento= strlen($sensores);

    $comp2= strlen($horaMinima);
    $comp3= strlen($horaMaxima);
    
    if($comp2==0 && $comp3==0){
        $comp2= "s.hour BETWEEN '00:00:00' and '23:59:59' AND ";
    }elseif($comp2==0 && $comp3 <> 0){
        $comp2= "s.hour BETWEEN '00:00:00' and '".$horaMaxima."' and ";
    }elseif($comp2 <> 0 && $comp3 <> 0){
        $comp2= "s.hour BETWEEN '".$horaMinima."' and '".$horaMaxima."' AND ";
    }else{
        $comp2= "s.hour BETWEEN '".$horaMinima."' and '23:59:59' AND ";
    }
    
    $datas= "s.date BETWEEN '".$dataMinima."' and '".$dataMaxima."' AND ";

    $sql = "SELECT distinct s.* FROM sensors s where ".$comp2.$datas."s.id_sensor in $sensores order by date ASC";
    $sql2 = "SELECT distinct s.id_sensor, s.date, s.hour, s.temperature, s.humidity, s.pressure, s.eCO2, s.eTVOC FROM sensors s where ".$comp2.$datas."s.id_sensor in $sensores order by date ASC";
    ?>
    <p id="sql" class="d-none"><?php echo $sql; ?></p>
    <p id="sql2" class="d-none"><?php echo $sql2; ?></p>
    <script src="js/pageScroll.js"></script>
    <main class="table">
        <section class="table_header"> 
            <h1 class="title">Consulta</h1>    
            <div class="input-group">
                <input type="search" placeholder="Procurar dados...">
                <img src="images/search.svg" alt="">
            </div>
            <div class="custom-select-wrapper">
                <select name="column" class="custom-select">
                    <option value="0" class="custom-option" selected>ID</option>
                    <option value="1" class="custom-option">Hora</option>
                    <option value="2" class="custom-option">Data</option>
                    <option value="3" class="custom-option">Temperatura (ºC)</option>
                    <option value="4" class="custom-option">Humidade (%)</option>
                    <option value="5" class="custom-option">Pressão (HPA)</option>
                    <option value="6" class="custom-option">CO2 (PPM)</option>
                    <option value="7" class="custom-option">TVOC (PPB)</option>
                </select>
            </div>


        </section>
        <section class="table_body" id="table_body">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hora</th>
                        <th>Data</th>
                        <th>Temperatura (ºC)</th>
                        <th>Humidade (%)</th>
                        <th>Pressão (HPA)</th>
                        <th>CO2 (PPM)</th>
                        <th>TVOC (PPB)</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="loader">
                <div class="justify-content-center jimu-primary-loading"></div>
            </div>
        </section>
        
        <section class="button-container">
            <button class="learn-more" onclick="window.location.href='consultaGraficos.php';">
                <div class="circle">
                    <div class="icon arrow"></div>
                </div>
                <span class="button-text">Gráficos</span>
            </button>
            <button class="learn-more" onclick="sendToCSV();">
                <div class="circle">
                    <div class="icon arrow"></div>
                </div>
                <span class="button-text">Obter CSV</span>
            </button>
            <button class="learn-more" onclick="window.location.href='archive.php';">
                <div class="circle">
                    <div class="icon arrow"></div>
                </div>
                <span class="button-text">Voltar</span>
            </button>
        </section>
    </main>
        
    <script src="js/consultaTabela.js"></script>
    <?php
    include('footer.inc.php');
    }else{
      header('Location: login.php');
    }