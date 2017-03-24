
function scroll_to_class(element_class, removed_height) {
	var scroll_to = $(element_class).offset().top - removed_height;
	if($(window).scrollTop() != scroll_to) {
		$('html, body').stop().animate({scrollTop: scroll_to}, 0);
	}
}

function bar_progress(progress_line_object, direction) {
	var number_of_steps = progress_line_object.data('number-of-steps');
	var now_value = progress_line_object.data('now-value');
	var new_value = 0;
	if(direction == 'right') {
		new_value = now_value + ( 100 / number_of_steps );
	}
	else if(direction == 'left') {
		new_value = now_value - ( 100 / number_of_steps );
	}
	progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
}

Stripe.setPublishableKey('pk_test_sxFwoflkE2e798m03dfS9QGn');

function stripeResponseHandler(status, response) {
	if (response.error) {
		$('input#hdf_stripeToken').val('');
		// re-enable the submit button
		$('.submit-button').removeAttr("disabled");
		// show the errors on the form
		$(".payment-errors").html(response.error.message);
	} else {
		var form$ = $("#frmPoolSubscriber");
		// token contains id, last4, and card type
		var token = response['id'];
		// alert(JSON.stringify(response));
		// insert the token into the form so it gets submitted to the server
		// form$.append("<input type='hidden' id='hdf_stripeToken' name='stripeToken' value='" + token + "' />");
		$('input#hdf_stripeToken').val(token);
	}
}

function validationInputData(form)
{	
	form.validate({
		rules: {
			'zipcode': {
				required: true,
				number: true,
				minlength: 3,
				maxlength: 10
			},
			'chk_service_type[]':{
				required: true,
			},
			'chk_weekly_pool[]':{
				required: true,				
			},
			'rdo_weekly_pool':{
				required: '#chk-weekly-pool:checked',
			},
			'email':{
				required: true,
				email:true,
				maxlength: 50,
				remote: {
					headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					url: "check-email-exists",
					type: 'POST',
					data:
					{
						email: function()
						{
							return $('#frmPoolSubscriber :input[name="email"]').val();
						}
					}
				}
			},
			'password':{
				required: true,
				minlength: 6,
				maxlength: 50
			},
			'repeat-password':{
				required: true,
				equalTo: "#password",
				minlength: 6,
				maxlength: 50
			},
			'fullname':{
				required: true,
				maxlength: 50
			},
			'street':{
				required: true,
				maxlength: 100
			},
			'city':{
				required: true,
				maxlength: 100
			},
			'zip':{
				required: true,
				number: true,
				maxlength: 5
			},
			'phone':{
				required: true,
				number: true,
				maxlength: 15
			},
			'card_name':{
				required: true,
				maxlength: 50
			},
			'card_number':{
				required: true,
				number: true,
				maxlength: 20
			},
			'stripeToken':{
				required: true,
			},
			'expiration_date':{
				required: true,
				maxlength: 9
			},
			'billing_address':{
				required: true,
				minlength: 4,
				maxlength: 50
			},
			'billing_city':{
				required: true,
				minlength: 2,
				maxlength: 50
			}
		},
		messages: {   
			'email':{
				required: "Please enter your email address.",
				email: "Please enter a valid email address.",
				remote: jQuery.validator.format("This email is already taken.")
			},      
			'chk_weekly_pool[]':{
				required: "You must choose at least 1 box",
			},
			'chk_service_type[]': {
				required:"Please choose at least 1 service"
			},
			'password': { 
				required: "Provide your password", 
				rangelength: jQuery.validator.format("Enter at least {0} characters") 
			},
			'repeat-password': { 
				required: "Repeat your password", 
				minlength: jQuery.validator.format("Enter at least {0} characters"), 
				equalTo: "Enter the same password as above" 
			}, 
			'stripeToken': { 
				required: "Invalid number account."
			},
		},
		highlight: function(label) {
			$(label).closest('.control-group').addClass('input-error');
		},
		// success: function(label) {
		// 	label
		// 	.text('passed!').addClass('valid')
		// 	.closest('.control-group').addClass('success');
		// },
		errorPlacement: function(error, element) {
			console.log(element.attr("name"));
			// alert(element.attr("name"));
			if (element.attr("name") == "chk_weekly_pool[]") {					
				error.insertAfter("#lblSpa");
			} else if(element.attr("name") == "chk_service_type[]"){
				error.insertAfter("#lblServiceType");
			} else if(element.attr("name") == "rdo_weekly_pool"){
				error.insertAfter("#error_weekly_pool");
			} else if(element.attr("name") == "stripeToken"){
				error.insertAfter("#error_token");
			}else{
				error.insertAfter(element);
			}
		}
	});	
}

jQuery(document).ready(function() {	

	$('#f1-expiration-date').payment('formatCardExpiry');
    /*Fullscreen background*/    
    $('#top-navbar-1').on('shown.bs.collapse', function(){
    	$.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
    	$.backstretch("resize");
    });
    
    /*Form*/
    $('.f1 fieldset:first').fadeIn('slow');
    
    $('.f1 input[type="text"], .f1 input[type="password"], .f1 textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });

	// $('input[name="chk_weekly_pool[]"]').change(function(){
	// 	if($("#chk-weekly-pool").is(':checked')==false){
	// 		// $('input[type="radio"]').prop('checked', true)
	// 		$(this).next('p').find('input[type="radio"]').prop('checked', this.checked);
	// 	}		
	// });

	// $('input[name="rdo_weekly_pool[]"]').change(function(){
	// 	var parent = $(this).closest('ul');
	// 	parent.prev().prop('checked', function(){
	// 		return parent.find('input[name="sub_cat[]"]').length === parent.find('input[name="sub_cat[]"]:checked').length;
	// 	});
	// });
    
    // next step bill
	$('.f1 .btn-next-bill').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
		var card=Stripe.card.validateCardNumber($('input#f1-cardnumber').val());
		console.log(card);
		var day=Stripe.card.validateExpiry($('input#f1-expiration-date').val());// true
		console.log(day);
		var ccv=Stripe.card.validateCVC($('input#f1-ccv-number').val());// true
		console.log(ccv);
		if(card && day && ccv)
		{
			Stripe.createToken({
				number:$('#f1-cardnumber').val(),
				cvc:$('#f1-ccv-number').val(),
				exp_month: '12',//$('#card-expiry-month').val(),
				exp_year: '18',//$('#card-expiry-year').val()
			}, stripeResponseHandler);
		}		

		var form = $( "#frmPoolSubscriber" );
		validationInputData(form);

    	if( next_step && form.valid()) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
    			// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
	});

	// next step
    $('.f1 .btn-next').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
		var form = $( "#frmPoolSubscriber" );
		validationInputData(form);		

    	// fields validation
    	// parent_fieldset.find('input[type="text"], input[type="password"], textarea').each(function() {
		// 	//alert($(this).attr('require'));
    	// 	if( $(this).val() == "" ) {
    	// 		$(this).addClass('input-error');
    	// 		next_step = false;
    	// 	}
    	// 	else {
    	// 		$(this).removeClass('input-error');
    	// 	}
    	// });
    	if( next_step && form.valid()) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
    			// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
    	
    });
    
    // previous step
    $('.f1 .btn-previous').on('click', function() {
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    	$(this).parents('fieldset').fadeOut(400, function() {
    		// change icons
    		current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
    		// progress bar
    		bar_progress(progress_line, 'left');
    		// show previous step
    		$(this).prev().fadeIn();
    		// scroll window to beginning of the form
			scroll_to_class( $('.f1'), 20 );
    	});
    });
    
    // submit
	$('.f1').on('submit', function(e) {			
		// alert('submit');
		// // fields validation
		// $(this).find('input[type="text"], input[type="password"], textarea').each(function() {
		// 	if( $(this).val() == "" ) {
		// 		e.preventDefault();
		// 		$(this).addClass('input-error');
		// 	}
		// 	else {
		// 		$(this).removeClass('input-error');
		// 	}
		// });
		// fields validation    	
	});
});
