<?php
    require_once "dbh.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Kpop Guessing Game: PHP</title>
    
    <script>
        // Retrieving shuffled names and urls from PHP file
        var names = <?php echo json_encode($names)?>;
        var urls = <?php echo json_encode($urls)?>;
        
        // Score and progress keeping variables
        var qCount = 0;                 // Loop counter; current question offset by 1
        var totalQs = names.length;     // Total number of questions
        var score = 0;                  // User's score
        var numCrrct = 0;               // Number of correct answers

        // Variables for multiple choice generation
        var refArray = [0, 1, 2, 3];    // Reference array for the multiple choice options
        var choices = [];               // Array to populate choices
        var crrctAns = "";              // Correct answer for current question

        /* HELPER FUNCTIONS */

        // [HELPER] Shuffles the given array
        function shuffle(arr) {

            for (var i = arr.length - 1; i > 0; i--) {
                var j = Math.floor(Math.random() * (i + 1 ));
                var temp = arr[i];
                arr[i] = arr[j];
                arr[j] = temp;
            }

        }

        // [HELPER] Determines if the given choice is unique in the current lineup
        function isUnique(ans) 
        {
            for (var c = 0; c < choices.length; c++)
            {
                if (choices[c] == ans)
                {
                    return false;
                }
            }
            return true;
        }

        // [HELPER] Disables the multiple choice buttons
        function disableButtons() {
            for (var i = 1; i < 5; ++i)
            { 
				btn = document.getElementById("opt-" + i);
                btn.disabled = true;
			}
        }

        // [HELPER] Returns buttons back to original state
        function resetButtons() {
            for (var i = 1; i < 5; ++i)
            { 
				btn = document.getElementById("opt-" + i);
                btn.disabled = false;                   // Reactivating button
                btn.style.border = "2px solid black";   // Returning border back to normal
			}
        }

        /* MAIN GAME FUNCTIONS */

        // Hides the welcome UI elements and shows the game UI elements in the view to indicate start of game
        function start() {
            document.getElementsByClassName("welcome-page")[0].style.display = "none";
            document.getElementsByClassName("game-page")[0].style.display = "block";
            update();
        }

        // Main game loop
        function update(){
            
            crrctAns = names[qCount];           // Updating correct answer for current question
            score = (numCrrct/totalQs) * 100;   // Updating user's score

            // Updating gameplay UI elements
            document.getElementById("qstn-num").textContent = "Question # " + (qCount + 1);
            document.getElementById("score").textContent = "Score: " +  score + "%";

            updateImage(qCount);
            updateChoices();

            if (qCount == totalQs) // Ending condition; no more questions to answer
            {
                end();
            }

        }

        // Updates the image currently being shown
        function updateImage(index) {
            var randImg = document.getElementById("pic");
            randImg.setAttribute("src", urls[index]);
            randImg.setAttribute("alt", "Image of " + names[index]);
        }

        // Updates the answer choices for current question using helper functions
        function updateChoices() {
            shuffle(refArray);  
            getChoices();       
            setChoices();       
        }

        // Generates 4 answer choices (3 wrong, 1 right)
        function getChoices() {
            choices[0] = crrctAns; // Correct answer is always in index 0
            var rIndex;
    
            for (var count = 1; count < 4; count++) // Looping to assign values to rest of indexes (1, 2, and 3)
            {
                rIndex = Math.floor(Math.random() * names.length);	// Generate random index
                    
                if (isUnique(names[rIndex])) // If the given group is unique to the current list of choices ...
                {
                    choices[count] = names[rIndex]; // Add it to the multiple choice list as an option
                }
                else
                {
                    count--; // Decrement counter so a different group can be generated
                }
            }
        }

        // Assigns each answer to a button
        function setChoices() {
            var optNum = 0;

            for (var n = 1; n <= 4; ++n) // Looping to assign values to multiple choice buttons (1, 2, 3, and 4)
            {	
                var nameIndex = refArray[optNum]; // Selecting the group name from our shuffled (options) array

                // Creating the buttons for our multiple choice answers, assigning the values, and adding event listeners
                choice = document.getElementById("opt-" + n);
                choice.setAttribute("type", "button");
                choice.setAttribute("value", choices[nameIndex]);		           
                choice.setAttribute("onclick", "buttonClicked(this)");	
                ++optNum;
            } 
        }

        // onclick function
        function buttonClicked(self) {
            
            var userAns = self.getAttribute("value");

            if (userAns == crrctAns)
            { 
                self.style.border = "2px solid green"; // Highlighting the answer choice to be green
                numCrrct++; 
            } 
            else {
                self.style.border = "2px solid red"; // Highlighting the answer choice to be red
            }

            disableButtons();

        }

        function next() {
            resetButtons();

            ++qCount;   // Increment "loop counter"
            update();   // Progress the game
        }

        // Hides gameplay UI elements and shows ending UI element in view to indicate end of game
        function end() {
            document.getElementsByClassName("game-page")[0].style.display = "none";
            document.getElementsByClassName("ending-page")[0].style.display = "block";
            
            document.getElementById("final-score").innerHTML = "<h1>Final Score: " +  score + "%</h1>";
        }

    </script>
</head>

<body>
    <!-- Welcome Page Elements -->
    <div class="welcome-page">
        <h1 id="game-title">Kpop Guessing Game</h1>
        
        <p id="welcome-msg">
            Welcome to the Kpop Quiz! 
            <br><br> 
            This quiz consists of 20 multiple choice questions
            that will test your knowledge of male and female Kpop groups! For those who are new 
            to Kpop, take this opportunity to learn about it! This quiz is <em>just for fun</em>
			so no pressure. Now that's out of the way, let's find out if you can answer all 20 
            questions correctly! 
            <br><br>
            <span style="font-weight: bold;">Click the start button below to begin!</span>
        </p>

        <button id="start-btn" onclick="start()">Start Game</button>
    </div>
    
    <!-- Gameplay Elements -->
    <div class="game-page">
        <h2 id="qstn-num"></h2>
        <h3 id="score"></h3>
    
        <img id="pic" src="" alt="">

        <div id="qstn-prompt"></div>

        <div id="btns">
            <input id="opt-1">
            <input id="opt-2">
            <input id="opt-3">
            <input id="opt-4">
        </div>

        <button id="nxt-btn" onclick="next()">Next</button>
    </div>
        
    <!-- Ending Page Elements -->
    <div class="ending-page">
        <h3 id="final-score"></h3>
        <p id="ending-msg">Thanks for playing! Refresh the page to play another round!</p>
    </div>
    
</body>
</html>