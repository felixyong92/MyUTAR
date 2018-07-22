<?php 
	
$target_dir = "basic/web/uploads/feedback_Images";
$imageName = $_POST["img_name"];

if(!file_exists($target_dir)){

	mkdir($target_dir, 0777, true);
}

$destination = $target_dir.'/'.$imageName;

if(move_uploaded_file($_FILES['file']['tmp_name'], $destination)){
	echo json_encode([
		"Message" => "The file ".$_POST['img_name']." has been uploaded",
	]);

}else{
	
	echo json_encode([
		"Message" => "The file ".$_POST['img_name']." has NOT been uploaded",
	]);

}

?>