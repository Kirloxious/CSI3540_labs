let pacmanPos = 0;
let ghostPos = 0;
let fruitPos = 0;
let score = 0;
let level = 1;

function createGame(n){
    let table = [];
    for(i = 0; i<=n; i++){
        table[i] = '.';
        if(i == n/2){
            pacmanPos = n/2
            table[i] = 'C';
        }
    }
    fruitPos = n-3;
    ghostPos = n-1;
    table[fruitPos] = '@';
    table[ghostPos] = '^';
    return table;
}

function moveLeft(game){
    game[pacmanPos] = '';
    if(pacmanPos-1 < 0){
        game[game.length-1] = 'C';
        pacmanPos = game.length-1;
    } else{
        game[pacmanPos-1] = 'C';
        pacmanPos--;

    }
    score++;
    return game;
}

function moveRight(game){
    game[pacmanPos] = '';
    if(pacmanPos+1 > game.length-1){
        game[0] = 'C';
        pacmanPos = 0;
    } else{
        game[pacmanPos+1] = 'C';
        pacmanPos++;
    }
    score++
    return game;
}

function checkBoardComplete(game){
    if(game.includes('.')) return false;
    else{
        level++;
        return createGame(game.length);
    } 
}

function moveGhost(game){
    if(ghostPos-1 < 0){
        game[ghostPos] = '.'
        ghostPos = game.length
        game[ghostPos] = '^'
    } else{
        temp = game[ghostPos-1];
        game[ghostPos] = temp;
        game[ghostPos-1] = '^';
    }
    ghostPos--;
};

let game = createGame(10);

setInterval( () =>{
    console.log(game);
    moveGhost(game);
}, 1000);


// console.log(moveLeft(game));
// console.log(moveRight(game));
// console.log(moveRight(game));
// console.log(moveRight(game));
// console.log(moveRight(game));
// console.log(moveRight(game));
// console.log(moveRight(game));
// console.log(moveRight(game));
// console.log(moveRight(game));
// console.log(moveRight(game));
// console.log(checkBoardComplete(game));
// console.log(moveRight(game));



