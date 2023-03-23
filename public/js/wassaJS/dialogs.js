var PopinHelper = (function(){
    var popup;

    function oDialogWithContent(formTitle, dialogWidth, content) {
        //load the page content first...
        $("#dialogForm").html(content);
        popup = $("#dialogForm").dialog({
            title: formTitle,
            autoOpen: false,
            width: dialogWidth,
            hide: { effect: 'fade', duration: 500 },
            modal: true,
            /*buttons: [
                {
                    text: "OK",
                    click: function () {
                        $(this).dialog("close");
                        $('#dialogForm').remove();
                    }
                }
            ],*/

            open: function (event, ui) {
                $("#dialogForm").css('overflow', 'hidden');
            }
        });
        popup.dialog("open");
    };

    return{
        openDialogWithContent: function (formTitle, dialogWidth, content) {
            oDialogWithContent(formTitle, dialogWidth, content);
        }
    };
})();

var CRUDDialog = (function(){

    return{
        deleteDialog: function (url, title, text, onSuccessFunction) {
            CRUDDialog.twoButtonPostDialog(url, title, text, onSuccessFunction, "Delete", "Cancel");
        },

        confirmDialog: function (url, title, text, onSuccessFunction, postData) {
            CRUDDialog.twoButtonPostDialog(url, title, text, onSuccessFunction, "  OK   ", "Cancel", postData);
        },

        twoButtonPostDialog: function (url, title, text, onSuccessFunction, okButtonLabel, cancelButtonLabel, postData) {
           console.log("two button post : "+postData);
            $("#dialog-confirm").html(text);
            // var dataToSendViaPost = rowid;
            // var requestType = 'GET';
            if (postData && typeof (postData) !== 'undefined')
            {
                dataToSendViaPost = postData;
                requestType = 'POST';
            }
            var btns = {};

            btns[okButtonLabel] = function () {
                $.ajax({
                    type: requestType,
                    dataType: 'json',
                    //context: $(grid),
                    data: dataToSendViaPost,
                    url: url}).done(function (response, textStatus, jqXHR) {
                        if (response.status == true) {
                            Notification.displaySuccess("Success", response.message);
                            $("#dialog-confirm").dialog("close");
                            if (jQuery.isFunction(onSuccessFunction)) {
                                onSuccessFunction();
                            }
                        }
                        else {
                            Notification.displayError("Error", response.message);
                        }}).fail(function (jqXHR, textStatus, errorThrown) {
                        Notification.displayError("Error", "Une erreur s'est produite : status("+status+") / erreur : "+errorThrown);
                    });
            };

            btns[cancelButtonLabel] = function () {
                $(this).dialog("close");
            };


            $("#dialog-confirm").dialog({
                title: title,
                resizable: false,
                height: 200,
                modal: true,
                buttons: btns
            });
         }
    };
})();