<?

	ini_set('memory_limit', '4096M');
	ini_set('max_execution_time', 0);
	
	include_once('simple_html_dom.php');
	include('functions.php');

	dbconnect();
	$kursanzahl = 0;
	$uni = 'Wirtschaftsuniversität Wien';
	mysql_query('insert into uni (title) values ("'.$uni.'")');
	$uni_id = mysql_insert_id();

	$html = file_get_html('http://vvz.wu.ac.at/cgi-bin/vvz.pl?LV=3;L2=38107;L3=38079;S=12W;LANG=DE');

	foreach($html->find('li[class=sub2]') as $studienrichtung){

		echo $studienrichtung->children(0)->plaintext.'</br>';
		$currentstudienrichtung = $studienrichtung->children(0)->plaintext;
		mysql_query('insert into studienrichtung (title) values("'.$currentstudienrichtung.'")');
		$currentstudienrichtung_id = mysql_insert_id();
		mysql_query('insert into uni_studienrichtung (uni_id,studienrichtung_id) values ("'.$uni_id.'","'.$currentstudienrichtung_id.'")');
		$link = $studienrichtung->children(0)->href;
		$html = file_get_html('http://vvz.wu.ac.at'.$link);

		foreach($html->find('li[class=sub1]') as $studienzweig){

			echo $studienzweig->children(0)->plaintext.'</br>';
			$currentstudienzweig = $studienzweig->children(0)->plaintext;
			mysql_query('insert into studienzweig (title) values("'.$currentstudienzweig.'")');
			$currentstudienzweig_id = mysql_insert_id();
			mysql_query('insert into studienrichtung_studienzweig (studienrichtung_id,studienzweig_id) values ("'.$currentstudienrichtung_id.'","'.$currentstudienzweig_id.'")');
			$link = $studienzweig->children(0)->href;
			$html = file_get_html('http://vvz.wu.ac.at'.$link);

			foreach($html->find('li[class=sub2]') as $studienfach){

				echo $studienfach->children(0)->plaintext.'</br>';
				$currentstudienfach = $studienfach->children(0)->plaintext;
				mysql_query('insert into studienfach (title) values("'.$currentstudienfach.'")');
				$currentstudienfach_id = mysql_insert_id();
				mysql_query('insert into studienfach_studienzweig (studienfach_id,studienzweig_id) values ("'.$currentstudienfach_id.'","'.$currentstudienzweig_id.'")');
				$link = $studienfach->children(0)->href;
				$html = file_get_html('http://vvz.wu.ac.at'.$link);

				if($html->find('li[class=pfeilblaulink]')){ //planpunkte vorhanden

					
					//$needle = 'li[class=pfeilblaulink]';
					$studienplanpunkte = $html->find('li[class=pfeilblaulink]');
					$link = $studienplanpunkt->children(0)->href;
					$html2 = file_get_html('http://vvz.wu.ac.at'.$link);
					echo "planpunkt vorhanden";
				}
				else if($html->find('div[class=vvzh5]')){ //keine planpunkte vorhanden

					echo "planpunkt nicht vorhanden";
					//$needle = 'div[class=vvzh5]';
					$studienplanpunkte = $html->find('div[class=vvzh5]');
				}

				foreach($studienplanpunkte as $studienplanpunkt){

						echo $studienplanpunkt->plaintext.'</br>';
						$currentstudienplanpunkt = $studienplanpunkt->plaintext;
						
						mysql_query('insert into studienplanpunkt (title) values("'.$currentstudienplanpunkt.'")');
						$currentstudienplanpunkt_id = mysql_insert_id();
						mysql_query('insert into studienplanpunkt_studienfach (studienplanpunkt_id,studienfach_id) values ("'.$currentstudienplanpunkt_id.'","'.$currentstudienfach_id.'")');
						
						if(isset($html2)){

							$html = $html2;
						}

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



