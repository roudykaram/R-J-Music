<?php
if(isset($_POST['boutonAfficher'])) { 

	$titreL = $_POST['titreL']; 
	
	
	echo"<b>Les titres de Chansons de la liste de lecture ". $titreL. ":</b><br>";
	$query_titreL=get_chansons_from_Liste($connexion,$titreL);
	while($row=mysqli_fetch_assoc($query_titreL)){
		echo $row['titreC']."<br>";
	}
}	

if(isset($_POST['Ajouter'])) {
	$titreListe = $_POST['titreListe']; 
	$titreC=$_POST['titreC'];
	
	ajoute_dans_liste($connexion,$titreC,$titreListe);
}

if(isset($_POST['Supprimer'])) {
	$titreListe = $_POST['titreListe']; 
	$titreC=$_POST['titreC'];
	
	delete_from_playlist($connexion,$titreC);
}

if (isset($_POST['Comparer'])){
	$titreListe1=$_POST['titreListe1'];
	$titreListe2=$_POST['titreListe2'];
	
	$compteur_titres_communs=comparer_titreC_Listes($connexion,$titreListe1,$titreListe2);
	$compteur_genres_communs=comparer_genres_Listes($connexion,$titreListe1,$titreListe2);
	$compteur_groupes_communs=comparer_groupes_Listes($connexion,$titreListe1,$titreListe2);
	
	$count_chansons1=count_chansons_dans_liste($connexion,$titreListe1);
	$count_chansons2=count_chansons_dans_liste($connexion,$titreListe2);

	
	$count_groupes1=count_groupes_dans_liste($connexion,$titreListe1);
	$count_groupes2=count_groupes_dans_liste($connexion,$titreListe2);
	
	$count_genres1=count_genres_dans_liste($connexion,$titreListe1);
	$count_genres2=count_genres_dans_liste($connexion,$titreListe2);
	
	if($count_chansons1<$count_chansons2){  //si la liste 1 est la plus courte
		$pourcentage_titre=($compteur_titres_communs/$count_chansons1)*100;
		$pourcentage_groupe=($compteur_groupes_communs/$count_groupes1)*100;
		$pourcentage_genre=($compteur_genres_communs/$count_genres1)*100;
		$pourcentagetot=$pourcentage_genre*0.2 + $pourcentage_groupe*0.3 + $pourcentage_titre*0.5;
		
		if($pourcentagetot>85){
				echo "Les deux playlistes sont très similaires ainsi la liste ". $titreListe1. " qui est la plus courte sera supprimée. <br>";
				delete_playlist($connexion,$titreListe1);
		}
		else{
			
			echo "Les playlistes ne sont pas assez similaires.<br>Le pourcentage de similarité est de " .$pourcentagetot. "%<br>";
		}
	}
	
	
	else{ //si la liste 2 est la plus courte
		$pourcentage_titre=($compteur_titres_communs/$count_chansons2)*100;
		$pourcentage_groupe=($compteur_groupes_communs/$count_groupes2)*100;
		$pourcentage_genre=($compteur_genres_communs/$count_genres2)*100;
		$pourcentagetot=$pourcentage_genre*0.2 + $pourcentage_groupe*0.3 + $pourcentage_titre*0.5;
		
		if($pourcentagetot>85){
				echo "Les deux playlistes sont très similaires ainsi la liste ". $titreListe2. " qui est la plus courte sera supprimée. <br>";
				delete_playlist($connexion,$titreListe2);
		}
		else{
			
			echo "Les playlistes ne sont pas similaires.<br>Le pourcentage de similarité est de " .$pourcentagetot. "%<br>";	
		}
		
	}
}

	

?>
