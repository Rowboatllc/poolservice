function collapsedAllGoTadi() {
    $('.panel-gotadi').each(function () {
        if (!$(this).hasClass('panel-gotadi-default')) {
            $(this).find('.panel-body').slideUp();
            $(this).find('div.clickable').addClass('panel-collapsed');
            $(this).find('div.clickable').find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
        }

    });
}

$(document).ready(function () {

    /**
     * This object controls the nav bar. Implement the add and remove
     * action over the elements of the nav bar that we want to change.
     *
     * @type {{flagAdd: boolean, elements: string[], add: Function, remove: Function}}
     */
    var myNavBar = {
        flagAdd: true,
        elements: [],
        init: function (elements) {
            this.elements = elements;
        },
        add: function () {
            if (this.flagAdd) {
                for (var i = 0; i < this.elements.length; i++) {
                    document.getElementById(this.elements[i]).className += " fixed-theme";
                }
                this.flagAdd = false;
            }
        },
        remove: function () {
            for (var i = 0; i < this.elements.length; i++) {
                document.getElementById(this.elements[i]).className =
                        document.getElementById(this.elements[i]).className.replace(/(?:^|\s)fixed-theme(?!\S)/g, '');
            }
            this.flagAdd = true;
        }

    };

    /**
     * Init the object. Pass the object the array of elements
     * that we want to change when the scroll goes down
     */
    myNavBar.init([
        "header",
        "header-container",
        "brand"
    ]);

    /**
     * Function that manage the direction
     * of the scroll
     */
    function offSetManager() {

        var yOffset = 0;
        var currYOffSet = window.pageYOffset;

        if (yOffset < currYOffSet) {
            myNavBar.add();
        }
        else if (currYOffSet == yOffset) {
            myNavBar.remove();
        }

    }

    /**
     * bind to the document scroll detection
     */
    window.onscroll = function (e) {
        offSetManager();
    }

    /**
     * We have to do a first detectation of offset because the page
     * could be load with scroll down set.
     */
    offSetManager();
    collapsedAllGoTadi();
});
jQuery(document).ready(function () {
    $(document).on('click', '.panel-heading span.clickable', function (e) {
        var $this = $(this);
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel .panel-gotadi').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
        } else {
            collapsedAllGoTadi();
            $this.parents('.panel .panel-gotadi').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
        }
    });
    $(document).on('click', '.panel div.clickable', function (e) {
        var $this = $(this);
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel .panel-gotadi').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
        } else {
            collapsedAllGoTadi();
            $this.parents('.panel .panel-gotadi').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
        }
    });
});
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
jQuery(document).ready(function () {
    function globalAssignEvent() {
        jQuery('.fieldset')
          .on('click', '.editfieldset', function () {
            let $fieldset = $(this).parents('.fieldset');
            $fieldset.find('.contenteditable').toggleClass('active');
            $fieldset.find('.icon.badge').toggleClass('no_display');
        }).on('click', '.savefieldset', function () {
            let $fieldset = $(this).parents('.fieldset');
            //console.log(isValidate($fieldset), $fieldset);
            //return;
            if(!isValidate($fieldset))
                return;
            saveEditableContent($fieldset, function(result){
                if(result.success!=true)
                    return;
                console.log('changed');
                $fieldset.find('.contenteditable').toggleClass('active');
                $fieldset.find('.icon.badge').toggleClass('no_display');
            });
        }).on('click', '.upload-imagefieldset', function () {
            let $fieldset = $(this).parents('.fieldset');
            $fieldset.find('input[type="file"]').trigger('click');
            $fieldset.find('.icon.badge').toggleClass('no_display');
        }).on('click', '.save-imagefieldset', function () {
            let $fieldset = $(this).parents('.fieldset');
            $fieldset.find('.icon.badge').toggleClass('no_display');
            $fieldset.find('form').submit();
        }).on('click', '.cancel-editfieldset', function () {
            let $fieldset = $(this).parents('.fieldset');
            $fieldset.find('.icon.badge').toggleClass('no_display');
            $fieldset.find('.contenteditable').toggleClass('active');
            $fieldset.find('.inputerror').removeClass('inputerror');
            //revertEditableFieldValues($fieldset);
        });
    }

    globalAssignEvent();
    
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
                        jQuery(obj).parents('.an_option').remove();
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
            var group = jQuery(obj).parents('.a_group').data('key');
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
            var $covergroup = jQuery(obj).parents('.a_group');
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
            jQuery(obj).parents('.a_group').append($aRow);
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

// $(document).ajaxStop(function () {
//     $('#loading').hide();
// });

// $(document).ajaxStart(function () {
//     $('#loading').show();
// });

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
    if (typeof data == 'string') {
        data = data + '&_token=' + token;
    } else {
        data._token = token;
    }
    jQuery.ajax({
        url: url,
        method: method,
        data: data,
        //dataType: "application/json",
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
        //dataType: "application/json",
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
    sendDataWithToken($obj.attr('action'), data, $obj.attr('method'), function (result) {
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
    let value = jQuery.trim(jQuery(field).text());
    for(let i=0; i<$needs.length; i++) {
        if(!checkContent(value, $needs[i]))
            return false;
    }
    jQuery(field).removeClass('inputerror');
    return true;
}

function checkContent(value, type) {
    switch(type) {
        case 'require':
            return (value!='');
        break;
        case 'email':
            let re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            return re.test(value); 
        break;
        case 'number':
        break;
    }
}

function saveForm($form, callback) {
    sendDataWithToken($form.attr('action'), $form.serialize(), $form.attr('method'), function (result) {
        (callback || jQuery.noop)(result);		
    }, function () {
        console.log('something wrong');
    })
}
/*!
 * bootstrap-star-rating v4.0.2
 * http://plugins.krajee.com/star-rating
 *
 * Author: Kartik Visweswaran
 * Copyright: 2013 - 2017, Kartik Visweswaran, Krajee.com
 *
 * Licensed under the BSD 3-Clause
 * https://github.com/kartik-v/bootstrap-star-rating/blob/master/LICENSE.md
 */
(function (factory) {
    "use strict";
    //noinspection JSUnresolvedVariable
    if (typeof define === 'function' && define.amd) { // jshint ignore:line
        // AMD. Register as an anonymous module.
        define(['jquery'], factory); // jshint ignore:line
    } else { // noinspection JSUnresolvedVariable
        if (typeof module === 'object' && module.exports) { // jshint ignore:line
            // Node/CommonJS
            // noinspection JSUnresolvedVariable
            module.exports = factory(require('jquery')); // jshint ignore:line
        } else {
            // Browser globals
            factory(window.jQuery);
        }
    }
}(function ($) {
    "use strict";

    $.fn.ratingLocales = {};
    $.fn.ratingThemes = {};

    var $h, Rating;

    // global helper methods and constants
    $h = {
        NAMESPACE: '.rating',
        DEFAULT_MIN: 0,
        DEFAULT_MAX: 5,
        DEFAULT_STEP: 0.5,
        isEmpty: function (value, trim) {
            return value === null || value === undefined || value.length === 0 || (trim && $.trim(value) === '');
        },
        getCss: function (condition, css) {
            return condition ? ' ' + css : '';
        },
        addCss: function ($el, css) {
            $el.removeClass(css).addClass(css);
        },
        getDecimalPlaces: function (num) {
            var m = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            return !m ? 0 : Math.max(0, (m[1] ? m[1].length : 0) - (m[2] ? +m[2] : 0));
        },
        applyPrecision: function (val, precision) {
            return parseFloat(val.toFixed(precision));
        },
        handler: function ($el, event, callback, skipOff, skipNS) {
            var ev = skipNS ? event : event.split(' ').join($h.NAMESPACE + ' ') + $h.NAMESPACE;
            if (!skipOff) {
                $el.off(ev);
            }
            $el.on(ev, callback);
        }
    };

    // rating constructor
    Rating = function (element, options) {
        var self = this;
        self.$element = $(element);
        self._init(options);
    };
    Rating.prototype = {
        constructor: Rating,
        _parseAttr: function (vattr, options) {
            var self = this, $el = self.$element, elType = $el.attr('type'), finalVal, val, chk, out;
            if (elType === 'range' || elType === 'number') {
                val = options[vattr] || $el.data(vattr) || $el.attr(vattr);
                switch (vattr) {
                    case 'min':
                        chk = $h.DEFAULT_MIN;
                        break;
                    case 'max':
                        chk = $h.DEFAULT_MAX;
                        break;
                    default:
                        chk = $h.DEFAULT_STEP;
                }
                finalVal = $h.isEmpty(val) ? chk : val;
                out = parseFloat(finalVal);
            } else {
                out = parseFloat(options[vattr]);
            }
            return isNaN(out) ? chk : out;
        },
        _parseValue: function (val) {
            var self = this, v = parseFloat(val);
            if (isNaN(v)) {
                v = self.clearValue;
            }
            return (self.zeroAsNull && (v === 0 || v === '0') ? null : v);
        },
        _setDefault: function (key, val) {
            var self = this;
            if ($h.isEmpty(self[key])) {
                self[key] = val;
            }
        },
        _initSlider: function (options) {
            var self = this, v = self.$element.val();
            self.initialValue = $h.isEmpty(v) ? 0 : v;
            self._setDefault('min', self._parseAttr('min', options));
            self._setDefault('max', self._parseAttr('max', options));
            self._setDefault('step', self._parseAttr('step', options));
            if (isNaN(self.min) || $h.isEmpty(self.min)) {
                self.min = $h.DEFAULT_MIN;
            }
            if (isNaN(self.max) || $h.isEmpty(self.max)) {
                self.max = $h.DEFAULT_MAX;
            }
            if (isNaN(self.step) || $h.isEmpty(self.step) || self.step === 0) {
                self.step = $h.DEFAULT_STEP;
            }
            self.diff = self.max - self.min;
        },
        _initHighlight: function (v) {
            var self = this, w, cap = self._getCaption();
            if (!v) {
                v = self.$element.val();
            }
            w = self.getWidthFromValue(v) + '%';
            self.$filledStars.width(w);
            self.cache = {caption: cap, width: w, val: v};
        },
        _getContainerCss: function () {
            var self = this;
            return 'rating-container' +
                $h.getCss(self.theme, 'theme-' + self.theme) +
                $h.getCss(self.rtl, 'rating-rtl') +
                $h.getCss(self.size, 'rating-' + self.size) +
                $h.getCss(self.animate, 'rating-animate') +
                $h.getCss(self.disabled || self.readonly, 'rating-disabled') +
                $h.getCss(self.containerClass, self.containerClass);
        },
        _checkDisabled: function () {
            var self = this, $el = self.$element, opts = self.options;
            self.disabled = opts.disabled === undefined ? $el.attr('disabled') || false : opts.disabled;
            self.readonly = opts.readonly === undefined ? $el.attr('readonly') || false : opts.readonly;
            self.inactive = (self.disabled || self.readonly);
            $el.attr({disabled: self.disabled, readonly: self.readonly});
        },
        _addContent: function (type, content) {
            var self = this, $container = self.$container, isClear = type === 'clear';
            if (self.rtl) {
                return isClear ? $container.append(content) : $container.prepend(content);
            } else {
                return isClear ? $container.prepend(content) : $container.append(content);
            }
        },
        _generateRating: function () {
            var self = this, $el = self.$element, $rating, $container, w;
            $container = self.$container = $(document.createElement("div")).insertBefore($el);
            $h.addCss($container, self._getContainerCss());
            self.$rating = $rating = $(document.createElement("div")).attr('class', 'rating-stars').appendTo($container)
                .append(self._getStars('empty')).append(self._getStars('filled'));
            self.$emptyStars = $rating.find('.empty-stars');
            self.$filledStars = $rating.find('.filled-stars');
            self._renderCaption();
            self._renderClear();
            self._initHighlight();
            $container.append($el);
            if (self.rtl) {
                w = Math.max(self.$emptyStars.outerWidth(), self.$filledStars.outerWidth());
                self.$emptyStars.width(w);
            }
            $el.appendTo($rating);
        },
        _getCaption: function () {
            var self = this;
            return self.$caption && self.$caption.length ? self.$caption.html() : self.defaultCaption;
        },
        _setCaption: function (content) {
            var self = this;
            if (self.$caption && self.$caption.length) {
                self.$caption.html(content);
            }
        },
        _renderCaption: function () {
            var self = this, val = self.$element.val(), html, $cap = self.captionElement ? $(self.captionElement) : '';
            if (!self.showCaption) {
                return;
            }
            html = self.fetchCaption(val);
            if ($cap && $cap.length) {
                $h.addCss($cap, 'caption');
                $cap.html(html);
                self.$caption = $cap;
                return;
            }
            self._addContent('caption', '<div class="caption">' + html + '</div>');
            self.$caption = self.$container.find(".caption");
        },
        _renderClear: function () {
            var self = this, css, $clr = self.clearElement ? $(self.clearElement) : '';
            if (!self.showClear) {
                return;
            }
            css = self._getClearClass();
            if ($clr.length) {
                $h.addCss($clr, css);
                $clr.attr({"title": self.clearButtonTitle}).html(self.clearButton);
                self.$clear = $clr;
                return;
            }
            self._addContent('clear',
                '<div class="' + css + '" title="' + self.clearButtonTitle + '">' + self.clearButton + '</div>');
            self.$clear = self.$container.find('.' + self.clearButtonBaseClass);
        },
        _getClearClass: function () {
            var self = this;
            return self.clearButtonBaseClass + ' ' + (self.inactive ? '' : self.clearButtonActiveClass);
        },
        _toggleHover: function (out) {
            var self = this, w, width, caption;
            if (!out) {
                return;
            }
            if (self.hoverChangeStars) {
                w = self.getWidthFromValue(self.clearValue);
                width = out.val <= self.clearValue ? w + '%' : out.width;
                self.$filledStars.css('width', width);
            }
            if (self.hoverChangeCaption) {
                caption = out.val <= self.clearValue ? self.fetchCaption(self.clearValue) : out.caption;
                if (caption) {
                    self._setCaption(caption + '');
                }
            }
        },
        _init: function (options) {
            var self = this, $el = self.$element.addClass('rating-input'), v;
            self.options = options;
            $.each(options, function (key, value) {
                self[key] = value;
            });
            if (self.rtl || $el.attr('dir') === 'rtl') {
                self.rtl = true;
                $el.attr('dir', 'rtl');
            }
            self.starClicked = false;
            self.clearClicked = false;
            self._initSlider(options);
            self._checkDisabled();
            if (self.displayOnly) {
                self.inactive = true;
                self.showClear = false;
                self.showCaption = false;
            }
            self._generateRating();
            self._initEvents();
            self._listen();
            v = self._parseValue($el.val());
            $el.val(v);
            return $el.removeClass('rating-loading');
        },
        _initEvents: function () {
            var self = this;
            self.events = {
                _getTouchPosition: function (e) {
                    var pageX = $h.isEmpty(e.pageX) ? e.originalEvent.touches[0].pageX : e.pageX;
                    return pageX - self.$rating.offset().left;
                },
                _listenClick: function (e, callback) {
                    e.stopPropagation();
                    e.preventDefault();
                    if (e.handled !== true) {
                        callback(e);
                        e.handled = true;
                    } else {
                        return false;
                    }
                },
                _noMouseAction: function (e) {
                    return !self.hoverEnabled || self.inactive || (e && e.isDefaultPrevented());
                },
                initTouch: function (e) {
                    //noinspection JSUnresolvedVariable
                    var ev, touches, pos, out, caption, w, width, params, clrVal = self.clearValue || 0,
                        isTouchCapable = 'ontouchstart' in window ||
                            (window.DocumentTouch && document instanceof window.DocumentTouch);
                    if (!isTouchCapable || self.inactive) {
                        return;
                    }
                    ev = e.originalEvent;
                    //noinspection JSUnresolvedVariable
                    touches = !$h.isEmpty(ev.touches) ? ev.touches : ev.changedTouches;
                    pos = self.events._getTouchPosition(touches[0]);
                    if (e.type === "touchend") {
                        self._setStars(pos);
                        params = [self.$element.val(), self._getCaption()];
                        self.$element.trigger('change').trigger('rating.change', params);
                        self.starClicked = true;
                    } else {
                        out = self.calculate(pos);
                        caption = out.val <= clrVal ? self.fetchCaption(clrVal) : out.caption;
                        w = self.getWidthFromValue(clrVal);
                        width = out.val <= clrVal ? w + '%' : out.width;
                        self._setCaption(caption);
                        self.$filledStars.css('width', width);
                    }
                },
                starClick: function (e) {
                    var pos, params;
                    self.events._listenClick(e, function (ev) {
                        if (self.inactive) {
                            return false;
                        }
                        pos = self.events._getTouchPosition(ev);
                        self._setStars(pos);
                        params = [self.$element.val(), self._getCaption()];
                        self.$element.trigger('change').trigger('rating.change', params);
                        self.starClicked = true;
                    });
                },
                clearClick: function (e) {
                    self.events._listenClick(e, function () {
                        if (!self.inactive) {
                            self.clear();
                            self.clearClicked = true;
                        }
                    });
                },
                starMouseMove: function (e) {
                    var pos, out;
                    if (self.events._noMouseAction(e)) {
                        return;
                    }
                    self.starClicked = false;
                    pos = self.events._getTouchPosition(e);
                    out = self.calculate(pos);
                    self._toggleHover(out);
                    self.$element.trigger('rating.hover', [out.val, out.caption, 'stars']);
                },
                starMouseLeave: function (e) {
                    var out;
                    if (self.events._noMouseAction(e) || self.starClicked) {
                        return;
                    }
                    out = self.cache;
                    self._toggleHover(out);
                    self.$element.trigger('rating.hoverleave', ['stars']);
                },
                clearMouseMove: function (e) {
                    var caption, val, width, out;
                    if (self.events._noMouseAction(e) || !self.hoverOnClear) {
                        return;
                    }
                    self.clearClicked = false;
                    caption = '<span class="' + self.clearCaptionClass + '">' + self.clearCaption + '</span>';
                    val = self.clearValue;
                    width = self.getWidthFromValue(val) || 0;
                    out = {caption: caption, width: width, val: val};
                    self._toggleHover(out);
                    self.$element.trigger('rating.hover', [val, caption, 'clear']);
                },
                clearMouseLeave: function (e) {
                    var out;
                    if (self.events._noMouseAction(e) || self.clearClicked || !self.hoverOnClear) {
                        return;
                    }
                    out = self.cache;
                    self._toggleHover(out);
                    self.$element.trigger('rating.hoverleave', ['clear']);
                },
                resetForm: function (e) {
                    if (e && e.isDefaultPrevented()) {
                        return;
                    }
                    if (!self.inactive) {
                        self.reset();
                    }
                }
            };
        },
        _listen: function () {
            var self = this, $el = self.$element, $form = $el.closest('form'), $rating = self.$rating,
                $clear = self.$clear, events = self.events;
            $h.handler($rating, 'touchstart touchmove touchend', $.proxy(events.initTouch, self));
            $h.handler($rating, 'click touchstart', $.proxy(events.starClick, self));
            $h.handler($rating, 'mousemove', $.proxy(events.starMouseMove, self));
            $h.handler($rating, 'mouseleave', $.proxy(events.starMouseLeave, self));
            if (self.showClear && $clear.length) {
                $h.handler($clear, 'click touchstart', $.proxy(events.clearClick, self));
                $h.handler($clear, 'mousemove', $.proxy(events.clearMouseMove, self));
                $h.handler($clear, 'mouseleave', $.proxy(events.clearMouseLeave, self));
            }
            if ($form.length) {
                $h.handler($form, 'reset', $.proxy(events.resetForm, self), true);
            }
            return $el;
        },
        _getStars: function (type) {
            var self = this, stars = '<span class="' + type + '-stars">', i;
            for (i = 1; i <= self.stars; i++) {
                stars += '<span class="star">' + self[type + 'Star'] + '</span>';
            }
            return stars + '</span>';
        },
        _setStars: function (pos) {
            var self = this, out = arguments.length ? self.calculate(pos) : self.calculate(), $el = self.$element,
                v = self._parseValue(out.val);
            $el.val(v);
            self.$filledStars.css('width', out.width);
            self._setCaption(out.caption);
            self.cache = out;
            return $el;
        },
        showStars: function (val) {
            var self = this, v = self._parseValue(val);
            self.$element.val(v);
            return self._setStars();
        },
        calculate: function (pos) {
            var self = this, defaultVal = $h.isEmpty(self.$element.val()) ? 0 : self.$element.val(),
                val = arguments.length ? self.getValueFromPosition(pos) : defaultVal,
                caption = self.fetchCaption(val), width = self.getWidthFromValue(val);
            width += '%';
            return {caption: caption, width: width, val: val};
        },
        getValueFromPosition: function (pos) {
            var self = this, precision = $h.getDecimalPlaces(self.step), val, factor, maxWidth = self.$rating.width();
            factor = (self.diff * pos) / (maxWidth * self.step);
            factor = self.rtl ? Math.floor(factor) : Math.ceil(factor);
            val = $h.applyPrecision(parseFloat(self.min + factor * self.step), precision);
            val = Math.max(Math.min(val, self.max), self.min);
            return self.rtl ? (self.max - val) : val;
        },
        getWidthFromValue: function (val) {
            var self = this, min = self.min, max = self.max, factor, $r = self.$emptyStars, w;
            if (!val || val <= min || min === max) {
                return 0;
            }
            w = $r.outerWidth();
            factor = w ? $r.width() / w : 1;
            if (val >= max) {
                return 100;
            }
            return (val - min) * factor * 100 / (max - min);
        },
        fetchCaption: function (rating) {
            var self = this, val = parseFloat(rating) || self.clearValue, css, cap, capVal, cssVal, caption,
                vCap = self.starCaptions, vCss = self.starCaptionClasses;
            if (val && val !== self.clearValue) {
                val = $h.applyPrecision(val, $h.getDecimalPlaces(self.step));
            }
            cssVal = typeof vCss === "function" ? vCss(val) : vCss[val];
            capVal = typeof vCap === "function" ? vCap(val) : vCap[val];
            cap = $h.isEmpty(capVal) ? self.defaultCaption.replace(/\{rating}/g, val) : capVal;
            css = $h.isEmpty(cssVal) ? self.clearCaptionClass : cssVal;
            caption = (val === self.clearValue) ? self.clearCaption : cap;
            return '<span class="' + css + '">' + caption + '</span>';
        },
        destroy: function () {
            var self = this, $el = self.$element;
            if (!$h.isEmpty(self.$container)) {
                self.$container.before($el).remove();
            }
            $.removeData($el.get(0));
            return $el.off('rating').removeClass('rating rating-input');
        },
        create: function (options) {
            var self = this, opts = options || self.options || {};
            return self.destroy().rating(opts);
        },
        clear: function () {
            var self = this, title = '<span class="' + self.clearCaptionClass + '">' + self.clearCaption + '</span>';
            if (!self.inactive) {
                self._setCaption(title);
            }
            return self.showStars(self.clearValue).trigger('change').trigger('rating.clear');
        },
        reset: function () {
            var self = this;
            return self.showStars(self.initialValue).trigger('rating.reset');
        },
        update: function (val) {
            var self = this;
            return arguments.length ? self.showStars(val) : self.$element;
        },
        refresh: function (options) {
            var self = this, $el = self.$element;
            if (!options) {
                return $el;
            }
            return self.destroy().rating($.extend(true, self.options, options)).trigger('rating.refresh');
        }
    };

    $.fn.rating = function (option) {
        var args = Array.apply(null, arguments), retvals = [];
        args.shift();
        this.each(function () {
            var self = $(this), data = self.data('rating'), options = typeof option === 'object' && option,
                theme = options.theme || self.data('theme'), lang = options.language || self.data('language') || 'en',
                thm = {}, loc = {}, opts;
            if (!data) {
                if (theme) {
                    thm = $.fn.ratingThemes[theme] || {};
                }
                if (lang !== 'en' && !$h.isEmpty($.fn.ratingLocales[lang])) {
                    loc = $.fn.ratingLocales[lang];
                }
                opts = $.extend(true, {}, $.fn.rating.defaults, thm, $.fn.ratingLocales.en, loc, options, self.data());
                data = new Rating(this, opts);
                self.data('rating', data);
            }

            if (typeof option === 'string') {
                retvals.push(data[option].apply(data, args));
            }
        });
        switch (retvals.length) {
            case 0:
                return this;
            case 1:
                return retvals[0] === undefined ? this : retvals[0];
            default:
                return retvals;
        }
    };

    $.fn.rating.defaults = {
        theme: '',
        language: 'en',
        stars: 5,
        filledStar: '<i class="glyphicon glyphicon-star"></i>',
        emptyStar: '<i class="glyphicon glyphicon-star-empty"></i>',
        containerClass: '',
        size: 'md',
        animate: true,
        displayOnly: false,
        rtl: false,
        showClear: true,
        showCaption: true,
        starCaptionClasses: {
            0.5: 'label label-danger',
            1: 'label label-danger',
            1.5: 'label label-warning',
            2: 'label label-warning',
            2.5: 'label label-info',
            3: 'label label-info',
            3.5: 'label label-primary',
            4: 'label label-primary',
            4.5: 'label label-success',
            5: 'label label-success'
        },
        clearButton: '<i class="glyphicon glyphicon-minus-sign"></i>',
        clearButtonBaseClass: 'clear-rating',
        clearButtonActiveClass: 'clear-rating-active',
        clearCaptionClass: 'label label-default',
        clearValue: null,
        captionElement: null,
        clearElement: null,
        hoverEnabled: true,
        hoverChangeCaption: true,
        hoverChangeStars: true,
        hoverOnClear: true,
        zeroAsNull: true
    };

    $.fn.ratingLocales.en = {
        defaultCaption: '{rating} Stars',
        starCaptions: {
            0.5: 'Half Star',
            1: 'One Star',
            1.5: 'One & Half Star',
            2: 'Two Stars',
            2.5: 'Two & Half Stars',
            3: 'Three Stars',
            3.5: 'Three & Half Stars',
            4: 'Four Stars',
            4.5: 'Four & Half Stars',
            5: 'Five Stars'
        },
        clearButtonTitle: 'Clear',
        clearCaption: 'Not Rated'
    };

    $.fn.rating.Constructor = Rating;

    /**
     * Convert automatically inputs with class 'rating' into Krajee's star rating control.
     */
    $(document).ready(function () {
        var $input = $('input.rating');
        if ($input.length) {
            $input.removeClass('rating-loading').addClass('rating-loading').rating();
        }
    });
}));