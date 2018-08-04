<?php

require_once '../functions.php';

xiu_get_current_user();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Settings &laquo; Admin</title>
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
        <h1>网站设置</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="form-horizontal">
          <label class="form-image">
            <input id="logo" type="file">
            <img src="/static/assets/img/logo.png">
            <i class="mask fa fa-upload"></i>
          </label>
      </form>
  <?php $current_page = 'settings'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
      $('input').on('change', function(event) {
         var slef = this;
          if (!$(this).prop('files').length) return;
          var file = $(this).prop('files')[0];
          var data =  new FormData(); 
          data.append("avatar", file);
          var xhr = new XMLHttpRequest();
          xhr.open('POST','/admin/api/baiavatat.php');
          xhr.send(data);
          xhr.onload = function () {
             $(slef).siblings('img').attr('src',this.responseText);
          }
      });
  </script>
</body>
</html>
