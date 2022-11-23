<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign Up &bull; <?php echo env('app_name');?></title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> -->
	
	<style>
		body
		{
			background: #ddefff;
			padding: 0px;
			margin: 0px;
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100vh;
		}
	</style>
</head>
<body>
	<div class="container" style="max-width: 800px;">
		<div class="row">
			<div class="col-md-6 p-5" style="background: #ddd">
				Ini adalah cubaan
			</div>
			<div class="col-md-6 p-5" style="background: #fff">
				<h1>Sign Up</h1>
				<p>Fill in your detail.</p>
				
				<form method="post">
					<div class="form-group mb-3">
						<label>Name</label>
						<input type="text" name="name" class="form-control" required>
					</div>
					<div class="form-group mb-3">
						<label>Email</label>
						<input type="email" name="email" class="form-control" required>
					</div>
					<input type="submit" class="btn btn-primary mb-4" value="Submit">
				</form>

				Already have account? <a href="/auth/login">Login &rarr;</a>
			</div>
		</div>
	</div>
</body>
</html>