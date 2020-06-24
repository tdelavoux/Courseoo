<?php

	namespace data\courseoo;

	class CategoriesRecettes extends \data\Data
	{

            /**--------------------------------------------------------------------------------
             * Récupération de toutes les catégories de recettes possibles
             */
            public function getAllCategories()
            {
                $statement = $this->db->prepare(
                        "SELECT * FROM CategoriesRecettes");
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }

	}

?>


