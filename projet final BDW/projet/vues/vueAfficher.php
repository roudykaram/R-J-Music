<br>
<br>

<table>
	<thead>
		<tr>
		<th>Titre de la Chansons </th>
		<th>Nom du Groupe </th>
		<th>Durée de la version </th>
		<th>Genre      </th>
		<th>nom de Fichier de la Version</th>
		</tr>
	</thead>
	
	<tbody>
	<?php
	$requete1=get_idC_numV($connexion);

	while($row=mysqli_fetch_assoc($requete1)){
		$Genres= get_genres_for_one_version($connexion,$row['idC'],$row['numV']);
		//print_r($Genres);
		$Genres=implode(', ',$Genres);
		
		$reqversion=requeteversion($connexion,$row['idC'],$row['numV']);
		echo "<tr>
		<td>". $reqversion['titreC'] ."</td>
		<td>". $reqversion['nomG'] ."</td>
		<td>". $reqversion['dureeV'] ."</td>
		<td>". $Genres ."</td>
		<td>". $reqversion['nomFichierV'] ."</td>
		</tr>";
	}
	
	?>
	</tbody>
	
</table>

