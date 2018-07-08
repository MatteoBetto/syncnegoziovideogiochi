<?php
	$con = pg_connect("host=localhost port=5432 dbname=negoziovideogiochi user=postgres password=unimi");
	if(!$con){
		echo "Errore nella connessione al database".pg_last_error($con);
		exit;
	}

    echo "pw".$_POST['password']; //perchè??
    $cf = pg_escape_string($_POST['CF']);
	$password = pg_escape_string($_POST['password']);
	$nome = pg_escape_string($_POST['nome']);
	$cognome = pg_escape_string($_POST['cognome']);
	$telefono = pg_escape_string($_POST['telefono']);
	$indirizzo = pg_escape_string($_POST['indirizzo']);
	$datanascita = pg_escape_string($_POST['datanascita']);

    $query = "SET datestyle = dmy; INSERT INTO dipendente (cf, password, nome, cognome, telefono, indirizzo, datanascita) VALUES ('".$cf."','".$password."','".$nome."','".$cognome."','".$telefono."','".$indirizzo."','".$datanascita."');";
    $query_res = pg_query($con, $query);

    echo "ciao".$query_res; //perchè??
echo "ciao".$query; //perchè??

    if(!query_res){
        echo "Errore nella query: ".pg_last_error($con);
        exit;
    }else{
        header("Location:home.html");
    }
?>