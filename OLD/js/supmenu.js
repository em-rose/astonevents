var table = document.getElementById('table-sup');
var tbody = table.getElementsByTagName('tbody')[0];
var cell = tbody.getElementsByTagName('td');
var width = table.rows[1].cells.length;


// If low stock (< 3), stock cell turns orange; if out of stock, cell turns red
for (var i=0, len=cell.length; i<len; i++) {
    if (i % width == 10) {
        //var count = "<?php echo $rowCount; ?>";
        //window.alert(count);
        if (parseInt(cell[i].innerHTML,10) <= 3 && parseInt(cell[i].innerHTML,10) >= 1) {
            cell[i].style.backgroundColor = '#ef8800';
            cell[i].style.fontWeight = 'bold';
        } else if (parseInt(cell[i].innerHTML,10) < 1) {
            cell[i].style.backgroundColor = '#dc0000';
            cell[i].style.fontWeight = 'bold';
        //} else if (count > 10) {
        //    cell[i].style.backgroundColor = 'blue';
        }
    }
}

function updateTable() {
    var query = "INSERT INTO menu VALUES ('";
    for (var j=0, len=cell.length; j < len-1; j++) {
        if (j % width == 9 || j % width == 11 || j % width == 12) {
        } else if (j % width !== 0) {
            query = query.concat("', '");                         // add commas between items
        }
        if (j % width === 0) {
            query = query.concat(j/width + "', '" + cell[j].innerText.trim()); // add j first as item_ref then name
        } else if (j % width == 1) {
            query = query.concat(cell[j].innerText.trim());       // description
        } else if (j % width == 2) {
            query = query.concat(cell[j].innerText.trim());       // price
        } else if (j % width == 3) {
            query = query.concat(cell[j].innerText.trim());       // drink_flag
        } else if (j % width == 4) {
            query = query.concat(cell[j].innerText.trim());       // vegetarian_flag
        } else if (j % width == 5) {
            query = query.concat(cell[j].innerText.trim());       // vegan_flag
        } else if (j % width == 6) {
            query = query.concat(cell[j].innerText.trim());       // dairy_free_flag
        } else if (j % width == 7) {
            query = query.concat(cell[j].innerText.trim());       // gluten_free_flag
        } else if (j % width == 8) {
            query = query.concat(cell[j].innerText.trim());       // breakfast_flag
        } else if (j % width == 10) {
            query = query.concat(cell[j].innerText.trim());       // quantity
        } else if (j % width == 11) {
            query = query.concat("'), ('");                       // add brackets at end
        } 
    }
    query = query.substring(0, query.length - 4);//.concat(" ;");    
    window.alert(query);
    //passInsertQuery(query);
    //return query;
    document.getElementById("postsql").value = query;
}

// function passInsertQuery(query) {
//     //window.alert(query);
//     var myData =query;
//     window.alert(myData);
//     $.ajax({
//         functionalert() 
//             {window.alert('ajax running');},
//         url:'/TechChallenge/www/updatesupmenu.php',
//         data: myData,
//         function() 
//             {window.alert(query);},
//         type:'POST',
//         success:function() {
//             window.alert('RAN');
//         },
//         error: function(jqXHR, textStatus, errorThrown){
//           alert('error');
//       }         
//     });
// }

// function updateDB() {
//     //window.alert("starting thing");
//     var query = updateTable();
//     window.alert(query);
//     jQuery.ajax({
//         url:'/TechChallenge/www/supmenu.php',
//         data: {$updatesupmenu: query},
//         type:'POST',
//         success:function(results) {
//             jQuery().load('updatesupmenu.php');
//         }
//     });
//     //window.alert("hooray");
// }    


//     function refresh_div() {
//     jQuery.ajax({
//         url:'/TechChallenge/www/suporders.php',
//         data: {$sql: "select t1.order_id, t2.name, t1.quantity, TIME_FORMAT(t1.time_ready, '%H:%i') as time_ready, CASE t1.paid_flag WHEN t1.paid_flag = 1 THEN 'Yes' ELSE 'No' END as paid	from orders as t1 join menu as t2 on t1.item_ref=t2.item_ref where order_completed=0"},
//         type:'POST',
//         success:function(results) {
//             jQuery("#table-holder").load('ordertable.php');
//         }
//     });


function addRow() {
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    var cell8 = row.insertCell(7);
    var cell9 = row.insertCell(8);
    var cell10 = row.insertCell(9);
    var cell11 = row.insertCell(10);
    var cell12 = row.insertCell(11);
    var cell13 = row.insertCell(12);
    
    cell1.innerHTML = "<div contenteditable><i>Item</i></div>";
    cell2.innerHTML = "<div contenteditable><i>Description</i></div>";
    cell3.innerHTML = "<div contenteditable><i>0.00</i></div>";
    cell4.innerHTML = "<div contenteditable><i>0</i></div>";
    cell5.innerHTML = "<div contenteditable placeholder = 'Bill Gates'><i>0</i></div>";
    
    cell6.innerHTML = "<div contenteditable><i>0</i></div>";
    cell7.innerHTML = "<div contenteditable><i>0</i></div>";
    cell8.innerHTML = "<div contenteditable><i>0</i></div>";
    cell9.innerHTML = "<div contenteditable><i>0</i></div>";
    cell10.innerHTML = "<div><button>-</button></div>";
    cell11.innerHTML = "<div contenteditable><i>0</i></div>";
    cell12.innerHTML = "<div><button>+</button></div>";
    cell13.innerHTML = "<div>X</div>";
}

function deleteRow(cellID) {
    var rowToDelete = cellID.substring((cellID.indexOf('_')+1), cellID.length);
    //window.alert(rowToDelete);
    table.deleteRow(rowToDelete);
    updateTable();
    document.forms["sqltophp"].submit();
}

// function runQuery() {
//     window.alert('function running');
//     var xhttp = new XMLHttpRequest();
//     var query=updateTable();
//    // window.alert('function running');
//     window.alert(query);
//     xhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             document.getElementById("demo").innerHTML =
//             this.responseText;
//             }
//         };
//     xhttp.open("GET", "updatesupmenu.php?q="+query, true);
//     xhttp.send();
// }