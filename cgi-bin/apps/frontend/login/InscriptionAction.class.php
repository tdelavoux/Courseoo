<?php

    namespace apps\frontend\login;

    class InscriptionAction
    {

        public static function execute()
        {               
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'inscription');
            \Page::display('inscription.template.php');
        }

        public static function signup()
        {               
            self::getFormInscriptionData();
            
            if(\Form::isValid()){
                \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                        ->data('courseoo\\User')->AddUser(\Form::param('login'), md5(\Form::param('passwd')), date('Ymd'));
                \Form::addConfirmation('Le compte a été créé avec succès !');      
                \Form::displayResult(\Application::getRoute('login', 'delog'));
            } else{
                \Form::addError('ErreurCreationCompte', 'Impossible de créer le compte. Rapprochez vous d\'un administrateur');
                \Form::displayErrors(\Application::getRoute('login', 'inscriptionForm'));
            }
        }

        /**
         * Récupération des informations du formulaire de login
         */
        private static function getFormInscriptionData(){
            \Form::addParams('login', $_POST, \Form::TYPE_STRING, 0, 50);
            \Form::addParams('passwd', $_POST, \Form::TYPE_STRING, 0, 100);
            \Form::addParams('passwd2', $_POST, \Form::TYPE_STRING, 0, 100);
            
            $alreadyExist =  \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                        ->data('courseoo\\User')->verifyLoginAlreadyExist(\Form::param('login'));
            
            if(trim(\Form::param('login')) === \Form::EMPTY_STRING || trim(\Form::param('passwd')) === \Form::EMPTY_STRING || trim(\Form::param('passwd2')) === \Form::EMPTY_STRING ){
                \Form::addError('inscript', 'Les champs ne peuvent pas être vide');
            }else if(trim(\Form::param('passwd')) !== trim(\Form::param('passwd2')) ){
                \Form::addError('inscript', 'Les passwords ne correspondent pas');
            }else if(intval($alreadyExist) > 0){
                \Form::addError('inscript', 'Le Login existe déjà');
            }
            
        }

    }

?>
