<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wordle</title>
    <link rel='stylesheet' type='text/css' href='assets/style.css' />
    <script type="text/javascript" src="assets/wordlegame.js"></script>
    <script type="text/javascript" src="assets/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            console.log("INIT")
            WordleApi.newGame();
        }
    </script>
</head>

<body>
    <div class="header">
        <span>Wordle</span>
    </div>
    <div >
        <div class="score-container">
            <span>Word Streak: </span> 
            <span id="score"></span>
        </div>
        <div class="score-container">
            <span>Best Streak: </span>
            <span id="best-score"></span>
        </div>
    </div>
    <div class="board" id="board">
        <div class="row" id="row1">
            <div class="letter-box" id="box1"></div>
            <div class="letter-box" id="box2"></div>
            <div class="letter-box" id="box3"></div>
            <div class="letter-box" id="box4"></div>
            <div class="letter-box" id="box5"></div>
        </div>
        <div class="row" id="row2">
            <div class="letter-box" id="box1"></div>
            <div class="letter-box" id="box2"></div>
            <div class="letter-box" id="box3"></div>
            <div class="letter-box" id="box4"></div>
            <div class="letter-box" id="box5"></div>
        </div>
        <div class="row" id="row3">
            <div class="letter-box" id="box1"></div>
            <div class="letter-box" id="box2"></div>
            <div class="letter-box" id="box3"></div>
            <div class="letter-box" id="box4"></div>
            <div class="letter-box" id="box5"></div>
        </div>
        <div class="row" id="row4">
            <div class="letter-box" id="box1"></div>
            <div class="letter-box" id="box2"></div>
            <div class="letter-box" id="box3"></div>
            <div class="letter-box" id="box4"></div>
            <div class="letter-box" id="box5"></div>
        </div>
        <div class="row" id="row5">
            <div class="letter-box" id="box1"></div>
            <div class="letter-box" id="box2"></div>
            <div class="letter-box" id="box3"></div>
            <div class="letter-box" id="box4"></div>
            <div class="letter-box" id="box5"></div>
        </div>
        <div class="row" id="row6">
            <div class="letter-box" id="box1"></div>
            <div class="letter-box" id="box2"></div>
            <div class="letter-box" id="box3"></div>
            <div class="letter-box" id="box4"></div>
            <div class="letter-box" id="box5"></div>
        </div>
    </div>
    <div class="input-container popup">
        <input id="inputBox" type="text" maxlength="5" autofocus />
        <span class="popuptext" id="myPopup">

            <button class="popupbutton" type="reset">Again?</button>
        </span>
    </div>
    <div id="keyboard-cont">
        <div class="first-row">
            <button class="keyboard-button">q</button>
            <button class="keyboard-button">w</button>
            <button class="keyboard-button">e</button>
            <button class="keyboard-button">r</button>
            <button class="keyboard-button">t</button>
            <button class="keyboard-button">y</button>
            <button class="keyboard-button">u</button>
            <button class="keyboard-button">i</button>
            <button class="keyboard-button">o</button>
            <button class="keyboard-button">p</button>
        </div>
        <div class="second-row">
            <button class="keyboard-button">a</button>
            <button class="keyboard-button">s</button>
            <button class="keyboard-button">d</button>
            <button class="keyboard-button">f</button>
            <button class="keyboard-button">g</button>
            <button class="keyboard-button">h</button>
            <button class="keyboard-button">j</button>
            <button class="keyboard-button">k</button>
            <button class="keyboard-button">l</button>
        </div>
        <div class="third-row">
            <button class="keyboard-button large-key">Enter</button>
            <button class="keyboard-button">z</button>
            <button class="keyboard-button">x</button>
            <button class="keyboard-button">c</button>
            <button class="keyboard-button">v</button>
            <button class="keyboard-button">b</button>
            <button class="keyboard-button">n</button>
            <button class="keyboard-button">m</button>
            <button class="keyboard-button large-key">Del</button>
        </div>
    </div>
</body>

</html>