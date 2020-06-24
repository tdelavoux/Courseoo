<?php 
    $mesures        = \Page::get('mesures'); 
    $userRecepe     = \Page::get('userRecepe');
    $listUser       = \Page::get('listUser');
?>

<div class="container">
    
    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron shoping-jumbo">
        <h1>Ma Liste de course</h1>
    </div>
    
    <!-------------------- CORPS  -------------------------------->
    <div class="container mb-4">
        
        <!-- ------------------- Line ajout manuel ---------->
        <form action="<?php echo \Application::getRoute('listecourse', 'addIngredientToList'); ?>" method="POST">
            <div class="row bottom_bordered">
                <table class="col-md-12 form-table">
                    <thead>
                        <tr>
                            <th style="width:30%;">Ingredient</th>
                            <th style="width:30%;">Mesure</th>
                            <th style="width:30%;">Quantite</th>
                            <th style="width:10%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td ><input type="text" class="form-control verifyText" id="ingredient" name="ingredient" data-name="ingredient"/></td>
                            <td>
                                <select class="form-control verifySelect " name="mesure" data-name="unité de mesure">
                                    <option value="null">Choissiez une unité de mesure</option>
                                    <?php foreach($mesures as $mesure): ?>
                                        <option value="<?php echo $mesure['id'] ?>"><?php echo \Db::decode($mesure['libelleLong']) . ' (' . \Db::decode($mesure['libelleCourt'])  . ')'?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td> <input type="number" class="form-control verifyInt" name="quantite" data-name="quantité"/></td>
                            <td > <button type="submit" class="btn btn-success">Ajouter</button></td>
                        </tr>
                    </tbody>
                </table>       
            </div>
        </form>
        
        <!-- ------------------- Line ajout manuel ---------->
        <form action="<?php echo \Application::getRoute('listecourse', 'addIngredientToListByRecepe'); ?>" method="POST">
            <div class="row ">
                <table class="col-md-12 form-table">
                    <thead>
                        <tr>
                            <th class="col-md-3">Ajouter depuis une recette</th>
                            <th class="col-md-3"></th>
                            <th class="col-md-3"></th>
                            <th class="col-md-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-3">
                                <select id="select-recette" class="form-control verifySlect selectpicker" data-live-search="true" name="recette" >
                                    <option value="null">Selectionnez une recette</option>
                                    <?php foreach($userRecepe as $recep) : ?>
                                        <option data-tokens="<?php echo \Db::decode($recep['nom']); ?>" value="<?php echo $recep['id']; ?>"><?php echo \Db::decode($recep['nom']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="col-md-3"></td>
                            <td class="col-md-3"></td>
                            <td class="col-md-3"> <button class="btn btn-success" <button type="submit">Ajouter</button></td>
                        </tr>
                    </tbody>
                </table>  
            </div>
        </form>
        
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Ingrédient</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Categorie</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($listUser as $ingredient) : ?>
                            <tr>
                                <td><?php echo \Db::decode($ingredient['ingredient']); ?></td>
                                <td><?php echo  array_sum($ingredient['qts']) . ' ' . \Db::decode($ingredient['uniteMesure']) ; ?></td>
                                <td><?php echo  \Db::decode($ingredient['categorie']); ?></td>
                                <td class="text-right"> <button class="btn btn-sm btn-danger btn-delete" data-ids="<?php $comp=''; foreach($ingredient['ids'] as $id){echo $comp. $id; $comp='-'; } ?>"><i class="fa fa-trash"></i> </button></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col mb-2">
                <div class="row justify-content-end">
                    <div class=" col-md-3"> 
                        <a class="btn btn-lg btn-block btn-warning text-uppercase" href="<?php echo \Application::getRoute('listecourse', 'deleteAll');?>">REINITIALISER</a>
                    </div>
                    <div class=" col-md-3"> 
                        <a class="btn btn-lg btn-block btn-success text-uppercase download" href="<?php echo \Application::getRoute('imprimerliste', 'index'); ?>">EXPORTER</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript" src="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>js/typeahead.js"></script>
<script>
    
    // ----------------- Autocomplete d'ingrédient---------------------
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
    
    //--------------------- Suppression d'éléments du panier -----------
    $('.btn-delete').click(function(){
        var ids = JSON.stringify($(this).attr('data-ids').split('-'));
        $.ajax({
            url: '<?php echo \Application::getRoute('listecourse', 'deleteElements'); ?>',
            type: 'post',
            data: { pattern: ids},
            success: function (result) {
                if(result === 'ok'){
                    $.notify("Supression effectuée avec succès", 'success');
                }else{
                    $.notify("Une erreur est survenue, contactez votre administrateur", 'error');
                    console.log('Erreur de suppressions' + ids);
                }
            }
        });  
    });

</script>
