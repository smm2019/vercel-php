<?php
$host= $_ENV["POSTGRES_HOST"];
print_r('host', $host);
echo $host;
//var_dump($_ENV("POSTGRES_URL"));echo '<br>';
/*
echo $_ENV(POSTGRES_URL_NON_POOLING);echo '<br>';
echo $_ENV(POSTGRES_PRISMA_URL);echo '<br>';
echo $_ENV(POSTGRES_USER);echo '<br>';
echo $_ENV(POSTGRES_HOST);echo '<br>';
echo $_ENV(POSTGRES_PASSWORD);echo '<br>';
echo $_ENV(POSTGRES_DATABASE);echo '<br>';


$conn_string = "host=ep-restless-lake-843526.us-east-1.postgres.vercel-storage.com port=5432 dbname=verceldb user=default password=Cb49hWnYOtaK";
$dbconn4 = pg_connect($conn_string);
var_dump($dbconn4);
*/
