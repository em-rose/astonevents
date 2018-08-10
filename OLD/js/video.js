var vid = document.getElementById("bgvid");

if (window.matchMedia('(prefers-reduced-motion)').matches) {
    vid.removeAttribute("autoplay");
    vid.pause();
    pauseButton.innerHTML = "Paused";
}

function vidFade() {
  vid.classList.add("stopfade");
}

//vid.addEventListener('ended', function()
//{
// only functional if "loop" is removed
//vid.pause();
// to capture IE10
//vidFade();
//});


vid.addEventListener('ended', function() {
  // get the active source and the next video source.
  // I set it so if there's no next, it loops to the first one
  var activesource = document.querySelector("#bgvid source.active");
  var nextsource = document.querySelector("#bgvid source.active + source") || document.querySelector("#bgvid source:first-child");
  
  activesource.className = "";
  nextsource.className = "active";
  
  // update the video source and play
  vid.src = nextsource.src;
  vid.play();
});