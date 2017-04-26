// Service company dashboard
jQuery(document).ready(function () {
    function assignEvent() {
        jQuery('.company-offered-service').find('.accept-service-offer, .deny-service-offer').bind('click', function() {
            var $me = jQuery(this);
            let data = $me.data();
            let url = $me.parents('[data-updateurl]');
            url = url.data('updateurl');
            if(data=='')
                return;
            sendDataWithToken(url, data, 'POST', function (result) {
                if(result.success!=true)
                    return;
                $me.parents('tr').find('.status').text(data.status);
                console.log('saved');
            }, function () {
                console.log('something wrong');
            });
        });
        
        jQuery('.technician-professionnal-service .save-techinician').bind('click', function() {
           $form = jQuery(this).parents('form');
            saveForm($form, function(result){
                console.log(result);
                $form.parents('.modal').modal('hide');
            });
        });
        
        jQuery('.technician-professionnal-service .remove-item-list').bind('click', function() {
            if(!confirm("Press a button!"))
                return;
            console.log('do delete');
            
        });
        
        jQuery('.technician-professionnal-service .edit-item-list').bind('click', function() {
        });
        
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