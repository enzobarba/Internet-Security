<?php

require_once('config.php');

$Username = $connessione->real_escape_string($_POST['Username']);
$Password = $connessione->real_escape_string($_POST['Password']);

if($_SERVER["REQUEST_METHOD"] === "POST"){
    
//si suppone di avere un utente admin fisso, non nel db, col seguente problema
//di hard-coded password secondo la CWE-259

    if($Username == "admin" && $Password == "admin"){
        session_start();
        $_SESSION['loggato'] = true;
        $_SESSION['id'] = "admin";
        header("location: ../area-privata.php");
    }

    $sql_select = "SELECT * FROM utente WHERE Username = '$Username' ";
    if($result = $connessione->query($sql_select)){

        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if(password_verify($Password, $row['Password'])) 
            //if(md5($Password) == $row['Password'])
            //if(sha1($Password) == $row['Password'])
            //if(hash("sha256",$Password) == $row['Password'])
            //if(hash("sha512",$Password) == $row['Password'])
            //manca controllo con salt manuale in md5 e sha512
            { 

                session_start();
                $_SESSION['loggato'] = true;
                $_SESSION['id'] = $row['Username'];
                header("location: ../area-privata.php");
                
            }
            else{
                echo "la password non è corretta";
            }
        }else{
            echo "Non ci sono account con questo username";
        }
    }else{
        echo "Errore in fase di login";
    }
    $connessione->close();
}