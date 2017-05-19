jQuery(document).ready(function () {
   
    function globalAssignEvent() {
        jQuery('.fieldset')
          .on('click', '.editfieldset', function () {
            let $fieldset = $(this).closest('.fieldset');
            $fieldset.find('.contenteditable').toggleClass('active').attr('contenteditable', true);
            $fieldset.find('.icon.badge').toggleClass('no_display');
        }).on('click', '.savefieldset', function () {
            let $fieldset = $(this).closest('.fieldset');
            if(!isValidate($fieldset))
                return;
            saveEditableContent($fieldset, function(result){
                if(result.success!=true)
                    return;
                console.log('changed');
                $fieldset.find('.contenteditable').toggleClass('active').attr('contenteditable', false);
                $fieldset.find('.icon.badge').toggleClass('no_display');
            });
        }).on('click', '.upload-imagefieldset', function () {
            let $fieldset = $(this).closest('.fieldset');
            $fieldset.find('input[type="file"]').trigger('click');
            $fieldset.find('.icon.badge').toggleClass('no_display');
        }).on('click', '.save-imagefieldset', function () {
            let $fieldset = $(this).closest('.fieldset');
            $fieldset.find('.icon.badge').toggleClass('no_display');
            $fieldset.find('form').submit();
        }).on('click', '.cancel-editfieldset', function () {
            let $fieldset = $(this).closest('.fieldset');
            $fieldset.find('.icon.badge').toggleClass('no_display');
            $fieldset.find('.contenteditable').toggleClass('active').attr('contenteditable', false);
            $fieldset.find('.inputerror').removeClass('inputerror');
            //revertEditableFieldValues($fieldset);
        });
        
        jQuery('.contenteditable[maxlength]').on('keydown input paste', function(event) {
            let $me = jQuery(this);
            let len = parseInt($me.attr('maxlength'));
            let val = $me.text();
            if(val.length < len)
                return;
            if(event.type=='keydown' && event.keyCode != 8) {
                event.preventDefault();
                return;
            }
            if(event.type=='paste' || event.type=='input') {
                $me.text(val.substring(0, len));
                return;
            }
        });
        
        // Global dashboard
        jQuery('.dashboard .content-block').on('click','.save-item', function() {
            let $me = jQuery(this);
            let $form = $me.closest('form');
            if(!isValidate($form))
                return;
            saveForm($form, function(result){
                $form.closest('.modal').modal('hide');
                let params = $form.closest('.content-block').find('.table-responsive').data();
                //reloadTechnicianPage(params, params.url);
                reloadCurrentPage($me.closest('.content-block')[0], params, params.url);
            });
        }).on('click', '.remove-item-list', function() {
            if(!confirm("Do you really want to delete?"))
                return;
            let $me = jQuery(this);
            let url = $me.closest('table').data('removeurl');
            let id = $me.data('id');
            sendData(url, {id:id}, 'POST', function (result) {
                let params = $me.closest('.table-responsive').data();
                reloadCurrentPage($me.closest('.content-block')[0], params, params.url);
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
            let page = $me.is('[data-page]')?$me.data('page'):$me.text();
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
        
        // Lazyload
        jQuery('.dashboard [data-lazyload][data-toggle="tab"]').bind('click', function(){
            var $me = jQuery(this);
            var data = $me.data();
            //var action = getTabAction(data.lazyload);
            var table = jQuery($me.attr('href')).find('.table-responsive');
            if( !isChanged() && (data.loaded==true) )
                return;
            $me.data('loaded', true)
            lazyLoadList(table);
            /*if(typeof action=='function')
                action(table);
            */
        })

    }
    
    /*var tabActions = {
        comanyCustomer: function(table){
            lazyLoadList(table);
            //zyLoadList('.company-customer.content-block .table-responsive');
        },
        companyOfferFromPoolowner: function(table){
            lazyLoadList(table);
            //lazyLoadList('.company-offered-service.content-block .table-responsive');
        },
        companyTechnician: function(table){
            lazyLoadList(table);
            //lazyLoadList('.content-block.content-block .table-responsive');
        }
    }*/
    
    // This function will detect if need to reload this page
    function isChanged() {
        return false;
    }
    
    /*function getTabAction(myvar) {
        return eval('tabActions.'+myvar)
    }*/
    
    function lazyLoadList(obj) {
        $coverTable = jQuery(obj);
        let params = $coverTable.data();
        reloadCurrentPage($coverTable[0], params, params.url);
    }

    var dboptionMethods = {
        params: function () {
            return {
                coverpanel: '.option_panel',
                option: '',
                group: ''
            }
        },
        init: function (options) {},
        destroy: function () {},
        assignEvent: function () {
            var params = this.dboption('params');
            var $me = this.dboption;
            jQuery(params.coverpanel).on('click', '.save_option', function () {
                $me('saveOptionParams', [this]);
            });
            jQuery(params.coverpanel).on('click', '.remove_option', function () {
                var obj = this;
                $me('removeOption', [
                    jQuery(obj).parent().data('key'),
                    function () {
                        jQuery(obj).closest('.an_option').remove();
                    }
                ]);
            });
            jQuery(params.coverpanel).on('click', '.add_new', function () {
                $me('newOption', [this]);
            });
            jQuery(params.coverpanel).find('.add_new_group').bind('click', function () {
                $me('newGroup');
            });
            jQuery(params.coverpanel).on('click', '.save_group', function () {
                $me('saveGroup', [this]);
            });
        },
        saveOptionParams: function (obj) {
            var url = jQuery('.option_panel').data('saveurl');
            var group = jQuery(obj).closest('.a_group').data('key');
            var data = jQuery(obj).parent().find('input').serialize() + '&group=' + group;
            sendData(url, data);
        },
        removeOption: function (key, callback) {
            var url = jQuery('.option_panel').data('removeurl');
            var data = {
                action: 'remove-option',
                key: key
            };
            sendData(url, data, 'POST', callback);
        },
        newGroup: function () {
            var $aRow = jQuery('.option_panel .cover_an_option .a_group').first().clone();
            jQuery('.option_panel .cover_an_option').after($aRow);
        },
        saveGroup: function (obj) {
            var $covergroup = jQuery(obj).closest('.a_group');
            console.log($covergroup);
            var url = jQuery('.option_panel').data('savegroupurl');
            var groupname = $covergroup.find('input[name="group_name"]').val();
            var data = {
                alias: $covergroup.find('input[name="group_alias"]').val(),
                name: groupname
            }
            sendData(url, data, 'POST', function (result) {
                $covergroup.find('input').attr('disabled', 'disabled');
                $covergroup.data('key', groupname);
            });
        },
        newOption: function (obj) {
            var $aRow = jQuery('.option_panel .cover_an_option .an_option').first().clone();
            jQuery(obj).closest('.a_group').append($aRow);
        }
    };

    jQuery.fn.dboption = function (method) {
        if (dboptionMethods[method]) {
            return dboptionMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return dboptionMethods.init.apply(this, arguments);
        } else {
            jQuery.error('Method ' + method + ' does not exist on jQuery.dboption');
        }
    };

    jQuery.fn.dboption('assignEvent');
    globalAssignEvent();
    autoPaging('.dashboard');
    jQuery('img').on( "error", function(){
        var url = $('base').attr('href');
        jQuery(this).attr('src', url+'/images/shim.png');
    })
});

// Upload ajax
ajaxUploadFile = {
    frameName: 'frameUpload',
    frame: function (c) {
        var d = document.createElement('DIV');
        d.innerHTML = '<iframe style="display:none" src="about:blank" id="'+this.frameName+'" name="'+this.frameName+'" onload="ajaxUploadFile.loaded(\''+this.frameName+'\')"></iframe>';
        document.body.appendChild(d);
        var i = document.getElementById(this.frameName);
        if (c && typeof (c.onComplete) == 'function') {
            i.onComplete = c.onComplete;
        }
        return this.frameName;
    },
    form: function (f, name) {
        f.setAttribute('target', name);
    },
    submit: function (f, c) {
        this.form(f, this.frame(c));
        if (c && typeof (c.onStart) == 'function') {
            return c.onStart();
        } else {
            return true;
        }
    },
    loaded: function (id) {
        var i = document.getElementById(id);
        if (i.contentDocument) {
            var d = i.contentDocument;
        } else if (i.contentWindow) {
            var d = i.contentWindow.document;
        } else {
            var d = window.frames[id].document;
        }
        if (d.location.href == "about:blank") {
            return;
        }
        if (typeof (i.onComplete) == 'function') {
            i.onComplete(d.body.innerHTML);
        }
    },
    resetUpload: function(form, callback) {
        var result = jQuery('#'+this.frameName).contents().find('body').text();
        result = JSON.parse(result);
        if(result.success==true) {
            if(typeof callback == 'function')
                callback(form, result);
        } else {
            console.log('Something wrong when upload file in server');  
        }
    }
}

function showLoading() {
    $('#loading').show();
}
function hideLoading() {
    $('#loading').hide();
}
    
function sendData(url, data, method, callback, error) {
    showLoading();
    method = method || 'POST';
    var token = data._token = jQuery('meta[name="csrf-token"]').attr('content');
    jQuery.ajax({
        url: url,
        method: method,
        data: data,
        dataType: "json",
        headers: {
            "X-CSRF-Token": token
        },
        success: function (result) {
            (callback || jQuery.noop)(result);
            hideLoading();
        },
        error: function (result) {
            (error || jQuery.noop)(result);
            hideLoading();
        }
    });
}

function sendDataWithToken(url, data, method, callback, error) {
    showLoading();
    var key = jQuery('meta[name="api-token"]').attr('content');
    method = method || 'POST';
    jQuery.ajax({
        url: url,
        method: method,
        data: data,
        dataType: "json",
        headers: {
            "Accept": "application/json",
            "Authorization": "Bearer " + key
        },
        success: function (result) {
            (callback || jQuery.noop)(result);
            hideLoading();
        },
        error: function (result) {
           (error || jQuery.noop)(result);
           hideLoading();
        }
    });
}

function getEditableFieldValues($obj){
    let values = [];
    $obj.find('.contenteditable').each(function(){
        let $me = jQuery(this);
        let value = $me.is(':input') ? $me.val() : $me.text();
        values.push({ name : $me.attr('name'), value: value });
    });
    return values;
}

function revertEditableFieldValues($obj){
    $obj.find('.contenteditable').each(function(){
        let $me = jQuery(this);
        let value = $me.data('value');
        $me.is(':input') ? $me.val(value) : $me.text(value);
    });
}

function saveEditableContent($obj, callback) {
    let data = getEditableFieldValues( $obj );
    console.log(data);
    data = jQuery.param(data);
    sendData($obj.attr('action'), data, $obj.attr('method'), function (result) {
        (callback || jQuery.noop)(result);
    }, function () {
        console.log('something wrong');
    });
}

function isValidate($fieldset) {
    let $fields = $fieldset.find('[data-validate]');
    let result = true;
    $fields.each(function(){    
        if(!checkOneField(this)) {
            jQuery(this).addClass('inputerror');
            result = false;
        }
    });
    return (result && ($fieldset.find('.inputerror').length==0));
}

function checkOneField(field) {
    let $needs = jQuery(field).data('validate');
    $needs = $needs.split('|');
    let value = (jQuery(field).is(':input')) ? 
                    jQuery.trim(jQuery(field).val()): 
                    jQuery.trim(jQuery(field).text());
    for(let i=0; i<$needs.length; i++) {
        if(!checkContent(value, $needs[i], field))
            return false;
    }
    jQuery(field).removeClass('inputerror');
    return true;
}

function checkOneFieldWithValue(field, value) {
    let $needs = jQuery(field).data('validate');
    $needs = $needs.split('|');
    for(let i=0; i<$needs.length; i++) {
        if(!checkContent(value, $needs[i], field)){
            jQuery(field).addClass('inputerror');
            return false;
        } 
    }
    jQuery(field).removeClass('inputerror');
    return true;
}

function checkContent(value, type, field) {
    switch(type) {
        case 'require':
            return (value!='');
        break;
        case 'email':
            var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            return re.test(value); 
        break;
        case 'number':
            return jQuery.isNumeric(value);
        case 'phonenumber':
           var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
           return re.test(value); 
        break;
    }
}

function saveForm($form, callback) {
    sendData($form.attr('action'), $form.serialize(), $form.attr('method'), function (result) {
        (callback || jQuery.noop)(result);		
    }, function () {
        console.log('something wrong');
    })
}

function reloadCurrentPage(parent, params, url, callback) {
    let $coverdiv = jQuery(parent);
    sendData(url, params, 'POST', function(result){
        let list = JSON.parse(result.list);
        parseData($coverdiv.find('[type="text/x-jquery-tmpl"]')[0], $coverdiv.find('table')[0], list.data, true);
        parsePaging(Math.ceil(list.total/list.per_page), $coverdiv.find('.pagination')[0], (params.page||''));
    });
}

function parseData(tpl, dest, data, append) {
    if(append) 
        jQuery(dest).find('tr:not(:first)').remove();
    jQuery(tpl).tmpl(data).appendTo(dest);
}

function parsePaging(totalpage, dest, curpage) {
    if(totalpage<=1 ) {
        jQuery(dest).html('');
        return;
    }
    let str='', nextbtn='', prevbtn='', btnLeftMore = '', btnRightMore = '', activeClass, arrbtns=[], noOfsideMember = 2;
    if(curpage=='') curpage = 1;
    prevbtn = (curpage==1) ? '' : '<li><span data-page=0> << </span></li><li><span data-page='+ (parseInt(curpage)-1) +'> < </span></li>';
    nextbtn = (curpage==totalpage) ? '' : '<li><span data-page='+ (parseInt(curpage)+1) +'> > </span></li><li><span data-page='+ totalpage +'> >> </span></li>';
    
    for(let i=(parseInt(curpage)-noOfsideMember); i<=(parseInt(curpage)+noOfsideMember); i++) {
        if(i<=0 || i>totalpage)
            continue;
        activeClass = (i==curpage) ? 'active' : '';
        str = str + '<li class="'+activeClass+'"><span data-page='+ i +'> '+ i +' </span></li>';
    }
    
    if( (parseInt(curpage)-noOfsideMember) > 1)
        btnLeftMore = '<li><span data-page='+(parseInt(curpage)-noOfsideMember-1)+'> ... </span></li>';
    if( (parseInt(curpage)+noOfsideMember) < totalpage)
        btnRightMore = '<li><span data-page='+(parseInt(curpage)+noOfsideMember+1)+'> ... </span></li>';
    
    str = prevbtn + btnLeftMore + str + btnRightMore + nextbtn;
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