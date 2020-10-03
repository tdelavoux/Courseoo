<?php $categories = \Page::get('categories'); ?>
<?php $userRecepe = \Page::get('userRecepe'); ?>

<div class="container">
    
    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron my_recepe">
        <h1>Mes recettes</h1>
    </div>
    
    <!-------------------- CORPS  -------------------------------->
    <div class="row">
        <div class="col-12 col-md-6 inline-top">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="js-shuffle-search form-control" type="text"/>
            </div>
        </div>
        <div class="col-12 col-md-6 btn-left-bloc">
            <button class="btn buttonAddExtend" data-toggle="modal" data-target="#addRecepeModal">
                <span class="circle">
                    <span class="icon arrow"></span>
                </span>
                <span class="button-text">Nouvelle Recette</span>
            </button>
        </div>
    </div>
    
    <div class="row">
   
        <?php foreach($userRecepe as $recep) : ?> 
            <div class="bloc-card col-md-3 Sortable recepe-card col-12 col-sm-6 col-md-6 col-lg-3" data-title="<?php echo \Db::decode(strtoupper($recep['nom'])); ?>">
                <div class="card sub-card-recepe">
                    <img class="card-img-top" src="<?php echo isset($recep['image']) ? 'images/upload/' . $recep['image'] : 'images/upload/untitled_' . $recep['catId'] . '.jpg' ?>" alt="" />
                    <div class="card-body p-card-text">
                        <div class="card-body-content">
                            <h5 class="card-title"><?php echo strlen($recep['nom']) > 40 ? substr($recep['nom'], 0, 37) .'...'  : $recep['nom']; ?></h5>
                            <p class="card-text">
                                <a href="<?php echo \Application::getRoute('categories', 'index', array($recep['catId'], 1));?>">#<?php echo \Db::decode($recep['nomCategorie'])?></a>
                                
                            </p>
                            <p><a href="<?php echo \Application::getRoute('mesrecettes', 'showRecette', array($recep['id'])) ; ?>" class="text-info"><i class="fas fa-pencil-alt"></i>Editer la recette</a></p>
                            <p><a href="<?php echo \Application::getRoute('mesrecettes', 'deleteRecette', array($recep['id'])) ; ?>" class="text-danger"><i class="far fa-trash-alt"></i></i>Supprimer la recette</a></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
    </div>
   
</div>



<!---------------------- MODALE  ------------------------------------------>
<form action="<?php echo \Application::getRoute('mesrecettes', 'newRecepe'); ?>" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="addRecepeModal" tabindex="-1" role="dialog" aria-labelledby="addRecepeModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nouvelle Recette</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nom de la recette</label>
                    <input class="form-control verifyText" data-name="Nom de la recette" type="text" name="recepeName">
                </div> 
                <div class="form-group">
                    <label>Pour combien de personnes</label>
                    <input class="form-control verifyInt" data-name="Nombre de personnes" type="number" name="recepeNbPersonne">
                </div>         
                <div class="form-group">
                    <label>Catégorie</label>
                    <select class="form-control verifySelect" data-name="Catégorie de la recette" name="recepeCategory">
                          <option value="null">Choissiez une catégorie principale</option>
                          <?php foreach($categories as $cat) :?>
                              <option value="<?php echo $cat['id']; ?>"><?php echo \Db::decode($cat['libelle']); ?></option>
                          <?php endforeach; ?>
                    </select>
                </div> 
                <div class="input-file-container">  
                    <input class="input-file" id="my-file" type="file" name="recepeImage">
                    <label tabindex="0" for="my-file" class="input-file-trigger">Image (optionel)</label>
                </div>
                <p class="file-return"></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" id="addNewRecepe" class="btn btn-primary submit-form-btn">Ajouter le recette</button>
            </div>
        </div>
      </div>
    </div>
</form>


<script>
   $('.js-shuffle-search').keyup(function(){
      if($(this).val() === ''){
          $('.Sortable').show(500);
      } 
      else{
          $('.Sortable').not('[data-title*="' + $(this).val().toUpperCase() + '"]').hide(500);
          $('.Sortable[data-title*="' + $(this).val().toUpperCase() + '"]').show();
      }
   });
   
   document.querySelector("html").classList.add('js');

    var fileInput  = document.querySelector( ".input-file" ),  
        button     = document.querySelector( ".input-file-trigger" ),
        the_return = document.querySelector(".file-return");

    button.addEventListener( "keydown", function( event ) {  
        if ( event.keyCode == 13 || event.keyCode == 32 ) {  
            fileInput.focus();  
        }  
    });
    button.addEventListener( "click", function( event ) {
       fileInput.focus();
       return false;
    });  
    fileInput.addEventListener( "change", function( event ) {  
        var temp = $(this).val().split("\\");
        the_return.innerHTML = temp[temp.length -1 ];  
    });  

</script>