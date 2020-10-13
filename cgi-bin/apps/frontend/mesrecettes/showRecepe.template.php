<?php 
    $recepeInfo     = \Page::get('recepeInfo'); 
    $mesures        = \Page::get('mesures'); 
    $ingredients    = \Page::get('ingredients'); 
    $categories     = \Page::get('categories'); 
    //die(var_dump($recepeInfo));
?>


<div class="container">
    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron black-overlay" style="background-image: url('./images/upload/<?php echo isset($recepeInfo['image']) ? $recepeInfo['image'] : 'untitled_' . $recepeInfo['catId'] . '.jpg' ?>');">
        
    </div>
    
    <h1 class="text-center"><?php echo $recepeInfo['nom']; ?> ( <?php echo $recepeInfo['nbPersonne'];?> personnes) <a class="btn btn-large btn-modif" data-toggle="modal" data-target="#modifyRecepeModal"><i class="fas fa-2x fa-pencil-alt"></i></a></h1>
    
    <!-------------------- CORPS  -------------------------------->
    <div class="btn-left-bloc">
        <button class="btn buttonAddExtend" data-toggle="modal" data-target="#addIngredientModal">
            <span class="circle">
                <span class="icon arrow"></span>
            </span>
            <span class="button-text">Nouvel ingrédient</span>
        </button>
    </div>
    
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="list-group list-cust">
                <span class="list-group-item active">Ingrédients de la recette</span>
                <?php foreach($ingredients as $ingredient) : ?>
                    <span  class="list-group-item">
                        <?php echo $ingredient['quantite'] . $ingredient['uniteMesure'] . ' ' .  $ingredient['ingredient']; ?>
                        <a class="list-group-item-delete" href="<?php echo \Application::getRoute('mesrecettes', 'deleteIngredients', array($ingredient['id'], $recepeInfo['id'])); ?>"><i class="fas fa-minus-circle"></i></a>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>



<!---------------------- MODALE INGREDIENTS ------------------------------------------>
<form action="<?php echo \Application::getRoute('mesrecettes', 'newIngredient'); ?>" method="POST">
    <div class="modal fade" id="addIngredientModal" tabindex="-1" role="dialog" aria-labelledby="addIngredientModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter un ingrédient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="<?php echo $recepeInfo['id'] ; ?>" name="fkRecepe">
                    <div class="form-group">
                        <label>Ingrédient</label>
                        <input type="text" class="form-control verifyText" id="ingredient" name="ingredient" data-name="ingredient"/>
                    </div>
                    <div class="form-group">
                        <label>Unité de mesure</label>
                        <select class="form-control verifySelect" name="mesure" data-name="unité de mesure">
                            <option value="null">Choissiez une unité de mesure</option>
                            <?php foreach($mesures as $mesure): ?>
                                <option value="<?php echo $mesure['id'] ?>"><?php echo \Db::decode($mesure['libelleLong']) . ' (' . \Db::decode($mesure['libelleCourt'])  . ')'?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Quantité</label>
                        <input type="number" class="form-control verifyInt" name="quantite" data-name="quantité"/>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                  <button type="submit" id="addNewRecepe" class="btn btn-primary submit-form-btn">Ajouter l'ingrédient</button>
                </div>
            </div>
        </div>
    </div>
</form>


<!---------------------- MODALE MODIF RECETTE  ------------------------------------------>
<form action="<?php echo \Application::getRoute('mesrecettes', 'updateRecepe'); ?>" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="modifyRecepeModal" tabindex="-1" role="dialog" aria-labelledby="modifyRecepeModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier la recette</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="<?php echo $recepeInfo['id'] ; ?>" name="fkRecepe">
                    <div class="form-group">
                        <label>Nom de la recette</label>
                        <input class="form-control verifyText" data-name="Nom de la recette" type="text" name="recepeName" value="<?php echo $recepeInfo['nom']; ?>">
                    </div> 
                    <div class="form-group">
                        <label>Pour combien de personnes</label>
                        <input class="form-control verifyInt" data-name="Nombre de personnes" type="number" name="recepeNbPersonne" value="<?php echo $recepeInfo['nbPersonne']; ?>">
                    </div>         
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select class="form-control verifySelect" data-name="Catégorie de la recette" name="recepeCategory">
                            <option value="null">Choissiez une catégorie principale</option>
                            <?php foreach($categories as $cat) :?>
                                <option <?php echo intval($recepeInfo['catId']) == intval($cat['id']) ? 'selected' : ''; ?> value="<?php echo $cat['id']; ?>"><?php echo \Db::decode($cat['libelle']); ?></option>
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
                    <button type="submit" id="updateNewRecepe" class="btn btn-primary submit-form-btn">Modifier la recette</button>
                </div>
            </div>
        </div>
    </div>
</form>

    
<script type="text/javascript" src="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>js/typeahead.js"></script>
<script>
    
    $('#ingredient').typeahead({
        delay : 500,
        source: function (query, process) {
            return $.ajax({
                url: '<?php echo \Application::getRoute('ajax', 'getIngredients'); ?>',
                type: 'post',
                dataType: 'json',
                data: { pattern: query, demand: 'byTitle' },
                success: function (jsonResult) {
                    console.log(jsonResult);
                    if(typeof jsonResult == 'undefined'){
                            return false;
                    }else{
                            return process(jsonResult);
                    }
                }
            });
        },
        updater: function (item) {
            return item;
        },
        minLength: 2
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