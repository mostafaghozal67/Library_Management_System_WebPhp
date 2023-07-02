<?php


include 'connection.php';

include 'header.php';

?>

<div class="d-flex align-items-center justify-content-center" style="height:700px;">
	<div class="col-md-6">
		
		<div class="card">
			<div class="card-header">User Login</div>
			<div class="card-body">
				<form method="POST">
					<div class="mb-3">
						<label class="form-label">Email address</label>
						<input type="text" name="user_email" id="user_email_address" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" name="user_password" id="user_password" class="form-control" />
					</div>
					<div class="d-flex align-items-center justify-content-between mt-4 mb-0">
						<input type="submit" name="login_button" class="btn btn-primary" value="Login" />
					</div>
				</form>
			</div>
		</div>
		<?php
			if($_SERVER['REQUEST_METHOD']=='POST'){
			  $email=$_POST['user_email'];
			  $password=$_POST['user_password'];
			  $hashpass=sha1($password);
			  $stmt=$con->prepare("SELECT User_ID ,Email ,Password FROM users WHERE Email=? AND Password=? LIMIT 1 ");
			  $stmt->execute(array($email, $hashpass));
			  $row=$stmt->fetch();
			  $count=$stmt->rowCount();
			  if($count>0){
				  header('location: home.php?userid='.$row["User_ID"]);
				  
			  }
			}
		?>
	</div>
</div>

<?php 

include 'footer.php';

?>