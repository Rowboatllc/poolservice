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
                reloadTechnicianPage(params, params.url);
            });
        }).on('click', '.remove-item-list', function() {
            if(!confirm("Do you really want to delete?"))
                return;
            let $me = jQuery(this);
            let url = $me.closest('table').data('removeurl');
            let id = $me.data('id');
            sendData(url, {id:id}, 'POST', function (result) {
                let params = $me.closest('.table-responsive').data();
                reloadTechnicianPage(params, params.url);
            });
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
        }).on('click', '.technician-img', function(event) {
            jQuery('.technician-professionnal-service .form_technician-avatar input[type="file"]').trigger('click');
        });
        
        // paging, sorting
        jQuery('.dashboard').on('click', '[data-orderfield]', function(event) {
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
            $coverTable.find('[data-orderfield]').removeClass('asc desc');
            $me.addClass($orderDirection);
            let params = $coverTable.data();
            reloadCurrentPage($coverTable[0], params, params.url);
        }).on('click', '.pagination li span', function(event) {
            event.preventDefault();
            let $me = jQuery(this);
            let page = $me.text();
            $me.closest('.table-responsive').data('page', page);
            let params = $me.closest('.table-responsive').data();
            reloadCurrentPage($me.closest('.table-responsive')[0], params, params.url);
        }).on('click', '.search', function(event) {
            let $parent = jQuery(this).closest('.table-responsive');
            let value = jQuery.trim($parent.find('[name="searchvalue"]').val());
            if(value.length<4)
                return;
            let field = $parent.find('[name="searchfield"]').val();
            $parent.data('searchvalue', value);
            $parent.data('searchfield', field);
            $parent.data('page', '');
            let params = $parent.data();
            reloadCurrentPage($parent[0], params, params.url);
        }).on('click', '.clear-filter', function(event) {
            let $parent = jQuery(this).closest('.table-responsive');
            $parent.find('[name="searchvalue"]').val('');
            $parent.find('[name="searchfield"]').val('');
            $parent.data('searchvalue', '');
            $parent.data('searchfield', '');
            $parent.data('page', '');
            let params = $parent.data();
            reloadCurrentPage($parent[0], params, params.url);
        });
        
    }
    
    function reloadCurrentPage(parent, params, url, callback) {
        let $coverdiv = jQuery(parent);
        sendData(url, params, 'POST', function(result){
            let list = JSON.parse(result.list);
            console.log(list.data);
            parseData($coverdiv.find('[type="text/x-jquery-tmpl"]')[0], $coverdiv.find('table')[0], list.data, true);
            parsePaging(Math.ceil(list.total/list.per_page), $coverdiv.find('.pagination')[0], (params.page||''));
        });
    }
    
    function reloadTechnicianPage(params, url, callback) {
        reloadCurrentPage(".technician-professionnal-service", params, url, callback)
    }
    
    function reloadCurrentCustomerPage(params, url, callback) {
        reloadCurrentPage(".company-customer", params, url, callback)
    }

    function toggleSaveButton() {
        let $obj = jQuery('.company_service_offers');
        let data = $obj.find('input').serialize();
        if(data=='') {
            $obj.find('.saveform-fieldset').addClass('no_display');
        } else {
            $obj.find('.saveform-fieldset').removeClass('no_display');
        }
    }
    
    assignEvent();
    autoPaging('.dashboard');
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
    jQuery(tpl).tmpl(data).appendTo(dest);
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
        setCurrentPage(this, curpage);
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