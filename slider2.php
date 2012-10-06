<!hmtl doctype>
<html>

	<header>

		<title>slider</title>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>-->
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<style type="text/css">

			#wrapper {width:1000px; margin: 100px auto;}
				#left {float:left; width:150px;}
					#filter_button {height:20px; background-color:blue; color:white}
					#filter_menu {height:40px; background-color:green; color:white}
					#filter_tree {height:300px; background-color:red; color:white}
				#workbench {float:left;width:700px; height:360px; background-color:grey;color:white}
				#right {float:left; width:150px; height:360px; background-color:#333333}

			
		</style>		
		

	

	</header>
	<body>

		<div id='wrapper'>

			<div id='left'>

				<div id="filter_button">
					filterbutton
				</div>

				<div id="filter_menu">
					filtermenu
				</div>

				<div id="filter_tree">
					netclass
				</div>
			</div>
			<div id="workbench">
				workbench
			</div>
			<div id='right'>
				right
			</div>
			<div>
		</div>

	<script type="text/javascript">
			
			//hides filter_menu and notleft
			$('#filter_menu').hide();
			$('#workbench').hide();
			$('#right').hide();

			//show and hidefilter_menu
			$('#filter_button').click(function () {
				if ($('#filter_menu').is(":hidden")) {

					$('#filter_menu').slideDown(300);
				}
				else {

					$('#filter_menu').slideUp(300);
				}
			});

			//show and hide workbench
			$('#filter_tree').click(function () {
				if ($('#workbench').is(":hidden")){

					$('#workbench').show('slide',300);
				}
				else{

					if(!$('#right').is(":hidden")){

						$('#right').hide('slide',300);
					}	

					$('#workbench').hide('slide',300);
				}
			});

			//show and hide right
			$('#workbench').click(function () {
				if ($('#right').is(":hidden")){

					$('#right').show('slide',300);
				}
				else{

					$('#right').hide('slide',300);
				}
			});	


		</script>	

	<body>
</html>

