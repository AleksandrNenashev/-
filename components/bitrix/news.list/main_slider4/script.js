function slider_go2()
{
    var html = $('.jcarousel-pagination2 .krigok_i2').html();
    //alert(html);
    //$('.jcarousel-pagination2:first-child + next').click();
    $('.jcarousel-pagination2 .krigok_i2').click();
}
(function($) {
    $(function() {
        $('.jcarousel').jcarousel({
            wrap: 'both',
        })
        .jcarouselAutoscroll({
            interval: 4000,
            target: '+=1',
            autostart: true
        });
            
        setTimeout("slider_go2()",2000);

        $('.jcarousel-pagination2')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .jcarouselPagination({
                item: function(page) {
                    return '<a class="krigok krigok_i'+page+'" href="#' + page + '"></a>';
                }
            });
    });
})(jQuery);
