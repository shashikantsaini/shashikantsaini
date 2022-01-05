require(
    [
        'jquery', 
        'jquery/ui'
    ], 
    function($) {
        $(document).ready(function() {
            $('.faq-section-title').click(function(e) {
                var currentAttrvalue = $(this).attr('href');
                if ($(e.target).is('.active')) {
                    $(this).removeClass('active');
                    $('.faq-section-content:visible').slideUp(300);
                } else {
                    $('.faq-section-title').removeClass('active').filter(this).addClass('active');
                    $('.faq-section-content').slideUp(300).filter(currentAttrvalue).slideDown(300);
                }
            });
    
            $('.faqgroup-section-title').click(function(e) {
                var currentAttrvalue = $(this).attr('href');
                if ($(e.target).is('.active')) {
                    $(this).removeClass('active');
                    $('.faqgroup-section-content:visible').slideUp(300);
                } else {
                    $('.faqgroup-section-title').removeClass('active').filter(this).addClass('active');
                    $('.faqgroup-section-content').slideUp(300).filter(currentAttrvalue).slideDown(300);
                    $(this).parent().addClass('faqgroup-faq-active');
                    $(this).parent().siblings().removeClass('faqgroup-faq-active');
                }
            });
        });
    });