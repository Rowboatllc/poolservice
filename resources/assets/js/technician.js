jQuery(document).ready(function() {
    let schedules = jQuery('.schedule-day-of-week');
    schedules.find('.addres-schedule').bind('click', function() {
        validateForm();
        schedules.selected = $(this);
        let id = $(this).find('[name="schedule_id"]').val();        
        let date = $(this).find('[name="date"]').val();
        let cleaning_steps = $(this).find('[name="cleaning_steps"]').val();
        let comment = $(this).find('[name="comment"]').val();
        let status = $(this).find('[name="status"]').val();

        let schedule = jQuery('.schedule-day-of-week.confirm-steps');

        schedule.find('#day-of-schedule').html(date);
        schedule.find('#schedule_id').val(id);
        
        if (status == "complete" || status == "unable" || status == 'billing_success' || status == 'billing_error') {
            schedule.find('#comment').val(comment);
            schedule.find('#comment').attr("readonly","true");
            schedule.find('.modal-footer').css("display", "none");
            
            for (var i = 1; i <= 6; i++) {
                let check = schedule.find('#step' + i);
                check.prop('checked', false);                
                check.attr('onclick', "return false;");
                if (cleaning_steps.indexOf(i) != -1) {
                    check.prop('checked', true);                    
                }
            }

        } else {
            schedule.find('#comment').val('');
            schedule.find('#comment').removeAttr("readonly");
            schedule.find('.modal-footer').css("display", "inherit");
            
            for (var i = 1; i <= 6; i++) {
                let check = schedule.find('#step' + i);
                check.prop('checked', false);
                check.removeAttr("onclick");
            }
        }

    });

    schedules.find('.btn-status').bind('click', function() {
        let self = $(this).parent().parent();
        self.find('.addres-schedule').click();
    });

    schedules.find('.technician-enroute').bind('click', function() {
        let link = $(this).attr('title');
        let self = $(this).parent().parent();
        sendData(link,[],'GET', function (result) {
            (jQuery.noop)(result);
            if(result.success){
                self.find('.btn-technician').toggleClass('no_display');                
            }
        }, function (result) {});
    });

    schedules.find('.btn-unable-steps').bind('click', function() {
        change(this,'unable');
    });

    schedules.find('.btn-complete-steps').bind('click', function() {
        change(this,'complete');
    });

    let technician = jQuery('.technician');
    technician.find('.schedule_weekday').bind('click', function() {
        let key = $(this).attr('title');
        removeMarkers();
        setMarker(key);
    });

    function change(me, status){        
        let frm = $('#form-confirm-steps');
        if(frm.valid()){
            let link = $(me).attr('title');
            let data = new FormData(frm[0]);
            $('#loading').show();
            $.ajax({
                type: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                url: link
            }).done(function (rawData) {
                $('#loading').hide();
                $('.modal-header .close').click();
                let self = schedules.selected.parent();
                self.find('[name="status"]').val(status);
                self.find('.technician-checkin').toggleClass('no_display');   
                self.find('.btn-'+status).toggleClass('no_display'); 

                let form_self = schedules.selected;
                let schedule = rawData.schedule;
                cleaning_steps = form_self.find('[name="cleaning_steps"]').val(schedule.cleaning_steps);
                form_self.find('[name="comment"]').val(schedule.comment);
                form_self.find('[name="status"]').val(schedule.status);  
                
            }).fail(function () {
                $('#loading').hide();
            })
        }
    }

    function validateForm(){
        var rules = {
            comment: {
                required: true
            }
        };
        var messages = {
            comment: {
                required: "Please enter comment"
            }
        };
        $("#form-confirm-steps").validate({
            rules: rules,
            messages: messages
        });
    }

});