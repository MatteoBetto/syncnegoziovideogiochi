<?php

    $con = pg_connect("host=localhost port=5432 dbname=negoziovideogiochi  user=postgres password=unimi");
    if(!$con){
      echo "Errore nella connessione al database: ".pg_last_error($con);
      exit;
    }

    $tipo = pg_escape_string($_POST["tipo"]);           //imposto la variabile $tipo in base alla richiesta, può essere "prenotazionevideogioco" o "prenotazioneconsole"

    if($tipo=="prenotazionevideogioco"){            //se il tipo è == a "prenotazionevideogioco"

        $cf = pg_escape_string($_POST["cf"]);
        $titolo = pg_escape_string($_POST["titolo"]);
        $piattaforma = pg_escape_string($_POST["piattaforma"]);                     //setto le variabili con gli input della pagina html
        $dataprenotazione = pg_escape_string($_POST["dataprenotazione"]);
        
        $query = "SELECT idtessera FROM tesserato WHERE cf = '".$cf."'";          //$query mi seleziona "idtessera" dalla tabella "tesserato" del tesserato che ha cf = $cf
        
        $query_res = pg_query($con, $query);
        while ($row = pg_fetch_array($query_res)) {  
        $tessera = $row[0]."";          //contiene il codice della tessera
        }
        
        $query2 = "SELECT codicevideogioco FROM videogioco WHERE titolo = '".$titolo."' AND piattaforma = '".$piattaforma."';";
        
        $query2_res = pg_query($con, $query2);
        while ($row2 = pg_fetch_array($query2_res)) {  
        $gioco = $row2[0]."";           //contiene il codice del videogioco
        }
        
        $query3 = "SET datestyle = dmy; INSERT INTO prenotazione (tesserato,tipoprodotto,codiceprodotto,dataprenotazione) VALUES ('".$tessera."','videogioco','".$gioco."','".$dataprenotazione."');";
        
        $query3_res = pg_query($con, $query3);
        
    }elseif($tipo=="prenotazioneconsole"){          //se il tipo è == a "prenotazioneconsole"
        
        $cf = pg_escape_string($_POST["cf"]);
        $nome = pg_escape_string($_POST["nome"]);
        $modello = pg_escape_string($_POST["modello"]);
        $dataprenotazione = pg_escape_string($_POST["dataprenotazione"]);
        
        $query = "SELECT idtessera FROM tesserato WHERE cf = '".$cf."'";          //$query mi seleziona "idtessera" dalla tabella "tesserato" del tesserato che ha cf = $cf
        
        $query_res = pg_query($con, $query);
        while ($row = pg_fetch_array($query_res)) {  
        $tessera = $row[0]."";          //contiene il codice della tessera
        }
        
        $query2 = "SELECT codiceconsole FROM console WHERE nome = '".$nome."' AND modello = '".$modello."';";
        
        $query2_res = pg_query($con, $query2);
        while ($row2 = pg_fetch_array($query2_res)) {  
        $console = $row2[0]."";         //contiene il codice della console
        }
        
        $query3 = "SET datestyle = dmy; INSERT INTO prenotazione (tesserato,tipoprodotto,codiceprodotto,dataprenotazione) VALUES ('".$tessera."','console','".$console."','".$dataprenotazione."');";
        
        $query3_res = pg_query($con, $query3);
    }

    $query3_res = pg_query($con, $query);

    if(!$query_res){
        echo "Errore nella query: ".pg_last_error($con);
        exit;
    }else{
        header("Location:home.html");
    }  
?>
