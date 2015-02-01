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