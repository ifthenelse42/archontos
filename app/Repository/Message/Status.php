<?php

namespace App\Repository\Message;

// Chargement de la base de donnée
use DB;

class Status
{
	public function get($status)
	{
		if($status == 0)
		{
			return 'well-erty';
		}

		else
		{
			return 'well';
		}
	}
}
