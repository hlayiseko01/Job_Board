<?php


$username = 'root';
$password = '*****';
$hostname='localhost';
$database='mysql';


    $conn= new mysqli($hostname,$username,$password,$database);

     if(!$conn){
         echo "connection failed";
     }

?>

