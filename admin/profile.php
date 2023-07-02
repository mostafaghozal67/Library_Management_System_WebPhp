<?php

//profile.php

include '../connection.php';
//include '../AdminLogin.php';
include '../header.php';
//$do=''
$userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : $_SESSION['ID'] ;
$stmt=$con->prepare("SELECT * FROM admin WHERE ID=? LIMIT 1");
$stmt->execute(array($userid));
$row=$stmt->fetch();
$count=$stmt->rowCount();





?>

<div class="container-fluid px-4">
	<h1 class="mt-4">Profile</h1>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Profile</a></li>
	</ol>
	<div class="row">
		<div class="col-md-6">
			
			<div class="card mb-4">
				<div class="card-header">
					<i class="fas fa-user-edit"></i> Edit Profile Details
				</div>
				<div class="card-body">

				

					<form method="POST">
						<div class="mb-3">
							<label class="form-label">Email Address</label>
							<input type="text" name="admin_email" id="admin_email" class="form-control" value="<?php echo $row['Email'] ?>" />
						</div>
						<div class="mb-3">
							<label class="form-label">Password</label>
							<input type="password" name="admin_password" id="admin_password" class="form-control" value="<?php echo $row['Password'] ?>" />
						</div>
						<div class="mt-4 mb-0">
							<input type="submit" name="edit_admin" class="btn btn-primary" value="Edit" />
						</div>
					</form>

				

				</div>
			</div>

		</div>
	</div>
</div>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
	$email=$_POST['admin_email'];
    $pass=$_POST['admin_password'];
    $hashpass=sha1($pass);
	$stmt=$con->prepare('UPDATE admin SET Email=? , Password=? WHERE ID=? ');
	$stmt->execute(array($email,$pass,$userid));
	
	
}
//<?php 

include '../footer.php';

?>