<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="../static/assets/vendors/jquery/jquery.js"></script>
</head>
<body>
	<ul>
		
	</ul>
	<!-- <script>
		function foo (res) {
            console.log(res);
		}
	</script> -->
	<!-- <script src="http://api.douban.com/v2/movie/in_theaters?callback=foo"></script> -->
	<script>
		$.ajax({
			url : "http://api.douban.com/v2/movie/in_theaters",
			dataType: "jsonp",
			success: function (res) {
				$(res.subjects).each(function (index,val) {
                    $('<li></li>').html(val.title).appendTo($('ul'));
				})
			}
		});
		
	</script>
</body>
</html>