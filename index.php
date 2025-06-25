<?php
    require_once "dbh.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kpop Guessing Game: PHP</title>
    
    <script>
        // Retrieving shuffled names and urls from PHP file
        var names = <?php echo json_encode($names)?>;
        var urls = <?php echo json_encode($urls)?>;
        
        document.write(names);
        document.write(urls);
    </script>
</head>
<body>
    
</body>
</html>