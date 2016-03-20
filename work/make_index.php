<?php

new makeIndex();

Class makeIndex {

	const TEMPLATE_FILE = 'src/common/_index.php';
	const DATA_JSON = '../blog/index.json';
	const WRITE_PATH = '../blog';

	public $data = array();

	function __construct() {
		$this->run();
	}

	/**
	 * 実行関数
	 */
	function run() {
		$this->data = json_decode(file_get_contents(self::DATA_JSON));

		$this->make(self::WRITE_PATH);
	}

	/**
	 * ディレクトリ階層を下ってindexを書き出す
	 * @param string $dirName
	 */
	function make($dirName) {
		$result = scandir($dirName);
		foreach($result as $fileName) {
			// 「.」始まりと「_」始まりはスキップ
			if(strpos($fileName, '.') === 0 || strpos($fileName, '_') === 0) {
				continue;
			}

			// ディレクトリであれば潜る
			if(is_dir($dirName . DIRECTORY_SEPARATOR . $fileName)) {
				$this->make($dirName . DIRECTORY_SEPARATOR . $fileName);
				continue;
			}
		}
		$this->makeIndex($dirName);
	}

	/**
	 * ブログを作ってファイルを書き出す
	 * @param string $dirName
	 * @param string $fileName
	 */
	function makeIndex($dirName) {
		// ブログを取得
		$dirName = str_replace('..', '', $dirName);
		$contents = $this->getFile($dirName, $this->data);

		// 書き出す
		file_put_contents('../' . $dirName . DIRECTORY_SEPARATOR . 'index.html', $contents);
 	}

	/**
	 * fileの実行結果を取得する
	 * @param string $dirName
	 * @param array $data
	 * @return string
	 */
	function getFile($dirName, $data) {
		$contents = "";
		ob_start();
		include(self::TEMPLATE_FILE);
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}
}
