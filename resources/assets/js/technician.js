jQuery(document).ready(function() {
    let schedules = jQuery('.schedule-day-of-week');
    schedules.find('.addres-schedule').bind('click', function() {
        let date = $(this).find('[name="date"]').val();
        let cleaning_steps = $(this).find('[name="cleaning_steps"]').val();
        let comment = $(this).find('[name="comment"]').val();
        let status = $(this).find('[name="status"]').val();

        let schedule = jQuery('.schedule-day-of-week.confirm-steps');

        schedule.find('#day-of-schedule').html(date);

        if (status == "complete") {
            schedule.find('#comment').html(comment);
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
            schedule.find('#comment').html('');
            schedule.find('#comment').removeAttr("readonly");
            schedule.find('.modal-footer').css("display", "inherit");
            
            for (var i = 1; i <= 6; i++) {
                let check = schedule.find('#step' + i);
                check.prop('checked', false);
                check.removeAttr("onclick");
            }
        }

    });
});