jQuery(document).ready(function () {
    // Your code here
    function saveParam(obj) {
        var $form = $(obj).parents('form');
        //console.log($form.length); return;
        jQuery.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            data: $form.serialize(),
            success : function(result){
                console.log(result);
            }
        });
    }

    jQuery('.saveParam').bind('click', function () {
        saveParam(this);
    });
});