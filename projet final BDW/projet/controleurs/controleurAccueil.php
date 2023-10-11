<?php
		$nbm = countInstances($connexion, "CHANSON");
		if($nbm <= 0){
			$message1 ="$nbm chanson n'a été trouvée dans la base de données !";
		}
		else{
			$message1 = "Actuellement il y a $nbm chansons dans la base.";
		}
		
		$nbv =countInstances($connexion, "VERSION");
		if($nbv <= 0){
			$message2 = "$nbv version de chanson n'a été trouvée dans la base de données !";
		}
		else{
			$message2 = "Actuellement il y a $nbv versions dans la base.";
		}
		
		$nbg =countInstances($connexion, "GENRE");
		if($nbg <= 0){
			$message3 = "$nbg genre n'a été trouvée dans la base de données !";
		}
		else{
			$message3 = "Actuellement il y a $nbg genres dans la base.";
		}
		$nbgr =countInstances($connexion, "GROUPE");
		if($nbgr <= 0){
			$message4 = "$nbgr groupe n'a été trouvée dans la base de données !";
		}
		else{
		   $message4 = "Actuellement il y a $nbgr groupes de musiciens dans la base.";
		}
		
		

	?>




