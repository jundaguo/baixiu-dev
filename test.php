<?php  
$show_pages = 5;
$total_pages = 20;
$page =  isset($_GET['p']) ? $_GET['p'] : 1;
$begin = $page - ($show_pages - 1)/2;
$begin = $begin > 1 ? $begin : 1;
$end =  $begin + 4;
$end = $end > $total_pages ? $total_pages : $end;
$begin = $end-4;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="static/assets/vendors/jquery/jquery.js"></script>
</head>
<body>
	<div style="width: 200px;height: 200px"></div>
	<?php for ($li = $begin; $li <= $end; $li++): ?>
	   <?php echo $li; ?>
	<?php endfor ?>
</body>
</html>