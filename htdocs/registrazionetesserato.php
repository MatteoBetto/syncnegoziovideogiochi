<?php

    $con = pg_connect("host=localhost port=5432 dbname=negoziovideogiochi  user=postgres password=unimi");
    if(!$con){
      echo "Errore nella connessione al database: ".pg_last_error($con);
      exit;
    }

    $cf = pg_escape_string($_POST["CF"]);
	$nome = pg_escape_string($_POST["nome"]);
	$cognome = pg_escape_string($_POST["cognome"]);
	$telefono = pg_escape_string($_POST["telefono"]);
	$datanascita = pg_escape_string($_POST["datanascita"]);
	$livellotesserato = pg_escape_string($_POST["livellotesserato"]);
	$datacreazionetesserato = pg_escape_string($_POST["datacreazionetesserato"]);
	$datascadenzatesserato = pg_escape_string($_POST["datascadenzatesserato"]);

    $query = "SET datestyle = dmy; INSERT INTO tesserato (cf, nome, cognome, telefono, datanascita, livellotessera, creazionetessera, scadenzatessera) VALUES ('".$cf."','".$nome."','".$cognome."','".$telefono."','".$datanascita."','".$livellotesserato."','".$datacreazionetesserato."','".$datascadenzatesserato."')";

    $query_res = pg_query($con, $query);

    if(!query_res){
        echo "Errore nella query: ".pg_last_error($con);
        exit;
    }else{
        header("Location:home.html");
    }
?>
