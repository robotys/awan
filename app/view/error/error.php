<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Application Error</title>
	<style>
		body
		{
			font-family: sans-serif;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			padding: 0px;
			margin: 0px;
		}
	</style>
</head>
<body>
<div style="max-width: 600px; text-align: center; padding: 20px">
	<span style="font-size: 5em; font-weight: bold;">\(T__T)/</span>
	<h1>Application Error</h1>
	<?php
		if(ISSET($message)) echo '<p>'.$message.'</p>';
	?>
</div>
</body>
</html>