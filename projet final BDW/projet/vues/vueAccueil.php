<main>
	
	
	<img widthsrc ="https://www.google.com/imgres?imgurl=https%3A%2F%2Fwww.aquaportail.com%2Fpictures1106%2Fanemone-clown_1307889811-fleur.jpg&imgrefurl=https%3A%2F%2Fwww.aquaportail.com%2Fdefinition-7708-fleur.html&tbnid=oXP1oMRgh6IWEM&vet=12ahUKEwiUgOvdhf76AhWCnCcCHUOKDL4QMygEegUIARDqAQ..i&docid=cLiW60pwgpwvvM&w=1280&h=960&q=une%20fleur&ved=2ahUKEwiUgOvdhf76AhWCnCcCHUOKDL4QMygEegUIARDqAQ" /img> 

	
	<div><p><?= $message1 ?></p></div>
	<div><p><?= $message2 ?></p></div>
	<div><p><?= $message3 ?></p></div>
	<div><p><?= $message4 ?></p></div>

	
	<br><br>
	
	<b>LE TOP 5 DES GENRES:</b>
	
	<br>
	
	<table>
	<thead>
		<tr>
		<th> Les genres </th>
		<th>nombre de Chansons ayanat ce genre </th>
		</tr>
	</thead>
	
	<tbody>
		<?php
			$req=top5genre($connexion);
			while($row=mysqli_fetch_assoc($req)){
				echo "<tr>
				<td>". $row['genreG'] ."</td>
				<td>". $row['nbgenre'] ."</td></tr>";
			}
		
		?>
	</tbody>
	
</table>
<br>
<br>

	<b>LE GROUPE FAVORI : </b>
	<?php
		$reqgroupefav=groupefavori($connexion);
		while($rowfav=mysqli_fetch_assoc($reqgroupefav)){
			echo" ".$rowfav['nomG']." <br><br>";
		}
	?>

	<div><p>Notre plateforme vous permet de trouver les chansons de vos artistes préférés!<br>
	Tu trouveras sûrement ton bonheur avec nos playlistes uniques. Laisse-toi envelopper par le son de la musique en écoutant des albums dédiés rien que pour toi.<br>
	Une expérience musicale sans égale... et tout cela gratuitement sur R&J MUSIC.
	</p></div>
	
	<img src="https://www.bloomberg.com/graphics/pop-star-ranking/img/pop-star-ranking-2020-04-twitter.jpg" width=50% height=30% align="center">
	
</main>






