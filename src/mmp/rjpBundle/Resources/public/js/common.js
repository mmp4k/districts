$(function() {
    $('.col-sm-6.border-right').each(function() {
        var heightLeft  = $(this).height();
        var heightRight = $(this).next().height();

        if(heightLeft > heightRight) {
            $(this).next().height(heightLeft);
        } else {
            $(this).height(heightRight);
        }
    });
});