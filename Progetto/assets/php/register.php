<?php

require_once('config.php');

$Username = $connessione->real_escape_string($_POST['Username']);
$Password = $connessione->real_escape_string($_POST['Password']);
//$options = ['salt' => "salt"];
$options = ['cost' => 19];
$salt = base64_encode(random_bytes(16));
$salted_password = $Password.$salt;

$salted = false;

//$hashed_password = password_hash($Password, PASSWORD_DEFAULT); //bcrypt without cost
//$hashed_password = md5($Password); //cracked
//$hashed_password = md5($salted_password); //cracked
//$hashed_password = sha1($Password); //cracked
//$hashed_password = hash("sha256",$Password); //cracked
//$hashed_password = hash("sha512",$Password); //cracked
//$hashed_password = hash("sha512",$salted_password); //cracked
//$hashed_password = crypt($Password); //errore, necessita sale per php
//$hashed_password = crypt($Password,'$1$rasmusle$'); //md5salt, cracked
//$hashed_password = crypt($Password,'$6$rounds=5000$weak_salt$'); //sha512 salted, cracked
$hashed_password = password_hash($Password, PASSWORD_BCRYPT, $options); //cracked with cost 10

if($salted){
   $sql = "INSERT INTO utente (Username,Password,Salt) VALUES ('$Username','$hashed_password','$salt')";
}
else{
   $sql = "INSERT INTO utente (Username,Password) VALUES ('$Username','$hashed_password')";
}
if($connessione->query($sql) === true){
    echo "Registrazione effettuata con successo";
} else{
    echo "Errore durante registrazione utente $sql. " . $connessione->error;
}


?>

