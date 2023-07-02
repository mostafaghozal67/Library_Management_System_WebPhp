<?php
include 'connection.php';
include 'header.php';
//$stmt=$con->prepare('select * from book');
$userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
$stmt=$con->prepare('select book.Name,book.Book_ID,book.Number,book.Category_ID,book.Author_ID,book.Publisher_ID,book.No_of_Copy,category.Category_Name,
					author.author_name,publishers.Publisher_Name,User_ID,User_Name
					from book,category,author,publishers,users WHERE (book.Category_ID=category.Category_ID) AND (book.Author_ID=author.author_ID)
					AND (book.Publisher_ID=publishers.Publisher_ID) AND(User_ID=?)');
$stmt->execute(array($userid));
$rows=$stmt->fetchAll();
$stmt2=$con->prepare('select User_ID from users');
$stmt2->execute();
$rows2=$stmt2->fetchAll();
isset($_GET['do']) ? $do=$_GET['do'] : $do='mange';

switch($do){
    case'mange':
        ?>
        <div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Available Books
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
                        echo '<td>';
                        
                        if($row['No_of_Copy']>0){
                            
                            echo '<a href="home.php?do=issue&userid=' . $row["User_ID"] . '&bookid=' . $row["Book_ID"] .'" class="btn btn-success">Issue</a>';                
                        }
                         if($row['No_of_Copy']==0){
                            $message='Book Is not available';
                            echo '<div class="alert alert-danger">'.$message.'</div>';

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
        
    case 'issue' :
        //echo'hi';
        $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
        $bookid=isset($_GET['bookid']) && is_numeric($_GET['bookid']) ? intval($_GET['bookid']) : 0 ;
        $date=date('Y-m-d');
        $dt = strtotime($date);
        $returndate=date('Y-m-d',strtotime("+7 days",$dt));
        //echo $returndate;
        $stmt=$con->prepare('INSERT INTO issuebook (User_ID,Book_ID,Issue_Date,Return_Date)
								VALUES(:userid,:bookid,:issuedate,:returndare)');
        $stmt->execute(array(
                              'userid'   => $userid,
                              'bookid'    => $bookid,
                              'issuedate' => $date,
                              'returndare' => $returndate
                              ));
        $message="Book Has Been issued";
			echo '<div class="alert alert-success">'.$message.'</div>';
        //header('location: home.php?userid='.$userid);
        header( "refresh:2;url=home.php?userid=".$userid);
        
    ?>
    
<?php      
}// end of switch



//echo $row['User_ID'];


include 'footer.php';

?>
