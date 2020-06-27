<div class="inscription-content container-fluid">
    <div id="login-Page-left">
        <div id="login-Page-101">
            <div id="centered-bloc">
                <h3 class="text-center">S'inscrire</h3>

                <form  action="<?php echo application ::getRoute('login', 'signup') ?> " method="post">

                    <div class="form-group">
                        <label for="login">Login</label>
                        <input id="login" placeholder="Dupont" name="login" type="text" class="form-control verifyText" value="<?php echo \Form::param('login') ? \Form::param('login')  : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="passwd">Password</label>
                        <input id="passwd" placeholder="******" name="passwd" type="password" class="form-control verifyText">
                    </div>

                    <div class="form-group">
                        <label for="passwd2">Ressaisir le password</label>
                        <input id="passwd2" placeholder="******" name="passwd2" type="password" class="form-control verifyText">
                    </div>

                    <div class="form-btn text-center">
                        <button type="submit" class="btn btn-primary submit-form-btn">Sign in <i class="fas fa-arrow-right"></i></button>
                    </div>

                    <?php $errors = \Form::getErrors(); ?>
                    <div class="row">

                        <?php if(!empty($errors)) : ?>
                            <?php foreach($errors as $error) : ?>
                            <p class="text-danger text-center w-100 mg-1"><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </p>
                    </div>

                    <div class="row">
                        <p class="text-center w-100 mg-1">Déjà un compte ? <a href="<?php echo \Application::getRoute('login', 'delog'); ?>">Connectez-vous</a></p>
                        <p class="text-center w-100 mg-1"><a href="mailto:thibault.delavoux@gmail.com">Mot de passe oublié</a></p>
                    </div>
                </form>	
            </div>
        </div>
    </div>

    <div id="inscription-Page-right"></div>

</div>