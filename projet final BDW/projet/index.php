<?php
//Roudy KARAM p2018275
//Jane AZIZ p2102430


// index.php fait office de controleur frontal
session_start(); // démarre ou reprend une session
ini_set('display_errors', 1); // affiche les erreurs (au cas où)
ini_set('display_startup_errors', 1); // affiche les erreurs (au cas où)
error_reporting(E_ALL); // affiche les erreurs (au cas où)
require('inc/config-bd.php'); // fichier de configuration d'accès à la BD
require('modele/modele.php'); // inclut le fichier modele
require('inc/includes.php'); // inclut des constantes et fonctions du site (nom, slogan)
require('inc/routes.php'); // fichiers de routes

$connexion = getConnexionBD(); // connexion à la BD
$connexiondata=getConnexiondata();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>R & J MUSIC</title>
    <!-- lie le style CSS externe  -->
    <link href="css/style.css" rel="stylesheet" media="all" type="text/css">
    <!-- ajoute une image favicon (dans l'onglet du navigateur) -->
    <link rel="shortcut icon" type="image/x-icon" href="https://i0.wp.com/img.icons8.com/glyph-neue/512/apple-music.png" />
	
</head>
<body>
    <?php include('static/header.php'); ?>
    <div id="divCentral">
		<?php include('static/menu.php'); ?>
		
		<main>
		<?php
		$controleur = 'controleurAccueil'; // par défaut, on charge accueil.php
		$vue = 'vueAccueil'; // par défaut, on charge accueil.php
		if(isset($_GET['page'])) {
			$nomPage = $_GET['page'];
			if(isset($routes[$nomPage])) { // si la page existe dans le tableau des routes, on la charge
				$controleur = $routes[$nomPage]['controleur'];
				$vue = $routes[$nomPage]['vue'];
			}
		}
		include('controleurs/' . $controleur . '.php');
		include('vues/' . $vue . '.php');
		?>
		</main>
	</div>
    <?php include('static/footer.php'); ?>
</body>
<footer>
	<link rel="ucbl icon" type="image/x-icon" href= "https://upload.wikimedia.org/wikipedia/en/thumb/d/d3/Claude_Bernard_University_Lyon_1_%28logo%29.svg/1280px-Claude_Bernard_University_Lyon_1_%28logo%29.svg.png" />
</footer>
</html>
