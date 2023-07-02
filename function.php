<?php

function is_admin_login()
{
	if(isset($_SESSION['admin_email']))
	{
		return true;
	}
	return false;
}



?>