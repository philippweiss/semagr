
<?

$a = array('1','2','3','4','5','6','7','8','9','10');



foreach($a as $b){

	echo ''.$b.'000000</br>';

	foreach($a as $c){

		echo $b.$c.'00000</br>';

		foreach($a as $d){

			echo $b.$c.$d.'0000</br>';

			foreach($a as $e){

				echo $b.$c.$d.$e.'000</br>';

				foreach($a as $f){

					echo $b.$c.$d.$e.$f.'00</br>';

					foreach($a as $g){

						echo $b.$c.$d.$e.$f.$g.'0</br>';

						foreach($a as $g){

							echo $b.$c.$d.$e.$f.$g.$h.'</br>';
						}
					}	
				}	
			}
		}
	}
}


?>