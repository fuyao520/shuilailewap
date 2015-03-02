<?php 
/*{
"name":"直接显示正文"
}*/
?>

<?php foreach($page['listdata']['list'] as $r){?>
<?php echo $r['info_body']; ?>
<?php break;} ?>