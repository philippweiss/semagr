<?

	
	include_once('simple_html_dom.php');


//git test karl


	for($i=1; $i<10000; $i++){

        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', '-1');
        
        if(isset ($_GET['round'])){
            
            $round = $_GET['round'];
        }
        else{
            $round = 1;
        }
        
        $pace = 10;

	for($i=($round-1)*$pace+1; $i<$round*$pace; $i++){


		$html = file_get_html('http://vvz.wu.ac.at/cgi-bin/vvz.pl?C=S&LANG=DE&S=12W&LV=3&L2=S&L3=S&T=&L=&I='.$i.'&JOIN=AND');

		if(stripos($html->plaintext, 'Keine Lehrveranstaltungen gefunden!') === false){


			$spantext = $html->find('span[class=text]');

			$id =  $spantext[0]->children(0)->children(1)->children(0)->plaintext;
			$type = $spantext[0]->children(0)->children(1)->children(1)->plaintext;
			$title = $spantext[0]->children(0)->children(1)->children(3)->children(0)->plaintext;
			
			
			$table2 = $spantext[0]->children(2);
			

			foreach($table2->find('td') as $cell){

			foreach($table2->find('td') as $cell){


				if($cell->plaintext == 'LV-Leiter/in'){

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

			foreach($lecturer->find('a') as $l){

				echo $l->plaintext.'</br>';
			}

			foreach($subject->find('a') as $s){

				echo $s->plaintext.'</br>';
			}

			echo $sst.'</br>';
			echo $language.'</br>';

			

			echo '</br></br>';

		}		
	}
?>


<script type="text/javascript">

window.location = "http://localhost/semagr/crawler.php?round=<? echo $round + 1; ?>" ;

</script>
