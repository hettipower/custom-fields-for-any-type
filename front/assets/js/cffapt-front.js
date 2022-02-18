jQuery(document).ready(function($) {
     
	$('.cffapt_shortcodeWrapper .shortcodeItem h3').on('click' , function(){
        $(this).parent().toggleClass('openAccordian');
        $(this).parent().find('.shortcodeContent').slideToggle('400');
    });
     
});