<?php
include '../connection.php';
include '../header.php';
$stmt=$con->prepare('select issuebook.User_ID,issuebook.Book_ID,issuebook.Issue_Status,issuebook.Issue_Date,issuebook.Return_Date,issuebook.Issue_ID,
                    book.Name,book.Book_ID,
                    users.User_ID,users.User_Name
					from issuebook,book,users WHERE (issuebook.Book_ID=book.Book_ID)
					AND (issuebook.User_ID=users.User_ID)');
$stmt->execute();
$rows=$stmt->fetchAll();
?>

<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Issue Book Management
                </div>

            </div>
        </div>
        <div class="card-body">
        	<table id="datatablesSimple">
        		<thead> 
        			<tr>
                        <th>User Name</th>
        				<th>Book Name</th>
        				<th>Issue Date</th>
        				<th>Return Date</th>
                        <!--<th id="s">Status</th>-->
        			</tr>
        		</thead>
        		<tfoot>
        			<tr>
                        <th>User Name</th>
        				<th>Book Name</th>
        				<th>Issue Date</th>
        				<th>Return Date</th>
                        <!--<th id="s">Status</th>-->
        			</tr>
        		</tfoot>
        		<tbody>
				<?php
                //$date=date('Y-m-d');
                //$dateTime = new DateTime('2023-01-13');
                
                
                //$issueid=$row['Issue_ID'];
				foreach($rows as $row)
				{
				
					echo '<tr>';
                        echo '<td>' . $row['User_Name'] . '</td>';                        
						echo '<td>' . $row['Name'] . '</td>';
                        echo '<td>' . $row['Issue_Date'] . '</td>';
                        echo '<td>' . $row['Return_Date'] . '</td>';
						//echo '<td>' . $row['Issue_Status'] . '</td>';
					echo '</tr>';
					
				}
			 ?>

                
        		</tbody>
        	</table>
        </div>
    </div>





<?php
include '../footer.php';
?>