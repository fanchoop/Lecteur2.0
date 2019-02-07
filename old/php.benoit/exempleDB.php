<?php

	require_once(PATH_MODELS.'DAO.php');
	class exemple extends DAO{
		
		// Retourne un tableau 2d( avec plusieurs rows, d'ou l'utilisation de queryAll )
		public function getListeCat(){
			return DAO::queryAll('select nomCategorie from Categorie');
		}
		// Retourne un tableau 1d ( avec une seule ligne, d'ou l'utilisation de queryRow ) 
		public function getNbCat(){
			return DAO::queryRow('select count(*) from Categorie');
		}
		// Ne retourne pas de tableau, a utiliser pour les requètes de type Update, Delete
		public function ajouterPhoto($nomFichier,$description,$catId){
	
			return DAO::queryBdd('INSERT INTO Photo (photoId, nomFichier, description, catId) VALUES (NULL,?,?,?)',[$nomFichier,$description,$catId]);
		}
	}

// IMPORTANT : lors de l'instance de la classe :
// $cat = new exemple(DEBUG);
// const DEBUG = true; // production : false; dev : true
// 
?>

