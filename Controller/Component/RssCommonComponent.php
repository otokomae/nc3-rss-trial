<?php
/**
 * RssCommonComponent
 *
 */
class RssCommonComponent extends Component
{
	protected $controller;

	public function startup(Controller $controller)
	{
		$this->controller = $controller;
	}

	/**
	 * RSSのキャッシュが有効かどうかの判別
	 */
	public function isEnableCache($rss)
	{
		return ($rss['Rss']['cache_time'] + $rss['Rss']['update_time_sec']) > time();
	}

	/**
	 * RSSキャッシュの保存用にデータ設定する
	 *
	 * キャッシュの有効時間が切れた場合は再度 URLよりデータを読み込み必要情報を保存する
	 *
	 * @param Array     $rss    更新対象となる $rssデータ配列
	 * @param SimpleXml $xml    読み込んだ xmlデータ
	 *
	 * @return 更新した $rss配列
	 */
	public function buildCache($rss, $xml)
	{
		$rss['Rss']['site_name'] = $xml->title;
		$rss['Rss']['encoding'] = $xml->encoding;
		$rss['Rss']['xml'] = $xml->jsonEncode();
		$rss['Rss']['update_time_sec'] = time();

		return $rss;
	}

	/**
	 * $xml->items について必要件数分を返す対応
	 *
	 * @param 	Array 	$items 	記事一覧が格納されている配列
	 * @param   Int 	$limit  取得する件数
	 *
	 * @param   Array   $items の先頭 $limit分の配列を返す
	 */
	public function takeItems($items, $limit = 0)
	{
		if ($limit == 0) {
			return $items;
		} else {
			return array_slice($items, 0, $limit);
		}


	}
}