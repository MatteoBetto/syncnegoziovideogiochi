<?php
    session_start();
    $con = pg_connect("host=localhost port=5432 dbname=negoziovideogiochi  user=postgres password=unimi");
    if(!$con){
      echo "Errore nella connessione al database: ".pg_last_error($con);
      exit;
    }

        $titolo = pg_escape_string($_POST["titolo"]);
        $data = pg_escape_string($_POST["data"]);
        $luogo = pg_escape_string($_POST["luogo"]);
        $genere = pg_escape_string($_POST["genere"]);
        $creatore = pg_escape_string($_SESSION["CF"]);
        
        $query = "SET datestyle = dmy; INSERT INTO evento (titolo,data,luogo,genere,creatore) VALUES ('".$titolo."','".$data."','".$luogo."','".$genere."','".$creatore."')";
        

    $query_res = pg_query($con, $query);
    echo "query: ".$query;
    if(!$query_res){
        echo "Errore nella query: ".pg_last_error($con);
        exit;
    }else{
        header("Location:home.html");
    }
?>