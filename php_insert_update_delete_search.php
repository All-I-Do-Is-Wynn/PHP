<?php

	$host = 'localhost';
	$user = "root";
	$password = "";
	$database = "uofl";
	
	$id = "";
	$fname = "";
	$lname = "";
	$age = "";
		
	
	//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	
	try{
		$connect = mysqli_connect($host,$user,$password,$database);
	}catch (Exception $ex){
		echo 'Error';
	}
	
	
	
	//Gets values from the form
	function getPosts()
	{
		$posts = array();
		$posts[0] = $_POST['id'];
		$posts[1] = $_POST['fname'];
		$posts[2] = $_POST['lname'];
		$posts[3] = $_POST['age'];
		return $posts;
	}

	
	//Search Function
if(isset($_POST['search']))
{
	$data = getPosts();
	$search_Query = "SELECT * FROM research WHERE id = $data[0]";
	$search_Result = mysqli_query($connect, $search_Query);
	
	if($search_Result)
	{
		if(mysqli_num_rows($search_Result))
		{
			while($row = mysqli_fetch_array($search_Result))
			{
				$id = $row['id'];
				$fname = $row['fname'];
				$lname = $row['lname'];
				$age = $row['age'];
			}
		}else{
			echo 'No data for this ID';
		}
	}else {
		echo 'Result Error';
	}	
}
	
	
	//Insert Function
if(isset($_POST['insert']))
{
	$data = getPosts();
	$insert_Query = "INSERT INTO
	research (fname, lname, age) VALUES 
	('$data[1]', '$data[2]', $data[3])";
		try{
			$insert_Result = mysqli_query($connect,$insert_Query);
			
			if($insert_Result)
			{
				if(mysqli_affected_rows($connect)>0)
				{
					echo 'Data inserted';
				}else{
					echo 'Data not inserted';
				}
			}
		}catch (Exception $ex) {
			echo 'Error Insert' . $ex->getMessage();
		}
}



	//Delete Function
if(isset($_POST['delete']))
{
	$data = getPosts();
	$delete_Query = "DELETE FROM research WHERE id = $data[0]";
	try{
		$delete_Result = mysqli_query($connect, $delete_Query);
			
		if($delete_Result)
		{
			if(mysqli_affected_rows($connect) > 0)
			{
				echo 'Data Deleted';
			}else{
				echo 'Data Not deleted';
			}
		}
	} catch (Exception $ex) {
		echo 'Error Delete '.$ex->getMessage();
	}
}
	
	
	
	//Edit Function
if(isset($_POST['update']))
{
	$data = getPosts();
	$update_Query = "UPDATE
	research SET fname= '$data[1]', lname='$data[2]', age=$data[3]
	WHERE id= $data[0]";
		try{
			$update_Result = mysqli_query($connect,$update_Query);
			
			if($update_Result)
			{
				if(mysqli_affected_rows($connect)>0)
				{
					echo 'Data updated';
				}else{
					echo 'Data not updated';
				}
			}
		}catch (Exception $ex) {
			echo 'Error update' . $ex->getMessage();
		}
}



?>

<!DOCTYPE Html>
<html>
	<head>
		<title>PHP INSERT UPDATE DELETE SEARCH </title>
	</head>
	<body>
		<!-- Form Created -->
		<form action = "php_insert_update_delete_search.php" method="POST">
			<input type="number" name="id" placeholder="Id" value="<?php echo $id;?>"><br><br>
			<input type="text" name="fname" placeholder="First Name" value="<?php echo $fname;?>"><br><br>
			<input type="text" name="lname" placeholder="Last Name" value="<?php echo $lname;?>"><br><br>
			<input type="number" name="age" placeholder="Age" value="<?php echo $age;?>"><br><br>
			<div>
				<!-- Sets each of the variables as a button -->
				<input type="submit" name="insert" value="Add">
				<input type="submit" name="update" value="Update">
				<input type="submit" name="delete" value="Delete">
				<input type="submit" name="search" value="Find">
			</div>
		</form>
</body>
</html>



