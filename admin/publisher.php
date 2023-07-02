<?php

//author.php

include '../connection.php';
include '../header.php';
isset($_GET['do']) ? $do=$_GET['do'] : $do='mange';
$stmt=$con->prepare('SELECT * FROM publishers');
$stmt->execute();
$rows=$stmt->fetchAll();
//$count=$stmt->rowCount();
/*
echo $count;
const i=1;
for($i;i<$count;$i++){
	$stmt2=$con->prepare('select Publisher_ID from book Where("select Publisher_ID from publishers where Publisher_ID= ")');
	$stmt2->execute(array($i));
	$rows2=$stmt->fetchAll();
	
	
}*/
?>


<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Publisher Management</h1>
	<?php
	switch($do)
	{
		case 'mange' :
		?>
		<!-- Mange Page-->
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Publisher Management</li>
	</ol>
	
	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Publisher Management
				</div>
				<div class="col col-md-6" align="right">
					<a href="publisher.php?do=add" class="btn btn-success btn-sm">Add</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Publisher Name</th>
						<th>Status</th>
						<th>Created On</th>
						<th>Action</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Author Name</th>
						<th>Status</th>
						<th>Created On</th>
						<th>Action</th>
					</tr>
				</tfoot>
				<tbody>
				<?php
							foreach($rows as $row)
							{
								echo '<tr>';
									   echo '<td>' . $row['Publisher_Name'] . '</td>';
									   echo '<td>' . $row['Status'] . '</td>';
									   echo '<td>' . $row['Publisher_Added_on'] . '</td>';
									   echo '<td>';
												echo '<a href="publisher.php?do=edit&publisherid=' . $row["Publisher_ID"] . '" class="btn btn-success">edit</a>';
												echo '<a href="publisher.php?do=delete&publisherid=' . $row["Publisher_ID"] . '" class="btn btn-danger confirm">delete</a>';
												if($row['Status']==0)
												{
													echo '<a href="publisher.php?do=activate&publisherid=' . $row["Publisher_ID"] . '" class="btn btn-info">Activate</a>';
												}
										echo '</td>';
								echo '</tr>';
							}
							?>
                
                
				</tbody>
			</table>
		</div>
	</div>
	<?php
	break;
		
		case 'edit' :
			$pubid=isset($_GET['publisherid']) && is_numeric($_GET['publisherid']) ? intval($_GET['publisherid']) : 0 ;
			$stmt=$con->prepare('SELECT * FROM publishers WHERE Publisher_ID=?');
			$stmt->execute(array($pubid));
			$row=$stmt->fetch();
			?>
			<!-- Edit page -->
		<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
			<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="author.php">Publisher Management</a></li>
			<li class="breadcrumb-item active">Edit Publisher</li>
		</ol>
		
		<div class="row">
			<div class="col-md-6">
				<div class="card mb-4">
					<div class="card-header">
						<i class="fas fa-user-edit"></i> Edit Publisher Details
					</div>
					<div class="card-body">
						<form method="post">
							<input type="hidden" name="date" value="<?php echo  date('Y-m-d'); ?>"
							<div class="mb-3">
								<label class="form-label">Author Name</label>
								<input type="text" name="publisher_name" id="author_name" class="form-control" value="<?php echo $row['Publisher_Name']; ?>" />
							</div>
							<div class="mt-4 mb-0">
								
								<input type="submit" name="edit_author" class="btn btn-primary" value="Edit" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$pubname=$_POST['publisher_name'];
		$updatedDate=$_POST['date'];
		$stmt=$con->prepare('UPDATE publishers SET publisher_Name=? WHERE Publisher_ID=?');
		$stmt->execute(array($pubname,$pubid));
	}
	break;

		case 'add' :
			?>
				<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
					<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="publisher.php">Publisher Management</a></li>
					<li class="breadcrumb-item active">Add Publisher</li>
				</ol>
				<!-- Add Page-->
				<div class="row">
					<div class="col-md-6">
						
						<div class="card mb-4">
							<div class="card-header">
								<i class="fas fa-user-plus"></i> Add New Publisher
							</div>
							<div class="card-body">
								<form method="post">
									<div class="mb-3">
										<label class="form-label">Publisher Name</label>
										<input type="text" name="publisher_name" id="author_name" class="form-control" />
									</div>
									<div class="mt-4 mb-0">
										<input type="submit" name="add_publisher" class="btn btn-success" value="Add" />
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
		<?php
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$publisher_name=$_POST['publisher_name'];
			$date=date('Y-m-d');
			$stmt=$con->prepare('INSERT INTO publishers (Publisher_Name, Publisher_Added_on) VALUES(:pubname,:pubadded)');
			$stmt->execute(array(
								  'pubname'    => $publisher_name,
								  'pubadded' => $date
								  ));
		}
		break;
		case 'activate' :
			$pubid=isset($_GET['publisherid']) && is_numeric($_GET['publisherid']) ? intval($_GET['publisherid']) : 0 ;
			$stmt=$con->prepare('UPDATE publishers SET Status=1 WHERE Publisher_ID=?');
			$stmt->execute(array($pubid));
			echo'Publisher '. $pubid . 'is activated';
			break;
		case 'delete' :
			$pubid=isset($_GET['publisherid']) && is_numeric($_GET['publisherid']) ? intval($_GET['publisherid']) : 0 ;
			$stmt=$con->prepare('Delete  from publishers WHERE Publisher_ID=?');
			$stmt->execute(array($pubid));
			echo'Publisher '. $pubid . 'is deleted';
			break;
			
			
			
		
	}
	?>
	

	<script>

	</script>

	
</div>

<?php 

include '../footer.php';

?>