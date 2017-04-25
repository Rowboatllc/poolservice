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
    }
    assignEvent();
});