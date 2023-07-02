<?php
//session_start();

include'header.php';
include 'connection.php';
?>
<div class="d-flex align-items-center justify-content-center" style="min-height:700px;">

	<div class="col-md-6">

		<div class="card">

			<div class="card-header">Admin Login</div>

			<div class="card-body">

				<form method="POST">

					<div class="mb-3">
						<label class="form-label">Email address</label>

						<input type="text" name="admin_email" id="admin_email" class="form-control" />

					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>

						<input type="password" name="admin_password" id="admin_password" class="form-control" />

					</div>
					<div class="d-flex align-items-center justify-content-between mt-4 mb-0">

						<input type="submit" name="login_button" class="btn btn-primary" value="Login" />

					</div>
				</form>

			</div>

		</div>

	</div>

</div>

<?php
//check if the user is coming from the post
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $email=$_POST['admin_email'];
    $pass=$_POST['admin_password'];
    $hashpass=sha1($pass);
    //check if the user exist in the database
    $stmt=$con->prepare("SELECT ID, Email,Password From admin Where Email=? AND Password=? ");
    $stmt->execute(array($email,$pass));
    $row=$stmt->fetch();//el fetch bygib al data ely f al database//w mhma 3shan lw 3ayz tgib record m3yn mn al row zy ma 3mltha f str 66
    $count=$stmt->rowCount();//3dd al rows ely hwa l2aha
    if($count>0)
    {
        $_SESSION['admin_email']=$email;//kdh hna anta 3mlt session b asm al email aly 3mlt login bih
        $_SESSION['ID']= $row['ID'];//3mlto 3shan lma ad5l b ay admin user w a3oz a3ml edit l ay 7aga t5oso ab2a 3arf al id bta3o w m2ry f al sf7a al tnya aly sh8al fiha zy sf7a profile kdh
        header('location: admin/index.php?adminid='.$row["ID"]);
        exit();
    }
    else{echo 'sorry this admin is not exist';}
}




include'footer.php';
?>