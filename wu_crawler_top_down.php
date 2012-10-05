<?

	ini_set('memory_limit', '4096M');
	ini_set('max_execution_time', 0);
	
	include_once('simple_html_dom.php');
	include('functions.php');
	dbconnect();
	include('cleardatabase.php');
	$uni = 'Wirtschaftsuniversität Wien';
	mysql_query('insert into uni (title) values ("'.$uni.'")');
	$uni_id = mysql_insert_id();

	$html = file_get_html('http://vvz.wu.ac.at/cgi-bin/vvz.pl?LV=3;L2=38107;L3=38079;S=12W;LANG=DE');

	foreach($html->find('li[class=sub2]') as $studienrichtung){

		//echo $studienrichtung->children(0)->plaintext.'</br>';
		$currentstudienrichtung = $studienrichtung->children(0)->plaintext;
		mysql_query('insert into studienrichtung (title) values("'.$currentstudienrichtung.'")');
		$currentstudienrichtung_id = mysql_insert_id();
		mysql_query('insert into uni_studienrichtung (uni_id,studienrichtung_id) values ("'.$uni_id.'","'.$currentstudienrichtung_id.'")');
		$link = $studienrichtung->children(0)->href;
		$html = file_get_html('http://vvz.wu.ac.at'.$link);

		foreach($html->find('li[class=sub1]') as $studienzweig){

			//echo $studienzweig->children(0)->plaintext.'</br>';
			$currentstudienzweig = $studienzweig->children(0)->plaintext;
			mysql_query('insert into studienzweig (title) values("'.$currentstudienzweig.'")');
			$currentstudienzweig_id = mysql_insert_id();
			mysql_query('insert into studienrichtung_studienzweig (studienrichtung_id,studienzweig_id) values ("'.$currentstudienrichtung_id.'","'.$currentstudienzweig_id.'")');
			$link = $studienzweig->children(0)->href;
			$html = file_get_html('http://vvz.wu.ac.at'.$link);

			foreach($html->find('li[class=sub2]') as $studienfach){

				//echo $studienfach->children(0)->plaintext.'</br>';
				$currentstudienfach = $studienfach->children(0)->plaintext;
				mysql_query('insert into studienfach (title) values("'.$currentstudienfach.'")');
				$currentstudienfach_id = mysql_insert_id();
				mysql_query('insert into studienzweig_studienfach (studienzweig_id,studienfach_id) values ("'.$currentstudienzweig_id.'","'.$currentstudienfach_id.'")');
				$link = $studienfach->children(0)->href;
				$html = file_get_html('http://vvz.wu.ac.at'.$link);

				if($html->find('li[class=pfeilblaulink]')){ //planpunkte vorhanden

					$studienplanpunkte = $html->find('li[class=pfeilblaulink]');
					$planpunktevorhanden = true;
				}
				else if($html->find('div[class=vvzh5]')){ //keine planpunkte vorhanden

					$studienplanpunkte = $html->find('div[class=vvzh5]');
					$planpunktevorhanden = false;
				}

				foreach($studienplanpunkte as $studienplanpunkt){

						//echo $studienplanpunkt->plaintext.'</br>';
						$currentstudienplanpunkt = $studienplanpunkt->plaintext;
						
						mysql_query('insert into studienplanpunkt (title) values("'.$currentstudienplanpunkt.'")');
						$currentstudienplanpunkt_id = mysql_insert_id();
						mysql_query('insert into studienfach_studienplanpunkt (studienfach_id,studienplanpunkt_id) values ("'.$currentstudienfach_id.'","'.$currentstudienplanpunkt_id.'")');
						
						if($planpunktevorhanden){

							$link = $studienplanpunkt->children(0)->href;
							$html = file_get_html('http://vvz.wu.ac.at'.$link);
						}

						foreach($html->find('td[class=vvzc1]') as $kurs){

							$link = $kurs->children(0)->href;
							$html = file_get_html('http://vvz.wu.ac.at'.$link);

							$spantext = $html->find('span[class=text]');
					
							$currentkurs_id =  $spantext[0]->children(0)->children(1)->children(0)->plaintext;
							$currentkurs_type = str_replace (" ", "", $spantext[0]->children(0)->children(1)->children(1)->plaintext);
							$currentkurs_type = str_replace ("&nbsp;", "", $currentkurs_type);
							$currentkurs_title = $spantext[0]->children(0)->children(1)->children(3)->children(0)->plaintext;
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

							//echo $currentkurs_id.'</br>';
							//echo $currentkurs_type.'</br>';
							//echo $currentkurs_title.'</br>';

							if(isset($lecturer)){
								
								foreach($lecturer->find('a') as $l){

									$currentlecturer_name = $l->plaintext;
									$res = mysql_query('select id from lvleiter where name="'.$currentlecturer_name.'"');

									if(mysql_num_rows($res) > 0){

										$row = mysql_fetch_row($res);
										$currentlecturer_id = $row[0];
									}
									else{

										mysql_query('insert into lvleiter (name) values("'.$currentlecturer_name .'")');
										$currentlecturer_id = mysql_insert_id();
									}

									echo $currentlecturer_id.$currentkurs_id;
									mysql_query('insert into lvleiter_kurs(lvleiter_id,kurs_id) values("'.$currentlecturer_id.'","'.$currentkurs_id.'")');
								}
							}
							else{

								$currentlecturer_name = 'Keine Angabe';
								$res = mysql_query('select id from lvleiter where name="'.$currentlecturer_name.'"');

									if(mysql_num_rows($res) > 0){

										$row = mysql_fetch_row($res);
										$currentlecturer_id = $row[0];
									}
									else{

										mysql_query('insert into lvleiter (name) values("'.$currentlecturer_name .'")');
										$currentlecturer_id = mysql_insert_id();
										
									}
									mysql_query('insert into lvleiter_kurs(lvleiter_id,kurs_id) values("'.$currentlecturer_id.'","'.$currentkurs_id.'")');
							}


							if(!isset($sst)){

								$sst = "Keine Angabe";
							}
							if(!isset($language)){

								$language = 'Keine Angabe';
							}

							mysql_query('insert into kurs(id,type,title,sst,language) values("'.$currentkurs_id.'","'.$currentkurs_type.'","'.$currentkurs_title.'","'.$sst.'","'.$language.'")');
							mysql_query('insert into studienplanpunkt_kurs (studienplanpunkt_id,kurs_id) values ("'.$currentstudienplanpunkt_id.'","'.$currentkurs_id.'")');

							$table3 = $spantext[0]->children(4);
							$first = $table3->first_child();
							$last = $table3->last_child();

							foreach($table3->find('tr') as $cell){

								if($cell != $last && $cell != $first){

									$weekday = str_replace(',','',$cell->children(0)->plaintext);
									$weekday = str_replace(' ','',$weekday);
									$datetimes = makeDatetimes($cell->children(1)->plaintext,$cell->children(2)->plaintext);
									$place = str_replace(' (Lageplan)','',$cell->children(3)->plaintext);
									$place = str_replace(' ','',$place);
									//echo $weekday.$datetimes[0].$datetimes[1].$place;
									mysql_query('insert into termine (weekday,start,end,place) values("'.$weekday.'","'.$datetimes[0].'","'.$datetimes[1].'","'.$place.'")');
									$currenttermin_id = mysql_insert_id();
									mysql_query('insert into kurs_termine (kurs_id,termine_id) values ("'.$currentkurs_id.'","'.$currenttermin_id.'")');
								}
							}
						}	
				}
			}
		}
	}

	//end of crawling
	echo "done biatch!";
	
?>



