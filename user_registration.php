<?php
include 'header.php';
include 'connection.php';

?>
<div class="d-flex align-items-center justify-content-center mt-5 mb-5" style="min-height:700px;">
	<div class="col-md-6">
		
		<div class="card">
			<div class="card-header">New User Registration</div>
			<div class="card-body">
				<form method="POST" enctype="multipart/form-data">
					<div class="mb-3">
						<label class="form-label">Email address</label>
						<input type="text" name="user_email" id="user_email_address" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" name="user_password" id="user_password" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">User Name</label>
                        <input type="text" name="user_name" class="form-control" id="user_name" value="" />
                    </div>
					<div class="mb-3">
						<label class="form-label">User Address</label>
						<textarea name="user_address" id="user_address" class="form-control"></textarea>
					</div>
					
					<div class="text-center mt-4 mb-2">
						<input type="submit" name="register_button" class="btn btn-primary" value="Register" />
					</div>
				</form>
			</div>
		</div>
		<?php
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$email=$_POST['user_email'];
			$password=$_POST['user_password'];
			$hashpass=sha1($password);
			$name=$_POST['user_name'];
			$address=$_POST['user_address'];
			$stmt=$con->prepare('INSERT INTO users (User_Name, Password,Email,Address) VALUES(:username,:userpass,:useremail,:useraddress)');
			$stmt->execute(array(
								  'username'    => $name,
								  'userpass'    => $hashpass,
								  'useremail'   => $email,
								  'useraddress' => $address
								  ));
			
			$message="User Has Been Registerd";
			echo '<div class="alert alert-success">'.$message.'</div>';
			//header("location:index.php");
			header( "refresh:3;url=user_login.php" );

			
		}
		?>
	</div>
</div>


<?php 


include 'footer.php';

?>