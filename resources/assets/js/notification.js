jQuery(document).ready(function () {
    function assignEvent() {
        // dashboard notification
        jQuery('.dashboard-notification').on('click','.view-item', function() {
        //jQuery('.dashboard .content-block').on('click','.new-item', function() {
            let modal = jQuery(this).data('target');
            let names = ['fullname', 'phone', 'email', 'id', 'avatar', 'is_owner'];
            setElementValues(modal, names, '');
        }).on('click', '.technician-img', function(event) {
            jQuery('.technician-professionnal-service .form_technician-avatar input[type="file"]').trigger('click');
        });
    }
    
    assignEvent();
});