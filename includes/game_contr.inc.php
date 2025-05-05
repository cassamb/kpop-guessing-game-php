<?php

/* This is the main game file (controller) for the program */

if ($_SERVER["REQUEST_METHOD"] === "POST") { // If the user accessed the page (properly) by submitting a form via POST method

    echo "This is the game controller";

} else { // Otherwise, ...
    // Redirect the user to the homepage and kill the script
    header("Location: ../index.php");
    die();
}