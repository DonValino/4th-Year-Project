<?php
if(isset($_POST['partialResult'])){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "freelanceme";
    	try{
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$searchQuery  = $_POST['partialResult'];
		$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM `users` WHERE username LIKE ?");
		$stmt->execute(array("%$searchQuery%"));
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		 	$user_count = $row["count"];
		}
		$stmt = $conn->prepare("SELECT * FROM `users` WHERE username LIKE ?");
		$stmt->execute(array("%$searchQuery%"));
		if ($user_count > 0 && $searchQuery != ''){
			echo '<p><strong> results found: '.$user_count.' </strong></p>'
                                . '<div class="table-responsive">
                                                        <table class="table sortable">
                                                        <tr>
                                                        <th style="text-align:center;">Username</th>
                                                        <th style="text-align:center;">Email</th>
                                                        </tr>';
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				echo '
                                                        <tr>
                                                        <td align="center"><a href="Messages.php?epr=view&fromusername='.$row['username'].'">'.$row['username'].'</a></td>
                                                        <td align="center">'.$row['email'].'</td>
                                                        </tr>
                                                        ';
			}
                        echo '</div>';
		} else if ($user_count > 0 && $searchQuery == '') {
			
		}else
                {
                    echo '<p> results found: '.$user_count.'</p>';	
                }
	} catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;
}
?>
