// Poolowner poolinfo
jQuery(document).ready(function () {
    function assignEvent() {
        jQuery('.poolowner_poolinfo input[type="checkbox"]').bind('click', function(){
            $children = jQuery(this).data('child');
            $children = jQuery($children);
            if(!jQuery(this).is(':checked')) {
                $children.each(function(){
                    jQuery(this).eq(0).prop('checked', false);
                })
            } else {
                $children.first().eq(0).prop('checked', true);
            }
        });
        jQuery('.poolowner_poolinfo input[type="radio"]').bind('click', function(){
            $parent = jQuery(this).data('parent');
            $parent = jQuery($parent);
            $parent.eq(0).prop('checked', true);
        });
        jQuery('.poolowner_poolinfo .saveform-fieldset').bind('click', function(){
            $obj = $(this).parents('.fieldset');
            let data = $obj.find('input').serialize();
            if(data=='') {
                //show error
            } else {
                sendDataWithToken($obj.attr('action'), data, $obj.attr('method'), function (result) {
                    (callback || jQuery.noop)(result);
                }, function () {
                    console.log('something wrong');
                });
            }
        });
    }
    assignEvent();
});

function afterUploadedImage(form, result) {
    $img = jQuery(document.querySelector(form)).parents('.fieldset').find('img');
    let cur = new Date();
    let newPath = $img.attr('path')+result.path+'?'+cur.getMilliseconds();
    $img.attr('src', newPath);
    document.querySelector(form).reset();
    jQuery('#'+ajaxUploadFile.frameName).remove();
}

// Poolowner profile
jQuery(document).ready(function () {
    $ownerProfile = jQuery('.poolowner_profile');
    $ownerProfile.find('[name="new-password"],[name="re-password"]').bind('keyup', function(){
        $newpwd = $ownerProfile.find('[name="new-password"]');
        $repwd = $ownerProfile.find('[name="re-password"]');
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
        $fieldset = $(this).parents('.fieldset');
        if(!isValidate($fieldset))
            return;
        saveEditableContent($fieldset, function(result){
            if(result.success!=true)
                return;
            console.log('changed');
            $fieldset.find('.contenteditable').toggleClass('active');
            $fieldset.find('.icon.badge').toggleClass('no_display');
            $ownerProfile.find('.cover_change_pwd').toggleClass('no_display');
        });
        
    });
});
