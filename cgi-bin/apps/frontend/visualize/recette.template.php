<?php 
    $recepeInfo     = \Page::get('recepeInfo'); 
    $ingredients    = \Page::get('ingredients'); 
?>
<div class="container">
    
 <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron black-overlay" style="background-image: url('./images/upload/<?php echo isset($recepeInfo['image']) ? $recepeInfo['image'] : 'untitled_' . $recepeInfo['catId'] . '.jpg' ?>');">
        
    </div>
    
    <!-------------------- CORPS  -------------------------------->
    <h1 class="text-center"><?php echo $recepeInfo['nom']; ?></h1>
    
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
