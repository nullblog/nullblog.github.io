<?php
$meta = array(
  'description' => 'phpとtemplateとcssとjsが複雑に絡み合っている場合とか複数の拡張子にまたがって検索かけたいのにクライアントソフトだと設定出来ない事が多いです。',
  'keywords' => 'find,grep,xargs,拡張子',
  'title' =>  '「find」と「xargs」と「grep」で大量ファイルを拡張子絞り込みで検索する方法',
  'date' => '2016-05-16'
);
?>
<?php include('src/common/_head.php'); ?>
<link href="http://alexgorbatchev.com/pub/sh/current/styles/shCoreDefault.css" rel="stylesheet" type="text/css">
<link href="http://alexgorbatchev.com/pub/sh/current/styles/shThemeDefault.css" rel="stylesheet" type="text/css">
<script src="http://alexgorbatchev.com/pub/sh/current/scripts/shCore.js" type="text/javascript"></script>
<script src="http://alexgorbatchev.com/pub/sh/current/scripts/shBrushBash.js" type="text/javascript"></script>
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
        <p><strong>いつも使うコマンドが検索で出てこない</strong></p>
        <p>phpとtemplateとcssとjsが複雑に絡み合っている場合とか</p>
        <p>複数の拡張子にまたがって検索かけたいのに</p>
        <p>クライアントソフトだと設定出来ない事が多いです。</p>
        <p>（最近のエディターのAtomとかSublimeText2とかはそういう拡張もあるんでしょうけど・・・）</p>
        <p>そんなわけでCLIでfindとgrepと組み合わせて検索かけるのですが</p>
        <p>長いコマンドだからちゃんと覚えていなかったりとかして。。。</p>
        <p>仕組さえわかればたいした話ではないんですけどね。</p>
        <p><strong>結論は以下の通り</strong></p>
        <pre class='brush: bash'>find . \( -name "*.php" -o -name "*.tpl" -o -name "*.js" -o -name "*.css" \) | xargs grep "hoge"</pre>
        <p>ファイル名だけ欲しい場合はgrepに<kbd>-l</kbd>オプション</p>
        <p>除外を行いたい場合はパイプで繋いで</p>
        <p>除外したい文言をgrepの<kbd>-V</kbd>オプションで指定してあげれば</p>
        <p>サクサク検索できます。</p>
        <p>完全に個人的な覚書用です。</p>
        <p>本当にありがとうございます。</p>
      </div>
    </div>
  </div>
</div>
<?php include('src/common/_foot.php'); ?>
