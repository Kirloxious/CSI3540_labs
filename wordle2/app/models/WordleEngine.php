<?php

namespace Wordle;

class WordleEngine
{
    private $GameState;

    public function __construct($GameState)
    {
        $this->GameState = $GameState;
    }

    public function getWordList(): array
    {
        $wordList = [];
        $wordFile = fopen("../app/models/words.csv", "r") or die("Unable to open file!");
        while (!feof($wordFile)) {
            array_push($wordList, str_replace("\n","",fgets($wordFile)));
        }
        fclose($wordFile);
        return $wordList;
    }

    public function selectRandomWord(): string
    {
        return $this->GameState->get_words()[array_rand($this->GameState->get_words())];
    }

    public function checkCorrectLetter(): array
    {
        $arrayInput = str_split($this->GameState->get_userInputWord());
        $arrayWord = str_split($this->GameState->get_chosenWord());
        $resultArray = [];
        //Check for green first
        for ($i = 0; $i < 5; $i++) {
            if ($arrayInput[$i] == $arrayWord[$i]) {
                $resultArray[$i] = color::GREEN;
                $arrayInput[$i] = "";
                $arrayWord[$i] = "";
            } else {
                $resultArray[$i] = color::GRAY;
            }
        }
        for ($i = 0; $i < 5; $i++) {
            if (in_array($arrayInput[$i], $arrayWord)) {
                $letterIndex = array_search($arrayInput[$i], $arrayWord);
                $arrayWord[$letterIndex] = "";
                $arrayInput[$i] = "";
                if ($resultArray[$i] != color::GREEN) {
                    $resultArray[$i] = color::YELLOW;
                }
            }
        }
        return $resultArray;
    }


    public function assertWordInList(){
        return in_array($this->GameState->userInputWord, $this->GameState->words);
    }

}
