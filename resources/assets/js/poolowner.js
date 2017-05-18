// Poolowner poolinfo
jQuery(document).ready(function () {
    function assignEvent() {
        jQuery('.poolowner_poolinfo input[type="checkbox"]').bind('click', function(){
            let $children = jQuery(this).data('child');
            $children = jQuery($children);
            if(!jQuery(this).is(':checked')) {
                $children.each(function(){
                    jQuery(this).eq(0).prop('checked', false);
                })
            } else {
                $children.first().eq(0).prop('checked', true);
            }
            toggleSaveButton();
        });
        jQuery('.poolowner_poolinfo input[type="radio"]').bind('click', function(){
            let $parent = jQuery(this).data('parent');
            $parent = jQuery($parent);
            $parent.eq(0).prop('checked', true);
            toggleSaveButton();
        });
        jQuery('.poolowner_poolinfo .saveform-fieldset').bind('click', function(){
            let $obj = $(this).closest('.fieldset');
            let data = $obj.find('input').serialize();
            if(data=='') {
                //show error
            } else {
                sendData($obj.attr('action'), data, $obj.attr('method'), function (result) {
                    if(result.success!=true)
                        return
                    $obj.find('.saveform-fieldset').addClass('no_display');
                }, function () {
                    console.log('something wrong');
                });
            }
        });
    }
    assignEvent();
    function toggleSaveButton() {
        let $obj = jQuery('.poolowner_poolinfo');
        let data = $obj.find('input').serialize();
        if(data=='') {
            $obj.find('.saveform-fieldset').addClass('no_display');
        } else {
            $obj.find('.saveform-fieldset').removeClass('no_display');
        }
    }
});

function afterUploadedImage(form, result) {
    let $img = jQuery(document.querySelector(form)).closest('.fieldset').find('img');
    let cur = new Date();
    let newPath = $img.attr('path')+result.path+'?'+cur.getMilliseconds();
    $img.attr('src', newPath);
    document.querySelector(form).reset();
    jQuery('#'+ajaxUploadFile.frameName).remove();
}

// Poolowner profile
jQuery(document).ready(function () {
    let $ownerProfile = jQuery('.poolowner_profile .pwdfieldset');
    $ownerProfile.find('[name="new-password"], [name="re-password"]').bind('keyup', function(){
        let $newpwd = $ownerProfile.find('[name="new-password"]');
        let $repwd = $ownerProfile.find('[name="re-password"]');
        ( jQuery.trim($newpwd.text()) == jQuery.trim($repwd.text()) ) ? 
            $repwd.removeClass('inputerror') : 
            $repwd.addClass('inputerror');
    });
    $ownerProfile.find('.icon.editfieldset').bind('click', function(){
        $ownerProfile.find('.cover_change_pwd').toggleClass('no_display');
    });
    $ownerProfile.find('.icon.cancel-editfieldset').bind('click', function(){
        $ownerProfile.find('.cover_change_pwd').toggleClass('no_display');
    });
    $ownerProfile.find('.icon.save-poolownerfieldset').bind('click', function(){
        let $fieldset = $(this).closest('.fieldset');
        if(!isValidate($fieldset))
            return;
        saveEditableContent($fieldset, function(result){
            if(result.success!=true)
                return;
            console.log('changed');
            $fieldset.find('.contenteditable').toggleClass('active');
            $fieldset.find('.icon.badge').toggleClass('no_display');
            $fieldset.find('.contenteditable.password').text('');
            $ownerProfile.find('.cover_change_pwd').toggleClass('no_display');
        });
    });
});

// My Pool Service company
jQuery(document).ready(function () {
    $.fn.stars = function() {
        return $(this).each(function() {
            // Get the value
            let val = parseFloat($(this).html());
            // Make sure that the value is in 0 - 5 range, multiply to get width
            let size = Math.max(0, (Math.min(5, val))) * 16;
            // Create stars holder
            let $span = $('<span />').width(size);
            // Replace the numerical value with stars
            $(this).html($span);
        });
    }
    $(function() {
        $('span.stars').stars();
    });

    let company = jQuery('.my-pool-service-company .list-company');

    company.find('.btn-choose').bind('click', function(){
        let link = $(this).attr('title');
        let self = $(this).parent().parent();
        sendData(link,[],'GET',function(result){
            changeNew(self,result)
        },changeNewError());
    });
    company.find('.btn-choose-new').bind('click', function(){
        let link = $(this).attr('title');
        let self = $(this).parent().parent();
        sendData(link,[],'GET',function(result){
            changeSuccess(self,result)
        },changeError());
    });

    $(".btn-save-rating").click(function (e) {
        e.preventDefault();

        let frm = $('#form-rating-company');
        let data = new FormData(frm[0]);
        let link = frm.attr('action');
        $.ajax({
            type: "POST",
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            url: link
        }).done(function (rawData) {
            $('.modal-header .close').click();
        })

    });

    function changeSuccess(self, result){
        if(result.success){
            company.find('.item-company').toggleClass('no_display');
            self.toggleClass('no_display');
            company.find('.btn.btn-primary').toggleClass('no_display');
        }else{
            
        }        
    }

    function changeError(){
    }

    function changeNew(self,result){
        if(result.success){
            self.toggleClass('no_display');       
            company.find('.item-company').toggleClass('no_display');
            company.find('.btn.btn-primary').toggleClass('no_display');

            let company_id = self.find('.company_id').val();
            $('#startModal').find('#company_id').val(company_id);

            let link = 'poolowner/get-point-rating-company/'+company_id;
            sendData(link,[],'GET', function (result) {
                (jQuery.noop)(result);
                if(result.success){
                    $('#startModal').find('#company_point').val(result.point);                
                }
            }, function (result) {});
        }else{

        }
    }

    function changeNewError(){
    }

});

// Services

jQuery(document).ready(function () {

    let services = jQuery('.poolowner .services');
    services.find('.item-schedule-poolowner').bind('click', function() {
        services.selected = $(this);     
        let date = $(this).find('[name="date"]').val();
        let now = $(this).find('[name="now"]').val();
        let dateFormat = $(this).find('[name="dateFormat"]').val();
        let cleaning_steps = $(this).find('[name="cleaning_steps"]').val();
        let comment = $(this).find('[name="comment"]').val();
        let status = $(this).find('[name="status"]').val();

        let schedule = jQuery('.services.confirm-info-steps');

        schedule.find('#day-of-schedule').html(dateFormat);
        schedule.find('#comment').html('');
        schedule.find('#recommendation').html('');

        for (let i = 1; i <= 6; i++) {
            let check = schedule.find('#step' + i);
            check.prop('checked', false);
        }
        
        if (status == "complete" || status == "unable" || status == 'billing_success' || status == 'billing_error') {
            schedule.find('#comment').html(comment);
            
            for (let i = 1; i <= 6; i++) {
                let check = schedule.find('#step' + i);
                if (cleaning_steps.indexOf(i) != -1) {
                    check.prop('checked', true);                    
                }
            }

            let date1 = new Date(date);let date2 = new Date(now);
            let time = 4*60*60*1000 - (date2 - date1);
            if(date2-date1>0 && time > 0){
                let m = Math.round(time/1000/60%60);
                let h = Math.floor(time/1000/60/60);
                if(m == 60){
                    h ++;
                    m = 0;
                }
                schedule.find('#recommendation').html('Recommendation: No pool use for '+ h + ' hours '+ m + ' minutes');
            }

        }

    });
});