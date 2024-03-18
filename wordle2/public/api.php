<?php

require_once('_config.php');
session_start();



use Wordle\WordleGame;

function game()
{
    if ($json = $_SESSION['game'] ?? null) {
        return WordleGame::fromJson($json);
    } else {
        return new WordleGame();
    }
}

function persistGame($game)
{
    $reply = $game->toJson();
    $_SESSION['game'] = $reply;
    return $reply;
}


function newGame()
{
    $new_game = new WordleGame();
    $new_game->init();
    if ($json = $_SESSION['game'] ?? null) {
        $old_session = WordleGame::fromJson($json);
        $new_game->scoreStreak = $old_session->scoreStreak;
        $new_game->bestScore = $old_session->bestScore;
    }
    $new_game_json = $new_game->toJson();
    $_SESSION['game'] = $new_game_json;
    return $new_game_json;
}

function updateGame($json_data)
{
    $currentState = WordleGame::fromJson($_SESSION['game']);
    $updatedState = WordleGame::fromJson($json_data);
    $updatedState->words = $currentState->words;
    $updatedState->chosenWord = $currentState->chosenWord;
    $jsonState = $updatedState->toJson();
    $_SESSION['game'] = $jsonState;
    return $jsonState;
}

function currentGame(){
    if ($json = $_SESSION['game'] ?? null) {
        return WordleGame::fromJson($json);
    }
    return NULL;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $fullPath = $_GET["path"] ?? "/version";
    $path = explode("/", $fullPath);

    switch ($fullPath) {
        case "/version":
            $reply = json_encode(["version" => "0.9"]);
            break;
        case "/game/new":
            $reply = newGame();
            break;
        case "/game/current":
            $reply = $_SESSION['game'];
            break;
        case "/game/check_word":
            if($game = currentGame() ?? null){
                //check word
                $game->inputWordInWordList = $game->WordleEngine->assertWordInList();
                $reply = $game->toJson();
            } else{
                $reply = "Could not find current game session.";
            }
            break;
        case "/game/check_letters":
            if($game = currentGame() ?? null){
                //check letters and add it to the color board table
                $game->colorBoard[$game->currentRow-1] = $game->WordleEngine->checkCorrectLetter();
                $reply = $game->toJson();
            } else{
                $reply = "Could not find current game session.";
            }
            break;
        case "/game/check_win":
            if($game = currentGame() ?? null){
                if($game->chosenWord == $game->userInputWord){
                    $game->scoreStreak++;
                    $game->win = true;
                }
                else if($game->currentRow == 7){
                    $game->win = false;
                    if($game->scoreStreak >= $game->bestScore){
                        $game->bestScore = $game->scoreStreak;
                    }
                    $game->scoreStreak = 0;

                }
                $reply = $game->toJson();
            } else{
                $reply = "Could not find current game session.";
            }
            break;
    }


    header("Content-Type: application/json");
    echo $reply;
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reply = updateGame((file_get_contents('php://input')));

    header("Content-Type: application/json");
    echo ($reply);

    // echo $reply;
}
