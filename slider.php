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


		<script>
			$('#filter_menu').hide();

			$('#filter_button').click(function () {
				if ($('#filter_menu').is(":hidden")) {
					$('#filter_menu').slideDown("slow");
				} else {
					$('#filter_menu').slideUp("300");
				}
			});
		</script>

	<body>


</html>