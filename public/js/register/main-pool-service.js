function validationPoolService()
{
	var form = $( "#frmPoolServiceDashBoard" );
	form.validate({
		rules: {
			'logo':{
				required: true,
			},
            'wq':{
				required: true,
			},
            'driver_license':{
				required: true,
			}
		},
		messages: {
			'logo':{
				required: "Please upload your logo.",
			},
            'wq':{
				required: "Please upload your W-q.",
			},
            'driver_license':{
				required: "Please upload your Driver License.",
			}
		},
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
		unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
	});	
}

$(document).ready(function() {

    validationPoolService();
    // next info
	$('.btn-next-info').on('click', function(e) {
        if($( "#frmPoolServiceDashBoard" ).valid()) {
            e.preventDefault();
            var current_active_step = $(this).parents('.f2').find('.list-group-item.active').next();
            current_active_step.siblings('a.active').removeClass("active");
            current_active_step.addClass("active");
            var index = current_active_step.index();
            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        }
    });

    // back info
	$('.btn-previous').on('click', function(e) {
        e.preventDefault();
        var current_active_step = $(this).parents('.f2').find('.list-group-item.active').prev();
        current_active_step.siblings('a.active').removeClass("active");
        current_active_step.addClass("active");
        var index = current_active_step.index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });

    $('.btn-submit').on('click', function(e) {
        e.preventDefault();
        var frm = $('#frmPoolServiceDashBoard');
        // Create an FormData object
        var data = new FormData(frm[0]);
        $.ajax({
			beforeSend:function() { 
				$("#divModelPoolService").css("display", "block");
			},
			complete:function() {
				$("#divModelPoolService").css("display", "none");
			},
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            url: 'upload-company-profile',
            data: data,
            contentType: false,
            processData: false,
			success: function(data) {
                alert('ok');
                $("#notifyModalPoolService #get_your_email").text('You are almost done! Please check your email at (' + data.message + ') and follow the instruction to completed the sign up process');
                // alert(data.message);
				// if(data.success===true)
				// {
				// 	$("#notifyModalPoolService #get_your_email").text('You are almost done! Please check your email at (' + data.message + ') and follow the instruction to completed the sign up process');
				// }
				// else
				// {
				// 	$("#notifyModalPoolService #get_your_email").text(data.message);
				// }
				
				// $("#notifyModalPoolService").modal();
				// $('#frmPoolServiceDashBoard .btn-submit').prop('disabled', 'disabled');	
				// $('#frmPoolServiceDashBoard .btn-previous').prop('disabled', 'disabled');		
			}
        });
		
        return false;
    });

    var frm = $('#frmPoolServiceDashBoard');
    frm.submit(function (ev) {
        // Create an FormData object
        var data = new FormData(frm[0]);
        $.ajax({
			beforeSend:function() { 
				$("#divModelPoolService").css("display", "block");
			},
			complete:function() {
				$("#divModelPoolService").css("display", "none");
			},
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: data,
			success: function(data) {
                alert('ok');
                $("#notifyModalPoolService #get_your_email").text('You are almost done! Please check your email at (' + data.message + ') and follow the instruction to completed the sign up process');
                // alert(data.message);
				// if(data.success===true)
				// {
				// 	$("#notifyModalPoolService #get_your_email").text('You are almost done! Please check your email at (' + data.message + ') and follow the instruction to completed the sign up process');
				// }
				// else
				// {
				// 	$("#notifyModalPoolService #get_your_email").text(data.message);
				// }
				
				// $("#notifyModalPoolService").modal();
				// $('#frmPoolServiceDashBoard .btn-submit').prop('disabled', 'disabled');	
				// $('#frmPoolServiceDashBoard .btn-previous').prop('disabled', 'disabled');		
			}
        });
		
        return false;
    });
});