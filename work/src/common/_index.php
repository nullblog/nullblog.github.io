<?php
$dataArr = array();
$currentDate = '';
foreach($data as $d) {
	if(strpos('/blog'.$d->blogtype, $dirName) !== false) {
		$dataArr[] = $d;
		if($currentDate == '' || strtotime($currentDate) < strtotime($d->date)) {
			$currentDate = $d->date;
		}
	}
}

$meta = array(
  'description' => $dirName . 'のブログ一覧',
  'keywords' => $dirName,
  'title' =>  $dirName . 'のブログ一覧',
  'date' => $currentDate
);
include('src/common/_head.php');
?>
<div class="row">
  <div class="col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title text-center"><?php echo $meta['title']; ?></h3>
      </div>
      <table class="table table-striped">
        <?php foreach($dataArr as $d): ?>
          <tr>
            <td><a href="<?php echo $d->href; ?>"><strong><?php echo $d->title; ?></strong></a></td>
            <td><a href="/blog<?php echo $d->blogtype; ?>/"><strong>/blog<?php echo $d->blogtype; ?></strong></a></td>
            <td><a href="<?php echo $d->href; ?>"><strong><?php echo $d->date; ?></strong></a></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
<?php include('src/common/_foot.php'); ?>
