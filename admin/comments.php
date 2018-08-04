<?php

require_once '../functions.php';

xiu_get_current_user();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
  <style type="text/css">
    .ball-scale-multiple {
/*       display: flex; */
     /*  justify-content: center;
      align-items: center; */
      transform: scale(1);
      z-index: 999;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, .5);
    }

    .ball-scale-multiple > div:nth-child(2) {
      -webkit-animation-delay: -0.4s;
      animation-delay: -0.4s;
    }

    .ball-scale-multiple > div:nth-child(3) {
      -webkit-animation-delay: -0.2s;
      animation-delay: -0.2s;
    }

    .ball-scale-multiple > div {
      background-color: #1D349A;
      width: 15px;
      height: 15px;
      border-radius: 100%;
      margin: 2px;
      -webkit-animation-fill-mode: both;
      animation-fill-mode: both;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      opacity: 0;
      margin: 0;
      width: 60px;
      height: 60px;
      -webkit-animation: ball-scale-multiple 1s 0s linear infinite;
      animation: ball-scale-multiple 1s 0s linear infinite;
    }

    @-webkit-keyframes ball-scale-multiple {
      0% {
        -webkit-transform: scale(0);
        transform: scale(0);
        opacity: 0;
      }

      5% {
        opacity: 1;
      }

      100% {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 0;
      }
    }

    @keyframes ball-scale-multiple {
      0% {
        -webkit-transform: scale(0);
        transform: scale(0);
        opacity: 0;
      }

      5% {
        opacity: 1;
      }

      100% {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 0;
      }
    }
  </style>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php'; ?>

    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
<ul id="pagecontrol" class="pagination pagination-sm pull-right"></ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th class="text-center" width="60">作者</th>
            <th>评论</th>
            <th class="text-center" width="120">评论在</th>
            <th class="text-center" width="150">提交于</th>
            <th class="text-center" width="60">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!--  <tr class={{if $value.author == "哈哈"}}"danger"{{else $value.author=="小右" }}"warning"{{/if}}> -->
          <script type="text/x-jsrender" id="comments_templ">
              {{each comments}}
                 <tr class={{$value['status'] == "准许" ? "success" : $value['status'] == "待审核" ? "danger": ""}}>
                    <td class="text-center"><input type="checkbox"></td>
                    <td class="text-center">{{$value.author}}</td>
                    <td>{{$value.content}}</td>
                    <td class="text-center">{{$value.title}}</td>
                    <td class="text-center">{{$value.created}}</td>
                    <td class="text-center">{{$value.status}}</td>
                    <td class="text-center" width="150">
                      {{if $value['status'] === '待审核'}}
                      <a class="btn btn-info btn-xs btn-edit" href="javascript:;" data-status="approved">批准</a>
                      <a class="btn btn-warning btn-xs btn-edit" href="javascript:;" data-status="rejected">拒绝</a>
                      {{/if}}
                      <a class="btn btn-danger btn-xs btn-delete" href="javascript:;" data-id="{{$value['id']}}">删除</a>
                    </td>
                 </tr>
              {{/each}}
          </script>
        </tbody>
      </table>
    </div>
  </div>
  
  <div class="ball-scale-multiple">
    <div></div>
    <div></div>
    <div></div>
  </div>
  
  <?php $current_page = 'comments'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- <script src="/static/assets/vendors/jsrender/jsrender.js"></script> -->
  <script src="/static/assets/vendors/twbs-pagination/template-web.js"></script>
  <script src="/static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>

  <script>NProgress.done()</script>

  <script>
    $(document).ajaxStart(function() {
      NProgress.start();
      $('.ball-scale-multiple').fadeIn();
    }).ajaxSend(function(event, xhr, settings) {
       NProgress.done()
       $('.ball-scale-multiple').fadeOut();
    });
    function loadpage (page) {
       $.getJSON('/admin/api/comments-get.php', {page: page}, function(res, textStatus) {
           var html = template('comments_templ',{comments: res});
           $('tbody').html(html);
       });

    }
    loadpage();
    $('.pagination').twbsPagination({
        totalPages: 100,
        visiablePages : 7,
        onPageClick : function (e, page) {
           loadpage(page);
        }
    })
    $('.btn-delete').on('click', function(event) {
          console.log("a");
    });
  </script>
</body>
</html>
