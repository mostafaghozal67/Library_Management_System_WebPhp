<?php

//setting.php

include '../connection.php';

include '../header.php';
$stmt=$con->prepare("SELECT * FROM settings LIMIT 1");
$stmt->execute(array());
$row=$stmt->fetch();
//$count=$stmt->rowCount();



?>

<div class="container-fluid px-4">
	<h1 class="mt-4">Settings</h1>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Setting</a></li>
	</ol>
	
	<div class="card mb-4">
		<div class="card-header">
			<i class="fas fa-user-edit"></i> Library Setting
		</div>
		<div class="card-body">

			<form method="POST">
				
				<div class="row">
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Library Name</label>
							<input type="text" name="library_name" id="library_name" class="form-control" value="<?php echo $row['Library_Name'];?>" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Address</label>
							<textarea name="library_address" id="library_address" class="form-control"><?php echo $row['Library_Address'];?></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Contact Number</label>
							<input type="text" name="library_contact_number" id="library_contact_number" class="form-control" value="<?php echo $row['Library_Number'];?>" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Email Address</label>
							<input type="text" name="library_email_address" id="library_email_address" class="form-control" value="<?php echo $row['Library_Email'];?>" />
						</div>
					</div>
				</div>
				<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Phone Number</label>
							<input type="text" name="library_email_address" id="library_phone_number" class="form-control" value="<?php echo $row['Library_Phone'];?>" />
						</div>
					</div>
				
				<div class="mt-4 mb-0">
					<input type="submit" name="edit_setting" class="btn btn-primary" value="Save" />
				</div>
				
				
			</form>

		</div>
	</div>
</div>

<?php 
if($_SERVER['REQUEST_METHOD']=='POST')
{
	$library_name=$_POST['library_name'];
	$library_address=$_POST['library_address'];
	$library_number=$_POST['library_contact_number'];
	$library_phone_number=$_POST['library_phone_number'];
	$library_email_address=$_POST['library_email_address'];
	$stmt=$con->prepare('UPDATE settings SET Library_Name=?,Library_Phone=?,Library_Address=?,Library_Number=?,Library_Email=?');
	$stmt->execute(array($library_name,$library_phone_number,$library_address,$library_number,$library_email_address));
	
	
}
include '../footer.php';

?>