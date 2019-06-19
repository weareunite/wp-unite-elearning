jQuery.noConflict();
(function ($) {
    $(function () {
        $(document).ready(function () {

            $('#un-el_submit-button').on('click', function () {

                var formData = $(this.closest('form')).serializeArray();

            });

        });
    });
})(jQuery);
