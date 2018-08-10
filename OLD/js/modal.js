// Get the regModal
var regModal = document.getElementById('rModal');

// Get the button that opens the regModal
var regbtn = document.getElementById("reg");

// Get the <span> element that closes the regModal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the regModal 
if(regbtn != null){
    regbtn.onclick = function() {
        regModal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the regModal
    span.onclick = function() {
        regModal.style.display = "none";
    }
}

/////////////////////////////////////////////////////


// Get the logModal
var logModal = document.getElementById('lModal');

// Get the button that opens the logModal
var logbtn = document.getElementById("login");

// Get the <span> element that closes the logModal
var logspan = document.getElementsByClassName("logclose")[0];

// When the user clicks on the button, open the logModal 
if(logbtn != null){
    logbtn.onclick = function() {
        logModal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the logModal
    logspan.onclick = function() {
        logModal.style.display = "none";
    }
}
function openLog(){
  logModal.style.display = "block";
}


// When the user clicks anywhere outside of the regModal, close it
window.onclick = function(event) {
    if (event.target == regModal) {
        regModal.style.display = "none";
      
    }
   if (event.target == logModal) {
        logModal.style.display = "none";
    }
}

