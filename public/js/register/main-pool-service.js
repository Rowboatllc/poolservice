function validationPoolService()
{
	var form = $( "#frmPoolServiceDashBoard" );
	form.validate({
		rules: {
			'logo':{
				required: true,
			}
		},
		messages: {
			'logo':{
				required: "Please upload your logo.",
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

    var frm = $('#frmPoolServiceDashBoard');
    frm.submit(function (ev) {
        $.ajax({
			beforeSend:function() { 
				$("#divModelPoolService").css("display", "block");
			},
			complete:function() {
				$("#divModelPoolService").css("display", "none");
			},
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
			success: function(data) {
				if(data.success===true)
				{
					$("#notifyModalPoolService #get_your_email").text('You are almost done! Please check your email at (' + data.message + ') and follow the instruction to completed the sign up process');
				}
				else
				{
					$("#notifyModalPoolService #get_your_email").text(data.message);
				}
				
				$("#notifyModalPoolService").modal();
				$('#frmPoolServiceDashBoard .btn-next-submit').prop('disabled', 'disabled');	
				$('#frmPoolServiceDashBoard .btn-previous').prop('disabled', 'disabled');		
			}
        });
		
        return false;
    });
});