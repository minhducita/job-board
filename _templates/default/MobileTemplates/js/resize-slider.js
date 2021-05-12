/**
 * Auth: SinhNguyen
 * Email: sinhnguyen193@gmail.com
 */
(function($){
    $(window).on('load resize orientationchange', function() {
        $('.carousel-inner .item').resizeSlider();
    });
    $.fn.resizeSlider = function(options) {
        var item     = $(this);
        var maxHeight = 0;
        $(item).each(function(){
            $(this).height('');
            var h     = $(this).height();
            maxHeight = Math.max(maxHeight, h);
        }).parent().height(maxHeight);
        $(item).each(function(){
            var h     = $(this).height();
            var img   = $(this).find('img');
            var paddingTop = (maxHeight - h) / 2;
            img.css('padding-top', paddingTop+'px');
        });
    }
})(jQuery);