
var Notification = (function () {

    return {
        toggleWaiting: function () {
            $(".waiting").fadeToggle("fast", function () { });
        },

        displayInfo: function (title, content) {
            $.pnotify({
                title: title,
                text: content,
                type: 'info',
                delay: 5000
            });
        },

        displaySuccess: function (title, content) {
            $.pnotify({
                title: title,
                text: content,
                type: 'success',
                delay: 5000
            });
        },

        displayError: function (title, content) {
            $.pnotify({
                title: title,
                text: content,
                type: 'error',
                hide: false,
                sticker: false,
                closer: true,
                closer_hover: false
            });
        },

        initialize: function () {
            $(".waiting").hide();
            $('.ui-pnotify').click(function () { $(this).remove(); });
        }
    };
})();

// init
$(document).ready(function () {
    Notification.initialize();
    $.pnotify.defaults.styling = "bootstrap3";
});
