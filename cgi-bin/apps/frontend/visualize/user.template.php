<?php $userInfos = \Page::get('userInfos'); ?>
<?php $userRecepe = \Page::get('userRecepe'); ?>


<div class="container">

    <!-------------------- ENTETE -------------------------------->
    <div class="row jumbotron account-jumbo">
        <div class="account-header">
            <h1 class="account-title"><?php echo \Db::decode($userInfos['login']) ?></h1>
            <div class="account-img">
                <div class="rounded-circle profile-img" style="background-image:url('./images/user/<?php echo $userInfos['image'] ;?>');background-position: center;background-repeat: no-repeat;background-size: cover;"></div>
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
    
    
    
    <h2>Les recettes de <?php echo \Db::decode($userInfos['login']) ?></h2>
    <div class="row m-b-2">
        <div class="col-md-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="js-shuffle-search form-control" type="text"/>
            </div>
        </div>
    </div>
    
    <div class="row">
   
        <?php foreach($userRecepe as $recep) : ?> 
            <div class="bloc-card col-md-3 Sortable recepe-card col-12 col-sm-6 col-md-6 col-lg-3" data-title="<?php echo \Db::decode(strtoupper($recep['nom'])); ?>">
                <div class="card sub-card-recepe">
                    <a  href="<?php echo \Application::getRoute('visualize','recepe', array($recep['id']));?>">
                        <img class="card-img-top" src="<?php echo isset($recep['image']) ? 'images/upload/'.$recep['image'] : 'images/upload/untitled_' . $recep['catId'] . '.jpg' ?>" alt="" />
                    </a>
                    <div class="card-body p-card-text">
                        <div class="card-body-content">
                            <h5 class="card-title"><?php echo \Db::decode($recep['nom']); ?> </h5>
                            <p class="card-text">
                                <a href="<?php echo \Application::getRoute('categories', 'index', array($recep['catId'], 1));?>">#<?php echo \Db::decode($recep['nomCategorie'])?></a>      
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
    </div>
 
</div>

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

</script>
