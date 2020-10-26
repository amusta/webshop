<?php include('../functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Create movies</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
		.header {
			background: #003366;
		}
		button[name=create_movie_btn] {
			background: #003366;
		}
	</style>
</head>
<body>
	<div class="header">
		<h2>Admin - create movie</h2>
	</div>
	
	<form method="post" action="create_movie.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Movie name</label>
			<input type="text" name="Name" value="<?php echo $Name; ?>">
		</div>
		<div class="input-group">
			<label>Genre</label>
			<input type="text" name="Genre" value="<?php echo $Genre; ?>">
		</div>


        <div class="input-group">
            <label>Year</label>
            <input type="number" name="Year" value="<?php echo $Year; ?>">
        </div>


        <div class="input-group">
            <label>Pics</label>
        <input type="file" name="Img" id="Img">
        </div>

        <div class="input-group">
            <label>Quantity</label>
            <input type="number" name="quantity" value="<?php echo $quantity; ?>">
        </div>
		<div class="input-group">
			<button type="submit" class="btn" name="create_movie_btn"> + Add movie</button>
		</div>
	</form>


</body>
</html>