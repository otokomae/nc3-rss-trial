<?php
/**
 * Rssモデル
 *
 * Rssデータを扱うモデル
 */
class Rss extends AppModel
{
	/*
	| Validationルール設定
	*/
	public $validate = array(
		'url' => array(
			'rule' => 'url',
			'required' => true,
			'message' => 'URLが正しくありません。',
		),
	);

	/*
	| デフォルト値設定
	*/
	const DEFAULT_URL = 'http://';
	const DEFAULT_CACHE_TIME = 3600;
	const DEFAULT_VISIBLE_ROW = 10;

	/*
	| option項目の設定値
	*/
	/* キャッシュタイム（値は秒） */
	static protected $cache_times = array(
		1800 	=> '30分',
		3600 	=> '1時間',
		18000 	=> '5時間',
		43200 	=> '12時間',
		86400 	=> '1日',
		259200 	=> '3日',
		604800 	=> '1週間',
		2592000 => '1か月',
	);

	/* 表示件数 */
	static protected $visible_rows = array(
		1  => 1,
		5  => 5,
		10 => 10,
		15 => 15,
		20 => 20,
		25 => 25,
		30 => 30,
		0  => 'すべて',
	);


	/**
	 * Rssモジュールのデフォルト値を返す
	 */
	public function getDefault($content_id)
	{
		$data['Rss'] = array(
			'content_id' => $content_id,
			'url' => self::DEFAULT_URL,
			'cache_time' => self::DEFAULT_CACHE_TIME,
			'visible_row' => self::DEFAULT_VISIBLE_ROW,
			'site_name' => null,
		);
		return $data;
	}

	/*
	| option項目の呼び出し
	*/
	/* キャッシュタイム */
	public static function getCacheTimeOptions(){
		return self::$cache_times;
	}

	/* 表示件数 */
	public static function getVisibleRowOptions(){
		return self::$visible_rows;
	}
}