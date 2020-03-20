require.config({
    deps: [
        'jquery'
    ],
    callback: function ($) {
        $(document).ready(function (e) {
            //Add event listener when any of the items to preview are changed
            $(document).on('change', '.update-preview', function () {
                updateBannerPreview();
            });
        });

        function updateBannerPreview() {
            var text = $('textarea[name="text"]').val();
            var bgColor = $('input[name="bg_color"]').val();
            var textColor = $('input[name="text_color"]').val();
            var icon = $('input[type="radio"]:checked').val();

            //Set the text & colors of the banner preview
            $('.banner-preview-box').css({'background-color' : bgColor});
            $('.banner-text').text(replaceTimerToken(text)).css({'color' : textColor});

            //Set the icon for preview if defined
            if (typeof icon != 'undefined') {
                var iconColor = $('input[name="icon_color"]').val();
                $('.banner-text').prepend('<i class="fas fa-' + icon + '"></i> ').append(' <i class="fas fa-' + icon + '"></i>');

                //Set the icon color
                $('.fa-' + icon).css({
                    'color' : iconColor
                });
            }

            //Display banner preview
            $('.banner-preview').show();
        }

        function replaceTimerToken(text) {
            var token = "{{timer}}";
            //Check if banner text contains timer token
            if(text.indexOf(token) !== -1) {
                //Replace token with default 30 min placeholder
                text = text.replace(token, '0 days 0 hours 0 minutes');
            }
            return text;
        }
    }
});
