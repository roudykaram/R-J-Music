

<h2>Création d'une liste de lecture</h2>

<form method="post" action="#">	
	<label for="dureeL">La durée de la playliste</label>
	<input type=text name="dureeL" id="dureeL" value="20" placeholder="">
	<br/><br/>
	<label for="genreL">Le genre des chansons</label>
	<input type=text name="genreL" id="genreL">
	<br/><br/>
	<label for="titreL">Le titre de la liste de lecture</label>
	<input type=text name="titreL" id="titreL">
	<br/><br/>
	<legend> Filtrez vos chansons </legend>
	<br/><br/>
	<input type=radio name="pref" id="jouee" value="jouee">
    <label for="jouee">les chansons les plus jouées</label>
	<br/><br/>
    <input type=radio name="pref" id="sautee" value="sautee">
	<label for="sautee">les chansons les plus sautées</label>
	<br/><br/>
    <input type=radio name="pref" id="recent" value="recent">
	<label for="recent">les chansons jouées le plus récement</label>
	<br/><br/>
	<label for="pourcentage">Le pourcentage </label>
	<input type=text name="pourcentage" id="pourcentage">
	<br/><br/>
	<input type="submit" name="Creer" value="Creer"/>
	<br/><br/>
	
	
</form>

