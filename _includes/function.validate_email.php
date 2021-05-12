<?php
/**
 * jobber job board platform
 *
 * @author     Filip C.T.E. <http://www.filipcte.ro> <me@filipcte.ro>
 * @license    You are free to edit and use this work, but it would be nice if you always referenced the original author ;)
 *             (see license.txt).
 * 
 * Function validates an e-mail address
 *
 * @param string $string		E-mail address to be validated
 */

function validate_email($string) 
{
	$string = trim($string);
	if(preg_match("/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i", $string))
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>