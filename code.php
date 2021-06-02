<?php
session_start();
$conn = mysqli_connect("localhost","root","","phptutorials");

if (isset($_POST['save_stud_image'])) {
	
	$name = $_POST['stud_name'];
	$class = $_POST['stud_class'];
	$phone = $_POST['stud_phone'];
	$image = $_FILES['stud_image']['name'];

	/*$allowed_extension = array('gif','png','jpg','jpeg');
	$filename = $_FILES['stud_image']['name'];
	$file_extension = pathinfo($filename,PATHINFO_EXTENSION);


	if ($in_array($file_extension,$allowed_extension)) 
	{
		$_SESSION['status'] = "You are allowed only with gif,png,jpg,jpeg";
		header('location: create.php');
	} 
	else 
	{*/
		if (file_exists('upload/'.$_FILES['stud_image']['name'])) 
		{
			
			$filename = $_FILES['stud_image']['name'];
			$_SESSION['status'] = "Image already Exists ".$filename;
			header('location: index.php');
		} 
		else 
		{
			$query = "insert into student (stud_name,stud_class,stud_phone,stud_image) values ('$name','$class','$phone','$image')";
			$query_run = mysqli_query($conn,$query);

			if ($query_run) {
				move_uploaded_file($_FILES['stud_image']['tmp_name'],"upload/".$_FILES['stud_image']['name']);
				$_SESSION['status'] = "Data Saved Successfully";
				header('location: index.php');
			}
			else
			{
				$_SESSION['status'] = "Data Not Saved Successfully";
				header('location: index.php');
			}
		}
	/*}*/
	

		
}

if (isset($_POST['update_stud_image'])) {
	
	$stud_id = $_POST['stud_id'];
	$name = $_POST['stud_name'];
	$class = $_POST['stud_class'];
	$phone = $_POST['stud_phone'];
	$new_image = $_FILES['stud_image']['name'];
	$old_image = $_POST['stud_image_old'];

	if ($new_image !='') 
	{
		$update_image = $_FILES['stud_image']['name'];
	} 
	else 
	{
		$update_image = $old_image;
	}
	

	/*$allowed_extension = array('gif','png','jpg','jpeg');
	$filename = $_FILES['stud_image']['name'];
	$file_extension = pathinfo($filename,PATHINFO_EXTENSION);


	if ($in_array($file_extension,$allowed_extension)) 
	{
		$_SESSION['status'] = "You are allowed only with gif,png,jpg,jpeg";
		header('location: create.php');
	} 
	else 
	{*/
		/*if ($_FILES['stud_image']['name'] !='') 
		{*/
			if (file_exists('upload/'.$_FILES['stud_image']['name'])) 
			{				
				$filename = $_FILES['stud_image']['name'];
				$_SESSION['status'] = "Image already Exists ".$filename;
				header('location: index.php');
			} 			
		/*}*/ 
		else 
		{
			$query = "update student set stud_name='$name',stud_class='$class',stud_phone='$phone',stud_image='$update_image' where id='$stud_id'";
			$query_run = mysqli_query($conn,$query);

			if ($query_run)
			{
				if ($_FILES['stud_image']['name'] !='') 
				{
					move_uploaded_file($_FILES['stud_image']['tmp_name'],"upload/".$_FILES['stud_image']['name']);
					unlink("upload/".$old_image);
				}
				
				$_SESSION['status'] = "Data Updated Successfully";
				header('location: index.php');
			}
			else
			{
				$_SESSION['status'] = "Data Not Updated Successfully";
				header('location: index.php');
			}
		}
	/*}*/
	

		
}

if (isset($_POST['delete_stud_image'])) 
{
	$id = $_POST['delete_id'];
	$stud_image = $_POST['del_stud_image'];

	$query = "delete from student where id='$id'";
	$query_run = mysqli_query($conn,$query);

	if ($query_run)
	{
		unlink("upload/".$stud_image);		
		$_SESSION['status'] = "Data Deleted Successfully";
		header('location: index.php');
	}
	else
	{
		$_SESSION['status'] = "Data Not Deleted Successfully";
		header('location: index.php');
	}
}

?>