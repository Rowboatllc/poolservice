// Service company dashboard
jQuery(document).ready(function () {
    function assignEvent() {
        // company-offered-service
        /*jQuery('.company-offered-service').find('.accept-service-offer, .deny-service-offer').bind('click', function() {
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
        */
        jQuery('.company_service_offers input[type="checkbox"]').bind('click', function(){
            toggleSaveButton();
        });
        
        jQuery('.company_service_offers .saveform-fieldset').bind('click', function(){
            $me = jQuery(this);
            let $obj = $me.parents('.fieldset');
            let data = $obj.find('input').serialize();
            if(data=='')
                return
            sendData($obj.attr('action'), data, $obj.attr('method'), function (result) {
                if(result.success!=true)
                    return
                $me.addClass('no_display');
            }, function () {
                console.log('something wrong');
            });
        });
       
        //technician-professionnal-service
        jQuery('.technician-professionnal-service').on('click','.save-techinician', function() {
            let $me = jQuery(this);
            let $form = $me.parents('form');
            saveForm($form, function(result){
                $form.parents('.modal').modal('hide');
                let params = jQuery('.technician-professionnal-service .table-responsive').data();
                reloadCurrentPage(params, params.url, function(result){
                    console.log(result);
                });
            });
        }).on('click', '.remove-item-list', function() {
            if(!confirm("Press a button!"))
                return;
            let $me = jQuery(this);
            let url = $me.parents('table').data('removeurl');
            let id = $me.data('id');
            sendData(url, {id:id}, 'POST', function (result) {
                let params = $me.parents('.table-responsive').data();
                reloadCurrentPage(params, params.url, function(result){
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
            //console.log(page);
            //let url = $me.parents('.table-responsive').data('url');
            $me.parents('.table-responsive').data('page', page);
            let params = $me.parents('.table-responsive').data();
            reloadCurrentPage(params, params.url, function(result){
                console.log(result);
            });
        }).on('click', '[data-orderfield]', function(event) {
            let $me = jQuery(this);
            $coverTable = $me.parents('.table-responsive');
            $orderDirection = $coverTable.data('orderdir')||'asc';
            $orderField = $coverTable.data('orderfield')||'';
            if($orderField==$me.data('orderfield')) {
                $orderDirection = (($orderDirection=='asc')? 'desc' : 'asc');
                $coverTable.data('orderdir', $orderDirection);
            } else {
                $coverTable.data('orderfield', $me.data('orderfield'));
            }
            let params = $coverTable.data();
            reloadCurrentPage(params, params.url, function(result){
                console.log(result);
            });
        });
        
    }
    
    function toggleSaveButton() {
        let $obj = jQuery('.company_service_offers');
        let data = $obj.find('input').serialize();
        console.log('data', data);
        if(data=='') {
            $obj.find('.saveform-fieldset').addClass('no_display');
        } else {
            $obj.find('.saveform-fieldset').removeClass('no_display');
        }
    }
    
    assignEvent();
    autoPaging('.technician-professionnal-service');
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

function reloadCurrentPage(params, url, callback) {
    sendData(url, params, 'POST', function(result){
        let list = JSON.parse(result.list);
        parseData(".rowtpl", ".technician-professionnal-service .table-list", list.data, true);
        parsePaging(Math.ceil(list.total/list.per_page), ".technician-professionnal-service .pagination", (params.page||''));
    });
}

function parseData(tpl, dest, data, append) {
    if(append) 
        jQuery(dest).find('tr:not(:first)').remove();
    $(tpl).tmpl(data).appendTo(dest);
}

function parsePaging(totalpage, dest, curpage) {
    let str=''; 
    let activeClass;
    if(curpage=='') curpage=1;
    if(totalpage>1) {
        for(let i=1; i<=totalpage; i++) {
            activeClass = (i==curpage) ? 'active' : '';
            str = str + '<li class="'+activeClass+'"><span>'+ i +'</span></li>';
        }
    }
    jQuery(dest).html('').append(str);
}

function autoPaging(cover_div) {
    let tables = jQuery(cover_div).find('.table-responsive');
    let totalpage, curpage, $me;
    tables.each(function(){
        $me = jQuery(this);
        totalpage = $me.data('totalpage');
        curpage = $me.data('page');
        setCurrentPage(this, curpage)
        parsePaging(totalpage, $me.find('.pagination')[0], curpage);
    });
}

function setCurrentPage(cover_div, page) {
    jQuery(cover_div).data('page', page)
}