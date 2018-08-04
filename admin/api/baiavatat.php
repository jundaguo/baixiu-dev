<?php  
// var_dump($_FILES['avatar']);

if (empty($_FILES['avatar'])) {
   exit("必须上传文件");
}

$file = $_FILES['avatar'];

$target = "../../static/assets/img/".uniqid().'.'.pathinfo($file['name'],PATHINFO_EXTENSION);



if (!move_uploaded_file($file['tmp_name'],$target)) {
	exit("移动失败");
}

echo $target;
?>