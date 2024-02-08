const words = ['fight', 'steak', 'input', 'steam']
window.onload = function() {
    const childDivs = document.getElementById("row1").getElementsByTagName('div')
    const ids = [...childDivs].map(d => d.id)
    const inputBox = document.querySelector("inputBox")
    console.log(ids)
    console.log(inputBox)
}
// inputBox.addEventListener("input", updateValues)

function selectRandomWord(){
    return words[Math.floor(Math.random()*words.length)]
}

function getInputArray(ele){
    if(event.key === 'Enter') {
        alert(ele.value); 
        return ele.value.split("")    

    }
}


let convertArray = []
// function getRowData{

// }

// function updateValues(e){

// }

console.log(getInputArray())

