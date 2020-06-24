<?php

	namespace data\courseoo;

	class Mesure extends \data\Data
	{

            /**--------------------------------------------------------------------------------
             * Récupération de toutes les catégories de recettes possibles
             */
            public function getAllMEsuress()
            {
                $statement = $this->db->prepare(
                        "SELECT * FROM Mesure");
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }

	}

?>


