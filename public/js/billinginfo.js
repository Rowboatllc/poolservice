
$(document).ready(function() {
		
	globalAssignEventBilling();
});
Stripe.setPublishableKey('pk_test_sxFwoflkE2e798m03dfS9QGn');

function saveEditableDataBilling($obj, callback) {
	var data_billing = getEditableFieldValues( $obj );

	for(var i=0;i<data_billing.length;i++){
		var key = data_billing[i];
		switch (key.name) {
			case "card_last_digits":
				var card_number = key.value;
				break;
			case "expiration_date":
				var expiration_date =  key.value;
				break;
			case "ccv":
				var ccv_number = key.value;
				data_billing[i].value="";
				break;
		}
	}
	var arr = expiration_date.split('/');
	Stripe.data_billing = data_billing;
	Stripe.obj = $obj;
	Stripe.callback = callback;	
	Stripe.createToken({
				number: card_number,
				cvc: parseInt(ccv_number),
				exp_month: parseInt(arr[0]),
				exp_year: parseInt(arr[1]),
			}, stripeResponseHandler);
	
}

function globalAssignEventBilling() {
	jQuery('.fieldset')
		.on('click', '.editfieldset_billing', function () {
		$fieldset = $(this).parents('.fieldset');
		$fieldset.find('.contenteditable').toggleClass('active');
		$fieldset.find('.icon.badge').toggleClass('no_display');
		$('#billing_ccv').css("display", "inline");
		$("#ccv_number").text(' ');
		var card_last_digits = $("#card_last_digits").text();
		$("#card_last_digits").text(card_last_digits.slice(8,card_last_digits.length)+' ');
	}).on('click', '.savefieldset_billing', function () {
		$fieldset = $(this).parents('.fieldset');
		//return;
		if(!isValidate($fieldset))
			return;
		saveEditableDataBilling($fieldset, function(result){
			if(!result.success){
				$("#payment-errors").html("update your billing info error.");
				$("#payment-errors").css("display", "block");
				$('#billing_ccv').css("display", "inline");
			}else{
				$fieldset.find('.contenteditable').toggleClass('active');
				$fieldset.find('.icon.badge').toggleClass('no_display');
				$('#billing_ccv').css("display", "none");
				$("#payment-errors").html("update your billing info success.");
				$("#payment-errors").css("display", "block");
				var card_last_digits = $("#card_last_digits").text();
				$("#card_last_digits").text("********"+card_last_digits.slice(card_last_digits.length-4,card_last_digits.length));
			}
		});
	});
}
function getEditableFieldValues($obj){
	let values = [];
	$obj.find('.contenteditable').each(function(){
		var $me = jQuery(this);
		values.push({ name : $me.attr('name'), value: $me.text() });
	});
	return values;
}
function stripeResponseHandler(status, response) {
	if (response.error) {
		$("#payment-errors").html(response.error.message);
		$("#payment-errors").css("display", "block");
		$('#billing_ccv').css("display", "inline");
	} else {
		$("#payment-errors").html("");
		$("#payment-errors").css("display", "none");
		$('#billing_ccv').css("display", "none");
		
		var token = response['id'];
		if(token){
			var tok = {name:"token",value:token};
			var data_billing = Stripe.data_billing;
			var $obj =Stripe.obj;
			var callback =Stripe.callback;
			data_billing.push(tok);			
			data_billing = jQuery.param(data_billing);
			sendData($obj.attr('action'), data_billing, $obj.attr('method'), function (result) {
				(callback || jQuery.noop)(result);
			}, function (result) {
				if(!result.success){
					$("#payment-errors").html("update your billing info error.");
					$("#payment-errors").css("display", "block");
					$('#billing_ccv').css("display", "inline");
				}else{
					$fieldset.find('.contenteditable').toggleClass('active');
					$fieldset.find('.icon.badge').toggleClass('no_display');
					$('#billing_ccv').css("display", "none");
					$("#payment-errors").html("update your billing info success.");
					$("#payment-errors").css("display", "block");
					var card_last_digits = $("#card_last_digits").text();
					$("#card_last_digits").text("********"+card_last_digits.slice(card_last_digits.length-4,card_last_digits.length));
				}
			});
		}
	}
}