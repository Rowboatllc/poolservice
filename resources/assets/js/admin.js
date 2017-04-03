jQuery(document).ready(function () {
    jQuery('.option_panel').on('click', '.save_option', function () {
        saveOptionParams(jQuery(this).parent());
    });

    jQuery('.option_panel').on('click', '.remove_option', function () {
        removeOption( jQuery(this).parent().data('key') );
    });

    jQuery('.option_panel .add_new').bind('click', function () {
        var $aRow = jQuery('.option_panel .an_option').first().clone();
        $aRow.find('input').val('');
        jQuery('.option_panel .an_option').last().after($aRow);
    });

    function saveOptionParams(obj) {
        var url = jQuery('.option_panel').data('saveurl');
        sendData(url, jQuery(obj).find('input').serialize());
    }
    
    function removeOption(key) {
        var url = jQuery('.option_panel').data('removeurl');
        var data = {
            action : 'remove-option',
            key : key
        };
        sendData(url, data);
    }
    
    function sendData(url, data, method, callback) {
        showLoading();
        method = method || 'POST';
        jQuery.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "application/json",
            success: function (result) {
                if(typeof callback == 'function')
                    callback(result);
                hideLoading();
            },
            error: function() {
                console.log('There is something wrong baby');
                hideLoading();
            }
        });
    }
    
    function showLoading() {
        
    }
    
    function hideLoading() {
        
    }
    
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