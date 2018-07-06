<?php
    session_start();
    $con = pg_connect("host=localhost port=5432 dbname=negoziovideogiochi  user=postgres password=unimi");
    if(!$con){
      echo "Errore nella connessione al database: ".pg_last_error($con);
      exit;
    }

    $tipo = pg_escape_string($_POST["tipo"]);

    if($tipo=="buonofedelta"){

        $valore = pg_escape_string($_POST["valore"]);
        $datainizio = pg_escape_string($_POST["datainizio"]);
        $datafine = pg_escape_string($_POST["datafine"]);
        $cf = pg_escape_string($_POST["cf"]);
        $creatore = pg_escape_string($_SESSION["CF"]);
        
        $query = "SET datestyle = dmy; INSERT INTO offerta (tipoofferta,datainizio,datafine,valore,creatore) VALUES ('".$tipo."','".$datainizio."','".$datafine."','".$valore."','".$creatore."');
        INSERT INTO assegnazioneofferta VALUES ()";
        

            
    }elseif($tipo=="offertaspeciale"){
        
        $valore = pg_escape_string($_POST["valore"]);
        $datainizio = pg_escape_string($_POST["datainizio"]);
        $datafine = pg_escape_string($_POST["datafine"]);
        $cf = pg_escape_string($_POST["cf"]);
        $creatore = pg_escape_string($_SESSION["CF"]);
        
        $query = "SET datestyle = dmy; INSERT INTO offerta (tipoofferta,datainizio,datafine,valore,creatore) VALUES ('".$tipo."','".$datainizio."','".$datafine."','".$valore."','".$creatore."');
        INSERT INTO assegnazioneofferta VALUES ()";
        
        
    }

    $query_res = pg_query($con, $query);
    echo "query: ".$query;
    if(!$query_res){
        echo "Errore nella query: ".pg_last_error($con);
        exit;
    }else{
        header("Location:home.html");
    }
?>