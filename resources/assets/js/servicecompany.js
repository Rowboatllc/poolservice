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
            let $obj = $me.closest('.fieldset');
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
        jQuery('.technician-professionnal-service').on('click','.new-item', function() {
            let modal = jQuery(this).data('target');
            let names = ['fullname', 'phone', 'email', 'id', 'avatar', 'is_owner'];
            setElementValues(modal, names, '');
        }).on('click','.save-item', function() {
            let $me = jQuery(this);
            let $form = $me.closest('form');
            if(!isValidate($form))
                return;
            saveForm($form, function(result){
                $form.closest('.modal').modal('hide');
                let params = $form.closest('.content-block').find('.table-responsive').data();
                reloadCurrentPage(params, params.url, function(result){
                    console.log(result);
                });
            });
        }).on('click', '.remove-item-list', function() {
            if(!confirm("Press a button!"))
                return;
            let $me = jQuery(this);
            let url = $me.closest('table').data('removeurl');
            let id = $me.data('id');
            sendData(url, {id:id}, 'POST', function (result) {
                let params = $me.closest('.table-responsive').data();
                reloadCurrentPage(params, params.url, function(result){
                    console.log(result);
                });
            }, function () {
                console.log('something wrong');
            })
        }).on('click', '.edit-item-list', function() {
            let $me = jQuery(this);
            let url = $me.closest('table').data('getitemurl');
            let params = {id:$me.data('id')};
            $me.closest('.content-block').find('.new-item').trigger('click');
            $modal = $me.closest('.content-block').find('.modal');
            
            sendData(url, params, 'POST', function(result){
                $items = $modal.find('[name]');
                $items.each(function(){
                    let key = jQuery(this).attr('name');
                    if(typeof result.item[key] != 'undefined')
                        setElementValue(jQuery(this), result.item[key]);
                });
            });
        }).on('click', '.pagination li span', function(event) {
            event.preventDefault();
            let $me = jQuery(this);
            let page = $me.text();
            $me.closest('.table-responsive').data('page', page);
            let params = $me.closest('.table-responsive').data();
            reloadCurrentPage(params, params.url, function(result){
                console.log(result);
            });
        }).on('click', '[data-orderfield]', function(event) {
            let $me = jQuery(this);
            $coverTable = $me.closest('.table-responsive');
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
        }).on('click', '.technician-img', function(event) {
            jQuery('.technician-professionnal-service .form_technician-avatar input[type="file"]').trigger('click');
        }); 
        
    }
    
    function reloadCurrentPage(params, url, callback) {
        sendData(url, params, 'POST', function(result){
            let list = JSON.parse(result.list);
            parseData(".rowtpl", ".technician-professionnal-service .table-list", list.data, true);
            parsePaging(Math.ceil(list.total/list.per_page), ".technician-professionnal-service .pagination", (params.page||''));
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
    jQuery('.technician-professionnal-service input[name="avatar"]').val(result.path);
    document.querySelector(form).reset();
    jQuery('#'+ajaxUploadFile.frameName).remove();
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

function setElementValue($item, value) {
    if($item.is('input[type="checkbox"]')) {
        var checked = (value==$item.attr('value')) ? true : false;
        $item[0].checked = checked;
        return;
    }
    if($item.is(':input')) {
        $item.val(value);
        return;
    }
    if($item.is('img')) {
        let path = $item.attr('path');
        $item.attr('src', path+value);
        return;
    }   
    $item.html(value);
}


function setElementValues(cover_div, names, val) {
    $cover_div = jQuery(cover_div);
    jQuery.each(names, function(key, value){
        $item = $cover_div.find('[name="'+value+'"]');
        for(let i=0; i<$item.length; i++) {
            setElementValue(jQuery($item[i]), val);
        }
    });
}