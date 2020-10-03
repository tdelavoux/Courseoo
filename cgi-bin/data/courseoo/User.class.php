<?php

	namespace data\courseoo;

	class User extends \data\Data
	{
            
            /** ###############################################################################
             *                          FONCTIONS D'ACTION
            * ###############################################################################*/
            
            /**
             * Ajout d'un nouvel utilisateur
             * @param STR $login        Nom du compte
             * @param STR $password     Mot de passe encrypté
             * @param STR $date         Date d'inscription
             * @param STR $profil       Type du profil (unused pour le moment)
             */
            public function AddUser($login, $password, $date, $profil="user")
            {
                $statement = $this->db->prepare(
                        "INSERT INTO User (login, password, profile, dInsc, dFin, image)
                        VALUES (:login, :password, :profil, :date, null, null)");
                $statement->bindParam(':login', $login, \PDO::PARAM_STR);
                $statement->bindParam(':password', $password, \PDO::PARAM_STR);
                $statement->bindParam(':profil', $profil, \PDO::PARAM_STR);
                $statement->bindParam(':date', $date, \PDO::PARAM_STR);
                $statement->execute();
            }
            
            public function deleteUser($fkUser, $date){
                $statement = $this->db->prepare(
                        "UPDATE User 
                        SET dFin = :date
                        WHERE id = :fkUser");
                $statement->bindParam(':fkUser', $fkUser, \PDO::PARAM_INT);
                $statement->bindParam(':date', $date, \PDO::PARAM_STR);
                $statement->execute();
            }
            
            public function updatePasswd($pwd, $fkUser){
                $statement = $this->db->prepare(
                        "UPDATE User 
                        SET password = :password
                        WHERE id = :fkUser");
                $statement->bindParam(':fkUser', $fkUser, \PDO::PARAM_INT);
                $statement->bindParam(':password', $pwd, \PDO::PARAM_STR);
                $statement->execute();
            }
            
            public function uploadImage($fkUser, $path){
                $statement = $this->db->prepare(
                        "UPDATE User 
                        SET image = :img
                        WHERE id = :fkUser");
                $statement->bindParam(':fkUser', $fkUser, \PDO::PARAM_INT);
                $statement->bindParam(':img', $path, \PDO::PARAM_STR);
                $statement->execute();
            }
            
            /** ###############################################################################
             *                          FONCTIONS DE RECUPERATION
             *###############################################################################*/
            
            /**
             * Renvoie les informations d'un utilisateurs si le login et le mot de passe sont existants
             * @param STR $login        Nom du compte
             * @param STR $password     Mot de passe encrypté
             */
            public function isValidLogin($login, $password){
                $statement = $this->db->prepare(
                        "SELECT * FROM User 
                        WHERE login =  :login
                        AND password = :password
                        AND dFin IS NULL");
                $statement->bindParam(':login', $login, \PDO::PARAM_STR);
                $statement->bindParam(':password', $password, \PDO::PARAM_STR);
                $statement->execute();
                return $statement->fetch(\PDO::FETCH_ASSOC);
            }
            
            public function verifyLoginAlreadyExist($login){
                $statement = $this->db->prepare(
                        "SELECT count(id) 
                         FROM User 
                        WHERE login =  :login
                        AND dFin IS NULL");
                $statement->bindParam(':login', $login, \PDO::PARAM_STR);
                $statement->execute();
                return $statement->fetch(\PDO::FETCH_COLUMN);
            }
            
            public function getUserInfos($fkUser){
                $statement = $this->db->prepare(
                        "SELECT User.id, User.login, User.dInsc, User.dFin , user.image, count(Recette.id) as nbRecettes 
                         FROM User, Recette
                        WHERE User.id =  :fkUser
                        AND Recette.fkUser = User.id
                        AND Recette.dateFin IS NULL");
                $statement->bindParam(':fkUser', $fkUser, \PDO::PARAM_INT);
                $statement->execute();
                return $statement->fetch(\PDO::FETCH_ASSOC);
            }

	}

?>


