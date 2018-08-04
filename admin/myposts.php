<?php 

require_once '../functions.php';

xiu_get_current_user();
// select 
// posts.id,
// users.nickname as author,
// categories.`name` as category,
// posts.created,
// posts.`status` from posts 
// inner join users on posts.user_id = users.id 
// inner join categories on posts.category_id = categories.id

function convert_date ($date) {
   $timestamp = strtotime($date);
   return date('Y年m月d日<b\r>h:m:s',$timestamp); 
}
function concert_status($status){
  // 草稿（drafted）/ 已发布（published）/ 回收站（trashed）
   $arr = array(
      'drafted' => "草稿",
      'published' => "已发布",
      'trashed' => "回收站"
   );
   return  isset($arr[$status]) ? $arr[$status] : "未知";
}
function convert_author ($author) {
  $result_user = xiu_fetch_one("select * from users where id = {$author};");
  return $result_user['nickname'];
}
function convert_category ($category) {
  $result_user = xiu_fetch_one("select * from categories where id = {$category};");
  return isset($result_user['name']) ? $result_user['name'] : "未知";
}

$id = isset($_GET['page']) ? $_GET['page'] : 0;
$id = ($id-1 > 0) ? $id-1 : 0;
$id = $id*10;
$res = xiu_fetch_all('select 
posts.id,
posts.title,
users.nickname as author,
categories.`name` as category,
posts.created,
posts.`status` from posts 
inner join users on posts.user_id = users.id 
inner join categories on posts.category_id = categories.id limit '.$id.',20');
if (isset($_GET['page']) && $_GET['page'] > 101) {
   exit('您请求的页面不存在');
}  
if ( $_SERVER['REQUEST_METHOD'] == "GET" && empty($_GET['page']) && $_COOKIE['page']) {
    setcookie('page','1');
}
if ( $_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['page']) ) {
    $_GET['page'] > 0 ? "" : $_GET['page'] = 1;
    setcookie('page',$_GET['page']);
}

!empty($_GET['page']) ? $_GET['page'] : $_GET['page'] = 1;


$categories = xiu_fetch_all('select `name` from categories');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm">
            whi
            
          </select>
          <select name="" class="form-control input-sm">
            <option value="">所有状态</option>
            
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <?php if ($_GET['page']-1 > 0): ?>
              <li id="lastpage"><a href="">上一页</a></li>
          <?php endif ?>
          <?php if ($_GET['page']-3 > 0): ?>
              <li><a href="">...</a></li>
          <?php endif ?>
          <?php if ($_GET['page']-2 > 0): ?>
          <li class="query_count"><a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($_GET['page']-2);?>"><?php echo $_GET['page']-2 ?></a></li>     
          <?php endif ?>
          <?php if ($_GET['page']-1 > 0): ?>
          <li class="query_count"><a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($_GET['page']-1);?>"><?php echo $_GET['page']-1 ?></a></li>     
          <?php endif ?>
          <li class="query_count"><a  style="background-color: #C595BB" href="<?php echo $_SERVER['PHP_SELF'].'?page='.$_GET['page'];?>"><?php echo $_GET['page']; ?></a></li>
          <li class="query_count"><a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($_GET['page']+1);?>"><?php echo $_GET['page']+1 ?></a></li>
          <li class="query_count"><a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($_GET['page']+2);?>"><?php echo $_GET['page']+2 ?></a></li>
          <li><a href="">...</a></li>
          <li id="nextpage"><a href="">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($res as $item): ?>
            <tr>
              <td class="text-center"><input type="checkbox"></td>
              <td><?php echo $item['title'];?></td>
              <td><?php echo $item['author']; ?></td>
              <td><?php echo $item['category'];?></td>
              <td class="text-center"><?php echo $item['created']; ?></td>
              <td class="text-center"><?php echo $item['status']; ?></td>
              <td class="text-center">
                <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = 'posts'; ?>
  <?php include 'inc/sidebar.php'; ?>
  
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
     $(function () {
       if ( document.cookie.indexOf('page') < 0 ) {
          document.cookie = "page=1";
       }
       var arr = document.cookie.split(";");
       var page = arr[0].split('=')[1];
       var nextpage = + page + 1;
       var lastpage = nextpage-2 > 0 ? nextpage-2 : 1;
       $('#nextpage').find('a').attr('href','/admin/posts.php?page=' + nextpage).click(function () {
           document.cookie = "page=" + nextpage;
       });
       $('#lastpage').find('a').attr('href','/admin/posts.php?page=' + lastpage).click(function () {
           document.cookie = "page=" + lastpage;
       });
       $('.query_count').find('a').on('click',function () {
          document.cookie = "page=" + this.innerHTML;
       })

     })
  </script>
</body>
</html>
