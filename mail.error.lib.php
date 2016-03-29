<?php

/* detection_erreur */

 function mail_detect_erreur($email, $debug = false)
 	{
 	// Miniscule
 	$email = strtolower($email);

 	// On replace les erreur courantes
 	$email = str_replace('#', '@', $email);
 	$email = str_replace(']', '@', $email);
 	$email = str_replace('ˆ', '@', $email);
 	$email = str_replace(',', '.', $email);
 	$email = str_replace('..', '.', $email);
 	$email = str_replace('gmail.fr', 'gmail.com', $email);
 	$email = str_replace('proxad.net', 'free.fr', $email);

	// On decoupe l'email
	list($user, $domaine) = explode("@", $email);

	// Le domaine

		$domaine = str_replace(' ', '', $domaine);

		// On le decoupe
		$ext = explode('.', $domaine);
		// Cas particulier
		if($ext[0] == 'orange')
			{
			$ext[1] = 'fr';
			$domaine = $ext[0].'.'.$ext[1];
			}
		if($ext[0] == 'gmail')
			{
			$ext[1] = 'com';
			$domaine = $ext[0].'.'.$ext[1];
			}
		if(empty($ext[1]))
			{
			$ext = '.fr';
			$fai = $domaine;
			}
		if(count($ext)==1)
			{
			$ext = '.fr';
			$fai = $domaine;
			}
		elseif(count($ext)>1)
			{
			$ext = '.'.end($ext);
			$fai = str_ireplace($ext, '', $domaine);
			}

		// le FAI



			// la poste
			$bad_domaine["lapostee"] = "laposte";

			// Numericable
			$bad_domaine["numericabl"] = "numericable";
			$bad_domaine["numericablefr"] = "numericable";
			$bad_domaine["numericablle"] = "numericable";
			$bad_domaine["numericbale"] = "numericable";
			// Orange
			$bad_domaine["orangr"] = "orange";
			$bad_domaine["orang"] = "orange";
			$bad_domaine["orangefr"] = "orange";
			$bad_domaine["orangfr"] = "orange";
			$bad_domaine["orang"] = "orange";
			$bad_domaine["orande"] = "orange";
			$bad_domaine["orangz"] = "orange";
			$bad_domaine["ornage"] = "orange";
			$bad_domaine["ornage"] = "orange";
			$bad_domaine["prange"] = "orange";
			$bad_domaine["ornge"] = "orange";
			$bad_domaine["oranga"] = "orange";
			$bad_domaine["orangr"] = "orange";
			$bad_domaine["oranges"] = "orange";
			$bad_domaine["oranges"] = "orange";
			$bad_domaine["orange"] = "orange";
			$bad_domaine["ofrange"] = "orange";

			// Free
			$bad_domaine["fre"] = "free";
			$bad_domaine["frer"] = "free";
			$bad_domaine["freefr"] = "free";
			$bad_domaine["afree"] = "free";

			// Wanadoo
			$bad_domaine["wanadoi"] = "wanadoo";
			$bad_domaine["anadoo"] = "wanadoo";
			$bad_domaine["wanaddo"] = "wanadoo";
			$bad_domaine["wanadoo.r"] = "wanadoo";
			$bad_domaine["wanadoofr"] = "wanadoo";
			$bad_domaine["wyanadoo"] = "wanadoo";
			$bad_domaine["wandoo"] = "wanadoo";
			$bad_domaine["wnadoo"] = "wanadoo";

			// LIve / hotmail
			$bad_domaine["hotmaifr"] = "hotmail";
			$bad_domaine["hotmail"] = "hotmail";
			$bad_domaine["hotmai"] = "hotmail";
			$bad_domaine["hohtmail"] = "hotmail";
			$bad_domaine["hotailmait"] = "hotmail";
			$bad_domaine["hotmailfr"] = "hotmail";
			$bad_domaine["hotùail"] = "hotmail";
			$bad_domaine["hotmail"] = "hotmail";
			$bad_domaine["hotmaim"] = "hotmail";
			$bad_domaine["hotmain"] = "hotmail";
			$bad_domaine["liv"] = "live";
			$bad_domaine["ive"] = "live";
			$bad_domaine["livz"] = "live";
			$bad_domaine["livefr"] = "live";
			$bad_domaine["outluok"] = "outlook";

			// Gmail
			$bad_domaine["gmil"] = "gmail";
			$bad_domaine["gmal"] = "gmail";
			$bad_domaine["gmel"] = "gmail";
			$bad_domaine["gmaille"] = "gmail";
			$bad_domaine["gmial"] = "gmail";
			$bad_domaine["gmiql"] = "gmail";
			$bad_domaine["gmqil"] = "gmail";
			$bad_domaine["gemail"] = "gmail";
			$bad_domaine["gmailcom"] = "gmail";
			$bad_domaine["gmaol"] = "gmail";
			$bad_domaine["glail"] = "gmail";

			// BBOX
			$bad_domaine["box"] = "bbox";

			// Yahoo
			$bad_domaine["yahooo"] = "yahoo";
			$bad_domaine["yaoo"] = "yahoo";
			$bad_domaine["yhahoo"] = "yahoo";
			$bad_domaine["yahoo-fr"] = "yahoo";
			$bad_domaine["yhahoo"] = "yahoo";

			// sfr
			$bad_domaine["sf"] = "sfr";
			$bad_domaine["lsfr"] = "sfr";
			$bad_domaine["fr"] = "sfr";
			$bad_domaine["neuffr"] = "neuf";
			$bad_domaine["nruf"] = "neuf";

			// Voila
			$bad_domaine["voiloa"] = "voila";
			$bad_domaine["viola"] = "voila";

			// Club internet
			$bad_domaine["clib-internet"] = "club-internet";
			$bad_domaine["clubinternet"] = "club-internet";
			$bad_domaine["club-internet"] = "club-internet";
			$bad_domaine["club-interne"] = "club-internet";
			$bad_domaine["club_internet"] = "club-internet";

			// Autres
			$bad_domaine["librtysurf"] = "libertysurf";
			$bad_domaine["alicedasl"] = "aliceadsl";

			// Apple
			$bad_domaine["iclou"] = "icloud";

			// On met ˆ jour le domaine
			foreach($bad_domaine as $key => $value)
				{
				if($fai == $key)
					{

					if($debug) echo $key." -> ".$value;
					$fai = $value;
					}
				}

		// Extensions

			// .FR
			$bad_extension[".frr"] = ".fr";
			$bad_extension[".frf"] = ".fr";
			$bad_extension[".frt"] = ".fr";
			$bad_extension[".ffr"] = ".fr";
			$bad_extension[".ffp"] = ".fr";
			$bad_extension[".rfr"] = ".fr";
			$bad_extension[".fre"] = ".fr";
			$bad_extension[".fra"] = ".fr";
			$bad_extension[".frd"] = ".fr";
			$bad_extension[".frR"] = ".fr";
			$bad_extension[".fru"] = ".fr";
			$bad_extension[".fixe"] = ".fr";
			$bad_extension[".frh"] = ".fr";
			$bad_extension[".france"] = ".fr";
			$bad_extension[".fr1"] = ".fr";
			$bad_extension[".fe"] = ".fr";
			$bad_extension[".ft"] = ".fr";
			$bad_extension[".fri"] = ".fr";
			$bad_extension[".frfr"] = ".fr";
			$bad_extension[".fraupoint"] = ".fr";
			$bad_extension[".ff"] = ".fr";
			$bad_extension[".rr"] = ".fr";
			$bad_extension[".frtfr"] = ".fr";
			$bad_extension[".fgr"] = ".fr";
			$bad_extension[".fdr"] = ".fr";
			$bad_extension[".f"] = ".fr";
			$bad_extension[".fdr"] = ".fr";
			$bad_extension[".frp"] = ".fr";
			$bad_extension[".cfr"] = ".fr";

			// .COM
			$bad_extension[".cop"] = ".com";
			$bad_extension[".cpm"] = ".com";
			$bad_extension[".comr"] = ".com";
			$bad_extension[".comp"] = ".com";
			$bad_extension[".coml"] = ".com";
			$bad_extension[".com11"] = ".com";
			$bad_extension[".ciom"] = ".com";
			$bad_extension[".cim"] = ".com";
			$bad_extension[".cil"] = ".com";
			$bad_extension[".ccom"] = ".com";
			$bad_extension[".om"] = ".com";
			$bad_extension[".col"] = ".com";
			$bad_extension[".cm"] = ".com";
			$bad_extension[".con"] = ".com";
			$bad_extension[".comet"] = ".com";
			$bad_extension[".c"] = ".com";
			$bad_extension[".comla"] = ".com";
			$bad_extension[".co"] = ".com";
			$bad_extension[".comv"] = ".com";
			$bad_extension[".comc"] = ".com";

			// .NET
			$bad_extension[".et"] = ".net";
			$bad_extension[".netiou"] = ".net";
			$bad_extension[".ten"] = ".net";
			$bad_extension[".ent"] = ".net";
			$bad_extension[".ner"] = ".net";
			$bad_extension[".ney"] = ".net";
			$bad_extension[".neg"] = ".net";
			$bad_extension[".nety"] = ".net";
			$bad_extension[".nrt"] = ".net";

			// On met ˆ jour le extension
			foreach($bad_extension as $key => $value)
				{
				if($ext == $key)
					$ext = $value;
				}

	// User
		$user = str_replace(' ', '.', $user);
		$user = vireaccent($user);

	// Nouvel email
		$new_email = trim($user.'@'.$fai.''.$ext);
		$new_email = str_replace('..', '.', $new_email);

	// Hack Gmail
		$new_email = str_replace('@gmail.fr', '@gmail.com', $new_email);
		$new_email = str_replace('@cegetel.fr', '@cegetel.net', $new_email);

	if($debug) echo "Email : $email / User : $user / Domaine : $domaine / FAI : $fai / Extension : $ext / Nouvel email : $new_email\n";
	return($new_email);
 	}

?>