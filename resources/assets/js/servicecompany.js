// Service company dashboard
jQuery(document).ready(function () {
    function assignEvent() {
        // Company accept/deny offer from Pool owner
        jQuery('.company-offered-service').on('click', '.accept-service-offer, .deny-service-offer', function() {
            
            let $me = jQuery(this);
            let data = $me.data();
            let url = $me.closest('table');
            url = url.data('url');
            if(data=='')
                return;
            sendData(url, data, 'POST', function (result) {
                if(result.success!=true)
                    return;
                $me.closest('tr').find('.offer_status').addClass(data.status);
                $me.closest('td').find('.icon').addClass('no_display');
                console.log('saved');
            }, function () {
                console.log('something wrong');
            });
        });
        
        // Company offers services
        jQuery('.company_service_offers input[type="checkbox"]').bind('click', function(){
            toggleSaveButton();
        });
        
        jQuery('.company_service_offers .saveform-fieldset').bind('click', function(){
            $me = jQuery(this);
            let $obj = $me.closest('.fieldset');
            let data = $obj.find('input').serialize();
            if(data=='')
                return
            sendData($obj.attr('action'), data, $obj.attr('method'), function (result) {
                if(result.success!=true)
                    return
                $me.addClass('no_display');
            }, function () {
                console.log('something wrong');
            });
        });
       
        // technician-professionnal-service
        jQuery('.technician-professionnal-service').on('click','.new-item', function() {
            let modal = jQuery(this).data('target');
            let names = ['fullname', 'phone', 'email', 'id', 'avatar', 'is_owner'];
            setElementValues(modal, names, '');
        }).on('click', '.technician-img', function(event) {
            jQuery('.technician-professionnal-service .form_technician-avatar input[type="file"]').trigger('click');
        });
    }

    function toggleSaveButton() {
        let $obj = jQuery('.company_service_offers');
        let data = $obj.find('input').serialize();
        if(data=='') {
            $obj.find('.saveform-fieldset').addClass('no_display');
        } else {
            $obj.find('.saveform-fieldset').removeClass('no_display');
        }
    }
    
    assignEvent();
});

function afterUploadedTechnicianAvatar(form, result) {
    let $img = jQuery('.technician-img');
    let cur = new Date();
    let newPath = $img.attr('path')+result.path+'?'+cur.getMilliseconds();
    $img.attr('src', newPath);
    jQuery('.technician-professionnal-service input[name="avatar"]').val(result.path);
    document.querySelector(form).reset();
    jQuery('#'+ajaxUploadFile.frameName).remove();
}