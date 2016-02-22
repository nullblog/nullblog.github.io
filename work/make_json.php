<?php

new makeJson();

Class makeJson {
	const BLOG_PATH = '../blog';

	public $result;

	function __construct() {
		$this->result = array();
		$this->run();
	}

	/**
	 * 実行関数
	 */
	function run() {
		$this->scan(self::BLOG_PATH);
		$this->write();
	}

	/**
	 * ディレクトリの中身を読み込み
	 * @param string $dirName
	 */
	function scan($dirName) {
		$result = scandir($dirName);
		foreach($result as $fileName) {
			// 「.」始まりはスキップ
			if(strpos($fileName, '.') === 0) {
				continue;
			}

			// ディレクトリであれば潜る
			if(is_dir($dirName . DIRECTORY_SEPARATOR . $fileName)) {
				$this->scan($dirName . DIRECTORY_SEPARATOR . $fileName);
				continue;
			}

	 		if(file_exists($dirName . DIRECTORY_SEPARATOR . $fileName) && preg_match('/\.html$/', $fileName)) {
	 			$this->result[] = $this->readBlog($dirName, $fileName);
	 		}
		}
	}

	/**
	 * ブログの読み込み
	 * @param string $dirName
	 * @param string $fileName
	 * @return array
	 */
	function readBlog($dirName, $fileName) {
		$result = array();
		$html = file_get_contents($dirName . DIRECTORY_SEPARATOR . $fileName);
		$domDocument = new DOMDocument();
		@$domDocument->loadHTML($html);
		$xmlString = $domDocument->saveXML();
		$xmlObject = simplexml_load_string($xmlString);
		$array = json_decode(json_encode($xmlObject), true);

		$result['href'] = str_replace('..', '', $dirName . DIRECTORY_SEPARATOR . $fileName);
		$result['title'] = isset($array['head']['title']) ? $array['head']['title'] : '';
		$result['blogtype'] = preg_replace('/^\.\.\/blog/', '', $dirName);

		if($array['head']['meta']) {
			foreach($array['head']['meta'] as $meta) {
				if(isset($meta['@attributes']) && isset($meta['@attributes']['name']) && $meta['@attributes']['name'] == 'createdate') {
					$result['date'] = $meta['@attributes']['content'];
					break;
				}
			}
		}
		return $result;
	}

	/**
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
	}
}
