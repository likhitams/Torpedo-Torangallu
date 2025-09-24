<?php

function updatepassword($password)
	{
	
		require_once 'includes/PkcsKeyGenerator.php';
		require_once 'includes/DesEncryptor.php';
		require_once 'includes/PbeWithMd5AndDes.php';
			
		$salt ='A99BC8325634E303';
	
		// Iteration count
		$iterations = 19;
		$segments = 1;
 		//secret key
		$keystring = 'akd89343My Pass Phrase';
			
		//encrypt the user entered password
		$crypt = PbeWithMd5AndDes::encrypt(
					$password, $keystring,
					$salt, $iterations, $segments
				);
	
		
	
		return $crypt;
	
	}
	
 echo updatepassword('jswm');


/*

cd E:\wamp\www\repjswlnewk>

e:\wamp\bin\php\php5.6.40\php.exe passwd.php



*/
?>


