<?php

    $con = pg_connect("host=localhost port=5432 dbname=negoziovideogiochi  user=postgres password=unimi");
    if(!$con){
      echo "Errore nella connessione al database: ".pg_last_error($con);
      exit;
    }

    $tipo = pg_escape_string($_POST["tipo"]);
    if($tipo=="videogioco"){

        $titolo = pg_escape_string($_POST["titolo"]);
        $piattaforma = pg_escape_string($_POST["piattaforma"]);
        $genere = pg_escape_string($_POST["genere"]);
        $condizione = pg_escape_string($_POST["condizione"]);
        $prezzo = pg_escape_string($_POST["prezzo"]);
        $quantita = pg_escape_string($_POST["quantita"]);
        $datauscita = pg_escape_string($_POST["datauscita"]);
    
        $query = "SET datestyle = dmy; INSERT INTO videogioco (titolo,piattaforma,genere,condizione,prezzo,quantita,datauscita) VALUES ('".$titolo."','".$piattaforma."','".$genere."','".$condizione."','".$prezzo."','".$quantita."','".$datauscita."')
ON CONFLICT (titolo,piattaforma,condizione) DO UPDATE SET quantita = videogioco.quantita + ".$quantita."";
            
    }elseif($tipo=="console"){
        
        $nome = pg_escape_string($_POST["nome"]);
        $modello = pg_escape_string($_POST["modello"]);
        $produttore = pg_escape_string($_POST["produttore"]);
        $condizione = pg_escape_string($_POST["condizione"]);
        $prezzo = pg_escape_string($_POST["prezzo"]);
        $quantita = pg_escape_string($_POST["quantita"]);
        $datauscita = pg_escape_string($_POST["datauscita"]);
        
     
        $query = "SET datestyle = dmy; INSERT INTO console (nome,modello,produttore,condizione,prezzo,quantita,datauscita) VALUES ('".$nome."','".$modello."','".$produttore."','".$condizione."','".$prezzo."','".$quantita."','".$datauscita."')
ON CONFLICT (nome,modello,condizione) DO UPDATE SET quantita = console.quantita + ".$quantita."";
    }

    $query_res = pg_query($con, $query);
    if(!$query_res){
        echo "Errore nella query: ".pg_last_error($con);
        exit;
    }else{
        header("Location:home.html");
    }
    
?>