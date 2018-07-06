<?php
    session_start();
    // Lettura da variabili globali dei valori passati in post
    if (!isset($_SESSION["CF"])) {
      $cf  = $_POST["CF"];
      $pass = $_POST["pwd"];
    } else {
      $cf=$_SESSION["CF"];
      $pass=$_SESSION["pwd"];
    }
    // connessione al database
    $con = pg_connect("host=localhost port=5432 dbname=negoziovideogiochi  user=postgres password=unimi");
    // se la connessione è andata male
    if(!$con){
      echo "Errore nella connessione al database: ".pg_last_error($con);
      exit;
    }
    $query="SELECT * FROM dipendente WHERE cf='$cf' AND password='$pass'";
    $query_res = pg_query($con, $query);
    if(!$query_res){
      echo "Errore nella query".pg_last_error($con);
      exit();
    }
    // se ho ottenuto almeno un risultato, vuol dire che il cliente è stato riconosciuto
    if (pg_fetch_array($query_res)) {
      $_SESSION["CF"]=$cf;
      $_SESSION["pwd"]=$pass;
      header("Location: home.html");
      echo "Sei dentro: ".$query_res;
    // l'utente non e' riconosciuto
    } else {
      unset($_SESSION["CF"]);
      unset($_SESSION["pwd"]);
      header("Location: index.html");
    }
    
        
?>