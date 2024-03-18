const WordleApi = {
  newGame: function () {
    $.ajax({
      type: "GET",
      url: "api.php?path=/game/new",
      success: function (game) {
        console.log(game);
        initComponents(game);
      },
    });
  },
  updateGameData: function (components) {
    $.ajax({
      type: "POST",
      url: "api.php",
      dataType: "json",
      data: JSON.stringify(components.game_state),
      success: function (result) {
        console.log("POST success");
        // components.game_state = result;
      },
    });
  },
  currentGame: function () {
    $.ajax({
      type: "GET",
      url: "api.php?path=/game/current",
      success: function (game) {
        console.log(game);
      },
    });
  },
  checkWord: function(components){
    $.ajax({
      type: "GET",
      url: "api.php?path=/game/check_word",
      success: function (game){
        if(!game.inputWordInWordList){
          var popup = document.getElementById("myPopup");
          popup.textContent = "Word is not valid."
          popup.classList.toggle("showtemp")
        }
        else{
          WordleApi.checkLetters(components);
        }
      }
    })
   },
   checkLetters: function(components){
    $.ajax({
      type: "GET",
      url: "api.php?path=/game/check_letters",
      success: function (game){
        //update box colors and keyboard colors
        components.game_state = game;
        components.updateValues()
        components.updateColors()
        for (let i = 0; i < 5; i++) {
          shadeKeyBoard(components.game_state.wordBoard[components.game_state.currentRow-1].split("")[i], components.game_state.colorBoard[components.game_state.currentRow-1][i]);
        }
        components.game_state.currentRow++;
        components.input_box.value = ""
        WordleApi.updateGameData(components);
        WordleApi.checkWin(components);
      }
    })
   },
   checkWin: function(components){
    $.ajax({
      type: "GET",
      url: "api.php?path=/game/check_win",
      success: function (game){
        components.game_state = game;
        if(components.game_state.win){
          components.showGameResultPopup(true);
          components.input_box.setAttribute("disabled", "")
          components.input_box.removeEventListener("input", components.handleUpdateRowValues)
          components.input_box.removeEventListener("keyup", components.handleKeyUpEnter)
          
        }else if(components.game_state.currentRow == 7){
          components.showGameResultPopup(false);
          components.input_box.setAttribute("disabled", "")
          components.input_box.removeEventListener("input", components.handleUpdateRowValues)
          components.input_box.removeEventListener("keyup", components.handleKeyUpEnter)
        }else{
          components.refresh(game);
        }
        WordleApi.updateGameData(components);
        components.updateScore();
      }
    })
   }
};

const colors = {
  green: "#538d4e",
  yellow: "#b59f3b",
  gray: "#565758",
  white: "#fff",
};


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

function resetKeyBoard(){
  for (const elem of document.getElementsByClassName("keyboard-button")){
    elem.style.backgroundColor = colors.white;
  }
}



function initComponents(game_state) {
  let components = {
    input_box: document.getElementById("inputBox"),
    row_boxes: (row_index) => {
      return document
        .getElementById("row" + row_index)
        .querySelectorAll(".letter-box");
    },
    game_state: game_state,
    score: document.getElementById("score"),
    best_score: document.getElementById("best-score"),
    id: 0,
  };

  components.updateScore = function(){
    this.score.innerText = this.game_state.scoreStreak;
    this.best_score.innerText = this.game_state.bestScore;
  }

  components.updateCurrentRowValues = function (e) {
    this.game_state.userInputWord = e.target.value;
    let arr = this.game_state.userInputWord.split("");
    for (let i = 0; i < 5; i++) {
      this.row_boxes(this.game_state.currentRow)[i].textContent = arr[i];
    }
  };

  components.updateValues = function () {
    let row = 1;
    this.game_state.wordBoard.forEach((word) => {
      let arr = word.split("");
      let boxes = this.row_boxes(row);
      for (let i = 0; i < 5; i++) {
        boxes[i].textContent = arr[i];
      }
      row += 1;
    });
  };

  components.updateColors = function (){
    let row = 1;
    this.game_state.colorBoard.forEach((colorArray) => {
      let i = 0
      colorArray.forEach((color) => {
        if(color != ""){
          this.row_boxes(row)[i].style.backgroundColor = color;
          this.row_boxes(row)[i].style.color = colors.white;
        }
        i++;
      });
      row++;
    });
  };

  components.resetColors = function(){
    let row = 1;
    this.game_state.colorBoard.forEach((colorArray) => {
      let i = 0
      colorArray.forEach((color) => {
        this.row_boxes(row)[i].style.backgroundColor = color;
        this.row_boxes(row)[i].style.color = "#000000";
        i++;
      });
      row++;
    });
  }

  components.highlightCurrentRow = function(){
    for (let i = 0; i < 5; i++) {
      this.row_boxes(this.game_state.currentRow)[i].style.borderColor =
        "#000000";
    }
  };

  components.resetRowColors = function(){
    for(let j = 1; j<7; j++){
      for (let i = 0; i < 5; i++) {
        this.row_boxes(j)[i].style.borderColor =
          "#808080";
      }
    }
  }

  components.showGameResultPopup = function(win){
    var popup = document.getElementById("myPopup");
    if(win){
      popup.innerHTML = `You win! Guess: ${components.game_state.currentRow-1} <button class="popupbutton" type="reset" onClick="createGame();">Again?</button>`
      popup.classList.toggle("show", true)
    }
    else{
      popup.innerHTML = `You lose!<br> The word was ${components.game_state.chosenWord} <button class="popupbutton" type="reset" onClick="createGame()">Again?</button>`
      popup.classList.toggle("show", true) 
    }
  }

  components.hidePopup = function(){
    var popup = document.getElementById("myPopup");
    popup.innerHTML = ''
    popup.classList.toggle("show", false);
  }


  //Listeners
  components.handleUpdateRowValues = function(e){
    components.updateCurrentRowValues(e, components.game_state);
  }
  components.handleKeyUpEnter = function(e){
    if (e.key == "Enter" && components.input_box.value.length == 5) {
      console.log("Enter registered");
      components.game_state.wordBoard[components.game_state.currentRow - 1] = components.game_state.userInputWord;
      //api call to check for word in word list
      WordleApi.updateGameData(components); //send updated data to server
      WordleApi.checkWord(components);
        //check if player won
        // if (checkWin(result)) {
        //   showGameResultPopup(true);
        //   inputBox.removeEventListener("input", updateValues);
        // } else if (gameController.currentRow == 6) {
        //   showGameResultPopup(false);
        //   inputBox.removeEventListener("input", updateValues);
        // } else {
        //   gameController.getNextRow();
        //   highlightCurrentRow();
        // }

      // components.updateColors(game_state);

      // else() api call to check correct letter, then update colors and shade keyboard
      // then check for win
      // and true show popup and remove updateValues listener
      // else continue game, update the currentRow (api call) and highlight rowg
    }
  }

  components.addListeners = () => {
    components.input_box.addEventListener("input", components.handleUpdateRowValues)
    components.input_box.addEventListener("keyup", components.handleKeyUpEnter)

  };

  components.refresh = function (){
    components.input_box.removeEventListener("input", components.handleUpdateRowValues)
    components.input_box.removeEventListener("keyup", components.handleKeyUpEnter)
    components.addListeners();
    components.highlightCurrentRow();
    components.updateScore();
  }
  
  //reset game
  components.updateScore();
  resetKeyBoard();
  components.input_box.removeAttribute("disabled");
  components.hidePopup();
  components.updateValues();
  components.resetColors();
  components.resetRowColors();
  components.input_box.removeEventListener("input", components.handleUpdateRowValues)
  components.input_box.removeEventListener("keyup", components.handleKeyUpEnter)
  
  //

  components.highlightCurrentRow();
  components.addListeners();
  return components;
}

function createGame(){
  components = WordleApi.newGame();
}