$(document).ready(function(){

      var deleteManageFileDiv = function(){
        $(this).closest("div").remove();
        //$(".manageImageDiv").remove();
      };

      var addManageFileDiv = function(eltId, fileName){
        var manageFileDiv = $("<div/>",{'data-filename':fileName});
        manageFileDiv.html("<i class='fas fa-trash-alt wassa-link cancel-upload'></i>");
        $(eltId).html(manageFileDiv);

        attachEventList();
      }

      var attachEventList = function(){

        $(".cancel-upload").on("click",function(e){
          $("#category_document").val(null);
          $(".custom-file-input").siblings(".custom-file-label").addClass("selected").html('');
          deleteManageFileDiv();
        });

        $(".downloadFile").on("click",function(){
            var fileName = $(this).closest("div").data("filename");
            var downloadUrl = $(this).closest("div").data("download-url");
            
            var request = $.ajax({
                url:  downloadUrl,
                type: "post",
                data: {fileName : fileName}
            });
    
          // Callback handler that will be called on success
          request.done(function (response, textStatus, jqXHR){      
              PopinHelper.openDialogWithContent('Previsualisation Image',550,response);
          });
  
          // Callback handler that will be called on failure
          request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            Notification.displayError("Erreur","Une erreur inattendue s'est produite : Statu : "+textStatus + " " +errorThrown);
          });
        });

        $(".deleteFile").on("click",function(){
          
            var contextDiv = $(this).closest("div");
            
            var fileName = $(contextDiv).data("filename");
            var deleteUrl = $(contextDiv).data("delete-url");
            var eltId = $(contextDiv).data("id");
            var pictureNumber = $(contextDiv).data("picture-number");
            
            var msg = "Etes-vous sûre de vouloir supprimer ce fichier ?";
            var dataToSend = {fileName:fileName,eltId:eltId,pictureNumber : pictureNumber};
            
            CRUDDialog.confirmDialog(deleteUrl,'Confirmation',msg,function(){
                contextDiv.remove();
            },dataToSend);
        });

        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
          addManageFileDiv("#parentDivManageFile",fileName);
        });
      };

      attachEventList();
});