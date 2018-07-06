<?php
    $con = pg_connect("host=localhost port=5432 dbname=negoziovideogiochi  user=postgres password=unimi");
    if(!$con){
      echo "Errore nella connessione al database: ".pg_last_error($con);
      exit;
    }

    $tipo = pg_escape_string($_POST["tipo"]);
    if($tipo=="ricercavideogioco"){

        $titolo = pg_escape_string($_POST["titolo"]);
        $piattaforma = pg_escape_string($_POST["piattaforma"]);
        $genere = pg_escape_string($_POST["genere"]);
        $condizione = pg_escape_string($_POST["condizione"]);
        $prezzo = pg_escape_string($_POST["prezzo"]);
        $quantita = pg_escape_string($_POST["quantita"]);
        $datauscita = pg_escape_string($_POST["datauscita"]);
    
        $query = "SET datestyle = dmy; SELECT titolo,piattaforma,genere,condizione,prezzo,quantita,datauscita FROM videogioco";
        //$query = "SET datestyle = dmy; SELECT * FROM videogioco WHERE (titolo,piattaforma,genere,condizione,prezzo,quantita,datauscita) VALUES ('".$titolo."','".$piattaforma."','".$genere."','".$condizione."','".$prezzo."','".$quantita."','".$datauscita."')"            
    }elseif($tipo=="prenotazioneconsole"){
        
        $nome = pg_escape_string($_POST["nome"]);
        $modello = pg_escape_string($_POST["modello"]);
        $produttore = pg_escape_string($_POST["produttore"]);
        $datauscita = pg_escape_string($_POST["datauscita"]);
        
        //$query = "SET datestyle = dmy; INSERT INTO console (nome,modello,produttore,condizione,prezzo,quantita,datauscita) VALUES ('".$nome."','".$modello."','".$produttore."','".$condizione."','".$prezzo."','".$quantita."','".$datauscita."');";
        $query = "SET datestyle = dmy; INSERT INTO console (nome,modello,produttore,condizione,prezzo,quantita,datauscita) VALUES ('".$nome."','".$modello."','".$produttore."','".$condizione."','".$prezzo."','".$quantita."','".$datauscita."')
ON CONFLICT (nome,modello,condizione) DO UPDATE SET quantita = console.quantita + ".$quantita."";
    }


    $query_res = pg_query($con, $query);
        echo $query;
          echo "<body><div>";
          echo "<table>";
          echo "<thead><tr>";
          echo "<td><b>titolo</b></td>";
          echo "<td><b>piattaforma</b></td>";
          echo "<td><b>genere</b></td>";
          echo "<td><b>condizione</b></td>";
          echo "<td><b>prezzo</b></td>";
          echo "<td><b>quantita</b></td>";
          echo "<td><b>datauscita</b></td>";

          echo "</thead></tr>";
          while ($row = pg_fetch_array($query_res)) {
            $titolo = $row[0]."";
            $piattaforma = $row[1]."";
            $genere = $row[2]."";
            $condizione = $row[3]."";      
            $prezzo = $row[4]."";
            $quantita = $row[5]."";
            $datauscita = $row[6]."";

            echo "<tbody><tr>";
            echo "<td>".$titolo."</td>";
            echo "<td>".$piattaforma."</td>";
            echo "<td>".$genere."</td>";
            echo "<td>".$condizione."</td>";
            echo "<td>".$prezzo."</td>";
            echo "<td>".$quantita."</td>";
            echo "<td>".$datauscita."</td>";
            
            echo "</tbody></tr>";
          }
          echo "</table></div></body>";


//
//    echo "<body>";
//    if(!$query_res){
//        echo "Errore nella query: ".pg_last_error($con);
//        exit;
//    }else{
//        echo "<table>
//                    <thead>
//                        <tr><th>Titolo</th><th>Piattaforma</th><th>Genere</th><th>Condizione</th><th>Prezzo</th><th>Quantità</th><th>Data uscita</th></tr>
//                    </thead>
//                    ";
//        while($row = pg_fetch_assoc($query_res)){
//            echo "<tr>";
//            foreach($row as $key => $value){
//              echo "<td>".$value."</td>";
//            }
//            echo "</tr>";
//        }
//        
//        echo "</table></body>";
        //header("Location:home.html");
    //}
    

    

    
?>