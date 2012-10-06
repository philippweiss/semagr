<!hmtl doctype>
<html>

	<header>

		<title>slider</title>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

	</header>

	<body>

		<wrapper style="position:fixed;left:0px;top:0px;width:100%;height:100%;background-color:white">

			<innerwrapper style="position:absolute;z-index:-2;margin:10%;height:500px;width:500px;background-color:6666">

				<div id="filter_button" style="position:relative;width:100px;height:20px;background-color:blue;color:white">
					filterbutton
				</div>

				<div id="filter_menu" style="position:relative;width:100px;height:40px;background-color:green;color:white">
					filtermenu
				</div>

				<div id="netclass" style="position:relative;width:100px;height:300px;background-color:red;color:white">
						netclass
				</div>

				<div id="workbench" style="position:relative;z-index:-1;top:-320px;width:450px;height:320px;background-color:grey;color:white">
				
				</div>

			</innerwrapper>

		</wrapper>

		<script>
			
			//hides filter_menu and workbench
			$('#filter_menu').hide();
			$('#workbench').hide();

			//slide-up and slide-down
		    $('#filter_button').click(function () {
      			$('#filter_menu').slideToggle("300");
    		});
			
		    /*
		    //alternative to above: makes differentiated sliding-time possible
			$('#filter_button').click(function () {
				if ($('#filter_menu').is(":hidden")) {
					$('#filter_menu').slideDown("slow");
				} else {
					$('#filter_menu').slideUp("300");
				}
			});
			*/

			//slide-sideways
			$('#netclass').click(function () {
				if ($('#workbench').is(":hidden")) {
					$('#workbench').show("slide",300);
				} else {
					$('#workbench').hide("slide",300);
				}	
			});

		</script>

	<body>


</html>