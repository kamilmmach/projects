$(function () {
    $('button.respond').click(function () {
        $(this).parent().next().slideToggle();
    });
});