jQuery(document).ready(function () {

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

    function saveForm($form, callback) {
        sendDataWithToken($form.attr('action'), $form.serialize(), $form.attr('method'), function (result) {
            (callback || jQuery.noop)(result);
            //console.log('form saved');
        }, function () {
            console.log('something wrong');
        })
    }

    function globalAssignEvent() {
        jQuery('.dashboard-panel').on('click', '.save_form', function () {
            var me = this;
            saveForm(jQuery(this).parents('form'), function(){
                //updateObjs();
                jQuery(me).parents('.modal').find('.close').trigger('click');
            });
        });
        
        jQuery('.dashboard-panel').on('change', 'input.avatar', function () {
            $(this).parent().submit();
            //var value = $(this).val();
            //$('.form-profile input.avatar').val(value);
            //document.formprofile.avatar.files[0].name = value;
            //document.formprofile.avatar.files[0] = value;
            //console.log(value,  document.formprofile.avatar.files[0]);
        });
    }

    globalAssignEvent();

    function showLoading() {
    }
    function hideLoading() {
    }

    function updateObjs(objs, data) {
        jQuery(objs).each( function(index){
            console.log(this);
           //jQuery(jQuery(this).)
        })
    }
    
    setTimeout(function(){
        updateObjs([1,2,3]);
    }, 3000);
    
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
        if(result.returnValue==true) {
            if(typeof callback == 'function')
                callback(form, result);
        } else {
            console.log('Something wrong when upload file in server');  
        }
    }
}

// Public function
function afterUploadedAvatar(form, result) {
    form = document.querySelector(form);
    //jQuery('.avatar').attr('src', form.avatar.value);
    document.formprofile.avatar.value = result.path;
    form.reset();
    jQuery('#'+ajaxUploadFile.frameName).remove();
}