jQuery(document).ready(function () {
    // dashboard notification
    function assignEvent() {
        jQuery('.dashboard-notification').on('click','.view-item-list', function() {
            let $me = jQuery(this);
            let url = $me.closest('table').data('getitemurl');
            let params = {id:$me.data('id')};
            if($me.closest('tr').is('.notopened'))
                params.isOpened = 1;
            $modal = $me.closest('.content-block').find('.modal');
            $modal.modal();
            sendData(url, params, 'POST', function(result){
                $items = $modal.find('[name]');
                $items.each(function(){
                    let key = jQuery(this).attr('name');
                    if(typeof result.item[key] != 'undefined')
                        setElementValue(jQuery(this), result.item[key]);
                    $me.closest('tr').removeClass('notopened');
                });
            });
        });
    }
    assignEvent();
});