<?php $page['dialog_skin']='idialog';?>
<?php include(dirname(__FILE__)."/../head.php")?>
<body>
<?php include(dirname(__FILE__)."/../global-bar.php")?>
<script>
art.dialog({
	cancel:false,
    icon: '<?php echo isset($msg['icon'])?$msg['icon']:'question'; ?>',
    content: '<?php echo isset($msg['msgwords'])?$msg['msgwords']:''; ?>'
});

</script>
<?php echo isset($msg['jscode'])?$msg['jscode']:'';?>
</body>
</html>