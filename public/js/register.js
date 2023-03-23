$(document).ready(function(){
   
    $("#register-form").on("submit",function(evt){
        
        evt.preventDefault();
        var userEmail = $("#registration_form_email").val();
        var currentForm = $(this);
        var postLink = $("#check_link").val();
        
        var checkEmailRequest = $.ajax({
                url:  postLink,
                type: "post",
                data: {userEmail : userEmail}
        });
    
        // Callback handler that will be called on success
        checkEmailRequest.done(function (response, textStatus, jqXHR){
            if(response.status == true && response.isUserExist == true){
                //an user exists with the same email
                var erreurs = {};
        
                var validator = $("#register-form").validate();
        
                erreurs["registration_form[email]"] = response.message;
                validator.showErrors(erreurs);
             
                //Notification.displayError("Erreur",response.message);
            }
            else if(response.status == false){
                Notification.displayError("Erreur",response.message);    
            }
            else{
                var t = currentForm;
                var tt = currentForm.attr('action');
                evt.currentTarget.submit();
            }
        });
        
        checkEmailRequest.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            Notification.displayError("Erreur","Erreur serveur rencontrée. Veuillez contacter l'administrateur."+errorThrown);
        });
          
    });
});


