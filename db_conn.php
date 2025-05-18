<?php

#servername
$servername = "localhost";
#username
$username = "root";
#password
$password = "";
#database name
$db_name = "online_bookstore_db";

try {
    #create connection
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", 
                    $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}