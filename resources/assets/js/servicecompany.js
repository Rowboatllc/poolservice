// Service company dashboard
jQuery(document).ready(function () {
    function assignEvent() {
        // company-offered-service
        jQuery('.company-offered-service').find('.accept-service-offer, .deny-service-offer').bind('click', function() {
            let $me = jQuery(this);
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
        //technician-professionnal-service
        jQuery('.technician-professionnal-service').on('click','.save-techinician', function() {
            let $me = jQuery(this);
            let $form = $me.parents('form');
            saveForm($form, function(result){
                console.log(result);
                $form.parents('.modal').modal('hide');
                page = jQuery('.technician-professionnal-service .table-responsive').find('.pagination .active').text();
                url = jQuery('.technician-professionnal-service table').data('url');
                reloadCurrentPage(page, url, function(result){
                    console.log(result);
                });
            });
        }).on('click', '.remove-item-list', function() {
            if(!confirm("Press a button!"))
                return;
            let $me = jQuery(this);
            let url = $me.parents('table').data('removeurl');
            let id = $me.data('id');
            sendDataWithToken(url, {id:id}, 'POST', function (result) {
                page = $me.parents('.table-responsive').find('.pagination li.active span').text();
                url = $me.parents('table').data('url');
                reloadCurrentPage(page, url, function(result){
                    console.log(result);
                });
            }, function () {
                console.log('something wrong');
            })
        }).on('click', '.edit-item-list', function() {
            let $me = jQuery(this);
            jQuery('.technician-professionnal-service .new-technician').trigger('click');
            $modal = jQuery('.technician-professionnal-serviceModal');
            let $cells = $me.parents('tr').find('[data-cell]');
            $cells.each(function(){
                let $cell = jQuery(this);
                let value = $cell.is('[data-value]') ? $cell.data('value') : $cell.text();
                $item = $modal.find('[name="'+$cell.data('cell')+'"]');//.val( value );
                if($item.is(':input')) {
                    $item.val(value);
                } else if($item.is('img')) {
                    $item.attr('src', value);
                } else {
                    $item.html(value);
                }
            });
        }).on('click', '.pagination li span', function(event) {
            event.preventDefault();
            let $me = jQuery(this);
            let page = $me.text();
            console.log(page);
            let url = $me.parents('.table-responsive').find('table').data('url');
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
    jQuery('.technician-professionnal-service input[name="avatar-path"]').val(result.path);
    document.querySelector(form).reset();
    jQuery('#'+ajaxUploadFile.frameName).remove();
}

function reloadCurrentPage(page, url, callback) {
    sendDataWithToken(url, {page:page}, 'POST', function(result){
        let list = JSON.parse(result.list);
        parseData(".rowtpl", ".technician-professionnal-service .table-list", list.data, true);
        parsePaging(Math.ceil(list.total/list.per_page), ".technician-professionnal-service .pagination", page);
    });
}

function parseData(tpl, dest, data, append) {
    if(append) 
        jQuery(dest).find('tr:not(:first)').remove();
    $(tpl).tmpl(data).appendTo(dest);
}

function parsePaging(total, dest, curpage) {
    let str=''; 
    let activeClass;
    if(curpage=='') curpage=1
    if(total>1) {
        for(let i=1; i<=total; i++) {
            activeClass = (i==curpage) ? 'active' : '';
            str = str + '<li class="'+activeClass+'"><span>'+ i +'</span></li>';
        }
    }
    jQuery(dest).html('').append(str);
}