<?php

/* This is the database handler file */

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

    // Checking if the given database has already been instantiated
    if (!check_db_status($conn, $dbname)) {

        // Database instantiation and initialization
        create_db($conn, $dbname);      // Creating the database
        create_table($conn, $dbname);   // Creating a table
        insert_data($conn, $dbname);    // Populating the table

    }

    // Updating the PDO object (now accessing 'flashcards' database directly) and closing general server connection
    $pdo = update_pdo($dbname, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
    // Getting and setting shuffled names and corresponding urls
    $data = get_shuffled_data($pdo);
    $names = $data[0];
    $urls = $data[1];

    // Closing server connections
    $conn = null;
    $pdo = null;
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

/* DATABASE INSTANTIATION AND INITIALIZATION HELPER FUNCTIONS */

// Checks if the given database has already been created
function check_db_status(object $conn, string $dbname) {

    $query = $conn->prepare("SHOW DATABASES like '" . $dbname . "';");
    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($results != null) {
        return true;
    } else {
        return false;
    }

}

// Creates a new database to hold the 'flashcards'
function create_db(object $conn, string $dbname) {

    $query = "CREATE DATABASE $dbname;";
    $conn->exec($query); 

}

// Creates new database table to hold the groups data (name, url)
function create_table(object $conn, string $dbname) {

    $query = "USE $dbname;
    CREATE TABLE Groups(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(31) NOT NULL,
    url VARCHAR(255),
    PRIMARY KEY (id)
    );";

    $conn->exec($query);

}

// Populates data into groups table from .csv file
function insert_data(object $conn, string $dbname) {

    $file = fopen("groups.csv", "r");
    $entries = [];

    while(!feof($file)) { // While there is still data to read in the file

        $entries = fgetcsv($file); // Store the data in the array so we can reference it

        $query = "USE $dbname; INSERT INTO groups (name, url) VALUES (:name, :url);";

        // Submitting the query to the database and binding the data to the parameters (separately)
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $entries[0]);
        $stmt->bindParam(":url", $entries[1]);

        $stmt->execute();

        $stmt = null; // Reset for the next entry
      
    }

}

// Updates the PDO object to enable direct access to 'flashcards' database
function update_pdo(string $dbname, string $dbusername, string $dbpassword) {

    $dsn = "mysql:host=localhost;dbname=$dbname";

    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;

}

/* GAMEPLAY INITIALIZATION HELPER FUNCTIONS */

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
