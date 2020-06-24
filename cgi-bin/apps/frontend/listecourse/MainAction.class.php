<?php

    namespace apps\frontend\listecourse;

    class MainAction
    {
        
        /* ################################################################################################
         *                          FONCTIONS D'AFFICHAGE
         ################################################################################################ */
        public static function execute()
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Index');

            $mesures =  \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                      ->data('courseoo\\Mesure')->getAllMEsuress();
            \Page::set('mesures', $mesures);
            
            $listUser = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\ListeIngredients')->getIngredientsListeByUser(\User::getId());
            $listUser = self::formatList($listUser);
            \Page::set('listUser', $listUser);
            
            $userRecepe = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                ->data('courseoo\\Recette')->getRecepeByUser(\User::getId());
            \Page::set('userRecepe', $userRecepe);

            \Page::display();
        }
        
        /* ################################################################################################
         *                          FONCTIONS D'ACTIONS
         ################################################################################################ */
        
        //Ajout manuel d'un ingrédient à la liste
        public static function addIngredientToList()
        {
            self::getIngredientFormDatas();
            
            if(\Form::isValid()){
                \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\ListeIngredients')->addNewIngredientToList(\User::getId(), \Form::param('ingredient'), \Form::param('quantite'), \Form::param('mesure'));
                \Form::addConfirmation('Ajout réalisé avec succès');
                \Form::displayResult(\Application::getRoute('listecourse', 'index'));
            }else{
                \Form::displayErrors(\Application::getRoute('listecourse', 'index'));
            } 
        }
        
        /**
         * Ajout au panier des ingéridents d'une recette
         */
        public static function addIngredientToListByRecepe()
        {
            self::getRecepeFormDatas();
            
            if(\Form::isValid()){
                
                //récupération des éléments d'une recette
                $IngredientsRecepe = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\IngredientRecette')->getIngredientsByRecette(\Form::param('recette'));
                
                foreach($IngredientsRecepe as $ingredient){
                    \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                        ->data('courseoo\\ListeIngredients')->addNewIngredientToList(\User::getId(), $ingredient['ingredient'], $ingredient['quantite'], $ingredient['idMesure']);
                }   
                
                \Form::addConfirmation('Ajout réalisé avec succès');
                \Form::displayResult(\Application::getRoute('listecourse', 'index'));
            }else{
                \Form::displayErrors(\Application::getRoute('listecourse', 'index'));
            } 
        }
        
        /**
         * Suppression d'un type d'ingrédients par leur ID
         */
        public static function deleteElements(){
            \Form::addParams('pattern', $_POST, \Form::TYPE_STRING, 0, 255);
            $ids = json_decode(\Form::param('pattern'));
            
            \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\ListeIngredients')->removeIngredientsFromList($ids);
            
            echo 'ok';
        }
        
        /**
         * Suppression de ous les éléments d'un user
         */
        public static function deleteAll(){
            
            \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\ListeIngredients')->removeAllIngredients(\User::getId());
            \Form::addConfirmation('Panier réinitalisé');
            \Form::displayResult(\Application::getRoute('listecourse', 'index'));
            
        }
        
        
        /* ################################################################################################
         *                        FONCTIONS DE TRAITEMENT DES FORMULAIRES
         ################################################################################################ */
        
        private static function getIngredientFormDatas(){
            \Form::addParams('ingredient', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('quantite', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::addParams('mesure', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            
            /* TODO faire les vérifications de présence des ingrédients */
            if(!\Form::param('ingredient') || !\Form::param('quantite') || !\Form::param('mesure')){
                \Form::addError('critical error', 'Les champs ne peuvent pas être vides');
            }
        }
        
        private static function getRecepeFormDatas(){
            \Form::addParams('recette', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            
            /* TODO faire les vérifications de présence des ingrédients */
            if(\Form::param('recette') === "null" || !\Form::param('recette')){
                \Form::addError('critical error', 'Les champs ne peuvent pas être vides');
            }
        }

        
        public static function formatList($array){
            
            $res = array();
            foreach($array as $line){
                if(isset($res[$line['ingredient'] . $line['uniteMesure']])){
                    $res[$line['ingredient']. $line['uniteMesure']]['ids'][] = $line['id'];
                    $res[$line['ingredient']. $line['uniteMesure']]['qts'][] = $line['quantite'];       
                }else{
                    $res[$line['ingredient']. $line['uniteMesure']] = array('ingredient' => $line['ingredient'], 'uniteMesure' => $line['uniteMesure'],'mesure' => $line['mesure'],  'categorie' => $line['categorie'], 'ids' => array($line['id']), 'qts' => array($line['quantite']));
                }
            }
            return $res;
        }
    }

?>
