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
        
        $query = "SET datestyle = dmy; INSERT INTO offerta (tipoofferta,datainizio,datafine,valore,creatore) VALUES ('".$tipo."','".$datainizio."','".$datafine."','".$valore."','".$creatore."') RETURNING codiceofferta; "; //creo l'offerta e prendo il codice
        echo $query;
        // RETURNING codiceofferta è uguale a fare SELECT codiceofferta FROM offerta WHERE tipoofferta = '".$tipo."' AND datainizio = '".$datainizio."' AND datafine = '".$datafine."' AND valore = '".$valore."' AND creatore = '".$creatore."';      
        
        $query_res = pg_query($con, $query);
        
        while ($row = pg_fetch_array($query_res)) {  
            $codofferta = $row[0]."";                       // $codofferta contiene il codice dell'offerta
        }

        $query1 = "SELECT idtessera FROM tesserato WHERE cf = '".$cf."';";           // $query1 seleziona l'id del tesserato che riceve l'offerta

        $query1_res = pg_query($con, $query1); 
        
        while ($row1 = pg_fetch_array($query1_res)) {  
            $id = $row1[0]."";                              // $id contiene l'id del tesserato
        }

        $query3 = "INSERT INTO assegnazioneofferta (offerta, tesserato) VALUES ('".$codofferta."','".$id."');";
        
        $query3_res = pg_query($con, $query3);
        
        if(!$query3_res){
            echo "Errore nella query: ".pg_last_error($con);
            exit;
        }else{
            header("Location:home.html");
        
    }
        
        //---------------------------------------------------------------------------------------------
        
            
    }elseif($tipo=="offertaspeciale"){ 
        
        $valore = pg_escape_string($_POST["valore"]);
        $datainizio = pg_escape_string($_POST["datainizio"]);
        $datafine = pg_escape_string($_POST["datafine"]);
        $destinatario = pg_escape_string($_POST["destinatario"]);
        $cf = pg_escape_string($_POST["cf"]);
        $creatore = pg_escape_string($_SESSION["CF"]);
        
        $query = "SET datestyle = dmy; INSERT INTO offerta (tipoofferta,datainizio,datafine,valore,creatore) VALUES ('".$tipo."','".$datainizio."','".$datafine."','".$valore."','".$creatore."') RETURNING codiceofferta; "; // creo l'offerta e prendo il codice
        $query_res = pg_query($con, $query);
        
        while ($row = pg_fetch_array($query_res)) {  
            $codofferta = $row[0]."";                       // $codofferta contiene il codice seriale dell'offerta
        }
    }

    if($destinatario=="cf"){ //---------------------------------------------------------------------------------------------

            $query1 = "SELECT idtessera FROM tesserato WHERE cf = '".$cf."';";           // $query1 seleziona l'id del tesserato che riceve l'offerta

            $query1_res = pg_query($con, $query1); 

            while ($row1 = pg_fetch_array($query1_res)) {  
                $id = $row1[0]."";           // $id contiene l'id del tesserato
            }

            $query3 = "INSERT INTO assegnazioneofferta (offerta, tesserato) VALUES ('".$codofferta."','".$id."');";

            $query3_res = pg_query($con, $query3);


    }else{ //---------------------------------------------------------------------------------------------

            $query1 = "SELECT idtessera FROM tesserato WHERE livellotessera = '".$destinatario."' AND scadenzatessera > current_date; ";   // $query1 seleziona l'id del tesserato che riceve l'offerta 

            $query1_res = pg_query($con, $query1); 

            while ($row1 = pg_fetch_array($query1_res)) {  
                $id = $row1[0]."";         // $id contiene l'id del tesserato
                echo $id;

                $query3 = "INSERT INTO assegnazioneofferta (offerta, tesserato) VALUES ('".$codofferta."','".$id."');";

                $query3_res = pg_query($con, $query3);

            }

    }
                    
    if(!$query3_res){
        echo "Errore nella query: ".pg_last_error($con);
        exit;
    }else{
        header("Location:home.html");

    }
?>










