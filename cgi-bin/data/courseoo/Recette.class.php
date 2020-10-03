<?php

	namespace data\courseoo;

	class Recette extends \data\Data
	{
            
            const OFFSET_AFFICHE = 16;
            
            /** ###############################################################################
             *                          FONCTIONS D'ACTIONS
            * ###############################################################################*/

            /**--------------------------------------------------------------------------------
             * Ajout d'une nouvelle recette
             * @param STR $nom          Nom de la recette
             * @param INT $fkCategorie  Id de la catégorie à laquelle appartient le plat
             * @param STR $image        Chemin vers l'image du plat
             * @param INT $fkUser       Id de l'utilisateur qui possède la recette
             */
            public function addRecette($nom, $fkCategorie, $image, $fkUser, $nbPersonnes)
            {
                $statement = $this->db->prepare(
                        "INSERT INTO recette (Nom, fkCategorie, image, dateFin, fkUser, nbPersonne)
                        VALUES (:nom, :fkCategorie, :image, null, :fkUser, :nbPersonne)");
                $statement->bindParam(':nom', $nom, \PDO::PARAM_STR);
                $statement->bindParam(':fkCategorie', $fkCategorie, \PDO::PARAM_INT);
                $statement->bindParam(':fkUser', $fkUser, \PDO::PARAM_INT);
                $statement->bindParam(':nbPersonne', $nbPersonnes, \PDO::PARAM_INT);
                $statement->bindParam(':image', $image, \PDO::PARAM_STR);
                $statement->execute();
                return $this->db->query('SELECT @@IDENTITY')->fetchColumn();
            }
            
            public function updatePictRecette($image, $fkRecette){
                $statement = $this->db->prepare(
                        "UPDATE recette "
                        . "SET image = :image "
                        . "WHERE id = :fkrecette");
                $statement->bindParam(':image', $image, \PDO::PARAM_STR);
                $statement->bindParam(':fkrecette', $fkRecette, \PDO::PARAM_INT);
                $statement->execute();
            }
            
            public function closeRecette($fkRecette, $date){
                $statement = $this->db->prepare(
                        "UPDATE recette "
                        . "SET dateFin = :date "
                        . "WHERE id = :fkrecette");
                $statement->bindParam(':date', $date, \PDO::PARAM_STR);
                $statement->bindParam(':fkrecette', $fkRecette, \PDO::PARAM_INT);

                $statement->execute();
            }
            
            /** ###############################################################################
             *                          FONCTIONS DE RECUPERATION
            * ###############################################################################*/
            
            /**--------------------------------------------------------------------------------
             * Récupération des 4 dernières recettes actives
             */
            public function getLastRecepe(){
                $statement = $this->db->prepare(
                        "SELECT recette.id, recette.nom, recette.image, recette.fkUser, user.image as imageUser, user.login as userName, categoriesRecettes.id as catId , categoriesRecettes.libelle as nomCategorie
                        FROM recette, categoriesRecettes, user
                        WHERE dateFin IS NULL
                        AND recette.fkCategorie = categoriesRecettes.id
                        AND recette.fkUser = user.id
                        ORDER BY recette.id DESC
                        LIMIT 4 OFFSET 0");
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
            
            /**--------------------------------------------------------------------------------
             * Récupération des recettes actives d'un utilisateur
             * @param INT $fkUser   Id de l'utilisateur pour lequel on souhaite récupérer les recettes
             */
            public function getRecepeByUser($fkUser){
                $statement = $this->db->prepare(
                        "SELECT recette.id, recette.nbPersonne ,recette.nom, recette.image, categoriesRecettes.id as catId , categoriesRecettes.libelle as nomCategorie
                        FROM recette, categoriesRecettes
                        WHERE dateFin IS NULL
                        AND recette.fkCategorie = categoriesRecettes.id
                        AND recette.fkUser = :userId
                        ORDER BY id DESC");
                $statement->bindParam(':userId', $fkUser, \PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
            
            /**
             * Récupération des données dune recette
             * @param INT $fkRecette 
             */
            public function getRecepeById($fkRecette){
                $statement = $this->db->prepare(
                        "SELECT recette.id, recette.nbPersonne ,recette.nom, recette.image,recette.dateFin, recette.fkUser, categoriesRecettes.id as catId , categoriesRecettes.libelle as nomCategorie
                        FROM recette, categoriesRecettes
                        WHERE recette.fkCategorie = categoriesRecettes.id
                        AND recette.id = :fkRecette");
                $statement->bindParam(':fkRecette', $fkRecette, \PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetch(\PDO::FETCH_ASSOC);
            }
            
            public function getPopularCategories(){
                $statement = $this->db->prepare(
                        "SELECT count(*) as nbRecettes, recette.fkCategorie, categoriesrecettes.libelle
                        FROM recette, categoriesRecettes
                        WHERE recette.fkCategorie = categoriesRecettes.id
                        GROUP BY recette.fkCategorie
                        ORDER BY nbRecettes DESC
                        LIMIT 4 OFFSET 0");
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
            
            public function getAllByCategories($limit, $categorie){
                $statement = $this->db->prepare(
                        "SELECT recette.id, recette.nom, recette.image, recette.fkUser, user.image as imageUser, user.login as userName, categoriesRecettes.id as catId , categoriesRecettes.libelle as nomCategorie
                        FROM recette, categoriesRecettes, user
                        WHERE dateFin IS NULL
                        AND recette.fkCategorie = categoriesRecettes.id
                        AND recette.fkUser = user.id
                        AND recette.fkCategorie = :categorie
                        LIMIT " . self::OFFSET_AFFICHE . " OFFSET :limit");
                $statement->bindParam(':categorie', $categorie, \PDO::PARAM_INT);
                $statement->bindParam(':limit', $limit, \PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
            
            public function getNbByCategories($categorie){
                $statement = $this->db->prepare(
                        "SELECT count(*)
                        FROM recette
                        WHERE recette.fkCategorie = :categorie ");
                $statement->bindParam(':categorie', $categorie, \PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetch(\PDO::FETCH_COLUMN);
            }
            
            public function getAllCategories(){
                $statement = $this->db->prepare(
                        "SELECT count(*) as nbRecettes, recette.fkCategorie, categoriesrecettes.libelle
                        FROM recette, categoriesRecettes
                        WHERE recette.fkCategorie = categoriesRecettes.id
                        GROUP BY recette.fkCategorie
                        ORDER BY categoriesrecettes.libelle");
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }

	}

?>


