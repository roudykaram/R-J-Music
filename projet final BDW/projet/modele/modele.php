<?php 

// connexion à la BD, retourne un lien de connexion
function getConnexionBD() {
	$connexion = mysqli_connect("localhost", "p2102430", "Finer93Giver", "p2102430");
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
	mysqli_query($connexion,'SET NAMES UTF8'); // noms en UTF8
	return $connexion;
}

// déconnexion de la BD
function deconnectBD($connexion) {
	mysqli_close($connexion);
}

function getConnexiondata() {
	$connexiondata = mysqli_connect("localhost", "p2102430", "Finer93Giver", "dataset");
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
	mysqli_query($connexiondata,'SET NAMES UTF8'); // noms en UTF8
	return $connexiondata;
}
function deconnectdata($connexiondata) {
	mysqli_close($connexiondata);
}

// nombre d'instances d'une table $nomTable
function countInstances($connexion, $nomTable) {
	$requete = "SELECT COUNT(*) AS nb FROM $nomTable";
	$res = mysqli_query($connexion, $requete);
	if($res != FALSE) {
		$row = mysqli_fetch_row($res);
		//print_r($row);
		//echo $row[0];
		return $row[0];
	}
	return -1;  // valeur négative si erreur de requête (ex, $nomTable contient une valeur qui n'est pas une table)
}





// retourne les informations sur la chanson nommée $titreC
function getChansonByName($connexion, $titreC) {
	$titreC = mysqli_real_escape_string($connexion, $titreC); 
	$requete = "SELECT * FROM CHANSON WHERE titreC = '". $titreC . "'";
	$res = mysqli_query($connexion, $requete);
	$titreChanson = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $titreChanson;
}

//donne l'idC en donnant le titre de la chanson
function getidbyname($connexion, $titreC) {
	$titreC = mysqli_real_escape_string($connexion, $titreC); 
	$requete = "SELECT idC FROM CHANSON WHERE titreC='". $titreC . "'";
	$res = mysqli_query($connexion, $requete);
	$id= mysqli_fetch_row($res);
	if($id !=NULL){
		$id_chanson=$id[0];
		return $id_chanson;
	}
	 
}

//donne le numero de version en donnant l'idC en parametres
function getnumVersionbyid($connexion,$id,$titreC){
		$titreC = mysqli_real_escape_string($connexion, $titreC); 
		$requete="SELECT idC FROM VERSION WHERE idC='". $id . "'";
		$res = mysqli_query($connexion, $requete);
		$num=mysqli_fetch_all($res, MYSQLI_ASSOC);
		$numero=count($num);
		//echo"le numero de version est: " .$numero. "<br>";
		return $numero;
}


function getGroupe($connexion, $nomG) {
	$nomG = mysqli_real_escape_string($connexion, $nomG); 
	$requete = "SELECT nomG FROM GROUPE WHERE nomG = '". $nomG . "'";
	$res = mysqli_query($connexion, $requete);
	$groupe = mysqli_fetch_row($res);
	return $groupe;
}
	
function getGenre($connexion, $genreG) {
	$genre = mysqli_real_escape_string($connexion, $genreG); 
	$requete = "SELECT genreG FROM GENRE WHERE genreG = '". $genreG . "'";
	$res = mysqli_query($connexion, $requete);
	$Genre = mysqli_fetch_row($res);
	return $Genre;
}
function getfichier($connexion, $nomFichierV) {
	$nfichier = mysqli_real_escape_string($connexion, $nomFichierV); 
	$requete = "SELECT nomFichierV FROM VERSION WHERE nomFichierV = '". $nomFichierV . "'";
	$res = mysqli_query($connexion, $requete);
	$nomfichier = mysqli_fetch_row($res);
	return $nomfichier;
}



// pour ajouter un chanson dans la table chanson
function insertChanson($connexion, $titreC, $dateV, $nomG) {
	$titreC = mysqli_real_escape_string($connexion, $titreC); 
	$dateV = mysqli_real_escape_string($connexion, $dateV); 
	$nomG = mysqli_real_escape_string($connexion, $nomG); 
	$requete = "INSERT INTO CHANSON (titreC, dateC, nomG) VALUES('". $titreC . "','". $dateV ."','". $nomG ."')";
	$res = mysqli_query($connexion, $requete);
	return $res;
	}

//pour ajouter une version dans la table version
function insertVersion($connexion, $nomFichierV, $dureeV, $dateV, $titreC) {
	$nomFichierV = mysqli_real_escape_string($connexion, $nomFichierV); 
	$dureeV = mysqli_real_escape_string($connexion, $dureeV);
	$dateV = mysqli_real_escape_string($connexion, $dateV);
	$titreC = mysqli_real_escape_string($connexion, $titreC);
	$id=getidbyname($connexion,$titreC);
	$numver=getnumVersionbyid($connexion,$id,$titreC);
	$numV=$numver +1;
	
    $idChanson="SELECT idC FROM CHANSON WHERE titreC = '". $titreC ."' ";
	$residC=mysqli_query($connexion, $idChanson);
	$row=$residC->fetch_assoc();
	
	$requete = "INSERT INTO VERSION (dureeV, dateV, nomFichierV, numV, idC) VALUES ('". $dureeV . "','". $dateV ."','". $nomFichierV ."', ". $numV .", ". $row['idC'] .")";
	
	$res = mysqli_query($connexion, $requete);
	
	return $res;
}

//insert dans la table jouer_par
function insertJouepar($connexion, $nomG, $nomFichierV){
	$nomG = mysqli_real_escape_string($connexion, $nomG);
	$nomFichierV = mysqli_real_escape_string($connexion, $nomFichierV);
	$idC="SELECT idC FROM VERSION WHERE nomFichierV = '".$nomFichierV."' ";
	$numV="SELECT numV FROM VERSION WHERE nomFichierV = '".$nomFichierV."' ";
	$residC=mysqli_query($connexion, $idC);
	$rowidC=$residC->fetch_assoc();
	$resnumV=mysqli_query($connexion, $numV);
	$rownumV=$resnumV->fetch_assoc();
	
	$requete= "INSERT INTO Jouer_par (nomG, idC, numV) VALUES ('". $nomG . "', ". $rowidC['idC'] .", ". $rownumV['numV'] .")";
	$res = mysqli_query($connexion, $requete);
	
	return $res;
	
}	

//insert dans la table EST
function insertEst($connexion, $genreG, $nomFichierV){

	$nomFichierV = mysqli_real_escape_string($connexion, $nomFichierV);
	$idC="SELECT idC FROM VERSION WHERE nomFichierV = '".$nomFichierV."' ";
	$numV="SELECT numV FROM VERSION WHERE nomFichierV = '".$nomFichierV."' ";
	$residC=mysqli_query($connexion, $idC);
	$rowidC=$residC->fetch_assoc();
	$resnumV=mysqli_query($connexion, $numV);
	$rownumV=$resnumV->fetch_assoc();
	
	$requete= "INSERT INTO EST (genreG, idC, numV) VALUES ('". $genreG . "', ". $rowidC['idC'] .", ". $rownumV['numV'] .")";
	$res = mysqli_query($connexion, $requete);
	
	return $res;
	
}		

function insertgenre ($connexion,$genreG){
	$genre = mysqli_real_escape_string($connexion, $genreG); 
	$requete = "INSERT INTO GENRE VALUES ('". $genreG . "')";
	$res = mysqli_query($connexion, $requete);
	return $res;
}

	
function trouverChansons($connexion, $titreC) {
	$titreC = mysqli_real_escape_string($connexion, $titreC); 
	$requete = "SELECT * FROM CHANSON";
	$res = mysqli_query($connexion, $requete);
	return $res;
}


//insert les albums de dataset dans notre BDD
function album_de_dataset ($connexiondata){
	
	$requete= "INSERT INTO p2102430.ALBUM(titre)
SELECT
	songs2000.album
FROM
	dataset.songs2000
 ";
	$req=mysqli_query($connexiondata,$requete);

	return $req;

}

//fonction qui permet d'explode les genres grace à plusieurs séparateurs qu'on a trouvé sur internet
function multipleExplode($separateurs = array(), $chaine = ''){
    $leseparateur=$separateurs[count($separateurs)-1];
    array_pop($separateurs);
    foreach($separateurs as $separateur){
        $chaine= str_replace($separateur, $leseparateur, $chaine);
    }
    $result= explode($leseparateur, $chaine);
    return $result;
} 





function explode_genre($connexiondata,$genre){
	$separateurs=array();
	$separateurs[0]=" - ";
	$separateurs[1]=":";
	$separateurs[2]="& ";
	$separateurs[3]=" and ";
	$separateurs[4]=" AND ";
	$separateurs[5]="/";
	$separateurs[6]=";";
	$separateurs[7]=" And ";
	$split = multipleExplode($separateurs,$genre);

	$taille=(sizeof($split));
		for ($i=0; $i<$taille; $i++) {
			 $split[$i]=trim($split[$i]); //supprime espaces debut et fin
			
		}
		$res=array_unique($split); // permet de supprimer les doublons
		return $res;
} 


//pour inserer les données de dataset dans notre BDD
function inserer ($connexiondata,$connexion){

	$req="SELECT * FROM dataset.songs2000";
	$requete=mysqli_query($connexiondata,$req);
	while ($row=mysqli_fetch_assoc($requete)){
		
		$requetegrp="SELECT * FROM p2102430.GROUPE WHERE nomG = '". $row['artist'] ."'";
		$resgrp=mysqli_query($connexiondata,$requetegrp);

		$grp=mysqli_fetch_row($resgrp);
 
					 
		if($grp==NULL){
			$tabgrp="INSERT INTO p2102430.GROUPE (nomG) VALUES ('". $row['artist'] ."')";			//INSERT DANS GROUPE
			$resg=mysqli_query($connexiondata,$tabgrp);
		}
		$requetechanson="SELECT  * FROM p2102430.CHANSON WHERE titreC = '". $row['title'] . "'";   
		$res= mysqli_query($connexiondata,$requetechanson);

		$ch = mysqli_fetch_row($res);
					 
		
		
		if($ch==NULL)
		{
			$tabtitle="INSERT INTO p2102430.CHANSON (titreC,dateC,nomG) VALUES ('". $row['title'] ."',". $row['year'] .",'". $row['artist'] ."')";
	        $res=mysqli_query($connexiondata,$tabtitle);
			$idchanson=mysqli_insert_id($connexion);          //INSERTION DANS CHANSON
			
			

		 
		}
		
		$id=getidbyname($connexion,$row['title']);

	    $numver=getnumVersionbyid($connexion,$id,$row['title']);
		$numV=$numver +1;
		$tabversion="INSERT INTO p2102430.VERSION (idC,numV,dureeV,dateV,nomFichierV) VALUES (". $id .", ". $numV .", ". $row['length'] .", ". $row['year'] .", '". $row['filename'] ."')"; 
		$resversion=mysqli_query($connexiondata,$tabversion);       // INSERTION DANS VERSION

		
		//album_de_dataset ($connexiondata); // INSERTION de ALBUM
		
		$tabg=explode_genre($connexiondata,$row['genre']);
		$tailletabg=sizeof($tabg);
		for($i=0;$i<$tailletabg;$i++){
			
		 $req="INSERT INTO p2102430.GENRE (genreG) VALUES ('". $tabg[$i] ."')";
		 $res=mysqli_query($connexiondata,$req);      // INSERTION DANS GENRE
		 $id=getidbyname($connexion,$row['title']);

		 $reqEst="INSERT INTO p2102430.EST (idC,numV,genreG) VALUES (". $id .",". $numV .",'". $tabg[$i] ."')"; //INSERTION DANS EST
		 $requeteEst=mysqli_query($connexiondata,$reqEst);
	 
		}
		$requetepropriete1="INSERT INTO PROPRIETE (libellé) VALUES ('playcount')";   ////INSERT le libellé playcount dans PROPRIETE
		$reqpropriete1=mysqli_query($connexion,$requetepropriete1);
		$idPropriete1 = mysqli_insert_id($connexion);
		echo $idPropriete1." ";
		$requeteADES1="INSERT INTO p2102430.A_DES_ (idC,numV,idp,valp) VALUES (". $id .",". $numV .",". $idPropriete1 .",". $row['playcount'] .")";
		echo $requeteADES1." ";
		$reqADES1=mysqli_query($connexiondata,$requeteADES1);
		
		$requetepropriete2="INSERT INTO PROPRIETE (libellé) VALUES ('lastplayed')"; //INSERT le libellé lastplayed dans PROPRIETE
		$reqpropriete2=mysqli_query($connexion,$requetepropriete2);
		$idPropriete2 = mysqli_insert_id($connexion);
		$requeteADES2="INSERT INTO p2102430.A_DES_ (idC,numV,idp,valp) VALUES (". $id .",". $numV .",". $idPropriete2 .",". $row['lastplayed'] .")";
		echo $requeteADES2." ";
		$reqADES1=mysqli_query($connexiondata,$requeteADES1);
		
		$requetepropriete3="INSERT INTO PROPRIETE (libellé) VALUES ('skipcount')";//INSERT le libellé skipcount dans PROPRIETE 
		$reqpropriete3=mysqli_query($connexion,$requetepropriete3);
		$idPropriete3 = mysqli_insert_id($connexion);
		$requeteADES3="INSERT INTO p2102430.A_DES_ (idC,numV,idp,valp) VALUES (". $id .",". $numV .",". $idPropriete3 .",". $row['skipcount'] .")"; //INSERTION DANS A_DES_
		echo $requeteADES3." ";
		$reqADES3=mysqli_query($connexiondata,$requeteADES3);
		
		$reqJouepar="INSERT INTO p2102430.Jouer_par (idC,numV,nomG) VALUES (". $id .",". $numV .",'". $row['artist'] ."')"; //INSERTION DANS Jouer_par
		$requeteJoue=mysqli_query($connexiondata,$reqJouepar);
		echo $requeteJoue." ";
					 
}	
	
	
}		
		
		
		

//pour la creation de la liste de lecture aleatoire
function recherche ($connexion,$dureeL,$genreG,$titreL){
	$duree=0;
	$dateL=2022;

	$requeteliste="INSERT INTO LISTE_DE_LECTURE (titreL,dateL) VALUES('". $titreL ."',". $dateL .")";
	$reqliste=mysqli_query($connexion,$requeteliste);
	$idListe = mysqli_insert_id($connexion);
	

		$reqmax_playcount=	"SELECT MAX(playcount) FROM dataset.songs2000"; //le maximum de playcount
		$requetemax_playcount=mysqli_query($connexion,$reqmax_playcount);
		$max_playcount=mysqli_fetch_row($requetemax_playcount);
		
		$reqmax_skipcount=	"SELECT MAX(skipcount) FROM dataset.songs2000"; //le maximum de skipcount
		$requetemax_skipcount=mysqli_query($connexion,$reqmax_skipcount);
		$max_skipcount=mysqli_fetch_row($requetemax_skipcount);
		
		$reqmax_lastplayed=	"SELECT MAX(lastplayed) FROM dataset.songs2000"; //le maximum de last played
		$requetemax_lastplayed=mysqli_query($connexion,$reqmax_lastplayed);
		$max_lastplayed=mysqli_fetch_row($requetemax_lastplayed);
		
		$req="SELECT * FROM EST WHERE genreG = '". $genreG ."' ORDER BY RAND()";
		
	    $requete=mysqli_query($connexion,$req);
		
	    while ($row=mysqli_fetch_assoc($requete)){

				$requetedureeV="SELECT dureeV FROM VERSION WHERE idC=". $row['idC'] ." AND numV=". $row['numV'] ."";
				$reqdureeV=mysqli_query($connexion,$requetedureeV);
				$dureeVer = mysqli_fetch_row($reqdureeV);
				$dureesomme=$duree + $dureeVer[0];
				$dureeplus=($dureeL+60)*($_POST['pourcentage'])/100;

				
				
				
				if(($dureesomme < $dureeplus)&&($_POST['pref']=="jouee")){ //si la duree du genre (% de la duree totale ) n'est pas atteinte et a choisi la preference les plus jouées
					$requeteplaycount="SELECT valp FROM A_DES_ NATURAL JOIN PROPRIETE WHERE libellé='playcount' AND idC=". $row['idC'] ."";
					
					$reqplaycount=mysqli_query($connexion,$requeteplaycount);
					$valplaycount = mysqli_fetch_row($reqplaycount);
					$playcountmin=$max_playcount[0]-5;
					if($valplaycount[0]>=$playcountmin){
					$requeteInclus="INSERT INTO INCLUS (idC,numV,idL) VALUES (". $row['idC'] .",". $row['numV'] .",". $idListe .")";
					

					$reqInclus=mysqli_query($connexion,$requeteInclus);
					$duree=$dureesomme;
					$dureeGenre=$duree;
					}
				}	
				
				if(($dureesomme < $dureeplus)&&($_POST['pref']=="sautee")){   ///si la duree du genre (% de la duree totale ) n'est pas atteinte et a choisi la preference les plus sautés
					$requeteskipcount="SELECT valp FROM A_DES_ NATURAL JOIN PROPRIETE WHERE libellé='skipcount' AND idC=". $row['idC'] ."";
					$reqskipcount=mysqli_query($connexion,$requeteskipcount);
					$valskipcount = mysqli_fetch_row($reqskipcount);
					$skipcountmin=$max_skipcount[0]-5;
					
					if($valskipcount[0]>=$skipcountmin){
					$requeteInclus="INSERT INTO INCLUS (idC,numV,idL) VALUES (". $row['idC'] .",". $row['numV'] .",". $idListe .")";
					
					$reqInclus=mysqli_query($connexion,$requeteInclus);
					$duree=$dureesomme;
					$dureeGenre=$duree;
					}
				}
				
				if(($dureesomme < $dureeplus)&&($_POST['pref']=="recent")){  //si la duree du genre (% de la duree totale ) n'est pas atteinte et a choisi la preference les plus recentes
					$requetelastplayed="SELECT valp FROM A_DES_ NATURAL JOIN PROPRIETE WHERE libellé='lastplayed' AND idC=". $row['idC'] ."";
					$reqlastplayed=mysqli_query($connexion,$requetelastplayed);
					$vallastplayed = mysqli_fetch_row($reqlastplayed);
					$lastplayedmin=$max_lastplayed[0]-400000;
					if($vallastplayed!=NULL && ($vallastplayed[0]>=$lastplayedmin) ){
					$requeteInclus="INSERT INTO INCLUS (idC,numV,idL) VALUES (". $row['idC'] .",". $row['numV'] .",". $idListe .")";
					
					$reqInclus=mysqli_query($connexion,$requeteInclus);
					$duree=$dureesomme;
					$dureeGenre=$duree;
					}
				}
				

					
				
						
		}
		
		$requeteantigenre="SELECT * FROM EST WHERE genreG != '". $genreG ."'";
		$reqantigenre=mysqli_query($connexion, $requeteantigenre);
		$dureemax=$dureeL+60;
		
		 while ($row2=mysqli_fetch_assoc($reqantigenre)){
			
			$requetedureeVersion="SELECT dureeV FROM VERSION WHERE idC=". $row2['idC'] ." AND numV=". $row2['numV'] ."";
			$reqdureeVersion=mysqli_query($connexion,$requetedureeVersion);
			$dureeVersion = mysqli_fetch_row($reqdureeVersion);
			$dureesomme=$duree + $dureeVersion[0];
			 
			 if($dureesomme < $dureemax){
				
					$requeteInclus="INSERT INTO INCLUS (idC,numV,idL) VALUES (". $row2['idC'] .",". $row2['numV'] .",". $idListe .")";
					
					$reqInclus=mysqli_query($connexion,$requeteInclus);
					$duree=$dureesomme;
			 }
			 
		}
		$pourcentagegenre=($dureeGenre/$duree)*100;
		echo"<b>La durée de la Liste créée: </b>".$duree." secondes<br><br>";
		echo"<b>Le pourcentage avec le genre ". $genreG ." : </b>".$pourcentagegenre."<br><br>";
		echo"<b>Les titres de Chanson dans la playlist: </b><br>";
		$requeteafficheTitre="SELECT titreC FROM INCLUS NATURAL JOIN CHANSON WHERE idL=". $idListe ."";
		$reqafficheTitre=mysqli_query($connexion,$requeteafficheTitre);
		while($row3=mysqli_fetch_assoc($reqafficheTitre)){
			echo $row3['titreC']."<br>";
		}	
		
		
			
		 
}


function requetegerer($connexion,$idL){
	
	$requete="SELECT SUM(dureeV) as dureetotale,COUNT(numV) as nbChansons,titreL FROM VERSION NATURAL JOIN INCLUS NATURAL JOIN LISTE_DE_LECTURE WHERE idL=" .$idL. "";
	$req=mysqli_query($connexion,$requete);
	return $req;
}

function get_idL($connexion){
	$r="SELECT idL FROM LISTE_DE_LECTURE";
	$idL=mysqli_query($connexion,$r);
	return $idL;
}

function get_idL_by_titreL($connexion,$titreL){
	$r="SELECT idL FROM LISTE_DE_LECTURE NATURAL JOIN INCLUS WHERE titreL='" .$titreL. "'";
	$req=mysqli_query($connexion,$r);
	$row=mysqli_fetch_row($req);
	if($row != NULL){
		$idL=$row[0];
		return $idL;
	}
}		

function get_chansons_from_Liste($connexion,$titreL){
		$requete="SELECT titreC FROM LISTE_DE_LECTURE NATURAL JOIN INCLUS NATURAL JOIN CHANSON WHERE titreL='" .$titreL. "'";
		$req=mysqli_query($connexion,$requete);
		return $req;
}		

//supprime chanson de playliste
function delete_from_playlist($connexion,$titreC){
	$id=getidbyname($connexion, $titreC);
	if($id !=NULL){
		$requete="DELETE FROM INCLUS WHERE idC=" .$id. "";
		$req=mysqli_query($connexion,$requete);
	}else echo "Erreur, Chanson inexistante dans la playlist!";
	
}

//ajoute chanson dans playliste
function ajoute_dans_liste($connexion,$titreC,$titreL){
	$id=getidbyname($connexion, $titreC);
	$numV= getnumVersionbyid($connexion,$id,$titreC);
	$idL= get_idL_by_titreL($connexion,$titreL);
	if($id!=NULL && $numV!=NULL && $idL!=NULL){
		$req="INSERT INTO INCLUS(idC,numV,idL) VALUES (" .$id. "," .$numV. "," .$idL. ")";
		$r=mysqli_query($connexion,$req);
	}else echo "Erreur, la chanson n'existe pas dans la BDD!";
}


function get_titreC_by_idC_numV($connexion,$idC,$numV){
	$r="SELECT titreC FROM CHANSON NATURAL JOIN VERSION WHERE idC=" .$idC. " and numV=" .$numV. "";
	$req=mysqli_query($connexion,$r);
	$res=mysqli_fetch_assoc($req);
	return $res;
}

function get_nomG_by_idC_numV($connexion,$idC,$numV){
	$r="SELECT nomG FROM Jouer_par WHERE idC=" .$idC. " and numV=" .$numV. "";
	$req=mysqli_query($connexion,$r);
	$res=mysqli_fetch_assoc($req);
	return $res;
}

function get_idC_numV($connexion){
	$r="SELECT idC,numV FROM VERSION";
	$req=mysqli_query($connexion,$r);
	return $req;
}	

function requeteversion($connexion,$idC,$numV){
	$r="SELECT titreC,nomG,dureeV,genreG,nomFichierV FROM EST NATURAL JOIN CHANSON NATURAL JOIN VERSION WHERE idC=" .$idC. " and numV=" .$numV. "";
	$req=mysqli_query($connexion,$r);
	$res=mysqli_fetch_assoc($req);
	return $res;
}

function get_genres_for_one_version($connexion,$idC,$numV){
	$num="SELECT COUNT(*) FROM EST WHERE idC=" .$idC. " and numV=" .$numV. "";
	$numg=mysqli_query($connexion,$num);
	$numgr=mysqli_fetch_row($numg);
	
	$numgenres=$numgr[0];

	$arraygenres=array();
	for($i=0;$i<$numgenres;$i++){
	
	$r="SELECT genreG FROM EST WHERE idC=" .$idC. " and numV=" .$numV. "";
	$req=mysqli_query($connexion,$r);
	$res=mysqli_fetch_all($req, MYSQLI_ASSOC);
	$res=$res[$i]['genreG'];
	$arraygenres[$i]=$res;
	}

	return $arraygenres;
}	

function top5genre($connexion){
		$r="SELECT genreG,COUNT(genreG) AS nbgenre FROM CHANSON NATURAL JOIN EST GROUP BY genreG ORDER BY nbgenre DESC LIMIT 5";
		$req=mysqli_query($connexion,$r);
		return $req;
	}

function groupefavori($connexion){
	$r="SELECT nomG,COUNT(nomG) AS nbgroupe FROM Jouer_par GROUP BY nomG ORDER BY nbgroupe DESC LIMIT 1";
	$req=mysqli_query($connexion,$r);
	return $req;			
}	

function get_genres_from_Liste($connexion,$titreL){
	$r="SELECT genreG FROM LISTE_DE_LECTURE NATURAL JOIN INCLUS NATURAL JOIN EST WHERE titreL='" .$titreL. "'";
	$req=mysqli_query($connexion,$r);
	return $req;
}

function get_groupes_from_Liste($connexion,$titreL){
	$r="SELECT nomG FROM Jouer_par NATURAL JOIN INCLUS NATURAL JOIN LISTE_DE_LECTURE WHERE titreL='" .$titreL. "'";
	$req=mysqli_query($connexion,$r);
	return $req;
}

function get_titreC_from_Liste($connexion,$titreL){
	$r="SELECT titreC FROM CHANSON NATURAL JOIN INCLUS NATURAL JOIN LISTE_DE_LECTURE WHERE titreL='" .$titreL. "'";
	$req=mysqli_query($connexion,$r);
	return $req;
}


//retourne le nmbre genres qui sont identiques dans les 2 listes
function comparer_genres_Listes($connexion,$titreListe1,$titreListe2){
	$compteur_genres=0;
	$genres1=get_genres_from_Liste($connexion,$titreListe1);
	$genres2=get_genres_from_Liste($connexion,$titreListe2);
	$row1=mysqli_fetch_all($genres1);
	$row2=mysqli_fetch_all($genres2);
	$taille1=count_genres_dans_liste($connexion,$titreListe1);
	$taille2=count_genres_dans_liste($connexion,$titreListe2);
	
	for($i=0;$i<$taille1;$i++){
		for($j=0;$j<$taille2;$j++){

			$g1=$row1[$i][0];
			$g2=$row2[$j][0];
			if($g1==$g2){
				$compteur_genres=$compteur_genres+1;
			}
		}
	}
	return $compteur_genres;
}

//retourne le nmbre groupes qui sont identiques dans les 2 listes
function comparer_groupes_Listes($connexion,$titreListe1,$titreListe2){
	$compteur_groupes=0;
	$groupes1=get_groupes_from_Liste($connexion,$titreListe1);
	$groupes2=get_groupes_from_Liste($connexion,$titreListe2);
	$row1=mysqli_fetch_all($groupes1);
	$row2=mysqli_fetch_all($groupes2);
	$taille1=count_groupes_dans_liste($connexion,$titreListe1);
	$taille2=count_groupes_dans_liste($connexion,$titreListe2);
	
	for($i=0;$i<$taille1;$i++){
		for($j=0;$j<$taille2;$j++){

			$g1=$row1[$i][0];
			$g2=$row2[$j][0];
			
			if($g1==$g2){
				$compteur_groupes=$compteur_groupes+1;
			}
		}
	}
	return $compteur_groupes;
	
}

//retourne le nombre de titres  qui sont identiques dans les 2 listes
function comparer_titreC_Listes($connexion,$titreListe1,$titreListe2){
	$compteur_titreC=0;
	$titreC1=get_titreC_from_Liste($connexion,$titreListe1);
	$titreC2=get_titreC_from_Liste($connexion,$titreListe2);
	$row1=mysqli_fetch_all($titreC1);
	$row2=mysqli_fetch_all($titreC2);
	$taille1=count_chansons_dans_liste($connexion,$titreListe1);
	$taille2=count_chansons_dans_liste($connexion,$titreListe2);
	
	for($i=0;$i<$taille1;$i++){
		for($j=0;$j<$taille2;$j++){
			$t1=$row1[$i][0];
			$t2=$row2[$j][0];
			if($t1==$t2){
				$compteur_titreC=$compteur_titreC+1;
			}
		}
	}
	return $compteur_titreC;
	
}

function count_chansons_dans_liste($connexion,$titreL){
	$r="SELECT COUNT(*) FROM VERSION NATURAL JOIN INCLUS NATURAL JOIN LISTE_DE_LECTURE WHERE titreL='" .$titreL. "'";
	$req=mysqli_query($connexion,$r);
	$row=mysqli_fetch_row($req);
	return $row[0];
}

function count_genres_dans_liste($connexion,$titreL){
	$r="SELECT COUNT(*) FROM EST NATURAL JOIN INCLUS NATURAL JOIN LISTE_DE_LECTURE WHERE titreL='" .$titreL. "'";
	$req=mysqli_query($connexion,$r);
	$row=mysqli_fetch_row($req);
	return $row[0];
}

function count_groupes_dans_liste($connexion,$titreL){
	$r="SELECT COUNT(*) FROM Jouer_par NATURAL JOIN INCLUS NATURAL JOIN LISTE_DE_LECTURE WHERE titreL='" .$titreL. "'";
	$req=mysqli_query($connexion,$r);
	$row=mysqli_fetch_row($req);
	return $row[0];
}


function delete_playlist($connexion,$titreL){
	$idL=get_idL_by_titreL($connexion,$titreL);
	$rinclus="DELETE FROM INCLUS WHERE idL=" .$idL. "";
	$reqinclus=mysqli_query($connexion,$rinclus);
	$r="DELETE FROM LISTE_DE_LECTURE WHERE idL=" .$idL. "";
	$req=mysqli_query($connexion,$r);
	
}

function get_chansons($connexion,$titreC){
    $requete="SELECT  * FROM CHANSON WHERE titreC = '". $titreC . "'"; 
	$res= mysqli_query($connexion,$requete);
	return $res;
}	
?>
