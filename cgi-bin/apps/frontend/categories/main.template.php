<?php $allCat    = \Page::get('allCat'); ?>
<?php $RecByCat  = \Page::get('RecByCat'); ?>
<?php $nbByCat   = \Page::get('nbByCat'); ?>

<div class="container">

    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron categories">
        <h1>Par catégories</h1>
    </div>
    
<!--    <div class="row card-rows justify-content-md-center">
        <div class="col-lg-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <select class="form-control">
                    <option>Voir les catégories</option>
                    <?php foreach($allCat as $cat) : ?>
                        <option value="<?php echo $cat['fkCategorie']; ?>"><?php echo \Db::decode($cat['libelle']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>-->

    <!-------------------- CORPS  -------------------------------->
    
    <?php if(!empty($allCat)): ?>   
        <div class="row card-rows">
            <?php foreach($allCat as $Cat) : ?>
            <div class="stats-card col-12 col-md-6 col-lg-3">
                <a href="<?php echo \Application::getRoute('categories', 'index', array($Cat['fkCategorie'],1));?>" 
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
    <?php endif; ?>
    
    <?php if(!empty($RecByCat)) : ?>
    
        <div class="row card-rows ">
            <a href="<?php echo \Application::getRoute('categories', 'index', array(null, null));?>" class="btn btn-link">Revenir aux catégories</a>
        </div>
    
        <div class="row">
            <?php foreach($RecByCat as $recep) : ?> 
                <div class="bloc-card col-md-3 Sortable recepe-card" data-title="<?php echo \Db::decode(strtoupper($recep['nom'])); ?>">
                    <div class="card sub-card-recepe">
                        <img class="card-img-top" src="<?php echo isset($recep['image']) ? $recep['image'] : 'images/upload/untitled_' . $recep['catId'] . '.jpg' ?>" alt="" />
                        <div class="card-body p-card-text">
                            <div class="card-body-content">
                                <h5 class="card-title"><?php echo \Db::decode($recep['nom']) . $recep['id']; ?></h5>
                                <p class="card-text">
                                    <a href="#">#<?php echo \Db::decode($recep['nomCategorie'])?></a>    
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="pagination">
        <?php for($i=1 ; $i<= $nbByCat/6 ; $i++): ?>
            <a href="<?php echo \Application::getRoute('categories', 'index', array(\Form::param('fkCategorie'), $i))?>" 
               class="page <?php echo (\Form::param('limit') === $i) ? 'active' : ''; ?>"><?php echo $i; ?>
                   </a>
        <?php endfor; ?>
		
	</div>
    <?php endif; ?>
</div>
