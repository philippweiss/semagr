<?php


	ini_set('memory_limit', '4096M');
	ini_set('max_execution_time', 0);

	include_once('simple_html_dom.php');
	include('functions.php');

	dbconnect();
	include('cleardatabase.php');

	$uni = 'Wirtschaftsuniversität Wien';
	mysql_query('insert into uni (title) values ("'.$uni.'")');

	$html = file_get_html('http://vvz.wu.ac.at/cgi-bin/vvz.pl?C=I;LV=4;L2=S;L3=V;L4=V;S=12W;LANG=DE#L_A');

	//extracts lecturers and inserts them into db
	$i = 0;
	foreach($html->find('div[id=content_durchgehend]') as $html){

		$html = $html->children(1);
		$i = 0;

		foreach($html->find('a[href]') as $lvleiter) {

			$str = strlen($lvleiter->href);

			if ($str > 5) {

				$currentlvleiter = $lvleiter->plaintext;
				mysql_query('insert into lvleiter (name) values ("'.$currentlvleiter.'")');
/*
				$link = $lvleiter->href;
				$html = file_get_html('http://vvz.wu.ac.at'.$link);

				foreach($html->find('div[id=content_durchgehend]') as $content){



				}
*/
				//echo $i.'</br>';
				$i++;
			}
		}
	}
echo "done";
?>