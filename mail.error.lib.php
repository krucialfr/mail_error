<?php

/* detection_erreur */

function mail_detect_del_accent($chaine)
	{
	// On supprime les accents
	$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
	$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
	return(strtr($chaine,$tofind,$replac));
	}

function mail_detect_nettoyage_de_mot($mot, $lettres_admises, $espace=false)
	{
	// On nettoie les caracteres chelous
	// $espace = true -> on remplace les caractere chelou par des espaces

	$ok_chaine = '';
	$mot = strtolower($mot);
	$mot = vireaccent($mot);
	for($a=0;$a<strlen($mot);$a++)
		{
		if(strpos($lettres_admises, $mot[$a]) !== false)
			{
			$ok_chaine .= $mot[$a];
			}
		elseif($espace)
			{
			$ok_chaine .= " ";
			}
		}

	if($espace)
		{
		// ON vire les doubles espaces
		$ok_chaine = preg_replace ("/\s+/", " ", $ok_chaine);
		}
	return($ok_chaine);
	}

 function mail_detect_erreur($email, $debug = false)
 	{
 	// Miniscule

 		$email = strtolower($email);

 	// Extensions à deux elements

 		$ext_spe = array(".co.uk");

 	// Domaine a ne pas toucher

 		$ok_domaine = array("fr.st" => true, "fr.fm" => true);

 	// On replace les erreur courantes

	 	$new_email = str_replace('#', '@', $email);
	 	$new_email = str_replace(']', '@', $new_email);
	 	$new_email = str_replace('ˆ', '@', $new_email);
	 	$new_email = str_replace(',', ' ', $new_email);
	 	$new_email = str_replace('..', ' ', $new_email);
	 	$new_email = str_replace('  ', ' ', $new_email);
	 	$new_email = mail_detect_del_accent($new_email);
	 	$new_email = mail_detect_nettoyage_de_mot($new_email, 'abcdefghijklmnopqrstuvwxyz0123456789-_ .@+');

	// On decoupe l'email

		list($user, $domaine) = explode("@", $new_email);
		$domaine = str_replace(' ', '', $domaine);

		// On vire le dernier point (et le premier)
		$domaine = preg_replace('|(.*)\.$|', "$1", $domaine);
		$domaine = preg_replace('|^\.(.*)|', "$1", $domaine);
		$domaine_element = explode('.', $domaine);

		if(count($domaine_element) == 1)
			{
			$extension = '';
			$serveur = $domaine_element[0];
			}
		else
			{
			// Extension
				$extension = $domaine_element[count($domaine_element)-1];
				$ext_element_nb = 1;
				for($a=0;$a<count($ext_spe);$a++)
					{
					if(stripos(' '.$domaine, $ext_spe[$a])>0)
						{
						$extension = $domaine_element[count($domaine_element)-2].'.'.$domaine_element[count($domaine_element)-1];
						$ext_element_nb = 2;
						}
					}

			// Serveur
				$serveur = '';
				for($a=0;$a<(count($domaine_element)-$ext_element_nb);$a++)
					{
					if(!empty($domaine_element[$a]))
						{
						if($a > 0)
							$serveur .= '.';
						$serveur .= $domaine_element[$a];
						}
					}
				//echo $serveur.' / '.$extension."\n";

			$user = trim($user);
			$serveur = trim($serveur);
			$extension = trim($extension);
			}

	// On regarde si c'est pas en whitelist

		$traite = true;
		if($ok_domaine[$domaine])
			{
			$traite = false;
			}

	// Le domaine

		if($traite)
			{

			// Cas particulier

				if(empty($extension))
					{
					// Pas d'extension, on place du .fr
					$extension = '.fr';
					}

			// le FAI

				// la poste

					$bad_domaine["lapostee"] = "laposte";
					$bad_domaine["lapostenet"] = "laposte";
					$bad_domaine["laposte-net"] = "laposte";
					//$force_extension["laposte"] = 'net';

				// Numericable

					$bad_domaine["numericabl"] = "numericable";
					$bad_domaine["numericablefr"] = "numericable";
					$bad_domaine["numericablle"] = "numericable";
					$bad_domaine["numericbale"] = "numericable";
					$bad_domaine["numericable-fr"] = "numericable";

				// Orange

					$bad_domaine["orangr"] = "orange";
					$bad_domaine["orang"] = "orange";
					$bad_domaine["orangefr"] = "orange";
					$bad_domaine["orangf"] = "orange";
					$bad_domaine["orangfr"] = "orange";
					$bad_domaine["orang"] = "orange";
					$bad_domaine["orande"] = "orange";
					$bad_domaine["orangz"] = "orange";
					$bad_domaine["ornage"] = "orange";
					$bad_domaine["ornage"] = "orange";
					$bad_domaine["prange"] = "orange";
					$bad_domaine["range"] = "orange";
					$bad_domaine["ornge"] = "orange";
					$bad_domaine["oranga"] = "orange";
					$bad_domaine["orangr"] = "orange";
					$bad_domaine["oranges"] = "orange";
					$bad_domaine["orange-fr"] = "orange";
					$bad_domaine["orange-com"] = "orange";
					$bad_domaine["oranges"] = "orange";
					$bad_domaine["orange"] = "orange";
					$bad_domaine["ofrange"] = "orange";
					$bad_domaine["erange"] = "orange";

				// Free

					$bad_domaine["fre"] = "free";
					$bad_domaine["frer"] = "free";
					$bad_domaine["free-fr"] = "free";
					$bad_domaine["freefr"] = "free";
					$bad_domaine["afree"] = "free";
					$bad_domaine["onlinefr"] = "online";
					$bad_domaine["proxad"] = "free";
					$force_extension["free"] = 'fr';
					$force_extension["online"] = 'fr';

				// Wanadoo

					$bad_domaine["wanadoi"] = "wanadoo";
					$bad_domaine["wanadou"] = "wanadoo";
					$bad_domaine["wanado"] = "wanadoo";
					$bad_domaine["anadoo"] = "wanadoo";
					$bad_domaine["wanaddo"] = "wanadoo";
					$bad_domaine["wanadoo.r"] = "wanadoo";
					$bad_domaine["wanadoofr"] = "wanadoo";
					$bad_domaine["wanadoo-fr"] = "wanadoo";
					$bad_domaine["wyanadoo"] = "wanadoo";
					$bad_domaine["wandoo"] = "wanadoo";
					$bad_domaine["wnadoo"] = "wanadoo";
					$force_extension["wanadoo"] = 'fr';

				// LIve / hotmail

					$bad_domaine["hotmaifr"] = "hotmail";
					$bad_domaine["hotmai-fr"] = "hotmail";
					$bad_domaine["hotmai-com"] = "hotmail";
					$bad_domaine["hotmail"] = "hotmail";
					$bad_domaine["hotmai"] = "hotmail";
					$bad_domaine["hogmail"] = "hotmail";
					$bad_domaine["hohtmail"] = "hotmail";
					$bad_domaine["hotailmait"] = "hotmail";
					$bad_domaine["htmail"] = "hotmail";
					$bad_domaine["hotmailfr"] = "hotmail";
					$bad_domaine["hotuail"] = "hotmail";
					$bad_domaine["hotamil"] = "hotmail";
					$bad_domaine["hotamail"] = "hotmail";
					$bad_domaine["h0tmail"] = "hotmail";
					$bad_domaine["hotmail"] = "hotmail";
					$bad_domaine["htomail"] = "hotmail";
					$bad_domaine["otmail"] = "hotmail";
					$bad_domaine["hotmaim"] = "hotmail";
					$bad_domaine["hotmain"] = "hotmail";
					$bad_domaine["homtail"] = "hotmail";
					$bad_domaine["homail"] = "hotmail";
					$bad_domaine["hotrmail"] = "hotmail";
					$bad_domaine["hortmail"] = "hotmail";
					$bad_domaine["hotm"] = "hotmail";
					$bad_domaine["liv"] = "live";
					$bad_domaine["ive"] = "live";
					$bad_domaine["livz"] = "live";
					$bad_domaine["livefr"] = "live";
					$bad_domaine["outluok"] = "outlook";

				// Gmail

					$bad_domaine["gmil"] = "gmail";
					$bad_domaine["gmai"] = "gmail";
					$bad_domaine["g-mail"] = "gmail";
					$bad_domaine["gail"] = "gmail";
					$bad_domaine["gmal"] = "gmail";
					$bad_domaine["gmel"] = "gmail";
					$bad_domaine["gmaille"] = "gmail";
					$bad_domaine["gmial"] = "gmail";
					$bad_domaine["gmiql"] = "gmail";
					$bad_domaine["gmqil"] = "gmail";
					$bad_domaine["gemail"] = "gmail";
					$bad_domaine["gmailcom"] = "gmail";
					$bad_domaine["gmail-com"] = "gmail";
					$bad_domaine["gmail-fr"] = "gmail";
					$bad_domaine["gmaol"] = "gmail";
					$bad_domaine["gmzil"] = "gmail";
					$bad_domaine["glail"] = "gmail";
					$force_extension["gmail"] = 'com';

				// BBOX

					$bad_domaine["box"] = "bbox";
					$force_extension["bbox"] = 'fr';

				// Yahoo

					$bad_domaine["yahooo"] = "yahoo";
					$bad_domaine["yaoo"] = "yahoo";
					$bad_domaine["yhahoo"] = "yahoo";
					$bad_domaine["yohoo"] = "yahoo";
					$bad_domaine["yahoo-fr"] = "yahoo";
					$bad_domaine["yahoofr"] = "yahoo";
					$bad_domaine["yhahoo"] = "yahoo";
					$bad_domaine["yaho"] = "yahoo";
					$bad_domaine["yhoo"] = "yahoo";
					$bad_domaine["yhaoo"] = "yahoo";
					$bad_domaine["ayhoo"] = "yahoo";

				// sfr

					$bad_domaine["sf"] = "sfr";
					$bad_domaine["lsfr"] = "sfr";
					$bad_domaine["sfr-fr"] = "sfr";
					$bad_domaine["sfrfr"] = "sfr";
					$bad_domaine["fr"] = "sfr";
					$force_extension["sfr"] = 'fr';

				// Neuf

					$bad_domaine["neuffr"] = "neuf";
					$bad_domaine["nruf"] = "neuf";
					$bad_domaine["neuf-fr"] = "neuf";
					$force_extension["neuf"] = 'fr';

				// Voila

					$bad_domaine["voiloa"] = "voila";
					$bad_domaine["viola"] = "voila";
					$bad_domaine["voila-fr"] = "voila";
					$force_extension["voila"] = 'fr';

				// Club internet

					$bad_domaine["clib-internet"] = "club-internet";
					$bad_domaine["clubinternet"] = "club-internet";
					$bad_domaine["club-internet"] = "club-internet";
					$bad_domaine["club-interne"] = "club-internet";
					$bad_domaine["club_internet"] = "club-internet";
					$force_extension["club-internet"] = 'fr';

				// Apple

					$bad_domaine["iclou"] = "icloud";
					$bad_domaine["icloud35"] = "icloud";
					$force_extension["icloud"] = 'com';

				// Autres

					$bad_domaine["librtysurf"] = "libertysurf";
					$force_extension["libertysurf"] = 'fr';
					$force_extension["cegetel"] = 'net';
					$bad_domaine["alicedasl"] = "aliceadsl";
					$force_extension["aliceadsl"] = 'fr';
					$bad_domaine["kynet"] = "skynet";

				// On met a jour le domaine
					if($debug) echo "On regarde les serveurs ...\n";
					foreach($bad_domaine as $key => $value)
						{
						if($serveur == $key)
							{

							if($debug) echo $key." -> ".$value;
							$serveur = $value;
							}
						}

				// On met a jour le domaine
					if($debug) echo "On regarde les extensions en fonction du nom de domaine ...\n";
					foreach($force_extension as $key => $value)
						{
						if($serveur == $key)
							{

							if($debug) echo $key." -> ".$value;
							$extension = $value;
							}
						}

			// Extensions

				// .FR

					$bad_extension["frr"] = "fr";
					$bad_extension["frf"] = "fr";
					$bad_extension["frt"] = "fr";
					$bad_extension["ffr"] = "fr";
					$bad_extension["ffp"] = "fr";
					$bad_extension["rfr"] = "fr";
					$bad_extension["fre"] = "fr";
					$bad_extension["fra"] = "fr";
					$bad_extension["frd"] = "fr";
					$bad_extension["frR"] = "fr";
					$bad_extension["fru"] = "fr";
					$bad_extension["fixe"] = "fr";
					$bad_extension["frh"] = "fr";
					$bad_extension["frl"] = "fr";
					$bad_extension["france"] = "fr";
					$bad_extension["fr1"] = "fr";
					$bad_extension["fe"] = "fr";
					$bad_extension["ft"] = "fr";
					$bad_extension["fri"] = "fr";
					$bad_extension["frfr"] = "fr";
					$bad_extension["fraupoint"] = "fr";
					$bad_extension["ff"] = "fr";
					$bad_extension["rr"] = "fr";
					$bad_extension["frtfr"] = "fr";
					$bad_extension["fgr"] = "fr";
					$bad_extension["fdr"] = "fr";
					$bad_extension["f"] = "fr";
					$bad_extension["fdr"] = "fr";
					$bad_extension["frp"] = "fr";
					$bad_extension["cfr"] = "fr";
					$bad_extension["dfr"] = "fr";
					$bad_extension["gouvfr"] = "gouv.fr";

				// .COM

					$bad_extension["cop"] = "com";
					$bad_extension["cpm"] = "com";
					$bad_extension["comr"] = "com";
					$bad_extension["comp"] = "com";
					$bad_extension["coml"] = "com";
					$bad_extension["com11"] = "com";
					$bad_extension["ciom"] = "com";
					$bad_extension["cim"] = "com";
					$bad_extension["cil"] = "com";
					$bad_extension["ccom"] = "com";
					$bad_extension["om"] = "com";
					$bad_extension["col"] = "com";
					$bad_extension["cm"] = "com";
					$bad_extension["con"] = "com";
					$bad_extension["comet"] = "com";
					$bad_extension["c"] = "com";
					$bad_extension["comla"] = "com";
					$bad_extension["co"] = "com";
					$bad_extension["comv"] = "com";
					$bad_extension["comc"] = "com";
					$bad_extension["comp"] = "com";

				// .NET

					$bad_extension["et"] = "net";
					$bad_extension["netiou"] = "net";
					$bad_extension["ten"] = "net";
					$bad_extension["ent"] = "net";
					$bad_extension["ner"] = "net";
					$bad_extension["ney"] = "net";
					$bad_extension["neg"] = "net";
					$bad_extension["nety"] = "net";
					$bad_extension["nrt"] = "net";

				// On met ˆ jour le extension

					if($debug) echo "On regarde les extensions ...\n";
					foreach($bad_extension as $key => $value)
						{
						if($extension == $key)
							$extension = $value;
						}

				// Derniers nettoyages

					// Email

						$new_email = trim($user.'@'.$serveur.'.'.$extension);

				}

		// User

			$new_email = str_replace(' ', '.', $new_email);
			$new_email = str_replace('..', '.', $new_email);
			$new_email = str_replace('._', '_', $new_email);
			$new_email = str_replace('_.', '_', $new_email);
			$new_email = str_replace('.fr.fr', '.fr', $new_email);
			$new_email = str_replace('.com.com', '.com', $new_email);

	if($debug) echo "Email : $email / User : $user / Domaine : $domaine / FAI : $serveur / Extension : $extension / Nouvel email : $new_email\n";
	return($new_email);
 	}

?>