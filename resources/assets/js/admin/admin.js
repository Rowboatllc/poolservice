jQuery(document).ready(function () {

    function sendData(url, data, method, callback, error) {
        showLoading();
        method = method || 'POST';
        var token = data._token = jQuery('meta[name="csrf-token"]').attr('content');
        if(typeof data=='string') {
            data = data + '&_token=' + token;
        } else {
            data._token = token;
        }
        jQuery.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "application/json",
            success: function (result) {
                if (typeof callback == 'function')
                    callback(result);
                hideLoading();
            },
            error: function (result) {
                console.log('There is something wrong baby');
                hideLoading();
                 if (typeof error == 'function')
                    error(result);
            }
        });
    }

    function showLoading() {
    }
    function hideLoading() {
    }

    var dboptionMethods = {
        params : function() {
            return { 
                coverpanel: '.option_panel',
                option: '',
                group: ''
            }
        },
        init: function (options) {
            /*return this.each(function () {
             var $this = $(this),
             data = $this.data('tooltip'),
             tooltip = $('<div />', {
             text: $this.attr('title')
             });
             alert('init called');
             // If the plugin hasn't been initialized yet
             if (!data) {
             
             jQuery(this).data('tooltip', {
             target: $this,
             tooltip: tooltip
             });
             }
             });*/
        },
        destroy: function () {
            /*return this.each(function () {
             var $this = $(this),
             data = $this.data('tooltip');
             // Namespacing FTW
             $(window).unbind('.tooltip');
             data.tooltip.remove();
             $this.removeData('tooltip');
             })*/
        },
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
                $me('saveGroup',[this]);
            });
        },
        saveOptionParams: function (obj) {
            var url = jQuery('.option_panel').data('saveurl');
            var group = jQuery(obj).parents('.a_group').data('key');
            var data = jQuery(obj).parent().find('input').serialize() + '&group='+group;
            
            //console.log(data);
           // return;
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
              alias : $covergroup.find('input[name="group_alias"]').val(),
              name : groupname
            }
            sendData(url, data, 'POST', function(result){
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