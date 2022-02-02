jQuery(document).ready(function ($) {
    $('.repeater').repeater({
        initEmpty: false,
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if(confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: true
    });

    $('.repeaterNested').repeater({
        initEmpty: false,
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if(confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: true,
        repeaters: [{
            initEmpty: false,
            isFirstItemUndeletable: true,
            selector: '.inner-repeater'
        }]
    });
});