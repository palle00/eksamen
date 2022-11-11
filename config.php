<?php
/* Database oplysninger */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'resturant');
 
/* Prøv og connect til databasen */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Tjek om vi er connected
if($link === false){
    die("ERROR: Kunne ikke connecte. " . mysqli_connect_error());
}
?>
