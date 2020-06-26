<?php $lastRecep    = \Page::get('lastRecepe'); ?>
<?php $bestCat      = \Page::get('bestCat'); ?>

<div class="container">
    
    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron categories">
        <h1>Catégories populaires</h1>
    </div>
    
    <!-------------------- CORPS  -------------------------------->
    <div class="row card-rows">
        <?php foreach($bestCat as $Cat) : ?>
        
            <div class="stats-card col-12 col-md-6 col-lg-3">
                <a href="<?php echo \Application::getRoute('categories', 'index', array($Cat['fkCategorie'], 1));?>" 
                   class="stats-card-body" 
                   style="background-image:url('images/upload/untitled_<?php echo $Cat['fkCategorie'] ?>_stats.jpg');background-position: center;background-repeat: no-repeat;background-size: cover;">
                <div >
                    <p><?php echo \Db::decode($Cat['libelle']) ; ?></p>
                    <p><?php echo \Db::decode($Cat['nbRecettes']) . ' Recettes' ; ?></p>
                </div>
                </a>
            </div>  
       
        <?php endforeach; ?>
    </div>
    
    
    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron last_recepe">
        <h1>Les dernières recettes</h1>
    </div>
    
    <!-------------------- CORPS  -------------------------------->
    <div class="row card-rows">
        <?php foreach($lastRecep as $recep) : ?>
            <div class="bloc-card col-6 col-md-6 col-lg-3">
                <div class="card sub-card-recepe">
                    <img class="card-img-top" src="<?php echo isset($recep['image']) ? $recep['image'] : './images/upload/untitled_' . $recep['catId'] . '.jpg' ?>" alt="imagePlat" />
                    <div class="card-body p-card-text">
                        <div class="card-body-content">
                            <h5 class="card-title"><?php echo strlen($recep['nom']) > 40 ? substr($recep['nom'], 0, 37) .'...'  : $recep['nom']; ?> 
                                <a  href="<?php echo \Application::getRoute('visualize','recepe', array($recep['id']));?>"><i class="fas fa-eye"></i></a>
                            </h5>
                            <p class="card-text">
                                <a href="<?php echo \Application::getRoute('categories', 'index', array($recep['catId'], 1));?>">#<?php echo \Db::decode($recep['nomCategorie'])?></a>
                            </p>

                            <a href="<?php echo \Application::getRoute('visualize','user', array($recep['fkUser']));?>">
                                <div class="profile-row">
                                    <div class="rounded-circle profile-img-xs" style="background-image:url('./images/user/<?php echo $recep['imageUser'] ? $recep['imageUser'] : 'anonyme.jpg';?>');background-position: center;background-repeat: no-repeat;background-size: cover;"></div>;
                                    <div class="user-title"><?php echo $recep['userName'];?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
   
</div>
