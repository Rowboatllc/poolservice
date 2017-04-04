jQuery(document).ready(function () {
    jQuery('.option_panel').on('click', '.save_option', function () {
        saveOptionParams(jQuery(this).parent());
    });

    jQuery('.option_panel').on('click', '.remove_option', function () {
        removeOption(jQuery(this).parent().data('key'), function () {
            $(this).parents('.an_option').remove();
        });
    });

    jQuery('.option_panel').on('click', '.add_new', function () {
        var $aRow = jQuery('.option_panel .cover_an_option .an_option').first().clone();
        jQuery(this).parents('.a_group').append($aRow);
    });

    jQuery('.option_panel .add_new_group').bind('click', function () {
        newGroup()
    });


    function saveOptionParams(obj) {
        var url = jQuery('.option_panel').data('saveurl');
        console.log(jQuery(obj).find('input').serialize());
        sendData(url, jQuery(obj).find('input').serialize());
    }

    function removeOption(key, callback) {
        var url = jQuery('.option_panel').data('removeurl');
        var data = {
            action: 'remove-option',
            key: key
        };
        sendData(url, data, 'POST', callback);
    }

    function newGroup() {
        var $aRow = jQuery('.option_panel .cover_an_option .a_group').first().clone();
        jQuery('.option_panel .cover_an_option').after($aRow);
    }

    function sendData(url, data, method, callback) {
        showLoading();
        method = method || 'POST';
        data._token = $('meta[name="csrf-token"]').attr('content');
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
            error: function () {
                console.log('There is something wrong baby');
                hideLoading();
            }
        });
    }

    function showLoading() {

    }

    function hideLoading() {

    }




    var methods = {
        init: function (options) {
            return this.each(function () {
                var $this = $(this),
                        data = $this.data('tooltip'),
                        tooltip = $('<div />', {
                            text: $this.attr('title')
                        });
                alert('init called');
                // If the plugin hasn't been initialized yet
                if (!data) {

                    /*
                     Do more setup stuff here
                     */

                    $(this).data('tooltip', {
                        target: $this,
                        tooltip: tooltip
                    });
                }
            });
        },
        destroy: function ( ) {
            return this.each(function () {
                var $this = $(this),
                        data = $this.data('tooltip');
                // Namespacing FTW
                $(window).unbind('.tooltip');
                data.tooltip.remove();
                $this.removeData('tooltip');
            })
        },
        reposition: function ( ) {
        },
        show: function ( ) {
        },
        hide: function ( ) {
        },
        hihi: function (o) {
            o = $.extend(true, {
                opt1: 40,
                opt2: 5,
            }, o);
            return this.each(function (i) {
                alert(o.opt1);
            });
        }
    };// end var methods

    $.fn.dboption = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.tooltip');
        }
    };










});