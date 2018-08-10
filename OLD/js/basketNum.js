$(document).ready(function(){
  if (count !== 0 || count != null) {
    $(".shoppingbasket").append("<div class=\"basketitems\">" + count + "</div>")
  }
});