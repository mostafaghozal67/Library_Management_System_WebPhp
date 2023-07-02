<?php

//author.php

include '../connection.php';
include '../header.php';
isset($_GET['do']) ? $do=$_GET['do'] : $do='mange';
$stmt=$con->prepare('SELECT * FROM author');
$stmt->execute();
$rows=$stmt->fetchAll();
?>


<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Author Management</h1>
	<?php
	switch($do)
	{
		case 'mange' :
		?>
		<!-- Mange Page-->
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Author Management</li>
	</ol>
	
	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Author Management
				</div>
				<div class="col col-md-6" align="right">
					<a href="author.php?do=add" class="btn btn-success btn-sm">Add</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Author Name</th>
						<th>Status</th>
						<th>Created On</th>
						<th>Updated On</th>
						<th>Action</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Author Name</th>
						<th>Status</th>
						<th>Created On</th>
						<th>Updated On</th>
						<th>Action</th>
					</tr>
				</tfoot>
				<tbody>
				<?php
							foreach($rows as $row)
							{
								echo '<tr>';
									   echo '<td>' . $row['author_name'] . '</td>';
									   echo '<td>' . $row['author_status'] . '</td>';
									   echo '<td>' . $row['author_created_on'] . '</td>';
									   echo '<td>' . $row['author_updated_on'] . '</td>';
									   echo '<td>';
												echo '<a href="author.php?do=edit&authorid=' . $row["author_ID"] . '" class="btn btn-success">edit</a>';
												echo '<a href="author.php?do=delete&authorid=' . $row["author_ID"] . '" class="btn btn-danger confirm">delete</a>';
												if($row['author_status']==0)
												{
													echo '<a href="author.php?do=activate&authorid=' . $row["author_ID"] . '" class="btn btn-info">Activate</a>';
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
			$authid=isset($_GET['authorid']) && is_numeric($_GET['authorid']) ? intval($_GET['authorid']) : 0 ;
			$stmt=$con->prepare('SELECT * FROM author WHERE author_ID=?');
			$stmt->execute(array($authid));
			$row=$stmt->fetch();
			?>
			<!-- Edit page -->
		<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
			<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="author.php">Author Management</a></li>
			<li class="breadcrumb-item active">Edit Author</li>
		</ol>
		
		<div class="row">
			<div class="col-md-6">
				<div class="card mb-4">
					<div class="card-header">
						<i class="fas fa-user-edit"></i> Edit Author Details
					</div>
					<div class="card-body">
						<form method="post">
							<input type="hidden" name="date" value="<?php echo  date('Y-m-d'); ?>"
							<div class="mb-3">
								<label class="form-label">Author Name</label>
								<input type="text" name="author_name" id="author_name" class="form-control" value="<?php echo $row['author_name']; ?>" />
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
		$authname=$_POST['author_name'];
		$updatedDate=$_POST['date'];
		$stmt=$con->prepare('UPDATE author SET author_name=? , author_updated_on=? WHERE author_ID=?');
		$stmt->execute(array($authname,$updatedDate,$authid));
	}
	break;

		case 'add' :
			?>
				<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
					<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="author.php">Author Management</a></li>
					<li class="breadcrumb-item active">Add Author</li>
				</ol>
				<!-- Add Page-->
				<div class="row">
					<div class="col-md-6">
						
						<div class="card mb-4">
							<div class="card-header">
								<i class="fas fa-user-plus"></i> Add New Author
							</div>
							<div class="card-body">
								<form method="post">
									<div class="mb-3">
										<label class="form-label">Author Name</label>
										<input type="text" name="author_name" id="author_name" class="form-control" />
									</div>
									<div class="mt-4 mb-0">
										<input type="submit" name="add_author" class="btn btn-success" value="Add" />
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
		<?php
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$author_name=$_POST['author_name'];
			$date=date('Y-m-d');
			$stmt=$con->prepare('INSERT INTO author (author_name, author_created_on,author_updated_on) VALUES(:authname,:authcreated,:authupdated)');
			$stmt->execute(array(
								  'authname'    => $author_name,
								  'authcreated' => $date,
								  'authupdated' => $date
								  ));
		}
		break;
		case 'activate' :
			$authid=isset($_GET['authorid']) && is_numeric($_GET['authorid']) ? intval($_GET['authorid']) : 0 ;
			$stmt=$con->prepare('UPDATE author SET author_status=1 WHERE author_ID=?');
			$stmt->execute(array($authid));
			echo'Category'. $authid . 'is activated';
			break;
		case 'delete' :
			$authid=isset($_GET['authorid']) && is_numeric($_GET['authorid']) ? intval($_GET['authorid']) : 0 ;
			$stmt=$con->prepare('Delete  from author WHERE author_ID=?');
			$stmt->execute(array($authid));
			echo'Category'. $authid . 'is deleted';
			break;
			
			
			
		
	}
	?>
	

	<script>

	</script>

	
</div>

<?php 

include '../footer.php';

?>