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
    
    function sendDataWithToken(url, data, method, callback, error) {
        showLoading();
        var key = 'EBZTD1ykD5k8U7GSfZDxlbu3smwlow3IEtBplB8n302cN2PuH0dcE6ooGEGS';
        method = method || 'POST';
        //var token = data._token = jQuery('meta[name="csrf-token"]').attr('content');
        /*if (typeof data == 'string') {
            data = data;// + '&_token=' + token;
        } else {
            data._token = token;
        }*/
        jQuery.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "application/json",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "Authorization": "Bearer " + key
            },
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

    function saveForm($form) {
        sendDataWithToken($form.attr('action'), $form.serialize(), $form.attr('method'), function () {
            console.log('form saved');
        }, function () {
            console.log('something wrong');
        })
    }

    function showLoading() {
    }
    function hideLoading() {
    }

    function globalAssignEvent() {
        jQuery('.adminpanel').on('click', '.save_form', function () {
            saveForm($(this).parents('form'));
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
                $me('saveGroup', [this]);
            });
        },
        saveOptionParams: function (obj) {
            var url = jQuery('.option_panel').data('saveurl');
            var group = jQuery(obj).parents('.a_group').data('key');
            var data = jQuery(obj).parent().find('input').serialize() + '&group=' + group;

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