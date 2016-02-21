<?php
$meta = array(
  'description' => 'TOPにも書いてあるように、わりとゲスな理由で始めて見ました。今後ちょっとずつコンテンツを増やしつつ、コンテンツを増やすということは開発をするということでして・・・',
  'keywords' => 'ご挨拶,エンジニア,ゆとり',
  'title' =>  'ブログの成り立ち（1）',
  'date' => '2016-02-21'
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
      <p><strong>githubでブログ作ろうとしたらめっちゃ大変やんけ・・・</strong></p>
      <p>以前WEB広告のお仕事をしていたので</p>
      <p>自分でブログ書いて広告貼ってチャリンチャリン儲けようと思ったわけですが</p>
      <p>サーバー代って結構厄介なわけです。</p>
      <p>場合によっては負荷高騰とか考えなくちゃいけないし</p>
      <p>既存のブログサービスに乗っかろうとすると</p>
      <p>自分で広告貼るには有料会員にならないといけなかったり。。。</p>
      <p>しかも自分で広告運用しようとしている人は絶対に<strong>優良会員</strong>ではないんですよねｗ</p>
      <p>cookie情報抜いたり色んな行動情報集めていたり</p>
      <p>そりゃあ広告業者は嫌われますよ</p>
      <p><small>広告貼ったらoptoutのリンクは付けなくちゃとは思っています。</small></p>
      <br>
      <p>そんで！</p>
      <p>計測タグとか広告タグとか色々突っ込まなくちゃいけないので</p>
      <p>「とりあえずheaderとfooterは共通化したい！」という</p>
      <p>ざっくりとした希望の元に動き出しました。</p>
      <p>今回は第一弾なので中でも一番核になる部分のblog-builderについてお話いたします。</p>
      <p>正直大した事はしていないので<a href="https://github.com/nullblog/nullblog.github.io/blob/master/work/make_blog.php" target="_blank">実装をさっくり見てもらった方が</a>早い人は早いです。</p>
      <br>
      <br>
      <p>最初はnode.jsでgulp使ってejs辺りで～とか思っていたんですけど</p>
      <p>やっぱり自分はphperなんだなと思い知らされました。</p>
      <p>故にphpで書いています。</p>
      <p>workスペースを区切ってそこにbuild用のscriptを置いています。</p>
      <p>テンプレート関連は<a href='https://github.com/nullblog/nullblog.github.io/tree/master/work/src' target="_blank">src</a>に</p>
      <p>その中には共通テンプレートの<a href='https://github.com/nullblog/nullblog.github.io/tree/master/work/src/common' target='_blank'>common</a>と</p>
      <p>記事詳細を突っ込んでおく<a href='https://github.com/nullblog/nullblog.github.io/tree/master/work/src/detail' target='_blank'>detail</a>があります。</p>
      <p>基本的にはdetailの中身を再帰的に探してきてhtmlとして書き出されたものを取得してファイル書き出しをする</p>
      <p>の繰り返しです。</p>
      <br>
      <br>
      <p>ファイルの書き出しをする時に面倒な事を考えたくなかったので</p>
      <p>普通にhttpリクエストで読み込む時と同じような書き方をしています。</p>
      <p>記事詳細の書き方をいちいち覚えていられないので<a href='https://github.com/nullblog/nullblog.github.io/blob/master/work/src/detail/_template.php' target="_blank">記事詳細用のテンプレート</a>なんてのも用意しています。</p>
      <p>meta情報をサクッと書いて、記事の詳細をhtmlで組んでいくと良い感じになるのがわかる</p>
      <p>とても良いテンプレートです。</p>
      <p>headファイルとfootファイルは繰り返し読み込む事になるので</p>
      <p>通常仕事では<a href='http://php.net/manual/ja/function.require-once.php' target='_blank'>「require_once」</a>とか使うんですけど</p>
      <p>今回は<a href='http://php.net/manual/ja/function.include.php' target='_blank'>「include」</a>を使っています。</p>
      <p>テンプレートの中にphpのメソッドは書いてはいけない状態になった事は肝に銘じておきます。</p>
      <br>
      <br>
      <p>実際の処理ですが、先に書いたように階層下ってfile拾って実行して書き出すだけなので</p>
      <p>特に珍しいことはしていません。</p>
      <p>唯一珍しい事と言えば、phpとして実行した結果を受け取らなくてはいけなかったので</p>
      <p><a href='http://php.net/manual/ja/function.ob-start.php'>「ob-start」</a>を使っていることぐらいでしょうか。</p>
<pre class='brush: php'>/**
 * fileの実行結果を取得する
 * @param string $fileName
 * @return string
 */
function getFile($fileName) {
	$contents = "";
	ob_start(); // 標準出力を抑制
	include($fileName); // ファイルの実行
	$contents = ob_get_contents(); // 実行結果を受け取る
	ob_end_clean(); // 標準出力の抑制解除
	return $contents;
}</pre>
      <p>こんな感じで使っていますね。</p>
      <p>あとは再帰処理の時に変数の使いまわしが簡単なようにclassに突っ込んだぐらいで</p>
      <p>特段珍しいことはしていません。</p>
      <br><br>
      <p>書き出しが愚痴っぽくなってしまったのでとりあえず次回に期待を・・・</p>
      </div>
    </div>
  </div>
</div>
<?php include('src/common/_foot.php'); ?>
