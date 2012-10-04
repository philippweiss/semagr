<?

	ini_set('memory_limit', '4096M');
	ini_set('max_execution_time', 0);
	
	include_once('simple_html_dom.php');
	include('functions.php');

	dbconnect();
	$kursanzahl = 0;
	$uni = 'Wirtschaftsuniversität Wien';
	mysql_query('insert into uni (title) values ("'.$uni.'")');

	$html = file_get_html('http://vvz.wu.ac.at/cgi-bin/vvz.pl?LV=3;L2=38107;L3=38079;S=12W;LANG=DE');

	foreach($html->find('li[class=sub2]') as $studienrichtung){

		echo $studienrichtung->children(0)->plaintext.'</br>';
		$currentstudienrichtung = $studienrichtung->children(0)->plaintext;
		mysql_query('insert into studienrichtung (title) values("'.$currentstudienrichtung.'")');
		$link = $studienrichtung->children(0)->href;
		$html = file_get_html('http://vvz.wu.ac.at'.$link);

		foreach($html->find('li[class=sub1]') as $studienzweig){

			echo $studienzweig->children(0)->plaintext.'</br>';
			$currentstudienzweig = $studienzweig->children(0)->plaintext;
			mysql_query('insert into studienrichtung (title) values("'.$currentstudienzweig.'")');
			$link = $studienzweig->children(0)->href;
			$html = file_get_html('http://vvz.wu.ac.at'.$link);

			foreach($html->find('li[class=sub2]') as $studienfach){

				echo $studienfach->children(0)->plaintext.'</br>';
				$currentstudienfach = $studienfach->children(0)->plaintext;
				mysql_query('insert into studienrichtung (title) values("'.$currentstudienfach.'")');
				$link = $studienfach->children(0)->href;
				$html = file_get_html('http://vvz.wu.ac.at'.$link);

				foreach($html->find('li[class=pfeilblaulink]') as $studienplanpunkt){

					echo $studienplanpunkt->children(0)->plaintext.'</br>';
					$currentstudienplanpunkt = $studienplanpunkt->children(0)->plaintext;
					mysql_query('insert into studienrichtung (title) values("'.$currentstudienplanpunkt.'")');
					$link = $studienplanpunkt->children(0)->href;
					$html = file_get_html('http://vvz.wu.ac.at'.$link);

					foreach($html->find('td[class=vvzc1]') as $kurs){

						//echo $kurs->children(0)->plaintext.'</br>';
						$kursanzahl += 1;
						$link = $kurs->children(0)->href;
						$html = file_get_html('http://vvz.wu.ac.at'.$link);

						$spantext = $html->find('span[class=text]');
				
						$id =  $spantext[0]->children(0)->children(1)->children(0)->plaintext;
						$type = $spantext[0]->children(0)->children(1)->children(1)->plaintext;
						$title = $spantext[0]->children(0)->children(1)->children(3)->children(0)->plaintext;
						$table2 = $spantext[0]->children(2);
				
						foreach($table2->find('td') as $cell){

							if($cell->plaintext == 'LV-Leiter/in'){

								$neighbour = $cell->next_sibling();
								$lecturer = $neighbour;
							}
							if($cell->plaintext == 'Planpunkte Bachelor'){

									$neighbour = $cell->next_sibling();
									$subject = $neighbour;
							}
							if($cell->plaintext == 'Semesterstunden'){

									$neighbour = $cell->next_sibling();
									$sst = $neighbour->plaintext;
							}
							if($cell->plaintext == 'Unterrichtssprache'){

									$neighbour = $cell->next_sibling();
									$language = $neighbour->plaintext;
							}
						}

						echo $id.'</br>';
						echo $type.'</br>';
						echo $title.'</br>';

						if(isset($lecturer)){
							
							foreach($lecturer->find('a') as $l){

								echo $l->plaintext.'</br>';
							}
						}

						if(isset($subject)){
								
							foreach($subject->find('a') as $s){

								echo $s->plaintext.'</br>';
							}
						}
						if(isset($sst)){

							echo $sst.'</br>';
						}
						if(isset($language)){

							echo $language.'</br>';
						}

					}
				}
			}
		}
	}

	//end of crawling

	echo $kursanzahl . " kurse gefunden.";
?>



