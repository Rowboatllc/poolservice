
$(document).ready(function() {
	globalAssignEventBilling();

	$('#expiration_date').keypress(function(e) {
		let input = String.fromCharCode(e.which);
		let value = (jQuery(this).is(':input')) ? 
                    jQuery.trim(jQuery(this).val()): 
                    jQuery.trim(jQuery(this).text());
		if(!jQuery.isNumeric(input)&&!(input=='/'&&value.length==2))
			return false;
        
		if(value.length==1){
			let temp = value + input;
			if(parseInt(temp)>12){
				value = '0' + value;
				value += '/';
				this.innerHTML = value;
				placeCaretAtEnd(this);
			}else{
				value += input;
				value += '/';
				this.innerHTML = value;
				placeCaretAtEnd(this);
				return false;
			}
		}else if(value.length==2){
			value += '/';
        	this.innerHTML = value;
			placeCaretAtEnd(this);
			return true;
		}else if(value.length>=7){
			return false;
		}
        }).on({
        'paste': function(e) {

        },
        'drop': function(e) {
            e.preventDefault();
            e.stopPropagation();
        }
    });

});
function checkDate(date) {
	var minMonth = new Date().getMonth() + 1;
	var minYear = new Date().getFullYear();
	var res = date.split("/");

	var $month = res[0];
	var $year = res[1];

	var month = parseInt($month, 10);
	var year = parseInt($year, 10);
	
	if ((year < minYear) || ((year === minYear) && (month < minMonth)) || (year > minYear+40)) {
		return false;
	} else {
		return true;
	}			
}

function placeCaretAtEnd(el) {
    el.focus();
    if (typeof window.getSelection != "undefined"
            && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}
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
					$("#payment-errors").html(result.responseJSON.message);
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