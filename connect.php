<?php
$server_name = "localhost";
$database_name = "flood_website";
$username = "root";
$password = "";

// Connect to the database
try {
    $db =  new PDO("mysql:host=$server_name;dbname=$database_name", $username, $password);
} catch (PDOException $e) {
    print "Can't connect: " . $e->getMessage();
    exit();
}
// Set up exceptions on DB errors
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Set up fetch mode: rows as objects
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>