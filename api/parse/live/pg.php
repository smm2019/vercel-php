<?php
$host=$_ENV["POSTGRES_HOST"];
$data=$_ENV["POSTGRES_DATABASE"];
$user=$_ENV["POSTGRES_USER"];
$pass=$_ENV["POSTGRES_PASSWORD"];


$conn_string = "host=$host dbname=$data user=$user password=$pass";
echo $conn_string;
$dbconn = pg_connect($conn_string);
var_dump($dbconn);

