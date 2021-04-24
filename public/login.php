<?php
$title="Login";
include('header.php');
include('navbar.php');
?>
<link rel="stylesheet" href="../css/login.css">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12" id="login-container">
        <div id="form-login">
			<form role="form" action="../config/login.php" method="POST">
				<div class="form-group">	
				<h1>Log-In</h1>			 
					<label for="exampleInputEmail1">Username</label>
					<input name="User" type="text" class="form-control" id="exampleInputEmail1" />
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input name="Pass" type="password" class="form-control" id="exampleInputPassword1" />
				</div>
				<button type="submit" class="btn btn-primary">Submit</button></br>
				<a href="reg.php">Nuovo Utente? Registrati!</a>
			</form>
            </div>
		</div>
	</div>
</div>
<?php
include('footer.php');
?>