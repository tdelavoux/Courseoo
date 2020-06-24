<?php

    namespace apps\frontend\login;

    class MainAction
    {

        public static function execute()
        {                     
            \User::logout();
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Identification');
            \Page::display();
        }

        public static function login()
        {               
            self::getFormLoginData();
            
            if(\Form::isValid()){
                \Form::displayResult(\Application::getRoute('index','index'));
            } else{
                \Form::addParams('login', \Form::param('login'));
                \Form::displayErrors(\Application::getRoute('login','delog'));
            }
        }
        
        public static function updatePasswd(){
           
            self::getFormUpdatePasswdData();
            
            if(\Form::isValid()){
                \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                        ->data('courseoo\\User')->updatePasswd(md5(\Form::param('pw1')), \Form::param('fkUser'));
                \Form::addConfirmation('Modification réalisée avec succès');
                \Form::displayResult(\Application::getRoute('account','index'));
            }else{
                \Form::displayErrors(\Application::getRoute('account','index'));
            }
        }
        
        public static function closeAccount($fkUser=null){
            \Form::addParams('fkUser', $fkUser, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            if(\Form::param('fkUser')){
                \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                        ->data('courseoo\\User')->deleteUser($fkUser, date('Ymd'));
                \Form::addConfirmation('Votre compte a été clôturé');
                \Form::displayResult(\Application::getRoute('login','delog'));
            }else{
                \Form::addError('accountDelete', 'Le compte ne peut pas être supprimé. Rapprochez vous d\'un administrateur');
                \Form::displayErrors(\Application::getRoute('account','index'));
            }
        }

        /**
         * Récupération des informations du formulaire de login
         */
        private static function getFormLoginData(){
            \Form::addParams('login', $_POST, \Form::TYPE_STRING, 0, 50);
            \Form::addParams('passwd', $_POST, \Form::TYPE_STRING, 0, 100);
            
            if(trim(\Form::param('login')) === \Form::EMPTY_STRING || trim(\Form::param('passwd')) === \Form::EMPTY_STRING ){
                \Form::addError('login', 'Le couple Login / Password est incorrect');
            }
            
            if(\Form::param('login') && \Form::param('passwd')){

                $valid = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                        ->data('courseoo\\User')->isValidLogin(\Form::param('login'), md5(\Form::param('passwd')));  
                $valid !== false ? \User::retrieveUser($valid) : \Form::addError('login', 'Le couple Login / Password est incorrect');
            }
        }
        
        private static function getFormUpdatePasswdData(){
             \Form::addParams('fkUser', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::addParams('pw1', $_POST, \Form::TYPE_STRING, 0, 255);
            \Form::addParams('pw2', $_POST, \Form::TYPE_STRING, 0, 255);
            
            if(!\Form::param('fkUser') ||\Form::param('pw1') === \Form::EMPTY_STRING || \Form::param('pw2') === \Form::EMPTY_STRING ){
                \Form::addError('updateMDP', 'Les champs ne peuvent pas être vide');
            }else if(trim(\Form::param('pw1')) !== trim(\Form::param('pw2')) ){
                \Form::addError('updateMDP', 'Les passwords ne correspondent pas');
            }
        }
        
        

    }

?>
