<?php $page['doctype']=1; ?>
<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
$(document).ready(function(){
	$("#content_left_menu").treeview({
		control: "#treecontrol"
	});

});
</script>
</head>

<body>
<div class="content_left_menu" id="content_left_menu">
     <div style="width:400px;">
     <div class="changebtn">
         <a href="<?php echo $this->createUrl('infoFrame/index'); ?>?is_select_mode=<?php echo  $this->get('is_select_mode'); ?>" target="main" onclick="if(!window.main){$(this).attr('target','_parent')}">分类</a>
         <a href="<?php echo $this->createUrl('infoModelFrame/index'); ?>?is_select_mode=<?php echo  $this->get('is_select_mode'); ?>" class="current" target="main" onclick="if(!window.main){$(this).attr('target','_parent')}">模型</a>
     </div>
     <div id="treecontrol" style="margin:0px 0 0 2px; display:inline-block; position:relative; top:5px;">
        <a></a>
        <a></a>
    </div> 
    <ul id="treeview-black">
       <ul class="filetree">
          <?php foreach($page['models'] as $r){ ?>
       <li>
       <div class="hitarea collapsable-hitarea"></div>
       <span class="folder">
       <a href="<?php echo $this->createUrl('infoModelList/index')?>?model_id=<?php echo $r['model_id']; ?>&is_select_mode=<?php echo  $this->get('is_select_mode'); ?>" target="info_content_main"><?php echo $r['model_name']; ?>(<?php echo InfoModel::model()->get_info_total($r['model_table_name']); ?>)</a>
       </span>
       </li>
      <?php }?>
     </ul> 
     </ul>
     </div>
    </div>
</body>
</html>