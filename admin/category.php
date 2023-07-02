<?php

//category.php

include '../connection.php';
//include '../function.php';
include '../header.php';
isset($_GET['do']) ? $do=$_GET['do'] : $do='mange';// if con
$stmt=$con->prepare('SELECT * FROM category');
$stmt->execute();
$rows=$stmt->fetchAll();

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Category Management</h1>
	
	<?php
	switch($do)
	{
		case'activate' :
			
			$catid=isset($_GET['categoryid']) && is_numeric($_GET['categoryid']) ? intval($_GET['categoryid']) : 0 ;
			$stmt=$con->prepare('UPDATE category SET Category_Status=1 WHERE Category_ID=?');
			$stmt->execute(array($catid));
			echo'Category'. $catid . 'is activated';
			break;
		//-------------------------------------------
		case'delete' :
			$catid=isset($_GET['categoryid']) && is_numeric($_GET['categoryid']) ? intval($_GET['categoryid']) : 0 ;
			$stmt=$con->prepare('DELETE FROM category WHERE Category_ID=?');
			$stmt->execute(array($catid));
			echo'Category'. $catid . 'is deleted';
			break;
			
		//------------------------------------------
		case'add':
		?>
			<!--Dh bta3 al add category-->
			<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
				<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="category.php">Category Management</a></li>
				<li class="breadcrumb-item active">Add Category</li>
			</ol>
			<div class="row">
				<div class="col-md-6">
					
					<div class="card mb-4">
						<div class="card-header">
							<i class="fas fa-user-plus"></i> Add New Category
						</div>
						<div class="card-body">
		
							<form method="POST">
		
								<div class="mb-3">
									<label class="form-label">Category Name</label>
									<input type="text" name="category_name" id="category_name" class="form-control" />
								</div>
		
								<div class="mt-4 mb-0">
									<input type="submit" name="add_category" value="Add" class="btn btn-success" />
								</div>
		
							</form>
		
						</div>
					</div>
				</div>
			</div>
			
		<?php
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$catname=$_POST['category_name'];
			$date=date('Y-m-d');
			$stmt=$con->prepare('INSERT INTO category (Category_Name, Category_Created_On,Category_Updated_ON) VALUES(:catname,:catcreated,:catupdated)');
			$stmt->execute(array(
								  'catname'    =>$catname,
								  'catcreated' => $date,
								  'catupdated' => $date
								  ));
		}
		
		break;
		//-------------------------------------------------------
		case'edit':
			$catid=isset($_GET['categoryid']) && is_numeric($_GET['categoryid']) ? intval($_GET['categoryid']) : 0 ;
			//echo $catid;
			$stmt=$con->prepare('SELECT * FROM category WHERE Category_ID=?');
			$stmt->execute(array($catid));
			$row=$stmt->fetch();
		?>
			
			<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
				<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="category.php">Category Management</a></li>
				<li class="breadcrumb-item active">Edit Category</li>
			</ol>
			<div class="row">
				<div class="col-md-6">
					<div class="card mb-4">
						<div class="card-header">
							<i class="fas fa-user-edit"></i> Edit Category Details
						</div>
						<div class="card-body">
		
							<form method="post">
								<input type="hidden" name="date" value="<?php echo  date('Y-m-d'); ?>"
		
								<div class="mb-3">
									<label class="form-label">Category Name</label>
									<input type="text" name="category_name" id="category_name" class="form-control" value="<?php echo $row["Category_Name"]; ?>" />
								</div>
		
								<div class="mt-4 mb-0">
									<input type="hidden" name="category_id" value="kan fi code hna?>" />
									<input type="submit" name="edit_category" class="btn btn-primary" value="Edit" />
								</div>
		
							</form>
		
						</div>
					</div>
		
				</div>
			</div>
			<?php
			if($_SERVER['REQUEST_METHOD']=='POST')
			{
				$catname=$_POST['category_name'];
				$updatedDate=$_POST['date'];
				$stmt=$con->prepare('UPDATE category SET Category_Name=? , Category_Updated_On=? WHERE Category_ID=?');
				$stmt->execute(array($catname,$updatedDate,$catid));
			}
			
			
			
			break; 
			//------------------------------------------------------
			case'mange':
				?>
				<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
					<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
					<li class="breadcrumb-item active">Category Management</li>
				</ol>
			
				
			
				
			
				<div class="card mb-4">
					<div class="card-header">
						<div class="row">
							<div class="col col-md-6">
								<i class="fas fa-table me-1"></i> Category Management
							</div>
							<div class="col col-md-6" align="right">
								<a href="category.php?do=add" class="btn btn-success btn-sm">Add</a>
							</div>
						</div>
					</div>
					<div class="card-body">
			
						<table id="datatablesSimple">
							<thead>
								<tr>
									<th>Category Name</th>
									<th>Status</th>
									<th>Created On</th>
									<th>Updated On</th>
									<th>Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Category Name</th>
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
									   echo '<td>' . $row['Category_Name'] . '</td>';
									   echo '<td>' . $row['Category_Status'] . '</td>';
									   echo '<td>' . $row['Category_Created_On'] . '</td>';
									   echo '<td>' . $row['Category_Updated_On'] . '</td>';
									   echo '<td>';
												echo '<a href="category.php?do=edit&categoryid=' . $row["Category_ID"] . '" class="btn btn-success">edit</a>';
												echo '<a href="category.php?do=delete&categoryid=' . $row["Category_ID"] . '" class="btn btn-danger confirm">delete</a>';
												if($row['Category_Status']==0)
												{
													echo '<a href="category.php?do=activate&categoryid=' . $row["Category_ID"] . '" class="btn btn-info">Activate</a>';
												}
										echo '</td>';
									  
									   
								echo '</tr>';
							}
							?>
								
							</tbody>
						</table>
			
						<script>
			
							
			
						</script>
			
					</div>
				</div>
				
			
			</div>
				
			
		
		
		
			
	<?php		
	}//end of switch
	?>
	



	
				
	

		
	

<?php 

include '../footer.php';

?>