

<div id="login-Page-left">
    <div id="login-Page-101">
        <div id="centered-bloc" class="col-md-8">
            <h3 class="text-center">Se connecter</h3>

            <form  action="<?php echo application ::getRoute('login', 'login') ?> " method="post">

                <div class="form-group">
                    <label for="login">Login</label>
                    <input id="login" placeholder="Dupont" name="login" type="text" class="form-control verifyText" data-name="login" value="<?php echo \Form::param('login') ? \Form::param('login') : '' ?>">
                </div>
                
                <div class="form-group">
                    <label for="passwd">Password</label>
                    <input id="passwd" placeholder="******" name="passwd" type="password" class="form-control verifyText" data-name="password">
                </div>

                <div class="form-btn text-center">
                    <button type="submit" class="btn btn-primary submit-form-btn">Login <i class="fas fa-arrow-right"></i></button>
                </div>

                
                <div class="row">
                    <p class="text-center w-100 mg-1">Pas encore de compte ? Créez en un <a href="<?php echo \Application::getRoute('login', 'inscriptionForm'); ?>">ici</a></p>
                    <p class="text-center w-100 mg-1"><a href="mailto:thibault.delavoux@gmail.com">Mot de passe oublié</a></p>
                </div>
            </form>	
        </div>
    </div>
</div>

<div id="login-Page-right"></div>