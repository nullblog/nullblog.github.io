<?php

new makeBlog($argv);

Class makeBlog {

	const COMMON_PATH = 'src/common';
	const DETAIL_PATH = 'src/detail';
	const WRITE_PATH = '../blog';

	public $args;

	function __construct($arg) {
		// 実行コマンドはいらないから消す
		unset($arg[0]);
		$this->arg = $arg;
		$this->run();
	}

	/**
	 * 実行関数
	 */
	function run() {
		if(count($this->arg) > 0) {
			// 引数があった場合は直接実行
			foreach($this->arg as $filePath) {
				$this->fairing($filePath);
			}
		} else {
			$this->scan(self::DETAIL_PATH);
		}
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
		$contents = $this->getFile($dirName . DIRECTORY_SEPARATOR . $fileName);

		// ブログを書き出す
		$this->writeBlog($dirName, $fileName, $contents);
 	}

	/**
	 * fileの実行結果を取得する
	 * @param string $fileName
	 * @return string
	 */
	function getFile($fileName) {
		$contents = "";
		ob_start();
		include($fileName);
		$contents = ob_get_contents();
		ob_end_clean();
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
}
