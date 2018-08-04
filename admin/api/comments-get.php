<?php  

require_once  '../../functions.php';

$length = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $length; 
$res = xiu_fetch_all("select
comments.*,
posts.title
from comments 
inner join posts on comments.post_id= posts.id
order by comments.created desc
limit {$offset},{$length}
");
$allcomments = xiu_fetch_one('select count(0) as num from comments')['num'];
$arr = array(
  "held" => "待审核",
  "approved" => "准许",
  "rejected" => "拒绝",
  "trashed" => "回收站"
);
// 待审核（held）/ 准许（approved）/ 拒绝（rejected）/ 回收站（trashed）
foreach ($res as &$item) {
	$str = strtotime($item['created']);
    $item['created'] = date('Y年m月d日h:m:s',$str);
    $item['status'] = $arr[$item['status']];
};

isset($_COOKIE['allcomments']) ? "" : setcookie('allcomments',$allcomments);

header('Content-type: application/json');

echo json_encode($res);
