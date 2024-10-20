<?php


$username = 'root';
$password = 'Mmmm@0000';
$hostname='localhost';
$database='mysql';


    $conn= new mysqli($hostname,$username,$password,$database);

     if(!$conn){
         echo "connection failed";
     }

?>

