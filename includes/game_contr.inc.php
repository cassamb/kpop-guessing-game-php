<?php

/* This is the main game file (controller) for the program */

if ($_SERVER["REQUEST_METHOD"] === "POST") { // If the user accessed the page (properly) by submitting a form via POST method

    require_once "dbh.inc.php";
    require_once "game_model.inc.php";

    // Checking if the given database has already been instantiated
    if (!check_db_status($conn, $dbname)) {

        // Database instantiation and initialization
        create_db($conn, $dbname);      // Creating the database
        create_table($conn, $dbname);   // Creating a table
        insert_data($conn, $dbname);    // Populating the table

    }

    // Updating the PDO object for ease of use throughout program and closing general server connection
    $pdo = update_pdo($dbname, $dbusername, $dbpassword);
    $conn = null; 

    // Instantiating global game variables
    $groups = shuffle_groups($pdo);
    $qCount = 0;
    $totalQs = count($groups);
    $score = 0;
    $numCrrct = 0;
    $choices = [];
    $ans = "";
    
    echo "There are " . $totalQs . " questions in this quiz";
    

} else { // Otherwise, ...
    // Redirect the user to the homepage and kill the script
    header("Location: ../index.php");
    die();
}

function shuffle_groups(object $pdo) {

    return get_shuffled_groups($pdo);
    
}