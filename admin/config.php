<?php
   define('DB_SERVER', 'db');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'test');
   define('DB_NAME', 'db_cbt');

   /* Attempt to connect to MySQL database */
   $link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

   // Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}