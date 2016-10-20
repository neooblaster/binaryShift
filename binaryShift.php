<?php//TabSize=3
/** -------------------------------------------------------------------------------------------------------------------- ** 
/** -------------------------------------------------------------------------------------------------------------------- ** 
/** ---																																					--- **
/** --- 										------------------------------------------------											--- **
/** ---															{ binaryShift.php }																--- **
/** --- 										------------------------------------------------											--- **
/** ---																																					--- **
/** ---		AUTEUR			: Nicolas DUPRE																									--- **
/** ---																																					--- **
/** ---		RELEASE			: 08.09.2016																										--- **
/** ---																																					--- **
/** ---		FILE_VERSION	: 1.0 NDU																											--- **
/** ---																																					--- **
/** ---																																					--- **
/** --- 														---------------------------														--- **
/** ---															{ C H A N G E L O G }															--- **
/** --- 														---------------------------														--- **
/** ---																																					--- **
/** ---																																					--- **
/** ---		VERSION 1.0 : 08.09.2016 : NDU																									--- **
/** ---		------------------------------																									--- **
/** ---			- Première release																												--- **
/** ---																																					--- **
/** -------------------------------------------------------------------------------------------------------------------- **
/** -------------------------------------------------------------------------------------------------------------------- **

	Requirements :
	--------------
	
		- None


	Input Params :
	--------------
	
		String $bin,
		Integer $offset
	
	
	Output Params :
	---------------
	
		String 


	Objectif du script :
	---------------------
	
		L'objectif du script est d'effectuer les opération binaire SHR et SHL dont la notation est la suivante :
			x >> n
			x << n
			
		Dont l'opération effectué sur une chaine visualisable en Hex renvoyait 30 au lieu de l'opération juste tel que le fait C++
	
	
	Description fonctionnelle :
	----------------------------

/** -------------------------------------------------------------------------------------------------------------------- **
/** -------------------------------------------------------------------------------------------------------------------- **/
/** --- Fonction maitre --- **/
/** ----------------------- **/
function binaryShift($bin, $offset, $way){
	/** Convertis la variable en entrée en Hexadécimal **/
	$hex = bin2hex($bin);
	
	
	/** Il faut que celle-ci soit paire - On complète la chaine hexa **/
	if(strlen($hex) % 2){
		$hex = "0".$hex;
	}
	
	
	/** Sur la base du C++, on reverse la chaine pour effectuer correctement l'opération SHx **/
	$reverse_hex = null;
	
	for($r = strlen($hex); $r >= 0; $r -= 2){
		$reverse_hex .= substr($hex, $r, 2);
	}
	
	
	/** Convertion de la chaine en binaire (0 et 1) **/
	$binary = null;
	for($i = 0; $i < strlen($reverse_hex); $i += 2){
		$dec = hexdec(substr($reverse_hex, $i, 2));
		
		$bitbinary = sprintf('%08s', decbin($dec));
		$binary .= $bitbinary;
	}
	
	
	/** Memorisation de la longeur de la chaine binaire **/
	$binary_length = strlen($binary);
	
	
	/** Ajouter autant de 0 que vaut l'offset fourni **/
	$fill = null;
	for($f = 0; $f < $offset; $f++){
		$fill .= '0';
	}
	
	
	/** Ajouter le complément du côté souhaité **/
	// On ajout le nombre de zéro voulu
	// On tronque la chaine à la taille mémorisé
	// Le valeur tronqué sont perdu (c'est normal)
	$binary_shift = null;
	switch(strtolower($way)){
		case 'right':
			$binary_shift = $fill.$binary;
			$binary_shift = substr($binary_shift, 0, $binary_length);
		break;
		case 'left':
			$binary_shift = $binary.$fill;
			$binary_shift = substr($binary_shift, $offset);
		break;
	}
	
	
	/** Restituation au format Hexadécimal **/
	$shr_hex = null;
	for($b = 0; $b < strlen($binary_shift); $b += 8){
		$shr_hex .= dechex(bindec(substr($binary_shift, $b, 8)));
	}
	
	/** On complète la chaine hexa pour qu'elle soit de taille paire **/
	if(strlen($shr_hex) % 2){
		$shr_hex = "0".$shr_hex;
	}
	
	/** on reverse la chaine pour qu'elle soit dans le bon sens **/
	$reverse_shr_hex = null;
	
	for($r = strlen($shr_hex); $r >= 0; $r -= 2){
		$reverse_shr_hex .= substr($shr_hex, $r, 2);
	}
	
	return hex2bin($reverse_shr_hex);
}


/** --------------------------------- **/
/** --- Fonction Diffusée (Alias) --- **/
/** --------------------------------- **/
/** Bitiwise Shift Right  **/
function binshr($bin, $offset){
	return binaryShift($bin, $offset, 'right');
}

/** Bitwise Shift Left **/
function binshl($bin, $offset){
	return binaryShift($bin, $offset, 'left');
}
?>
