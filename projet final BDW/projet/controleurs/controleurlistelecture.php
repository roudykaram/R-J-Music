<?php 
$connexion = getConnexionBD(); // connexion à la BD

if(isset($_POST['Creer'])) {
	
	$dureeL = $_POST['dureeL']; 
	$dureeL = $dureeL * 60;
	$genreG = $_POST['genreL']; 
	$pref = $_POST['pref']; 
	$pourcentage=$_POST['pourcentage'];
	$titreL=$_POST['titreL'];
	
	$dureeListe=0;
	
	recherche ($connexion,$dureeL,$genreG,$titreL);
	

}
?>
