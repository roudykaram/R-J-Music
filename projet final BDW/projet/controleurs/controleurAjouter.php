<?php 
if(isset($_POST['boutonValider'])) { 

	$titreC = $_POST['titreC']; 
	$nomG = $_POST['nomG']; 
	$genreG = $_POST['genreG']; 
	$nomFichierV = $_POST['nomFichierV']; 
	$dureeV=$_POST['dureeV'];
	$dateV=$_POST['dateV'];
	
	$vertitre = getChansonByName($connexion, $titreC);
    $vergroupe = getGroupe($connexion, $nomG);
	$vergenre= getGenre($connexion, $genreG);
	$ext = pathinfo($nomFichierV, PATHINFO_EXTENSION);
	$verfichier = getfichier($connexion, $nomFichierV);


	

	$idch=getidbyname($connexion,$titreC); 
	$res=get_chansons($connexion,$titreC);
	$ch = mysqli_fetch_row($res);
	
	
	
	if($ch == NULL){
		if($vergroupe == NULL){

									echo " Erreur, le Groupe n existe pas, saisissez un autre. <br>";
									return 0;
							  }
		if($vergenre ==NULL){
								echo " Erreur, le genre n'existe pas, saisissez un autre. <br>";
								return 0;
							}
		
		if(strtolower($ext) != 'mp3') {
             echo " Erreur, le format de fichier est incorrect : vous devez utiliser un format .mp3 <br>";
             return 0;
		}
		
		if($verfichier != NULL){
			echo " Erreur, le fichier existe dejà, veuillez saisir un nouveau nom de fichier pour votre chanson. <br>" ;
			return 0;
		}
		
		if(!is_numeric($dateV)||($dateV>2022)){
			echo " Erreur, la date doit représenter l'année de sortie de la version. <br>";
			return 0;
		}
		
		if(!is_numeric($dureeV)){
			echo " Erreur, pour la durée, donner un nombre qui représente la durée en secondes. <br>";	
			return 0;
		}				
			
		insertChanson($connexion, $titreC, $dateV, $nomG);
		insertVersion($connexion, $nomFichierV, $dureeV, $dateV, $titreC);
		insertJouepar($connexion, $nomG, $nomFichierV);
		insertEst($connexion, $genreG, $nomFichierV);
		echo "La chanson a bien été dans CHANSON et VERSION";
		echo is_numeric($dateV);
	}
			
					
	elseif($ch!=NULL){
		
		if($vergroupe == NULL){

									echo " Erreur, le Groupe n existe pas, saisissez un autre <br>";
									return 0;
							  }
		if($vergenre ==NULL){
								echo " Erreur, le genre n'existe pas, saisissez un autre <br>";
								return 0;
							}
							
		if(strtolower($ext) != 'mp3') {
             echo " Erreur, le format de fichier est incorrect : vous devez utiliser un format .mp3 <br>";
             return 0;
		}
		
		if($verfichier != NULL){
			echo " Erreur, le fichier existe dejà, veuillez saisir un nouveau nom de fichier pour votre chanson. <br>" ;
			return 0;
		}
		
		if(!is_numeric($dateV)||($dateV>2022)){
			echo " Erreur, la date doit représenter l'année de sortie de la version. <br>";
			return 0;
		}
		
		if(!is_numeric($dureeV)){
			echo " Erreur, pour la durée, donner un nombre qui représente la durée en secondes. <br>";	
			return 0;
		}
		
		insertVersion($connexion, $nomFichierV, $dureeV, $dateV, $titreC);
		insertJouepar($connexion, $nomG, $nomFichierV);
		insertEst($connexion, $genreG, $nomFichierV);
		echo "La chanson a bien été dans VERSION";
		echo is_numeric($dateV);
	}
	
}
				 
?>
