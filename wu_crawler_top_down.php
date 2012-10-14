<?


	$memorylimit = 1024*1024*1024 . 'M';
	ini_set('memory_limit', $memorylimit);
	//ini_set('max_execution_time', 0);
	set_time_limit(0);
	
	include_once('simple_html_dom.php');
	include('functions.php');
	dbconnect();
	clearDatabase();
	$uni = 'Wirtschaftsuniversität Wien';
	$query = 'insert into uni (title) values ("'.$uni.'")';
	//echo $query."</br>";
	mysql_query($query);
	$currentuni_id = mysql_insert_id();

	$html = file_get_html('http://vvz.wu.ac.at/cgi-bin/vvz.pl?LV=3;L2=38107;L3=38079;S=12W;LANG=DE');

	foreach($html->find('li[class=sub2]') as $studienrichtung){

		$currentstudienrichtung = $studienrichtung->children(0)->plaintext;
		$query = 'insert into studienrichtung (title,uni_id) values ("'.$currentstudienrichtung.'","'.$currentuni_id.'")';
		//echo $query."</br>";
		mysql_query($query);
		$currentstudienrichtung_id = mysql_insert_id();
		$link = $studienrichtung->children(0)->href;
		$html = file_get_html('http://vvz.wu.ac.at'.$link);

		foreach($html->find('li[class=sub1]') as $studienzweig){

			$currentstudienzweig = $studienzweig->children(0)->plaintext;
			$query = 'insert into studienzweig (title,studienrichtung_id) values ("'.$currentstudienzweig.'","'.$currentstudienrichtung_id.'")';
			//echo $query."</br>";
			mysql_query($query);
			$currentstudienzweig_id = mysql_insert_id();
			$link = $studienzweig->children(0)->href;
			$html = file_get_html('http://vvz.wu.ac.at'.$link);

			foreach($html->find('li[class=sub2]') as $studienfach){

				$currentstudienfach = $studienfach->children(0)->plaintext;
				$query = 'insert into studienfach (title,studienzweig_id) values ("'.$currentstudienfach.'","'.$currentstudienzweig_id.'")';
				//echo $query."</br>";
				mysql_query($query);
				$currentstudienfach_id = mysql_insert_id();
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
					$query = 'insert into studienplanpunkt (title,studienfach_id) values("'.$currentstudienplanpunkt.'","'.$currentstudienfach_id.'")';	
					//echo $query."</br>";
					mysql_query($query);
					$currentstudienplanpunkt_id = mysql_insert_id();
						
					if($planpunktevorhanden){

						$link = $studienplanpunkt->children(0)->href;
						$html = file_get_html('http://vvz.wu.ac.at'.$link);
					}

					foreach($html->find('td[class=vvzc1]') as $kurs){

						$query = 'select id from kurs where id ='.$kurs->plaintext;
						$res = mysql_query($query);

						if(mysql_num_rows($res) == 0){

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
								if($cell->plaintext == 'Semesterstunden'){

										$neighbour = $cell->next_sibling();
										$sst = $neighbour->plaintext;
								}
								if($cell->plaintext == 'Unterrichtssprache'){

										$neighbour = $cell->next_sibling();
										$language = $neighbour->plaintext;
								}
							}
							
							if(isset($lecturer)){
									
								foreach($lecturer->find('a') as $l){

									$currentlecturer_name = $l->plaintext;
									$query = 'select id from lvleiter where name like "'.$currentlecturer_name.'"';
									$res = mysql_query($query);

									if(mysql_num_rows($res) > 0){

										$row = mysql_fetch_row($res);
										$currentlecturer_id = $row[0];
									}
									else{

										$query = 'insert into lvleiter (name) values("'.$currentlecturer_name .'")';
										//echo $query."</br>";
										mysql_query($query);
										$currentlecturer_id = mysql_insert_id();
									}
									$query = 'insert into lvleiter_kurs(lvleiter_id,kurs_id) values("'.$currentlecturer_id.'","'.$currentkurs_id.'")';
									//echo $query."</br>";
									mysql_query($query);
								}
							}
							else{

								echo "!!!!!!KEIN LV LEITER</br>";
							}
							

							if(!isset($sst)){

								$sst = "Keine Angabe";
							}
							if(!isset($language)){

								$language = 'Keine Angabe';
							}
							
							$query = 'insert into kurs(id,type,title,sst,language) values("'.$currentkurs_id.'","'.$currentkurs_type.'","'.$currentkurs_title.'","'.$sst.'","'.$language.'")';
							//echo $query."</br>";
							mysql_query($query);
							$query = 'insert into studienplanpunkt_kurs (studienplanpunkt_id,kurs_id) values ("'.$currentstudienplanpunkt_id.'","'.$currentkurs_id.'")';
							//echo $query."</br>";
							mysql_query($query);

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
									$query = 'insert into termine (weekday,start,end,place,kurs_id) values("'.$weekday.'","'.$datetimes[0].'","'.$datetimes[1].'","'.$place.'","'.$currentkurs_id.'")';
									//echo $query."</br>";
									mysql_query($query);			
								
								}
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



