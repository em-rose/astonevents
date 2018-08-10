var table = document.getElementById("table");


function add(id) {
    var rowNumber = document.getElementById(id).value;
    console.info(rowNumber);
    var quant = document.getElementById(rowNumber);
    var number = quant.innerText;
    number++;
    quant.innerText = number;
}

function min(id){
    var rowNumber = document.getElementById(id).value;
    console.info(rowNumber);
    var quant = document.getElementById(rowNumber);
    var number = quant.innerText;
    if(number<=0){
        number=0;
    }
    else{
        number--;
    }
    quant.innerText = number;   
}

function getContents(){
    var arrString = "array(";
    if (table != null) {
        for (var i = 1; i < table.rows.length; i++) {
            arrString += rows[i].cells[4].innerText;
            arrString += ",";
            console.info(arr);       
        }
    }
    return arrString;
}