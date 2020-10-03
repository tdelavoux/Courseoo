<?php

	namespace data\courseoo;

	class IngredientRecette extends \data\Data
	{
            
            /** ###############################################################################
             *                          FONCTIONS D'ACTIONS
            * ###############################################################################*/

           
            public function addIngredientToRecette($ingredient, $fkRecepe, $quantite, $mesure)
            {
                $statement = $this->db->prepare(
                        "INSERT INTO IngredientRecette (fkMesure, quantite, fkRecette, ingredient)
                        VALUES (:fkMesure, :quantite, :fkRecette, :ingredient)");
                $statement->bindParam(':ingredient', $ingredient, \PDO::PARAM_STR);
                $statement->bindParam(':fkRecette', $fkRecepe, \PDO::PARAM_INT);
                $statement->bindParam(':fkMesure', $mesure, \PDO::PARAM_INT);
                $statement->bindParam(':quantite', $quantite, \PDO::PARAM_INT);
                $statement->execute();
            }
            
            /** ###############################################################################
             *                          FONCTIONS DE RECUPERATION
            * ###############################################################################*/
            
            public function getIngredientsByRecette($fkRecepe)
            {
                $statement = $this->db->prepare(
                        "SELECT IngredientRecette.id , IngredientRecette.ingredient, IngredientRecette.quantite,  Mesure.libelleCourt as uniteMesure, Mesure.libelleLong as mesure, Mesure.id as idMesure 
                        FROM  IngredientRecette, Mesure
                        WHERE IngredientRecette.fkRecette = :fkRecette
                        AND IngredientRecette.fkMesure = Mesure.id");
                $statement->bindParam(':fkRecette', $fkRecepe, \PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
	}

?>


