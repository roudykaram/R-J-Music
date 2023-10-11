<br>
<br>
<br>

<table>
	<thead>
		<tr>
		<th>Titre de la liste</th>
		<th>Durée totale</th>
		<th>Nombre de Chansons</th>
		</tr>
	</thead>
	
	<tbody>
	<?php
	$req=get_idL($connexion);
	while($row=mysqli_fetch_assoc($req)){
		$get_val_tab=requetegerer($connexion,$row['idL']);
		$req_gerer=mysqli_fetch_assoc($get_val_tab);
		echo "<tr>
		<td>". $req_gerer['titreL'] ."</td>
		<td>". $req_gerer['dureetotale'] ."</td>
		<td>". $req_gerer['nbChansons'] ."</td></tr>";
	}
	
	?>
	</tbody>
	
</table>

<br>
<br>

<b>Quelle liste de lecture voulez-vous afficher?</b>
<form method="post" action="#">
	<label for="titreL">Titre: </label>
	<input type="text" name="titreL" id="titreL" placeholder="" required />
	<br/><br/>
	<input type="submit" name="boutonAfficher" value="Afficher"/>
</form>

<br>
<br>
<b>Quelle playlist voulez-vous modifier?</b>
<form method="post" action="#">
	<label for="titreListe">Titre de la liste: </label>
	<input type="text" name="titreListe" id="titreListe" placeholder="" required />
	<br/><br/>

	<b>Quelle titre voulez vous supprimer ou ajouter?</b><br>

	<label for="titreC">Titre de la Chanson: </label>
	<input type="text" name="titreC" id="titreC" placeholder="" required />
	<br>
	<input type="submit" name="Ajouter" value="Ajouter"/>
	<br>
	<input type="submit" name="Supprimer" value="Supprimer"/>
</form>
<br>
<br>

<b>Quelle playlists voulez-vous comparer?</b>
<form method="post" action="#">
	<label for="titreListe1">Titre de la première liste: </label>
	<input type="text" name="titreListe1" id="titreListe1" placeholder="" required />
	<br/><br/>

	<label for="titreListe2">Titre de la deuxième liste: </label>
	<input type="text" name="titreListe2" id="titreListe2" placeholder="" required />
	<br>
	<input type="submit" name="Comparer" value="Comparer"/>
	<br>
</form>



