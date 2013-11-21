<?php
/**
 *
 */
class Rss extends AppModel
{
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