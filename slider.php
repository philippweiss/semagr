<!hmtl doctype>
<html>

	<header>

		<title>slider</title>
		<script src="http://code.jquery.com/jquery-latest.js"></script>

	</header>

	<body>

		<div id="filter_button" style="width:100px;height:20px;background-color:blue;color:white">
			filterbutton


		</div>

		<div id="filter_menu" style="width:100px;height:40px;background-color:green;color:white">
			filtermenu


		</div>


		<div id="netclass" style="width:100px;height:300px;background-color:red;color:white">
				netclass


		</div>

		<div id="workbench" style="z-index:-1;position:relative;left:0px;top:-320px;width:400px;height:320px;background-color:grey;color:white">
		

		</div>


		<script>
			//slide-up and slide-down
			$('#filter_menu').hide();

		    $('#filter_button').click(function () {
      			$('#filter_menu').slideToggle("slow");
    		});
			
		    /*
		    //alternative to above: makes alternating sliding time possible
			$('#filter_button').click(function () {
				if ($('#filter_menu').is(":hidden")) {
					$('#filter_menu').slideDown("slow");
				} else {
					$('#filter_menu').slideUp("300");
				}
			});
			*/

			//slide-sideways

			$(document).ready(function() {
				$('#netclass').click(function() {
					var $lefty = $(this).next();
					$lefty.animate({
						left: parseInt($lefty.css('left'),10) == 0 ?
						-$lefty.outerWidth() :
						0
					});
				});
			});
			


		</script>

	<body>


</html>