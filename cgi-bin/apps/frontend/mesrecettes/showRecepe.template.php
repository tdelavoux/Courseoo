<?php 
    $recepeInfo     = \Page::get('recepeInfo'); 
    $mesures        = \Page::get('mesures'); 
    $ingredients    = \Page::get('ingredients'); 
?>


<div class="container">
    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron black-overlay" style="background-image: url('./images/upload/<?php echo isset($recepeInfo['image']) ? $recepeInfo['image'] : 'untitled_' . $recepeInfo['catId'] . '.jpg' ?>');">
        
    </div>
    
    <h1 class="text-center"><?php echo $recepeInfo['nom']; ?></h1>
    
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
                    <span  class="list-group-item"><?php echo $ingredient['quantite'] . $ingredient['uniteMesure'] . ' ' .  $ingredient['ingredient']; ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>



<!---------------------- MODALE  ------------------------------------------>
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
                  <button type="submit" id="addNewRecepe" class="btn btn-primary submit-form-btn">Ajouter le recette</button>
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

</script>