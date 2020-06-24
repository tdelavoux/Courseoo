<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo \config\Configuration::$vars['application']['name']; if (\Page::get('title')): ?> - <?php echo strip_tags(\Page::get('title')); endif ?></title>
        <meta name="viewport"  content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>/favicon.png">
        <link rel="stylesheet" type="text/css" href="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>fontawesome-5.13.0/css/all.css">
        <link rel="stylesheet" type="text/css" href="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>bootstrap-4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>css/datatables.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>bootstrap-4.4.1/css/bootstrap-select.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo \config\Configuration::$vars['application']['dir']; ?>css/main.css">
        <?php if(LOGIN_INTERFACE) : ?>
            <link rel="stylesheet" type="text/css" href="<?php echo \config\Configuration::$vars['application']['dir']; ?>css/login.css">
        <?php endif; ?>

        <?php
                if (\Page::get('style')):
        ?>
        <style type="text/css"><?php echo \Page::get('style'); ?></style>
        <?php
                endif;
        ?>
        </head>
    <body>


        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link logo-apps" href="<?php echo \Application::getRoute('index', 'index')?>">
                            <img src="images/logo.png" height="60px;">
                        </a>
                    </li>

                    <?php if(\User::getLogin()) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo \Application::getRoute('index', 'index')?>">
                            <i class="fas fa-home"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo \Application::getRoute('listecourse', 'index')?>">
                            <i class="fas fa-shopping-cart"></i>Ma Liste de course
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo \Application::getRoute('mesrecettes', 'index')?>">
                            <i class="fas fa-receipt"></i>Mes recettes
                        </a>
                    </li>
                     <?php endif; ?>
                </ul>


                <?php if(LOGIN_INTERFACE) : ?>
                    <?php if(\User::getLogin()) : ?>
                        <div class="form-inline my-2 my-lg-0">
                             <a class="accountNav" type="submit" href="<?php echo \Application::getRoute('account', 'index'); ?>"><?php echo \User::getLogin() ? \User::getLogin() : ''; ?> </a>
                        </div>
                    <?php endif; ?>
                    <div class="form-inline my-2 my-lg-0">
                         <a class="btn btn-outline-success my-2 my-sm-0" type="submit" href="<?php echo \Application::getRoute('login', 'delog'); ?>"><?php echo \User::getLogin() ? 'Logout' : 'Login'; ?> </a>
                    </div> 
                <?php endif; ?>
            </div>
        </nav>


        <script src="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>jquery/jquery-3.5.1.min.js"></script>
        <script src="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>js/notify.min.js"></script>
        <script src="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>js/popper.min.js"></script>
        <script src="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>bootstrap-4.4.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>js/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>js/formHandler.js"></script>
        <script type="text/javascript" src="<?php echo \config\Configuration::$vars['application']['dirLib']; ?>bootstrap-4.4.1/js/bootstrap-select.min.js"></script>


        <div id="contentPage">
                <?php require $template; ?>
        </div>
        <script>
                <?php echo \Page::get('bottomScript'); ?>
        </script>
    </body>
</html>

<!---------------------- Notification  ------------------------------------------>
<?php $confirms = \Form::getConfirms(); ?>
<?php if($confirms) : ?>
    <script>
        $.notify("<?php echo $confirms[0]; ?>", "success");
    </script>
<?php endif; ?>
    
<?php $errors = \Form::getErrors(); ?>
<?php if($errors) : ?>
    <script>
        <?php foreach($errors as $error) :?> 
            $.notify("<?php echo $error; ?>", 'error');
        <?php endforeach; ?>
    </script>
<?php endif; ?>
