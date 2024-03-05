<?php

enum color: string
{
    case GREEN = "#538d4e";
    case YELLOW = "#b59f3b";
    case GRAY = "#565758";
    case WHITE = "#fff";
}

class WordleGame
{
    private $words = ["fight", "steak", "input", "steam", "sense"];
    private $chosenWord;
    private $userInputWord;
    private $currentRow;

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
