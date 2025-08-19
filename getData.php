<?php

declare(strict_types=1); // Enabling type declarations

// Database helper variables
$dbname = "flashcards";
$dsn = "mysql:host=localhost;dbname=$dbname";
$dbusername = "root";
$dbpassword = "";

try {

    // Establishing a connection to the 'flashcards' database with exception handling
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
    // Getting and setting shuffled names and corresponding urls
    $data = get_shuffled_data($pdo);
    $names = $data[0];
    $urls = $data[1];

    // Closing server connections
    $pdo = null;
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Retrieves shuffled names and urls from database
function get_shuffled_data(object $pdo) {

    // Shuffling database entries
    $query = $pdo->prepare("SELECT name, url FROM groups ORDER BY RAND();");
    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    // Temporary storage
    $name_data = [];
    $url_data = [];

    // Populating name and url arrays respectively
    foreach ($results as $result) {
        array_push($name_data, $result["name"]);
        array_push($url_data, $result["url"]);
    }

    return [$name_data, $url_data]; // Return results as multidimensional array
}
