<?php

	namespace data\courseoo;

	class ListeIngredients extends \data\Data
	{
            
            /** ###############################################################################
             *                          FONCTIONS D'ACTIONS
             ###############################################################################*/

           
            public function addNewIngredientToList($fkUser, $ingredient, $quantite, $mesure)
            {
                $statement = $this->db->prepare(
                        "INSERT INTO ListeIngredients (fkUser, fkMesure, quantite, ingredient)
                        VALUES (:fkUser, :fkMesure, :quantite, :ingredient)");
                $statement->bindParam(':ingredient', $ingredient, \PDO::PARAM_STR);
                $statement->bindParam(':fkUser', $fkUser, \PDO::PARAM_INT);
                $statement->bindParam(':fkMesure', $mesure, \PDO::PARAM_INT);
                $statement->bindParam(':quantite', $quantite, \PDO::PARAM_INT);
                $statement->execute();
            }
            
            public function removeIngredientsFromList($ids){
                
                $values = '(';
                $com    = '';
                foreach($ids as $id){
                    $values .= $com . ':id'.$id;
                     $com    = ',';
                }
                $values .= ')';

                $statement = $this->db->prepare(
                        "DELETE FROM ListeIngredients
                        WHERE id IN " . $values);
                foreach($ids as $id){
                    $statement->bindValue(':id'.$id , $id, \PDO::PARAM_INT);
                }
                $statement->execute();
            }
            
            public function removeAllIngredients($fkUser){
                
                $statement = $this->db->prepare(
                        "DELETE FROM ListeIngredients
                        WHERE fkUser = :fkUser");
                $statement->bindParam(':fkUser', $fkUser, \PDO::PARAM_INT);
                $statement->execute();
            }
            
            /** ###############################################################################
             *                          FONCTIONS DE RECUPERATION
             ###############################################################################*/
            
            public function getIngredientsListeByUser($fkUser)
            {
                $statement = $this->db->prepare(
                        "SELECT ListeIngredients.id, ListeIngredients.ingredient, ListeIngredients.quantite as quantite, Mesure.libelleCourt as uniteMesure, Mesure.libelleLong as mesure, ingredients.categorie
                        FROM  (ListeIngredients
                             LEFT OUTER JOIN ingredients ON ListeIngredients.ingredient = ingredients.ingredient)
                             INNER JOIN Mesure ON ListeIngredients.fkMesure = Mesure.id
                        WHERE ListeIngredients.fkUser = :fkUser
                        ORDER BY ingredients.categorie, ListeIngredients.ingredient, ListeIngredients.fkMesure");
                $statement->bindParam(':fkUser', $fkUser, \PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
	}

?>


