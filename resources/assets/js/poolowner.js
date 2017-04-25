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
            let $obj = $(this).parents('.fieldset');
            let data = $obj.find('input').serialize();
            if(data=='') {
                //show error
            } else {
                sendDataWithToken($obj.attr('action'), data, $obj.attr('method'), function (result) {
                    if(result.success!=true)
                        return
                    console.log('saved');
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
    let $img = jQuery(document.querySelector(form)).parents('.fieldset').find('img');
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
        let $fieldset = $(this).parents('.fieldset');
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


// My Pool Service company
jQuery(document).ready(function () {
    let $company = jQuery('.my-pool-service-company .list-company');
    $company.find('.btn-choose').bind('click', function(){
        let link = $(this).attr('title');
        console.log(link);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
            }
        };
        xhttp.open("GET", link, true);
        xhttp.send();

        $company.find('.item-company').toggleClass('no_display');
        var self = $(this).parent().parent();
        self.toggleClass('no_display');
        $company.find('.btn.btn-primary').toggleClass('no_display');
    });
    $company.find('.btn-choose-new').bind('click', function(){
        var self = $(this).parent().parent();
        self.toggleClass('no_display');       
        $company.find('.item-company').toggleClass('no_display');
        $company.find('.btn.btn-primary').toggleClass('no_display');                
    });
});
