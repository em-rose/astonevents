// I have made three methods so far that each work a little differently
// First is a basic hover function for the side bar
// Second has a delay before closing bar again 
// Third uses some jQuery plugin that is more advanced

/*
$(function(){
	$('#sidebar').width = '80px';
    $('#sidebar').hover(function(){
        $(this).animate({width:'240px'},280);
    },function(){
        $(this).animate({width:'80px'}, 280);
    }).trigger('mouseleave');
});
*/

//$('#sidebar').animate({width:'80px'}, 0);

/*
var timer;
$('#sidebar').hover(function() {
	clearTimeout(timer);
	$('#sidebar').animate({width:'240px'},280);
}, function() {
	var sidebar = $('#sidebar');
	timer = setTimeout(function() {
		sidebar.animate({width:'80px'},280);
	}, 800);
});
*/

$(function() {
	$('#sidebar').hoverIntent(mouse_in, mouse_out);
});
function mouse_in() {
	$('#sidebar').animate({width:'190px'},250);
}
function mouse_out() {
	$('#sidebar').animate({width:'80px'},250);
}



