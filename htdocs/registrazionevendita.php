<?php
    $con = pg_connect("host=localhost port=5432 dbname=negoziovideogiochi  user=postgres password=unimi");
    if(!$con){
        echo "Errore nella connessione al database: ".pg_last_error($con);
        exit;
    }

    $tipo = pg_escape_string($_POST["tipo"]);
    
    if($tipo=="videogioco"){
        
        $tessera = pg_escape_string($_POST["tessera"]);
        $datavendita = pg_escape_string($_POST["datavendita"]);
        $titolo = pg_escape_string($_POST["titolo"]);
        $piattaforma = pg_escape_string($_POST["piattaforma"]);
        $genere = pg_escape_string($_POST["genere"]);
        $condizione = pg_escape_string($_POST["condizione"]);
        $prezzo = pg_escape_string($_POST["prezzo"]);
        $quantita = 1;
        $datauscita = pg_escape_string($_POST["datauscita"]);
        
        
        // Inserimento del videogioco nel catalogo
        $query_inserimento = "SET datestyle = dmy; INSERT INTO videogioco (titolo,piattaforma,genere,condizione,prezzo,quantita,datauscita) VALUES ('".$titolo."','".$piattaforma."','".$genere."','".$condizione."','".$prezzo."','".$quantita."','".$datauscita."')
ON CONFLICT (titolo,piattaforma,condizione) DO UPDATE SET quantita = videogioco.quantita + ".$quantita.";";
        
        // Estrazione del codice del videogioco
        $codicevideogioco = "SELECT codicevideogioco FROM videogioco WHERE titolo='".$titolo."' AND piattaforma='".$piattaforma."' AND condizione='".$condizione."'";
        
        
        // Registrazione della vendita
        $query_vendita = "INSERT INTO vendita (tesserato, tipoprodotto, codiceprodotto, importocad, datavendita) VALUES ('".$tessera."','videogioco',(".$codicevideogioco."),'".$prezzo."','".$datavendita."')";
            
        
        
        
    }elseif($tipo=="console"){
        
        $tessera = pg_escape_string($_POST["tessera"]);
        $datavendita = pg_escape_string($_POST["datavendita"]);
        $nome = pg_escape_string($_POST["nome"]);
        $modello = pg_escape_string($_POST["modello"]);
        $produttore = pg_escape_string($_POST["produttore"]);
        $condizione = pg_escape_string($_POST["condizione"]);
        $prezzo = pg_escape_string($_POST["prezzo"]);
        $quantita = 1;
        $datauscita = pg_escape_string($_POST["datauscita"]);
        
        
        // Inserimento della console nel catalogo
        $query_inserimento = "SET datestyle = dmy; INSERT INTO console (nome,modello,produttore,condizione,prezzo,quantita,datauscita) VALUES ('".$nome."','".$modello."','".$produttore."','".$condizione."','".$prezzo."','".$quantita."','".$datauscita."')
ON CONFLICT (nome,modello,condizione) DO UPDATE SET quantita = console.quantita + ".$quantita.";";
        
        
        // Estrazione del codice della console
        $codiceconsole = "SELECT codiceconsole FROM console WHERE nome='".$nome."' AND modello='".$modello."' AND condizione='".$condizione."'";
        
        
        // Registrazione della vendita
        $query_vendita = "INSERT INTO vendita (tesserato, tipoprodotto, codiceprodotto, importocad, datavendita) VALUES ('".$tessera."','console',(".$codiceconsole."),'".$prezzo."','".$datavendita."')";
        
        
    }




    //echo $query_inserimento;
    //echo "<br>".$query_vendita;
    pg_query("BEGIN") or die("La transazione non può iniziare\n");
    

    $res1 = pg_query($con, $query_inserimento);
    $res2 = pg_query($con, $query_vendita);

    if ($res1 and $res2) {
        echo "Commiting transaction\n";
        pg_query("COMMIT") or die("Transaction commit failed\n");
        header("Location:home.html");
    } else {
        echo "Errore nella transazione\n";
        pg_query("ROLLBACK") or die("Transaction rollback failed\n");
    }

    pg_close($con); 



/*
    $query_res = pg_query($con, $query);
    if(!$query_res){
        echo "Errore nella query: ".pg_last_error($con);
        exit;
    }else{
        //header("Location:home.html");
        echo "TUTTO OK";
    }*/
    

?>


