function collapsedAllGoTadi() {
    $('.panel-gotadi').each(function () {
        if (!$(this).hasClass('panel-gotadi-default')) {
            $(this).find('.panel-body').slideUp();
            $(this).find('div.clickable').addClass('panel-collapsed');
            $(this).find('div.clickable').find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
        }

    });
}

$(document).ready(function () {

    /**
     * This object controls the nav bar. Implement the add and remove
     * action over the elements of the nav bar that we want to change.
     *
     * @type {{flagAdd: boolean, elements: string[], add: Function, remove: Function}}
     */
    var myNavBar = {
        flagAdd: true,
        elements: [],
        init: function (elements) {
            this.elements = elements;
        },
        add: function () {
            if (this.flagAdd) {
                for (var i = 0; i < this.elements.length; i++) {
                    document.getElementById(this.elements[i]).className += " fixed-theme";
                }
                this.flagAdd = false;
            }
        },
        remove: function () {
            for (var i = 0; i < this.elements.length; i++) {
                document.getElementById(this.elements[i]).className =
                        document.getElementById(this.elements[i]).className.replace(/(?:^|\s)fixed-theme(?!\S)/g, '');
            }
            this.flagAdd = true;
        }

    };

    /**
     * Init the object. Pass the object the array of elements
     * that we want to change when the scroll goes down
     */
    myNavBar.init([
        "header",
        "header-container",
        "brand"
    ]);

    /**
     * Function that manage the direction
     * of the scroll
     */
    function offSetManager() {

        var yOffset = 0;
        var currYOffSet = window.pageYOffset;

        if (yOffset < currYOffSet) {
            myNavBar.add();
        }
        else if (currYOffSet == yOffset) {
            myNavBar.remove();
        }

    }

    /**
     * bind to the document scroll detection
     */
    window.onscroll = function (e) {
        offSetManager();
    }

    /**
     * We have to do a first detectation of offset because the page
     * could be load with scroll down set.
     */
    offSetManager();
    collapsedAllGoTadi();
});
jQuery(document).ready(function () {
    $(document).on('click', '.panel-heading span.clickable', function (e) {
        var $this = $(this);
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel .panel-gotadi').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
        } else {
            collapsedAllGoTadi();
            $this.parents('.panel .panel-gotadi').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
        }
    });
    $(document).on('click', '.panel div.clickable', function (e) {
        var $this = $(this);
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel .panel-gotadi').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
        } else {
            collapsedAllGoTadi();
            $this.parents('.panel .panel-gotadi').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
        }
    });
});
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

jQuery(document).ready(function () {
    function globalAssignEvent() {
        jQuery('.fieldset')
          .on('click', '.editfieldset', function () {
            let $fieldset = $(this).parents('.fieldset');
            $fieldset.find('.contenteditable').toggleClass('active');
            $fieldset.find('.icon.badge').toggleClass('no_display');
        }).on('click', '.savefieldset', function () {
            let $fieldset = $(this).parents('.fieldset');
            //console.log(isValidate($fieldset), $fieldset);
            //return;
            if(!isValidate($fieldset))
                return;
            saveEditableContent($fieldset, function(result){
                if(result.success!=true)
                    return;
                console.log('changed');
                $fieldset.find('.contenteditable').toggleClass('active');
                $fieldset.find('.icon.badge').toggleClass('no_display');
            });
        }).on('click', '.upload-imagefieldset', function () {
            let $fieldset = $(this).parents('.fieldset');
            $fieldset.find('input[type="file"]').trigger('click');
            $fieldset.find('.icon.badge').toggleClass('no_display');
        }).on('click', '.save-imagefieldset', function () {
            let $fieldset = $(this).parents('.fieldset');
            $fieldset.find('.icon.badge').toggleClass('no_display');
            $fieldset.find('form').submit();
        }).on('click', '.cancel-editfieldset', function () {
            let $fieldset = $(this).parents('.fieldset');
            $fieldset.find('.icon.badge').toggleClass('no_display');
            $fieldset.find('.contenteditable').toggleClass('active');
            $fieldset.find('.inputerror').removeClass('inputerror');
            //revertEditableFieldValues($fieldset);
        });
    }

    globalAssignEvent();
    
    var dboptionMethods = {
        params: function () {
            return {
                coverpanel: '.option_panel',
                option: '',
                group: ''
            }
        },
        init: function (options) {},
        destroy: function () {},
        assignEvent: function () {
            var params = this.dboption('params');
            var $me = this.dboption;
            jQuery(params.coverpanel).on('click', '.save_option', function () {
                $me('saveOptionParams', [this]);
            });
            jQuery(params.coverpanel).on('click', '.remove_option', function () {
                var obj = this;
                $me('removeOption', [
                    jQuery(obj).parent().data('key'),
                    function () {
                        jQuery(obj).parents('.an_option').remove();
                    }
                ]);
            });
            jQuery(params.coverpanel).on('click', '.add_new', function () {
                $me('newOption', [this]);
            });
            jQuery(params.coverpanel).find('.add_new_group').bind('click', function () {
                $me('newGroup');
            });
            jQuery(params.coverpanel).on('click', '.save_group', function () {
                $me('saveGroup', [this]);
            });
        },
        saveOptionParams: function (obj) {
            var url = jQuery('.option_panel').data('saveurl');
            var group = jQuery(obj).parents('.a_group').data('key');
            var data = jQuery(obj).parent().find('input').serialize() + '&group=' + group;
            sendData(url, data);
        },
        removeOption: function (key, callback) {
            var url = jQuery('.option_panel').data('removeurl');
            var data = {
                action: 'remove-option',
                key: key
            };
            sendData(url, data, 'POST', callback);
        },
        newGroup: function () {
            var $aRow = jQuery('.option_panel .cover_an_option .a_group').first().clone();
            jQuery('.option_panel .cover_an_option').after($aRow);
        },
        saveGroup: function (obj) {
            var $covergroup = jQuery(obj).parents('.a_group');
            console.log($covergroup);
            var url = jQuery('.option_panel').data('savegroupurl');
            var groupname = $covergroup.find('input[name="group_name"]').val();
            var data = {
                alias: $covergroup.find('input[name="group_alias"]').val(),
                name: groupname
            }
            sendData(url, data, 'POST', function (result) {
                $covergroup.find('input').attr('disabled', 'disabled');
                $covergroup.data('key', groupname);
            });
        },
        newOption: function (obj) {
            var $aRow = jQuery('.option_panel .cover_an_option .an_option').first().clone();
            jQuery(obj).parents('.a_group').append($aRow);
        }
    };

    jQuery.fn.dboption = function (method) {
        if (dboptionMethods[method]) {
            return dboptionMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return dboptionMethods.init.apply(this, arguments);
        } else {
            jQuery.error('Method ' + method + ' does not exist on jQuery.dboption');
        }
    };

    jQuery.fn.dboption('assignEvent');

});

// Upload ajax
ajaxUploadFile = {
    frameName: 'frameUpload',
    frame: function (c) {
        var d = document.createElement('DIV');
        d.innerHTML = '<iframe style="display:none" src="about:blank" id="'+this.frameName+'" name="'+this.frameName+'" onload="ajaxUploadFile.loaded(\''+this.frameName+'\')"></iframe>';
        document.body.appendChild(d);
        var i = document.getElementById(this.frameName);
        if (c && typeof (c.onComplete) == 'function') {
            i.onComplete = c.onComplete;
        }
        return this.frameName;
    },
    form: function (f, name) {
        f.setAttribute('target', name);
    },
    submit: function (f, c) {
        this.form(f, this.frame(c));
        if (c && typeof (c.onStart) == 'function') {
            return c.onStart();
        } else {
            return true;
        }
    },
    loaded: function (id) {
        var i = document.getElementById(id);
        if (i.contentDocument) {
            var d = i.contentDocument;
        } else if (i.contentWindow) {
            var d = i.contentWindow.document;
        } else {
            var d = window.frames[id].document;
        }
        if (d.location.href == "about:blank") {
            return;
        }
        if (typeof (i.onComplete) == 'function') {
            i.onComplete(d.body.innerHTML);
        }
    },
    resetUpload: function(form, callback) {
        var result = jQuery('#'+this.frameName).contents().find('body').text();
        result = JSON.parse(result);
        if(result.success==true) {
            if(typeof callback == 'function')
                callback(form, result);
        } else {
            console.log('Something wrong when upload file in server');  
        }
    }
}

function showLoading() {
}
function hideLoading() {
}
    
function sendData(url, data, method, callback, error) {
    showLoading();
    method = method || 'POST';
    var token = data._token = jQuery('meta[name="csrf-token"]').attr('content');
    if (typeof data == 'string') {
        data = data + '&_token=' + token;
    } else {
        data._token = token;
    }
    jQuery.ajax({
        url: url,
        method: method,
        data: data,
        //dataType: "application/json",
        success: function (result) {
            (callback || jQuery.noop)(result);
            hideLoading();
        },
        error: function (result) {
            (error || jQuery.noop)(result);
            hideLoading();
        }
    });
}

function sendDataWithToken(url, data, method, callback, error) {
    showLoading();
    var key = 'EBZTD1ykD5k8U7GSfZDxlbu3smwlow3IEtBplB8n302cN2PuH0dcE6ooGEGS';
    method = method || 'POST';
    jQuery.ajax({
        url: url,
        method: method,
        data: data,
        //dataType: "application/json",
        headers: {
            "Accept": "application/json",
            "Authorization": "Bearer " + key
        },
        success: function (result) {
            (callback || jQuery.noop)(result);
            hideLoading();
        },
        error: function (result) {
           (error || jQuery.noop)(result);
           hideLoading();
        }
    });
}

function getEditableFieldValues($obj){
    let values = [];
    $obj.find('.contenteditable').each(function(){
        let $me = jQuery(this);
        let value = $me.is(':input') ? $me.val() : $me.text();
        values.push({ name : $me.attr('name'), value: value });
    });
    return values;
}

function revertEditableFieldValues($obj){
    $obj.find('.contenteditable').each(function(){
        let $me = jQuery(this);
        let value = $me.data('value');
        $me.is(':input') ? $me.val(value) : $me.text(value);
    });
}

function saveEditableContent($obj, callback) {
    let data = getEditableFieldValues( $obj );
    console.log(data);
    data = jQuery.param(data);
    sendDataWithToken($obj.attr('action'), data, $obj.attr('method'), function (result) {
        (callback || jQuery.noop)(result);
    }, function () {
        console.log('something wrong');
    });
}

function isValidate($fieldset) {
    let $fields = $fieldset.find('[data-validate]');
    let result = true;
    $fields.each(function(){    
        if(!checkOneField(this)) {
            jQuery(this).addClass('inputerror');
            result = false;
        }
    });
    return (result && ($fieldset.find('.inputerror').length==0));
}

function checkOneField(field) {
    let $needs = jQuery(field).data('validate');
    $needs = $needs.split('|');
    let value = jQuery.trim(jQuery(field).text());
    for(let i=0; i<$needs.length; i++) {
        if(!checkContent(value, $needs[i]))
            return false;
    }
    jQuery(field).removeClass('inputerror');
    return true;
}

function checkContent(value, type) {
    switch(type) {
        case 'require':
            return (value!='');
        break;
        case 'email':
            let re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            return re.test(value); 
        break;
        case 'number':
        break;
    }
}