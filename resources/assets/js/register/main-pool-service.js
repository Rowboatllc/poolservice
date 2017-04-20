$(document).ready(function() {
    // next info
	$('.btn-next-info').on('click', function(e) {
        e.preventDefault();
        var current_active_step = $(this).parents('.f2').find('.list-group-item.active').next();
        current_active_step.siblings('a.active').removeClass("active");
        current_active_step.addClass("active");
        var index = current_active_step.index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });

    // back info
	$('.btn-previous').on('click', function(e) {
        e.preventDefault();
        var current_active_step = $(this).parents('.f2').find('.list-group-item.active').prev();
        current_active_step.siblings('a.active').removeClass("active");
        current_active_step.addClass("active");
        var index = current_active_step.index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});