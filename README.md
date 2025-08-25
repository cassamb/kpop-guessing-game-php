# Kpop Guessing Game: PHP Implementation

This is the second of three iterations in the Kpop Guessing Game series which also includes the [kpop-guessing-game-js](https://github.com/cassamb/kpop-guessing-game-js) and [kpop-guessing-game-ajax](https://github.com/cassamb/kpop-guessing-game-ajax) projects.

![Static Badge](https://img.shields.io/badge/JavaScript-yellow?style=for-the-badge&logo=javascript&logoColor=white)
![Static Badge](https://img.shields.io/badge/HTML-%23e34c26?style=for-the-badge&logo=HTML5&logoColor=white)
![Static Badge](https://img.shields.io/badge/CSS-%231572B6?style=for-the-badge&logo=CSS&logoColor=white)
![Static Badge](https://img.shields.io/badge/PHP-%238993be?style=for-the-badge&logo=PHP&logoColor=white)
![Static Badge](https://img.shields.io/badge/MySQL-%2300758f?style=for-the-badge&logo=MySQL&logoColor=white)
![Static Badge](https://img.shields.io/badge/XAMPP-%23fb7a24?style=for-the-badge&logo=XAMPP&logoColor=white)

**Disclaimer:** Due to the knowledge and experience gained since this project was originally commissioned in 2019, some specifications (i.e., certain technologies, requirements, and practices) have been modified and/or removed to improve the overall quality of the program while maintaining the original intent. **Any notable modifications made in this iteration (and beyond) will be addressed accordingly.**

## Introduction

### Background

This project was originally commissioned by Professor Kumar of Nova Southeastern University's College of Computing and Engineering for the 2019 Web Programming and Design course. Students were tasked with creating a flashcard quiz game on the topic of their choosing. The **K-pop genre** was selected as the subject matter for this implementation due to personal interest as well as the music genre's growing popularity at the time. 

This is a continuation of the JavaScript implementation (refer to the [kpop-guessing-game-js](https://github.com/cassamb/kpop-guessing-game-js) repository for more details) which laid the foundation for the overall project. This version is the integration of a proper backend (using PHP, SQL, and mySQL) into the existing foundation of the program. Thus, the purpose of this project was to demonstrate one’s understanding of database communication, server-side languages and processes, relational databases, and incremental development by implementing additional functionalities in an existing project. This project was tested in the Google Chrome web browser and developed using PHP, SQL, mySQL, JavaScript, HTML, CSS, Visual Studio Code, and XAMPP v3.3.0.

### Project Overview

As mentioned before, this project is a flashcard quiz game so the user is presented an image of a Kpop group along with four possible names for that group (3 wrong answers, one correct answer). If the user selects the correct answer, their score is incremented; otherwise, the score stays the same. This continues until the array of "flashcards" has been exhausted. Once the game is considered over, the user’s final score is displayed and they are prompted to return to the home page to start the game again.

## Specifications

### UI Requirements

The UI design was left to the student’s discretion, so there was a freedom to do however little or however much one desired in terms of aesthetics as long as the following "pages" and elements within them were included:
* **Start Page**: Page that welcomes the user and explains the rules of the quiz.
  * Game Title
  * Game Explanation
  * Start Button
* **Game Page**: Page in which the actual gameplay occurs.
  * Question Number
  * Score
  * Randomized Image
  * Prompt
  * Multiple Choice Buttons
  * **Next Button**
* **Ending Page**: Page that is displayed once the user completes the game and displays the user's final score.
  * Final Score
  * **Customized Goodbye Message**
  * Home Button

The **bold** elements denote components of the UI that were not required in the original assignment specification; however, they are included in this implementation in an effort to improve the usability and user experience while operating the program.

### Logical Requirements

Considering the foundation of the program was already laid with the previous iteration, the following requirements are an addition to what was outlined in that version of the program.
- [x] Creating a ‘flashcards’ database which stored the names of the groups and the corresponding image URLs.
  * **Note:** The data needed to be loaded from a .csv file. 
- [x] Retrieving the data from the database using PHP and SQL to populate the name and url arrays respectively.
- [x] Providing additional feedback to the user by highlighting their selection when clicked.
  * If correct, the border of the button should be turned green; otherwise, the border turns red.


## Design

### Front-End Design

“Boba runs” and cafe hangouts are popular activities amongst Kpop fans, so much so that bubble tea shops often host events catering to fans of Kpop. So, an in an effort to appeal to the demographic and pay homage to the aesthetic, the UI utilizes bright neutrals to evoke a feeling of familiarity and comfort for the users. In addition, the borders of the images are rounded to mimic that of photocards that fans receive in the albums they purchase and trade with each other at events hosted by various bubble tea shops. Overall, the UI is designed to evoke the feelings of attending a trading card event at a cozy bubble tea shop with friends. 

### Architectural Design

Given the specifications and the simple nature of the project, procedural programming was the best suited paradigm for development. The idea is the update() function serves as the “main” which controls the progression of the game by calling modular functions to carry out the various responsibilities of the program (i.e., updateProgress() which updates the UI to display the current question number and the user’s score). There are also helper functions which assist the subroutines during their execution throughout the program (i.e., the isUnique(ans) function which determines if the given argument is unique in the current lineup of multiple choice answers).

### Back-End Design

The most apparent change from the last iteration is the addition of a database to store the flashcard data. Therefore, we'll be working with the 'flashcards' database which contains a 'groups' table that holds the ID (primary key), NAME, and URL for each group. The data was to be specifically loaded from the groups.csv file. Originally, students were provided files that contained SQL code to assist with instantiating the database, it's table, and it's data manually. The process was a bit convulted, so instead an external database handler (see [kpop-guessing-game-dbh](https://github.com/cassamb/kpop-guessing-game-dbh) repository) has been created to streamline the initialization process a bit more. The handler is responsible for the following:
* Establishing a server connection and checking whether or not the ‘flashcards’ database currently exists on the user’s local machine. 
* Instantiates the ‘flashcards’ database if it does not currently exist.
* Shuffles the order of the questions and populates the names and urls arrays respectively.
* Displays the 'groups' table entries to ensure the images are rendered properly.

## Afterword

### Previous Limitations & Modifications

#### Functional Modifications

Given this project was assigned in a lower-level programming and design course, the requirements and capabilities of the program are reflective of my knowledge at the time. Therefore, in an effort to improve the quality of this project in terms of usability and generality, the following changes have been made to the program:
* **The inclusion of a database handler:** Originally, the database initialization was a preliminary step that *had* to be done manually by the user independent of the program's execution. In this implementation, an external database initializer/handler is available to supplement the execution of the program (see [kpop-guessing-game-dbh](https://github.com/cassamb/kpop-guessing-game-dbh) repository for more details). The handler checks whether the “flashcards” database exists or not. If it does not exist, it is instantiated for the user using the provided .csv file; otherwise, the program references the existing database. Thus, all the user is required to do is to start the Apache and MySQL modules in XAMPP. 
* **Using PDO instead of sqli for the database connection:** sqli was used to connect to the server in the original specification; however, in an effort to not constrain the user to only SQL databases, a PDO connection was used in this implementation as well as the next.

#### Non-Functional Modifications

In an effort to improve the user experience, the following additions have been made to the game:
* The ability to opt-out of answering questions via the "Skip Question" button.
* User-based game progression via the "Next Question" button. **Players are no longer forcibly moved to the next question once an answer is selected and can progress at their own pace.**
* Customized messages based on player's final score.

### Future Expectations

The functionality expected in the next iteration of the program includes the following:
* UX Improvements 
  * Better visual feedback so correct answer is highlighted if the user selects a wrong answer.
  * Hint mechanism which allows users to receive hints for each question through process of elimination.
  * Score bar implementation
* Improved storage capabilties via AJAX (all groups data no longer need to be stored on the client-side).
