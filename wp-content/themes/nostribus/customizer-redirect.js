(function($) {
    wp.customize.bind('ready', function() {
        var section = wp.customize.section('nos_tribus_intro_video');

        if (section) {
            section.expanded.bind(function(isExpanded) {
                console.log({section, isExpanded}, nosTribusCustomizer.introPageUrl)
                if (isExpanded) {
                    // Charger la page d'intro lorsqu'on ouvre la section
                    wp.customize.previewer.previewUrl.set(nosTribusCustomizer.introPageUrl);
                } else {
                    // Revenir à la home lorsqu'on quitte la section
                    wp.customize.previewer.previewUrl.set(nosTribusCustomizer.homePageUrl);
                }
            });
        }
    });
})(jQuery);


// (function ($) {
//     wp.customize('footer_text', function (value) {
//         value.bind(function (newval) {
//             $('.custom-footer').html(newval);
//             $('html, body').animate({
//                 scrollTop: $('.custom-footer').offset().top
//             }, 1000);
//         });
//     });
// })(jQuery);
