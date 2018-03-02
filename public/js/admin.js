$(function () {
    $('span.ajaxRotate').on('click', function (e) {
        e.preventDefault();
        var element = $(this);
        var url = element.attr('data-action');

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                var img = $('img.' + element.attr('data-img'));
                tmp = new Date();
                tmp = "?" + tmp.getTime();
                img.attr('src', img.attr('src') + tmp);
            },
            error: function (error) {
                console.log(error);
            }

        });
    });
});
