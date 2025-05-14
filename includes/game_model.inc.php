<?php

declare(strict_types=1); // Enabling type declarations

/* DATABASE INSTANTIATION AND INITIALIZATION */

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

    $file = fopen("../groups.csv", "r");
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

/* GAMEPLAY FUNCTIONS */

// Shuffles the entries of the 'groups' table and returns the result as an associative array
function get_shuffled_groups(object $pdo) {

    $query = $pdo->prepare("SELECT name FROM groups ORDER BY RAND();");
    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    return $results;

}