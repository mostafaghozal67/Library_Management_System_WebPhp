<?php

//book.php

include '../connection.php';
include '../header.php';
isset($_GET['do']) ? $do=$_GET['do'] : $do='mange';
$stmt=$con->prepare('select book.Name,book.Book_ID,book.Number,book.Category_ID,book.Author_ID,book.Publisher_ID,book.No_of_Copy,book.Status,book.Created_on,book.Updated_on,category.Category_Name,
					author.author_name,publishers.Publisher_Name
					from book,category,author,publishers WHERE (book.Category_ID=category.Category_ID) AND (book.Author_ID=author.author_ID)
					AND (book.Publisher_ID=publishers.Publisher_ID)');
$stmt->execute();
$rows=$stmt->fetchAll();
$stmt2=$con->prepare('select Category_ID from category');
$stmt2->execute();
$results=$stmt2->fetchAll();
$stmt3=$con->prepare('select author_ID from author');
$stmt3->execute();
$options=$stmt3->fetchAll();
$stmt4=$con->prepare('select Publisher_ID from publishers');
$stmt4->execute();
$publishers=$stmt4->fetchAll();

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Book Management</h1>
<?php
switch($do){
    case 'add' :
        
        ?>
        <!-- add page--> 
        <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="book.php">Book Management</a></li>
            <li class="breadcrumb-item active">Add Book</li>
        </ol>
    
        
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-plus"></i> Add New Book
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Book Name</label>
                                <input type="text" name="book_name" id="book_name" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Select Author</label>
                                <select name="book_author" id="book_author" class="form-control">
                                    <option>Select Author</option>
									<?php
									foreach($options as $option) {
										    echo'<option>'. $option['author_ID'].  '</option>';
	
									}
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Select Category</label>
                                <select name="book_category" id="book_category" class="form-control">
									<option>Select Category</option>
									<?php
									foreach($results as $result) {
										    echo'<option>'. $result['Category_ID'].  '</option>';
	
									}
                                    ?>
                                </select>
                            </div>
                        </div>
						
                        <div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Select Publisher</label>
        					<select name="book_publisher" id="book_location_rack" class="form-control">
        						<option>Select Publisher</option>
									<?php
									foreach($publishers as $publisher) {
										    echo'<option>'. $publisher['Publisher_ID'].  '</option>';
	
									}
                                    ?>
        					</select>
        				</div>
        			</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Book ISBN Number</label>
                                <input type="text" name="book_number" id="book_isbn_number" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. of Copy</label>
                                <input type="number" name="book_no_of_copy" id="book_no_of_copy" step="1" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-3 text-center">
                        <input type="submit" name="add_book" class="btn btn-success" value="Add" />
                    </div>
                </form>
            </div>
        </div>
    <?php
	
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$bookname=$_POST['book_name'];
			$number=$_POST['book_number'];
			$bookcat=$_POST['book_category'];
			$bookauth=$_POST['book_author'];
			$bookpub=$_POST['book_publisher'];
			$bookcopy=$_POST['book_no_of_copy'];
			$date=date('Y-m-d');
			$stmt=$con->prepare('INSERT INTO book (Name,Number,Category_ID,Author_ID,Publisher_ID,No_of_Copy ,Created_on,Updated_on)
								VALUES(:bookname,:booknum,:bookcat,:bookauth,:bookpub,:bookcopy,:bookcreated,:bookupdated)');
			$stmt->execute(array(
								  'bookname'   => $bookname,
								  'booknum'    => $number,
								  'bookcat'    => $bookcat,
								  'bookauth'   => $bookauth,
								  'bookpub'    => $bookpub,
								  'bookcopy'   => $bookcopy,
								  'bookcreated' => $date,
								  'bookupdated' => $date
								  ));
		}
    break;
    
    case 'mange' :
        ?>
        <div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Book Management
                </div>
                <div class="col col-md-6" align="right">
                	<a href="book.php?do=add" class="btn btn-success btn-sm">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
        	<table id="datatablesSimple">
        		<thead> 
        			<tr> 
        				<th>Book Name</th>
        				<th>ISBN No.</th>
        				<th>Category</th>
        				<th>Author</th>
						<th>Publisher</th>
        				<th>No. of Copy</th>
        				<th>Status</th>
        				<th>Created On</th>
        				<th>Updated On</th>
        				<th>Action</th>
						
						
        			</tr>
        		</thead>
        		<tfoot>
        			<tr>
        				<th>Book Name</th>
        				<th>ISBN No.</th>
        				<th>Category</th>
        				<th>Author</th>
						<th>Publisher</th>
        				<th>No. of Copy</th>
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
						echo '<td>' . $row['Name'] . '</td>';
						echo '<td>' . $row['Number'] . '</td>';
						echo '<td>' . $row['Category_Name'] . '</td>';
						echo '<td>' . $row['author_name'] . '</td>';
						echo '<td>' . $row['Publisher_Name'] . '</td>';
						echo '<td>' . $row['No_of_Copy'] . '</td>';
						echo '<td>' . $row['Status'] . '</td>';
						echo '<td>' . $row['Created_on'] . '</td>';
						echo '<td>' . $row['Updated_on'] . '</td>';
						
						
						echo '<td>';
								 echo '<a href="book.php?do=edit&bookid=' . $row["Book_ID"] . '" class="btn btn-success">edit</a>';
								 echo '<a href="book.php?do=delete&bookid=' . $row["Book_ID"] . '" class="btn btn-danger confirm">delete</a>';
								 if($row['Status']==0)
								 {
									 echo '<a href="book.php?do=activate&bookid=' . $row["Book_ID"] . '" class="btn btn-info">Activate</a>';
								 }
						 echo '</td>';
						 //echo '<td>' . $row['Publisher_Name'] . '</td>';
					   
						
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
		
		$book_id=isset($_GET['bookid']) && is_numeric($_GET['bookid']) ? intval($_GET['bookid']) : 0 ;
		$stmt=$con->prepare('SELECT * FROM book WHERE Book_ID=?');
		$stmt->execute(array($book_id));
		$row=$stmt->fetch();
		
        ?>
        <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="book.php">Book Management</a></li>
            <li class="breadcrumb-item active">Edit Book</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-plus"></i> Edit Book Details
            </div>
            <div class="card-body">
                <form method="post">
					
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Book Name</label>
                                <input type="text" name="book_name" id="book_name" class="form-control" value="<?php echo $row['Name']; ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Select Author</label>
                                <select name="book_author" id="book_author" class="form-control">
									 <option><?php echo $row['Author_ID'];?></option>
									<?php
									foreach($options as $option) {
										    echo'<option>'. $option['author_ID'].  '</option>';
	
									}
                                    ?>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Select Category</label>
                                <select name="book_category" id="book_category" class="form-control">
                                    <option><?php echo $row['Category_ID'];?></option>
									<?php
									foreach($results as $result) {
										    echo'<option>'. $result['Category_ID'].  '</option>';
	
									}
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Select Publisher</label>
                                <select name="book_publisher" id="book_location_rack" class="form-control">
									<option><?php echo $row['Publisher_ID'];?></option>
									<?php
									foreach($publishers as $publisher) {
										    echo'<option>'. $publisher['Publisher_ID'].  '</option>';
	
									}
                                    ?>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Book ISBN Number</label>
                                <input type="text" name="book_number" id="book_isbn_number" class="form-control" value="<?php echo $row['Number']; ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. of Copy</label>
                                <input type="number" name="book_no_of_copy" id="book_no_of_copy" class="form-control" step="1" value="<?php echo $row['No_of_Copy']; ?>" />
								
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-3 text-center">
                        
                        <input type="submit" name="edit_book" class="btn btn-primary" value="Edit" />
                    </div>
                </form>
                <script>
                    
                </script>
            </div>
        </div>
		<?php
		if($_SERVER['REQUEST_METHOD']=='POST')
			{
				$bookname=$_POST['book_name'];
				$number=$_POST['book_number'];
				$bookcat=$_POST['book_category'];
				$bookauth=$_POST['book_author'];
				$bookpub=$_POST['book_publisher'];
				$bookcopy=$_POST['book_no_of_copy'];
				$date=date('Y-m-d');
				$stmt=$con->prepare('UPDATE book SET Name=?, Number=?, Category_ID=?, Author_ID=?,Publisher_ID=?,No_of_Copy=? ,Updated_On=? WHERE Book_ID=?');
				$stmt->execute(array($bookname,$number,$bookcat,$bookauth,$bookpub,$bookcopy,$date,$book_id));
			}
		break;
	case 'activate' :
			$book_id=isset($_GET['bookid']) && is_numeric($_GET['bookid']) ? intval($_GET['bookid']) : 0 ;
			$stmt=$con->prepare('UPDATE book SET Status=1 WHERE Book_ID=?');
			$stmt->execute(array($book_id));
			echo'Category'. $book_id . 'is activated';
			break;
	case'delete':
			$book_id=isset($_GET['bookid']) && is_numeric($_GET['bookid']) ? intval($_GET['bookid']) : 0 ;
			$stmt=$con->prepare('Delete  from book WHERE Book_ID=?');
			$stmt->execute(array($book_id));
			echo'Category'. $book_id . 'is deleted';
			break;
		?>
		
		
		
        
       
        
<?php 
}
?>
   


	
    <script>


    </script>
   
</div>


<?php

include '../footer.php';

?>