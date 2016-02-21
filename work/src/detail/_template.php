<?php
$meta = array(
  'description' => 'string',
  'keywords' => 'csv',
  'title' =>  'string',
  'date' => 'yyyy-mm-dd'
);
?>
<?php include('src/common/_head.php'); ?>
<div class="row">
  <div class="col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title text-center"><?php echo $meta['title']; ?></h3>
      </div>
      <div class="panel-body">
      記事をがりがり書いていくスペース
      </div>
    </div>
  </div>
</div>
<?php include('src/common/_foot.php'); ?>
