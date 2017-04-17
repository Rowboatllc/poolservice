
$(document).ready(function() {	
	//main form validation
	validationInputData();
});

function validationInputData()
{	
	var form = $( "#formBillingInfo" );
	form.validate({
		rules: {
			'name_card':{
				required: true,
				maxlength: 50
			},
			'card_last_digits':{
				required: true,
				creditcard: true,
				number: true,
				maxlength: 20
			},
			'expiration_date':{
				required: true,
				maxlength: 9
			},
            'address':{
				required: true,
				maxlength: 100
			},
			'city':{
				required: true,
				maxlength: 100
			},
			'state':{
				required: true
			},
			'zipcode':{
				required: true,
				number: true,
				maxlength: 5
			}
		},
		messages: {
			'name_card':{
				required: 'Provide card name.'
			},
			'card_last_digits':{
				required: 'Provide card number.'
			},
			'expiration_date':{
				required: 'Provide expiration date.'
			},	
			'adress':{
				required: 'Provide address.'
			},
			'city':{
				required: 'Provide city.'
			},		
			'state':{
				required: 'Provide state.'
			},		
			'zipcode':{
				required: 'Provide zipcode.'
			}
		},
		highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
		unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
		errorPlacement: function(error, element) {
		}
	});	
}