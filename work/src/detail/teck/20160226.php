<?php
$meta = array(
  'description' => '',
  'keywords' => 'ご挨拶,エンジニア,ゆとり',
  'title' =>  'ブログの成り立ち（2）',
  'date' => '2016-02-26'
);
?>
<?php include('src/common/_head.php'); ?>
<link href="http://alexgorbatchev.com/pub/sh/current/styles/shCoreDefault.css" rel="stylesheet" type="text/css">
<link href="http://alexgorbatchev.com/pub/sh/current/styles/shThemeDefault.css" rel="stylesheet" type="text/css">
<script src="http://alexgorbatchev.com/pub/sh/current/scripts/shCore.js" type="text/javascript"></script>
<script src="http://alexgorbatchev.com/pub/sh/current/scripts/shBrushPhp.js" type="text/javascript"></script>
<script type="text/javascript">
SyntaxHighlighter.all();
SyntaxHighlighter.defaults['toolbar'] = false;
</script>
<style>
.syntaxhighlighter {
  border:solid 1px #EEE !important;
  overflow-y: hidden !important;
}
.syntaxhighlighter table {
  margin-top: 1em !important;
  margin-bottom: 1em !important;
}
.syntaxhighlighter .line.alt2 {
  background-color: #F8F8F8 !important;
}
</style>
<div class="row">
  <div class="col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title text-center"><?php echo $meta['title']; ?></h3>
      </div>
      <div class="panel-body">
      <p><strong>ブログ一覧の表示って結構やばいよね</strong></p>
      <p>成り立ちの第二弾です。</p>
      <p>そうは言ってもソースが全公開されているので</p>
      <p>「ソース読んでくれれば良いよ」</p>
      <p>と言ってしまえばそれまでなんですが・・・</p>
      <br><br>
      <p>前の記事で生成したhtmlのコードをクローリングして</p>
      <p>中のmetaタグ等からjsonデータを生成します</p>
      <p>その生成したjsonデータをajaxで取得して</p>
      <p>htmlとして書き出す</p>
      <p>みたいなのがざっくりした流れです</p>
      <br><br>
      <p>まずはhtmlの解析ですが</p>
      <p>ざっくりと以下のような感じですね</p>
<pre class='brush: php'>/**
 * ブログの読み込み
 * @param string $dirName
 * @param string $fileName
 * @return array
 */
function readBlog($dirName, $fileName) {
	$result = array();
	// fileを取得してくる
	$html = file_get_contents($dirName . DIRECTORY_SEPARATOR . $fileName);

	// DOMDocumentとして取得する
	$domDocument = new DOMDocument();

	// 読み込みを行う
	// @はエラー抑制の演算子
	@$domDocument->loadHTML($html);

	// xmlデータとして取得
	$xmlString = $domDocument->saveXML();
	$xmlObject = simplexml_load_string($xmlString);

	// 配列に変換
	$array = json_decode(json_encode($xmlObject), true);

	// 欲しいデータを取得
	$result['href'] = str_replace('..', '', $dirName . DIRECTORY_SEPARATOR . $fileName);
	$result['title'] = isset($array['head']['title']) ? $array['head']['title'] : '';
	$result['blogtype'] = preg_replace('/^\.\.\/blog/', '', $dirName);

	// metaデータを回してほしい情報を取ってくる
	if($array['head']['meta']) {
		foreach($array['head']['meta'] as $meta) {
			if(isset($meta['@attributes']) && isset($meta['@attributes']['name']) && $meta['@attributes']['name'] == 'createdate') {
				$result['date'] = $meta['@attributes']['content'];
				break;
			}
		}
	}
	return $result;
}</pre>
      <p>超簡単ですね！ｗ</p>
      <p>後はjson_decodeで書き出せばおしまいです</p>
<pre class='brush: php'>/**
 * 書き出し
 */
function write() {
	// 順番の入れ替え
	usort(
		$this->result,
		function($a, $b){
			$a_time = strtotime($a['date']);
			$b_time = strtotime($b['date']);
			if($a_time === $b_time) {
				return 0;
			}
			return ($a_time < $b_time)? 1: -1;
		});
	file_put_contents(self::BLOG_PATH . DIRECTORY_SEPARATOR . 'index.json', json_encode($this->result));
}</pre>
      <p>fileの取得順で配列データが作られてしまうので</p>
      <p>書き出しの直前に日付順でsortをしています</p>
      <br><br>
      <p>あとはblogを取得して生成する側ですね</p>
      <p>これは<a href='http://nullblog.github.io/js/makelist.js' target='_blank'>makelist.js</a>というのを作って対応しています。</p>
      <p>jQueryとvue.jsを使って対応しています</p>
      <p>jQueryにしてもvueにしても</p>
      <p>ググったらいくらでも使い方が出てくるので</p>
      <p>まあここには書かなくても良いかなと・・・</p>
      <p>サンプルプログラムとしてお使い下さいな</p>
      </div>
    </div>
  </div>
</div>
<?php include('src/common/_foot.php'); ?>
