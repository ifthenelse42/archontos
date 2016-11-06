<?php

namespace App\Repository\Forum;

class Quotes
{
	public function get()
	{
		$select = rand(0,5);


		switch($select)
		{
			case 5:
				$message = 'If liberty means anything at all, it means the right to tell people what they do not want to hear.';
				$autor = 'George Orwell';
			break;

			case 4:
				$message = 'I may not agree with you, but I will defend to the death your right to make an ass of yourself.';
				$autor = 'Oscar Wilde';
			break;

			case 3:
				$message = 'Hypocrites get offended by the truth.';
				$autor = 'Jess C. Scott, Bad Romance: Seven Deadly Sins Anthology';
			break;

			case 2:
				$message = 'Freedom of speech does not protect you from the consequences of saying stupid shit.';
				$autor = 'Jim C. Hines';
			break;

			case 1:
				$message = 'Give me the liberty to know, to utter, and to argue freely according to conscience, above all liberties.';
				$autor = 'John Milton, Areopagitica';
			break;

			default:
				$message = 'I disapprove of what you say, but I will defend to the death your right to say it.';
				$autor = 'S.G. Tallentyre, The Friends of Voltaire';
			break;
		}

		$quote = '<blockquote class="blockquote-reverse">
		<p>'.$message.'</p>
		<footer>'.$autor.'</footer>
		</blockquote>';

		return $quote;
	}
}
