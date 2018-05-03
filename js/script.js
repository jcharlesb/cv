$(document).ready(function(){   

    var link = $('.nav-link');
    
    /* ============== page scroll on click ============= */
    var scroll = function() {   
        $('.page-scroll a').bind('click', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1000, 'easeInOutExpo');
            event.preventDefault();
        });       
    }
    
	$(".navbar-toggler").click(function () {
	    $("#menu").toggle();
	});

	$(".nav-link").click(function () {
	    $("#menu").hide();
	});
	
	
    /* ============== contact via email ============= */
    var sendMail = function(){
		$('#contact-form').submit(function(e){
	        e.preventDefault();
	        $('.comments').empty();
	        var postdata = $('#contact-form').serialize();
	        
	        $.ajax({
	            type: 'POST',
	            url: 'php/contact.php',
	            data: postdata,
	            dataType: 'json',
	            success: function(json){
	                 
	                if(json.isSuccess) 
	                {
	                    $('#contact-form').append("<p class='thank-you fontAwesome'>&#xf087; <br>Votre message a bien été envoyé.</p>");
	                    $('#contact-form')[0].reset();
	                }
	                else
	                {
	                    $('#firstname + .comments').html(json.firstnameError);
	                    $('#name + .comments').html(json.nameError);
	                    $('#email + .comments').html(json.emailError);
	                    $('#phone + .comments').html(json.phoneError);
	                    $('#message + .comments').html(json.messageError);
	                }
	            }
	        });
	    });   
	}

	scroll()
	sendMail()
});
