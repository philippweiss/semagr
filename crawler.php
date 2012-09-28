<?

	
	include_once('simple_html_dom.php');

//test commit -a -m with 2 files
	for($i=1; $i<100; $i++){

	$html = file_get_html('http://vvz.wu.ac.at/cgi-bin/vvz.pl?C=S&LANG=DE&S=12W&LV=3&L2=S&L3=S&T=&L=&I='.$i.'&JOIN=AND');

	if(stripos($html->plaintext, 'Keine Lehrveranstaltungen gefunden!') === false){


		$spantext = $html->find('span[class=text]');

		$id =  $spantext[0]->children(0)->children(1)->children(0)->plaintext;
		$type = $spantext[0]->children(0)->children(1)->children(1)->plaintext;
		$title = $spantext[0]->children(0)->children(1)->children(3)->children(0)->plaintext;
		$lecturer = $spantext[0]->children(2)->children(0)->children(1);
		


		if($spantext[0]->children(2)->children(1)->children(0)->plaintext == 'Planpunkte Bachelor'){

			$subject = $spantext[0]->children(2)->children(1)->children(1)->plaintext;
		}

		$subject = $spantext[0]->children(2)->children(1)->children(1)
		$sst = $spantext[0]->children(2)->children(2)->children(1);
		$language = $spantext[0]->children(2)->children(3)->children(1);

		echo $id.'</br>';
		echo $type.'</br>';
		echo $title.'</br>';

		foreach($lecturer->find('a') as $l){

			echo $l->plaintext .'</br>';
		}

		foreach($subject->find('a') as $s){

			echo $s->plaintext .'</br>';
		}

		echo $sst.'</br>';
		echo $language.'</br>';

		echo '</br></br>';

		}
		else{

			
		}
	




	}
?>