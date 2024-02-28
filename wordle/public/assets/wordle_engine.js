const colors = {
  green: "#538d4e",
  yellow: "#b59f3b",
  gray: "#565758",
};
const gameController = {
  words: ["fight", "steak", "input", "steam", "sense"],
  chosenWord: "",
  userInput: "",
  currentRow: 0,
  rowBoxes: null,
  incrementRow: function () {
    this.currentRow++;
  },
  selectRandomWord: function () {
    return this.words[Math.floor(Math.random() * this.words.length)];
  },
  getNextRow: function () {
    this.incrementRow();
    this.rowBoxes = document
      .getElementById("row" + this.currentRow)
      .querySelectorAll(".letter-box");
  },
};

window.onload = function () {
  // gameController.chosenWord = gameController.selectRandomWord(); // selects the current games word
  gameController.chosenWord = "sense";
  console.log(gameController.chosenWord);
  gameController.getNextRow();
  const inputBox = document.getElementById("inputBox");
  if (gameController.currentRow <= 6) {
    inputBox.addEventListener("input", updateValues);
    inputBox.addEventListener("keyup", (e) => {
      if (e.key == "Enter" && inputBox.value.length == 5) {
        let result = checkCorrectLetter(
          gameController.userInput,
          gameController.chosenWord,
        );
        console.log(result);
        updateColors(result);
        inputBox.value = "";

        if (checkWin(result)) {
          console.log("Win");
          console.log(gameController.currentRow);
          inputBox.removeEventListener("input", updateValues);
        } else if (gameController.currentRow == 6) {
          //game over
          inputBox.removeEventListener("input", updateValues);
        } else {
          gameController.getNextRow();
        }
      }
    });
  }
};

function updateValues(e) {
  gameController.userInput = e.target.value;
  let arr = gameController.userInput.split("");
  for (let i = 0; i < 5; i++) {
    gameController.rowBoxes[i].textContent = arr[i];
  }
}

function setValues() {
  let arr = gameController.userInput.split("");
  for (let i = 0; i < 5; i++) {
    document.getElementById(gameController.ids[i]).textContent = arr[i];
  }
}

function updateColors(colorResult) {
  for (let i = 0; i < 5; i++) {
    gameController.rowBoxes[i].style.backgroundColor = colorResult[i];
  }
}

function checkCorrectLetter(input, word) {
  let arrInput = input.split("");
  let arrWord = word.split("");
  let resultArr = [];
  //check for green first
  for (let i = 0; i < 5; i++) {
    if (arrInput[i] == arrWord[i]) {
      resultArr[i] = colors.green;
      arrInput[i] = "";
      arrWord[i] = "";
    } else {
      resultArr[i] = colors.gray;
    }
  }
  for (let i = 0; i < 5; i++) {
    if (arrWord.includes(arrInput[i])) {
      let letterIndex = arrWord.indexOf(arrInput[i], i);
      arrWord[letterIndex] = "";
      arrInput[i] = "";
      if (resultArr[i] != colors.green) {
        resultArr[i] = colors.yellow;
      }
    }
  }
  return resultArr;
}

function checkWin(result) {
  return result.map((r) => {
    return r === colors.green;
  });
}

function countLetterOccurence(str, letter) {
  return str.filter((char) => char === letter).length;
}
