$(function() {
    $('.col-sm-6.border-right img').load(function() {
        var row = $(this).parents('.col-sm-6.border-right');
        var heightLeft  = $(row).height();
        var heightRight = $(row).next().height();

        if(heightLeft > heightRight) {
            $(row).next().height(heightLeft);
        } else {
            $(row).height(heightRight);
        }
    });
});
$(document).ready(function() {

    var div = $('.navbar-fixed-top-to-parent');
    if(!div.length) {
        return;
    }
    div.css('background', '#fff');
    div.css('z-index', '9999');
    div.css('width', div.parent().width());
    var start = $(div).offset().top;

    $.event.add(window, "scroll", function() {
         var p = $(window).scrollTop();
         $(div).css('position',((p)>start) ? 'fixed' : 'static');
         $(div).css('top',((p)>start) ? '0px' : '');
         if(((p)>start)) {
            div.next('.tab-content').css('margin-top', $(div).height());
         } else {
            div.next('.tab-content').css('margin-top', '0px');
         }
    });
});