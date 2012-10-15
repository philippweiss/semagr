<!hmtl doctype>
<html>

	<header>

		<title>slider2</title>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>-->
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<style type="text/css">

			#wrapper {width:1000px; margin: 100px auto;}
				#left {float:left; width:150px;}
					#filter_button {height:40px; background-color:B8008A; color:white}
					#filter_menu {height:40px; background-color:red; color:white}
					#filter_tree {height:300px; background-color:grey; color:white; padding:6px;}
					#c_filter_tree {height:90%; background-color:white; color:black; overflow:auto; border-radius: 10px; padding:5px;}
				#workbench {float:left; margin:0px; width:700px; height:340px; background-color:grey;color:white; padding:5px;}
				#right {float:left; width:150px; height:360px; background-color:#333333}

			.shadowin {
   						-moz-box-shadow:	inset 0 0 20px #000000;
   						-webkit-box-shadow:	inset 0 0 20px #000000;
   						box-shadow:			inset 0 0 20px #000000;
						}
			.shadowout {
						-webkit-box-shadow:	1px 0 10px rgba(0, 0, 0, 0.6);
						-moz-box-shadow:	1px 0 10px rgba(0, 0, 0, 0.6);
						box-shadow:			5px 5px 10px 0px rgba(0, 0, 0, 0.6);	
						}

			
		</style>		
		

	

	</header>
	<body>
<!--  -->
		<div id='wrapper'>

			<div id='left', class="shadowout">

				<div id="filter_button">
					filterbutton
				</div>

				<div id="filter_menu", class="shadowin">
					filtermenu
				</div>

				<div id="filter_tree">
					netclass

					<div id="c_filter_tree", class="shadowin">
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
						hier steht etwas wichtiges.<br>
					</div>

				</div>
			</div>
			<div id="workbench", class="shadowout">
				workbench

				<div id="c_filter_tree", class="shadowin">
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
					hier steht etwas wichtiges.<br>
				</div>

			</div>
			<div id='right'>
				right
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

					$('#workbench').show('slide',450);
				}
				else{

					if(!$('#right').is(":hidden")){

						$('#right').hide('slide',300);
					}	

					$('#workbench').hide('slide',450);
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

