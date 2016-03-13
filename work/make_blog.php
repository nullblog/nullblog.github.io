<?php

new makeBlog($argv);

Class makeBlog {

	const COMMON_PATH = 'src/common';
	const DETAIL_PATH = 'src/detail';
	const WRITE_PATH = '../blog';

	// blogのmeta情報収取用
	public $list = array();

	function __construct($arg) {
		$this->run();
	}

	/**
	 * 実行関数
	 */
	function run() {
		$this->scan(self::DETAIL_PATH);
		$this->jsonWrite();
	}

	/**
	 * @param string $filePath
	 */
	function fairing($filePath) {
		// 配列に分割
		$arr = explode(DIRECTORY_SEPARATOR, $filePath);
		// 最後の要素がファイル名
		$fileName = array_pop($arr);
		// ディレクトリパスの生成
		$dirPath = implode(DIRECTORY_SEPARATOR, $arr);
		// ブログ書き出し
		$this->makeBlog($dirName, $fileName);
	}

	/**
	 * ディレクトリの中身を読み込みブログ書き出し
	 * @param string $dirName
	 */
	function scan($dirName) {
		$result = scandir($dirName);
		foreach($result as $fileName) {
			// 「.」始まりと「_」始まりはスキップ
			if(strpos($fileName, '.') === 0 || strpos($fileName, '_') === 0) {
				continue;
			}

			// ディレクトリであれば潜る
			if(is_dir($dirName . DIRECTORY_SEPARATOR . $fileName)) {
				$this->scan($dirName . DIRECTORY_SEPARATOR . $fileName);
				continue;
			}

			$this->makeBlog($dirName, $fileName);
		}
	}

	/**
	 * ブログを作ってファイルを書き出す
	 * @param string $dirName
	 * @param string $fileName
	 */
 	function makeBlog($dirName, $fileName) {
 		if(!file_exists($dirName . DIRECTORY_SEPARATOR . $fileName)) {
 			// ファイルが無い時は何もしない
 			return;
 		}
		// ブログを取得
		$contents = $this->getFile($dirName . DIRECTORY_SEPARATOR . $fileName, $dirName);

		// ブログを書き出す
		$this->writeBlog($dirName, $fileName, $contents);
 	}

	/**
	 * fileの実行結果を取得する
	 * @param string $fileName
	 * @param string $dirName
	 * @return string
	 */
	function getFile($fileName, $dirName) {
		$contents = "";
		$list = array();
		ob_start();
		include($fileName);
		$contents = ob_get_contents();
		ob_end_clean();
		$list = array(
			'href' => preg_replace('/php$/', 'html', preg_replace('/^src\/detail/', '/blog', $fileName), 1),
			'title' => $meta['title'],
			'blogtype' => preg_replace('/^src\/detail/', '', $dirName),
			'date' => $meta['date']);
		$this->list[] = $list;
		return $contents;
	}

	/**
	 * ブログを書き出す
	 * @param string $dirName
	 * @param string $fileName
	 * @param string $contents
	 */
	function writeBlog($dirName, $fileName, $contents) {
		// ディレクトリ名の修正
		$dirName = preg_replace('/^src\/detail/', self::WRITE_PATH, $dirName, 1);
		// ファイル名の修正
		$fileName = preg_replace('/php$/', 'html', $fileName, 1);

		// 書き出す
		file_put_contents($dirName . DIRECTORY_SEPARATOR . $fileName, $contents);
	}

	/**
	 * jsonの書き出し
	 */
	function jsonWrite() {
		// 順番の入れ替え
		usort(
			$this->list,
			function($a, $b){
				$a_time = strtotime($a['date']);
				$b_time = strtotime($b['date']);
				if($a_time === $b_time) {
					return 0;
				}
				return ($a_time < $b_time)? 1: -1;
			});
		file_put_contents(self::WRITE_PATH . DIRECTORY_SEPARATOR . 'index.json', json_encode($this->list));
	}
}
