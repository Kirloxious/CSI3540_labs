const colors = {
  green: "#538d4e",
  yellow: "#b59f3b",
  gray: "#565758",
  white: "#fff",
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
  selectRandomWord: async function () {
    await getWords();
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

  gameController.selectRandomWord().then((result)=>{
    console.log(result)
    gameController.chosenWord = result;
  }); // selects the current games word
  // gameController.chosenWord = "sense";
  gameController.getNextRow();
  highlightCurrentRow();
  const inputBox = document.getElementById("inputBox");
  if (gameController.currentRow <= 6) {
    inputBox.addEventListener("input", updateValues);
    inputBox.addEventListener("keyup", (e) => {
      if (e.key == "Enter" && inputBox.value.length == 5) {
        if(!assertWordInList(gameController.userInput)){
          console.log("word not in list")
        }else{
          let result = checkCorrectLetter(
            gameController.userInput,
            gameController.chosenWord,
          );
          console.log(result);
          updateColors(result);
          for (let i = 0; i < 5; i++) {
            shadeKeyBoard(gameController.userInput.split("")[i], result[i]);
          }
          inputBox.value = "";
  
          if (checkWin(result)) {
            showGameResultPopup(true);
            inputBox.removeEventListener("input", updateValues);
          } else if (gameController.currentRow == 6) {
            showGameResultPopup(false);
            inputBox.removeEventListener("input", updateValues);
          } else {
            gameController.getNextRow();
            highlightCurrentRow();
          }
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
    gameController.rowBoxes[i].style.color = colors.white;
  }
}

function highlightCurrentRow() {
  for (let i = 0; i < 5; i++) {
    gameController.rowBoxes[i].style.borderColor = "#000000";
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
  return result.every((val) => {
    return val == colors.green;
  });
}

function assertWordInList(word){
  let result = gameController.words.includes(word);
  if(!result){
    var popup = document.getElementById("myPopup");
    popup.textContent = "Word is not valid."
    popup.classList.toggle("showtemp")
  }
  return result
}

function shadeKeyBoard(letter, color) {
  for (const elem of document.getElementsByClassName("keyboard-button")) {
    if (elem.textContent === letter) {
      let oldColor = elem.style.backgroundColor;
      if (oldColor === colors.green) {
        return;
      }

      if (oldColor === colors.yellow && color !== colors.green) {
        return;
      }

      elem.style.backgroundColor = color;
      break;
    }
  }
}

async function getWords(){
  return await fetch('assets/words.csv')
    .then(response => response.text())
    .then(data => {
      const lines = data.split("\n");
      gameController.words = lines.map(line => line.trim());
      console.log(gameController.words);
    })
    .catch(error => console.error("An error occurred:", error));
}

function showGameResultPopup(win){
  var popup = document.getElementById("myPopup");
  if(win){
    popup.innerHTML = `You win! Guess: ${gameController.currentRow} <button class="popupbutton" type="reset" onClick="reload();">Again?</button>`
    popup.classList.toggle("show")
  }
  else{
    popup.innerHTML = `You lose! The word was ${gameController.chosenWord} <button class="popupbutton" type="reset" onClick="reload();">Again?</button>`
    popup.classList.toggle("show") 
  }
}

function reload(){
  window.location = window.location
}

function clearFields(){
  for (const elem of document.getElementsByClassName("letter-box")) {
    elem.textContent = ""
  }
  for (const elem of document.getElementsByClassName("keyboard-button")) {
    elem.style.backgroundColor = colors.white
  }
  const popup = document.getElementById("myPopup")
  popup.classList.toggle("show")
}