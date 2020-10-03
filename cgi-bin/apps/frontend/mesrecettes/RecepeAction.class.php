<?php

    namespace apps\frontend\mesrecettes;

    class RecepeAction
    {
        
        /* ################################################################################################
         *                          FONCTIONS D'AFFICHAGE
         ################################################################################################ */
        
        /**
         * Fonciton d'affichage d'une recette
         * @param INT $fkRecette    Id de la recette
         */
        public static function showRecette($fkRecette){
            
            \Page::set('title', 'Editer une Recette');
            
            $recepeInfo =  \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                      ->data('courseoo\\Recette')->getRecepeById($fkRecette);
            \Page::set('recepeInfo', $recepeInfo);
            
            $mesures =  \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                      ->data('courseoo\\Mesure')->getAllMEsuress();
            \Page::set('mesures', $mesures);
            
            $ingredients =  \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                      ->data('courseoo\\IngredientRecette')->getIngredientsByRecette($fkRecette);
            \Page::set('ingredients', $ingredients);
            
            \Page::display('showRecepe.template.php');
        }
        
        
        /* ################################################################################################
         *                          FONCTIONS D'ACTIONS
         ################################################################################################ */
        
        /**
         * Fonction d'ajout d'une nouvelle recette et redirection à la page de mes recettes
         */
        public static function addRecepe()
        {
            self::getAddRecepeFormData();    
            if(\Form::isValid()){
                
                $idRecette = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                      ->data('courseoo\\Recette')->addRecette(\Form::param('recepeName'), \Form::param('recepeCategory'), null, \User::getId(), \Form::param('recepeNbPersonne'));
                
                $fileName =  $idRecette . '.jpg';
                $uploadfile = \config\Configuration::$vars['quaiRecette']['pathRecette'] . $fileName;
                
                if(!empty($_FILES) && move_uploaded_file($_FILES['recepeImage']['tmp_name'], $uploadfile)){
                    
                    \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                      ->data('courseoo\\Recette')->updatePictRecette($fileName, $idRecette);

                    \Form::addConfirmation('Photo chargée avec succès !');
                }
                
                \Form::addConfirmation('Nouvelle Recette ajoutée avec succès');
                \Form::displayResult(\Application::getRoute('mesrecettes', 'index'));
            }else{
                 \Form::displayErrors(\Application::getRoute('mesrecettes', 'index'));
            }
        }
        
        /**
         * Fonction d'ajout d'un ingrédient dans une recette
         */
        public static function newIngredient(){
            
            self::getAddIngredientFormData();
            
            if(\Form::isValid()){
                
                \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                      ->data('courseoo\\IngredientRecette')->addIngredientToRecette(
                                                                            \Form::param('ingredient'), 
                                                                            \Form::param('fkRecepe'),
                                                                            \Form::param('quantite'),
                                                                            \Form::param('mesure'));
            
                \Form::addConfirmation('Nouvel ingrédient ajoutée avec succès');
                \Form::displayResult(\Application::getRoute('mesrecettes', 'showRecette', array(\Form::param('fkRecepe'))));
            }else{
                 \Form::displayErrors(\Application::getRoute('mesrecettes', 'showRecette', array(\Form::param('fkRecepe'))));
            }
        }
        
        public static function deleteRecette($fkRecette){
            \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                      ->data('courseoo\\Recette')->closeRecette($fkRecette, date('Ymd'));
                \Form::addConfirmation('Recette supprimée avec succès');
                \Form::displayResult(\Application::getRoute('mesrecettes', 'index'));
        }
        
        
        
        /* ################################################################################################
         *                        FONCTIONS DE TRAITEMENT DES FORMULAIRES
         ################################################################################################ */
        
        /**
         * Récupération des données du formulaire d'ajout d'une recette
         */
        private static function getAddRecepeFormData(){
            
            \Form::addParams('recepeName', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('recepeCategory', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::addParams('recepeNbPersonne', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::addParams('recepeImage', $_POST, \Form::TYPE_STRING, 1, 255);
            
            if(trim(\Form::param('recepeName')) === \Form::EMPTY_STRING || trim(\Form::param('recepeCategory')) === "null"){
                \Form::addError('critical error', 'Les champs ne peuvent pas être vides');
            }
            
        }
        
        /**
         * Récupération des données du formulaire d'ajout d'un ingrédient
         */
        private static function getAddIngredientFormData(){
            \Form::addParams('ingredient', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('fkRecepe', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::addParams('quantite', $_POST, \Form::TYPE_NUMERIC, 0, \Form::SIGNED_INT_32_MAX);
            \Form::addParams('mesure', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            
            /* TODO faire les vérifications de présence des ingrédients */
            if(!\Form::param('ingredient') ||!\Form::param('fkRecepe') || !\Form::param('quantite') || \Form::param('mesure') === "null" ){
                \Form::addError('critical error', 'Les champs ne peuvent pas être vides');
            }
            
        }
    }

?>
