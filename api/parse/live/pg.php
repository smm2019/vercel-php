<?php
$conn_string = "host=ep-restless-lake-843526.us-east-1.postgres.vercel-storage.com port=5432 dbname=verceldb user=default password=Cb49hWnYOtaK";
$dbconn4 = pg_connect($conn_string);
var_dump($dbconn4);
