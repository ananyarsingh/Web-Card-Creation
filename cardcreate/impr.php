<?php 
$count = 0;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	// let's first check whether the image is selected or not
	if(empty($_FILES['ImageToProcess']))
	{
		echo "<p>Image is required before doing processing using PHP.</p>";
		echo "<p>Exiting...</p>";
		exit();
	}
	else 
	{
		$tmp_image = $_FILES['ImageToProcess']['tmp_name'];
		// in last part of code given below contains double \ 
		// where first \ is the part of directory and second 
		// \ is to make double inverted comma works
		$where_to_process_image = "C:/xampp/htdocs/uploaded-file/";
		$original_image_name = basename($_FILES['ImageToProcess']['name']);
		$original_image_name_with_directory = $where_to_process_image.$original_image_name;
		$process_image_type = pathinfo($original_image_name_with_directory, PATHINFO_EXTENSION);
		if(isset($_POST['submit']))
		{
			$check_image_before_process = getimagesize($_FILES['ImageToProcess']['tmp_name']);
			if($check_image_before_process != false)
			{
				// if image is correct according to image size
			}
			else 
			{
				echo "<p>Error before processing the given image.</p>";
				echo "<p>Exiting...</p>";
				exit();
			}
		}
		$processed_image = $original_image_name.".".$process_image_type;
		$process_image_size = $_FILES['ImageToProcess']['size'];
		// now check whether the processing image size is less than 
		// 10MB or not. You can also change the size value according
		// to your requirement. Here you have to provide the byte value
		// for 10 MB it will be 1024*1024*10, which will be 
		// 10485760 bytes
		if($process_image_size > 10485760)
		{
			echo "<p>Image with size greather than 10MB is not allowed to processs...exiting...</p>";
			exit();
		}
		// now check the type of image before finalizing the process of given image
		if($process_image_type != "jpg" && $process_image_type != "png" && $process_image_type != "jpeg")
		{
			echo "<p>Image other than jpeg, jpg and png is not allowed to process...exiting...</p>";
			exit();
		}
		// now move the processed image from temporary directory to your 
		// provided directory and at the same time also check whether 
		// the image is successfully moved or not
		if(move_uploaded_file($tmp_image, $where_to_process_image.$processed_image))
		{
			$save_processed_image = $where_to_process_image.$processed_image;
			$image_file = $where_to_process_image.$processed_image;
			list($width, $height) = getimagesize($image_file);
			$tln = imagecreatetruecolor($width, $height);
			$target = $where_to_process_image.$processed_image;
			$image_info = getimagesize($target);
			$tln = imagecreatetruecolor($width, $height);
			$target = $where_to_process_image.$processed_image;
			$image_info = getimagesize($target);
			if($image_info['mime'] == 'image/jpeg')
			{
				$image = imagecreatefromjpeg($image_file);
			}
			elseif($image_info['mime'] == 'image/png')
			{
				$image = imagecreatefrompng($image_file);
			}
			imagecopyresampled($tln, $image, 0, 0, 0, 0, $width, $height, $width, $height);
			$count++;
		}
		else 
		{
			echo "<p>Error occurred in saving the image in your given directory..exiting..</p>";
			exit();
		}
	}
}
?>
<html>
<head>
	<title>PHP Image Processing Example - codescracker</title>
</head>
<body>
<?php 
	if($count==0) 
	{ 
?>
		<form method="post" enctype="multipart/form-data">
			<input type="file" name="ImageToProcess" required><br/><br/>
			<input type="submit" value="Process and Upload Image">
		</form>
<?php 
	}
	else 
	{
		echo "<p>Your image is processed and saved successfully.</p>";
	}
?>
</body>
</html>
