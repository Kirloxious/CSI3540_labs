<?php

namespace Wordle;

enum color: string
{
    case GREEN = "#538d4e";
    case YELLOW = "#b59f3b";
    case GRAY = "#565758";
    case WHITE = "#fff";
}

class WordleGame
{
    public $WordleEngine;
    public $scoreStreak;
    public $bestScore;

    public $chosenWord;
    public $userInputWord;
    public $inputWordInWordList;
    public $win;
    public $currentRow;
    public $wordBoard;
    public $colorBoard;
    public $words;



    public function __construct()
    {
        $this->WordleEngine  = new WordleEngine($this);
        $this->scoreStreak = 0;
        $this->bestScore = 0;

        $this->words = [];
        $this->chosenWord = '';
        $this->userInputWord = "";
        $this->win = false;
        $this->currentRow = 1;
        $this->wordBoard = ['', '', '', '', '', ''];
        $this->colorBoard = [['', '', '', '', ''], ['', '', '', '', ''], ['', '', '', '', ''], ['', '', '', '', ''], ['', '', '', '', ''], ['', '', '', '', '']];
        $this->inputWordInWordList = $this->WordleEngine->assertWordInList();

    }


    public function init()
    {
        $this->words = $this->WordleEngine->getWordList();
        $this->chosenWord = $this->WordleEngine->selectRandomWord();
    }

    public static function fromJson($json)
    {
        $game = new WordleGame();
        foreach ((array)json_decode($json, true) as $key => $value) {
            if ($key != "WordleEngine") {
                $game->{$key} = $value;
            }
        }
        return $game;
    }

    public function convertFromJson($json)
    {
        foreach ((array)json_decode($json, true) as $key => $value) {
            if ($key != "words") {
            }
            $this->{$key} = $value;
        }
    }

    public function toJson()
    {
        return json_encode($this);
    }



    function set_words($wordList)
    {
        $this->words = $wordList;
    }
    function get_words(): array
    {
        return $this->words;
    }
    function set_chosenWord($chosenWord)
    {
        $this->chosenWord = $chosenWord;
    }
    function get_chosenWord(): string
    {
        return $this->chosenWord;
    }

    function set_userInputWord($userInput)
    {
        $this->userInputWord = $userInput;
    }
    function get_userInputWord(): string
    {
        return $this->userInputWord;
    }

    function set_currentRow($currentRow)
    {
        $this->currentRow = $currentRow;
    }
    function get_currentRow(): int
    {
        return $this->currentRow;
    }
}
