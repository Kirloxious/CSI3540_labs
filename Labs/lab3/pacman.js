let pacmanPos = 0;
let ghostPos = 0;
let fruitPos = 0;
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
    table[ghostPos] = '^.';
    return table;
}

function moveLeft(game){
    game[pacmanPos] = '.';
    game[pacmanPos-1] = 'C';
    pacmanPos--;
    return game;
}

function moveRight(game){
    game[pacmanPos] = '.';
    game[pacmanPos+1] = 'C';
    pacmanPos++;
    return game;
}

let game = createGame(10);

console.log(game);
console.log(moveLeft(game));
console.log(moveRight(game));
