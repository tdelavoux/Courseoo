<?php

	namespace data\courseoo;

	class Ingredients extends \data\Data
	{

            /**--------------------------------------------------------------------------------
             * Récupération de toutes les catégories de recettes possibles
             */
            public function getTypeaheadIngredients($pattern)
            {

                $statement = $this->db->prepare(
                        "SELECT DISTINCT ingredient 
                        FROM Ingredients
                        WHERE ingredient LIKE '%". trim($pattern) . "%'
                        LIMIT 10 OFFSET 0");
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_COLUMN);
            }

	}

?>


