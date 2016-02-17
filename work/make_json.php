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
	 * ���s�֐�
	 */
	function run() {
		$this->scan(self::BLOG_PATH);
		$this->write();
	}

	/**
	 * �f�B���N�g���̒��g��ǂݍ���
	 * @param string $dirName
	 */
	function scan($dirName) {
		$result = scandir($dirName);
		foreach($result as $fileName) {
			// �u.�v�n�܂�̓X�L�b�v
			if(strpos($fileName, '.') === 0) {
				continue;
			}

			// �f�B���N�g���ł���ΐ���
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
	 * �u���O�̓ǂݍ���
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
	 * �����o��
	 */
	function write() {
		file_put_contents(self::BLOG_PATH . DIRECTORY_SEPARATOR . 'index.json', json_encode($this->result));
	}
}