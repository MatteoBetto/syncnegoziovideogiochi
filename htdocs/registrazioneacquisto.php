<?php
    $con = pg_connect("host=localhost port=5432 dbname=negoziovideogiochi  user=postgres password=unimi") or die ("ERRORE DI CONNESSIONE AL DB");

    // Metto gli elementi del carrello in un array associativo
    foreach ($_POST as $key => $val)
    {
        $count++;
        $formElements[]=array($key => $val);
    }
    print_r($formElements);
    
    //"INSERT INTO acquisto(cf, tipoprodotto, codiceprodotto, quantita, importocad, dataacquisto) VALUES ()
    //echo $formElements['prodotto1'];

?>