const disp = document.getElementById('disp');
var a = '';
var b = '';
var res = '';
var operation = '';

console.log(disp.value)


function ToDisp(n) {
    if ( res == '') {}
    else {
        ClearD_CE();
        res = '';
    }
    disp.value += n;
  }

function ClearD_CE(){
    disp.value = '';
}

function ClearD_C(){
    disp.value = '';
     a = '';
     b = '';
     operation = '';
}


function sqrt() {
    x = parseFloat(disp.value);
    disp.value = Math.sqrt(x) ;
}

function percent() {
    disp.value = parseFloat(disp.value)/100;
}

function bspace() {
    disp.value = disp.value.slice(0, -1);
}

function op(str) {
    a = disp.value;
    ClearD_CE();
    operation = str;
}

function equals(str) {
    a = parseFloat(a);
    b = parseFloat(disp.value);
    switch (str) {
        case "plus":
            disp.value = a + b;
            break;
        case "minus":
            disp.value = a - b;
            break;
        case "multiply":
            disp.value = a * b;
            break;
        case "divide":
            disp.value = a / b;
            break;
    }
}

function signchange() {
    disp.value = disp.value * (-1);
}

function inverse_proposition(){
    disp.value = 1 / parseFloat(disp.value);
}
