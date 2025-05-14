<?php

declare(strict_types=1); // Enabling type declarations

// Database helper variables
$dsn = "mysql:host=localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "flashcards";

try {
    
    // Establishing a connection to the server and exception handling
    $conn = new PDO($dsn, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Updates the PDO object to enable direct access to 'flashcards' database
function update_pdo(string $dbname, string $dbusername, string $dbpassword) {

    $dsn = "mysql:host=localhost;dbname=$dbname";

    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;

}