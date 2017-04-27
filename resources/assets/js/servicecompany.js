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
        
        jQuery('.technician-professionnal-service').on('click','.save-techinician', function() {
           $form = jQuery(this).parents('form');
            saveForm($form, function(result){
                console.log(result);
                $form.parents('.modal').modal('hide');
            });
        }).on('click', '.remove-item-list', function() {
            if(!confirm("Press a button!"))
                return;
            $me = jQuery(this);
            let url = $me.parents('table').data('removeurl');
            let id = $me.data('id');
            sendDataWithToken(url, {id:id}, 'POST', function (result) {
                page = $me.parents('.table-responsive').find('.pagination .active').text();
                url = $me.parents('table').data('url');
                reloadCurrentPage(page, url, function(result){
                    console.log(result);
                });
            }, function () {
                console.log('something wrong');
            })
        }).on('click', '.edit-item-list', function() {
            
        }).on('click', '.pagination span', function(event) {
            event.preventDefault();
            $me = jQuery(this);
            page = $me.text();
            url = $me.parents('.table-responsive').find('table').data('url');
            reloadCurrentPage(page, url, function(result){
                console.log(result);
            });
        });
        
    }
    assignEvent();
});

function afterUploadedTechnicianAvatar(form, result) {
    let $img = jQuery('.technician-img');
    let cur = new Date();
    let newPath = $img.attr('path')+result.path+'?'+cur.getMilliseconds();
    $img.attr('src', newPath);
    jQuery('.technician-professionnal-service input[name="avatar"]').val(result.path);
    document.querySelector(form).reset();
    jQuery('#'+ajaxUploadFile.frameName).remove();
}

function reloadCurrentPage(page, url, callback) {
    sendDataWithToken(url, {page:page}, 'POST', function(result){
        let list = JSON.parse(result.list);
        parseData(".rowtpl", ".technician-professionnal-service .table-list", list.data, true);
        parsePaging(Math.ceil(list.total/list.per_page), ".technician-professionnal-service .pagination");
    });
}

function parseData(tpl, dest, data, append) {
    if(append) 
        jQuery(dest).find('tr:not(:first)').remove();
    $(tpl).tmpl(data).appendTo(dest);
}

function parsePaging(total, dest) {
    str='';
    for(let i=1; i<=total; i++) {
        str = str + '<li><span>'+ i +'</span></li>';
    }
    jQuery(dest).html('').append(str);
}