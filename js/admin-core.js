jQuery.noConflict();
(function ($) {
    $(function () {
        $(document).ready(function () {

            $('.un-el_generate-qr-button').on('click', function () {

                var testId = $(this).closest('.qr-generator-wrapper').find('select option:selected').val();
                var classId = $(this).data('class-id');

                $.ajax({
                    url: Core.rest_url + Core.routes.generate_qr,
                    type: 'POST',
                    data: {
                        test_id: testId,
                        class_id: classId
                    },
                    success: function (data) {
                        var success = data.success;
                        var message = data.message;

                        if (success) {
                            toastr.success(message);
                        } else {
                            toastr.error(message);
                        }
                    }
                });

            });

        });
    });
})(jQuery);
