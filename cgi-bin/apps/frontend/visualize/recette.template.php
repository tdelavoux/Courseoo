<?php 
    $recepeInfo     = \Page::get('recepeInfo'); 
    $ingredients    = \Page::get('ingredients'); 
?>
<div class="container">
    
 <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron">
        <h1 class=""><?php echo \Db::decode($recepeInfo['nom']); ?></h1>
    </div>
    
    <!-------------------- CORPS  -------------------------------->
    
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="list-group list-cust">
                <span class="list-group-item active">Ingrédients de la recette</span>
                <?php foreach($ingredients as $ingredient) : ?>
                    <span  class="list-group-item"><?php echo $ingredient['quantite'] . $ingredient['uniteMesure'] . ' ' .  \Db::decode($ingredient['ingredient']); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
 
</div>
