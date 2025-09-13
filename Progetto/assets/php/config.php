<?php

$connessione = new mysqli('localhost','root','','progetto_IS');

if($connessione == false){
    die("Errore durante la connessione:". $connessione->conncet_error);
}

?>