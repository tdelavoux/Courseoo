<?php $userInfos = \Page::get('userInfos'); ?>

<div class="container">
    
    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron account-jumbo">
        <div class="account-header">
            <h1 class="account-title"><?php echo \Db::decode($userInfos['login']) ?></h1>
            <div class="account-img">
                <btn data-toggle="modal" data-target="#changePict">
                    <div class="rounded-circle profile-img" style="background-image:url('./images/user/<?php echo $userInfos['image'] ? $userInfos['image'] : 'anonyme.jpg';?>');background-position: center;background-repeat: no-repeat;background-size: cover;">
                        <i class="fas fa-camera-retro ico-change"></i>
                    </div>
                </btn>
            </div>
        </div>
    </div>
  
    
    <div class="account-row row">     
        <div class="card-account col-12 col-sm-6">
            <div class="card blue">
                <div class="card-body">
                    <h6 class="card-title">Recettes</h6>
                    <p class="card-text blue-text"><i class="fas fa-receipt fa-2x"></i><?php echo $userInfos['nbRecettes'] ?></p>
                </div>
            </div>
        </div>
        <div class="card-account col-12 col-sm-6">
            <div class="card yellow">
                <div class="card-body">
                    <h6 class="card-title">Stars</h6>
                    <p class="card-text blue-text"><i class="fas fa-star fa-2x"></i>0</p>
                </div>
            </div>
        </div>
    </div>

    <div class="account-form">
        <h2 class="center">Mes informations</h2>
        <div class="form-group">
            <label>Nom de compte</label>
            <input type="text" class=" form-control borderless" placeholder="<?php echo \Db::decode($userInfos['login']) ?>" readonly />
        </div>
        <div class="form-group">
            <label>Inscrit depuis</label>
            <input type="text" class=" form-control borderless" placeholder="<?php echo \Db::decode($userInfos['dInsc']) ?>" readonly />
        </div>
        <div class="row justify-content-center">
            <span class="col-12 col-md-6 col-ld-3 p-1-2">
                <button class="btn btn-success col-12" data-toggle="modal" data-target="#changePassword">Changer mon mot de passe</button>
            </span>
            <span class="col-12 col-md-6 col-ld-3 p-1-2">
                <button class="btn btn-danger col-12" data-toggle="modal" data-target="#closeAccount">Clotûrer le compte</button>
            </span>
        </div>
    </div>
</div>


<!-- Modal -->
<form action="<?php echo \Application::getRoute('login', 'updatePasswd');?>" method="POST">   
    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePassword" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Changer de mot de passe</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <input type="hidden" class="form-control" name="fkUser" value="<?php echo $userInfos['id']?>"/>
                <div class="form-group">
                    <label>Nouveau mot de passe</label>
                    <input id="pw1" type="passwd" class="form-control verifyText" data-alternate-verif="verifyCorrespondance()" data-error-message="Les mots de passe ne correspondent pas " data-name="Mot de passe 1" name="pw1"/>
                </div>

                <div class="form-group">
                    <label>Retapez le mot de passe</label>
                    <input id="pw2" type="passwd" class="form-control verifyText" data-name="Mot de passe 2" name="pw2"/>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary submit-form-btn">Valider les modifications</button>
          </div>
        </div>
      </div>
    </div>
</form>

<!------------------------------ CLOTURE DE COMPTE ------------------------------------------------->

<div class="modal fade" id="closeAccount" tabindex="-1" role="dialog" aria-labelledby="closeAccount" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Vous nous quittez ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p class="text-danger">Attention cette action est irréversible</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a type="button" class="btn btn-danger" href="<?php echo \Application::getRoute('login','closeAccount', array( $userInfos['id'])); ?>">Clotûrer mon compte</a>
      </div>
    </div>
  </div>
</div>




<!------------------------------ CHANGEMENT DE PHOTO ------------------------------------------------->
<form role="form" action="<?php echo \Application::getRoute('account', 'modifyPict'); ?>" method="POST" enctype="multipart/form-data"> 
    <div class="modal fade" id="changePict" tabindex="-1" role="dialog" aria-labelledby="changePict" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nouvelle photo de profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">  
                    <legend>Ajouter une image</legend> 
                    <div class="row justify-content-md-center img-picker-body">
                        <div class="form-group col-3 flex-center"> 
                            <div class="img-picker"></div>
                        </div>   
                    </div>   
                    
                    <div id="test" style="display:none;"></div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
      </div>
    </div>
</form> 


<script>
    function verifyCorrespondance(){
        if($('#pw1').val() !== $('#pw1').val()){
            return true;
        }
        return false;
    }
    
    (function ( $ ) {
 
        $.fn.imagePicker = function( options ) {

            // Define plugin options
            var settings = $.extend({
                // Input name attribute
                name: "testImg",
                // Classes for styling the input
                class: "form-control btn btn-default btn-block",
                // Icon which displays in center of input
                icon: "fas fa-plus"
            }, options );

            // Create an input inside each matched element
            return this.each(function() {
                $(this).html(create_btn(this, settings));
            });

        };

        // Private function for creating the input element
        function create_btn(that, settings) {
            // The input icon element
            var picker_btn_icon = $('<i class="'+settings.icon+'"></i>');

            // The actual file input which stays hidden
            var picker_btn_input = $('<input id="fileUpload" type="file" name="'+settings.name+'" />');

            // The actual element displayed
            var picker_btn = $('<div class="'+settings.class+' img-upload-btn"></div>')
                .append(picker_btn_icon)
               .append(picker_btn_input);

            // File load listener
            picker_btn_input.change(function() {
                $('#test').html($(this));
                if ($(this).prop('files')[0]) {
                    // Use FileReader to get file
                    var reader = new FileReader();

                    // Create a preview once image has loaded
                    reader.onload = function(e) { 
                        var preview = create_preview(that, e.target.result, settings);
                        $(that).html(preview);
                    }

                    // Load image
                    reader.readAsDataURL(picker_btn_input.prop('files')[0]);
                }                
            });

            return picker_btn
        };

        // Private function for creating a preview element
        function create_preview(that, src, settings) {
                
                // The preview image
                var picker_preview_image = $('<div class="rounded-circle profile-img-sm" style="background-image:url('+src+');">');

                // The remove image button
                var picker_preview_remove = $('<button class="btn btn-link"><small>Remove</small></button>');

                // The preview element
                var picker_preview = $('<div class="text-center"></div>')
                    .append(picker_preview_image)
                    .append(picker_preview_remove);

                // Remove image listener
                picker_preview_remove.click(function() {
                    var btn = create_btn(that, settings);
                    $(that).html(btn);
                });

                return picker_preview;
        };

    }( jQuery ));

    $(document).ready(function() {
        $('.img-picker').imagePicker({name: 'images'});
    })
</script>