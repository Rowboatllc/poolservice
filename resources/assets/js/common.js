jQuery(document).ready(function () {
    // Your code here
    function saveParam(obj) {
        var $form = $(obj).parent('form');
        console.log($form.length); return;
        jQuery.ajax({
            url: "test/abc",
            method: "POST",
            data: {id: menuId},
            dataType: "html",
            success : function(result){
                console.log(result);
            }
        });
    }

    jQuery('.saveParam').bind('click', function () {
        saveParam();
    });
});