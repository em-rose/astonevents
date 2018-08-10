var table = document.getElementById("table");

var basket =  document.getElementById("elements");

function add(id) {
    var rowNumber = document.getElementById(id).value;
    var quant = document.getElementById(rowNumber);
    var number = quant.innerText;
    number++;
    quant.innerText = number;
    
   addToArr(rowNumber);
}

function min(id){
    var rowNumber = document.getElementById(id).value;
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

addToArr = function(rowNumber){
    var elements= "";
    
    var basket =  table.rows[rowNumber].cells[6].innerText;
    var itemRef   =  table.rows[rowNumber].cells[5].innerText;
    var amount = table.rows[rowNumber].cells[4].innerText;
    
    console.info("BASKET = " + basket);
    console.info("ITEMREF = " + itemRef);
    console.info("AMOUNT = " + amount);
    
    for(var i = basket.length; i--;){
        if (basket[i] === itemRef){
            basket.splice(i, 1);
        }
    }   
    console.info("BASKET = " + basket);
   
    for(var j = 0;j<amount;j++){
        basket.push(itemRef);
    }
    
    
     elements = basket.join(',');
    
     var contents = elements;
     document.getElementById("postarray").value = contents;
  
}


basket.onclick = function(){
    var arr = [];
    var elements= "";
    if (table != null) {
        
        for (var i = 1; i < table.rows.length; i++) {
            /**
            for (var j = 0; j < table.rows[i].cells.length; j++)
                table.rows[i].cells[j].onclick = function () {
                    //tableText(table.rows[0].cells[4]); 
                    alert(i);
                    alert(j);

                };*/
            var amount = table.rows[i].cells[4].innerText;
            
            for(var j = 0;j<amount;j++){
                
                var itemRef = table.rows[i].cells[5].innerText;

                arr.push(itemRef);
            }
        }
        
       elements = arr.join(',');
        
       var contents = elements;
       document.getElementById("postarray").value = contents;
    }
    else{
        alert("table empty")
    }
}
