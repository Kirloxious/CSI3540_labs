input = 1234;

function encrypt(input){

    strInput = String(input).split("");
    result = ""
    for(let elem of strInput){
        result += (parseInt(elem) + 7) % 10
    }
    arr = result.split("")
    
    temp = arr[0];
    arr[0] = arr[2]
    arr[2] = temp;
    
    temp = arr[1]
    arr[1] = arr[3]
    arr[3] = temp
    
    result2 = ""
    for(let x of arr){
        result2 += x
    }

    return result2
}


console.log(encrypt(input))