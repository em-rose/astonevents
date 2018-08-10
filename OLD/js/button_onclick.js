('.main_buttons').click(function(){
// fire off the request to /redirect.php
request = $.ajax({
    url: "../www/redirect.php",
    type: "post",
    data: 'facebook'
});

// callback handler that will be called on success
request.done(function (response, textStatus, jqXHR){
    // log a message to the console
    console.log("Hooray, it worked!");
});

// callback handler that will be called on failure
request.fail(function (jqXHR, textStatus, errorThrown){
    // log the error to the console
    console.error(
        "The following error occured: "+
        textStatus, errorThrown
    );
    });
});