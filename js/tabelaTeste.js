$(function() {
    $('a[data-toggle=modal][data-target]').click(function () {
        var target = $(this).attr('href');
        $('a[data-toggle=tab][href=' + target + ']').tab('show');
    });

    
});

