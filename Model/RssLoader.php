<?php
App::uses('HttpSocket', 'Network/Http');

/**
 * RssLoader
 *
 * Rssを URLから読み込みパースする
 */
class RssLoader
{
	protected $http;

	/**
	 * 文字コード
	 * get() で URLから取得したときのみそのエンコーディングがセットされる
	 */
	public $encoding;

	/** RSSの channel */
	public $channel;

	/** RSS の items */
	public $items;

	/**
	 * コンストラクタ
	 */
	public function __construct()
	{
		$this->http = new HttpSocket();
	}

	/**
	 * Xmlを読み込んでデータの取得を行う
	 *
	 * @param   String  $input  URL, XML文字列（Xmlクラスの buildを同じ動き）
	 */
	public function get($url)
	{
		try {
			$response = $this->http->get($url);

			if (!$response->isOk()) {
				return false;
			}

			// 文字コードの解析
			preg_match('/.*charset=(.+)/', $response->headers['Content-Type'], $matches);
			$this->encoding = !empty($matches[1]) ? $matches[1] : null;

			$this->build($response->body);

		} catch (SocketException $e) {
			return false;
		} catch (XmlException $e) {
			return false;
		}

		return $this;
	}

	/**
	 * Xmlを読み込んでデータの取得を行う
	 *
	 * @param   String  $input  URL, XML文字列（Xmlクラスの buildを同じ動き）
	 * @param   Int     $limit  XMLから取得するデータ数
	 */
	public function build($input)
	{
		try {
			$xml = Xml::build($input);

			$this->channel = $xml->channel;
			$this->items   = $xml->channel->item;

			echo $this->items->count();

		} catch (XmlException $e) {
			return false;
		}

		return $this;
	}

	/**
	 * 必要件数分の記事を取得する
	 *
	 * @param 	Int 	$limit 	取得件数
	 */
	public function limit($limit = 10)
	{
		// 取得アイテムがないときは false を返す
		if (empty($this->items)) {
			return false;
		}

		// 上位○件を配列に落とし込み return する
		$ret = array();
		$i = 0;
		foreach ($this->items as $item) {
			if ($i > $limit) {
				break;
			}

			$ret[] = $item;
			$i++;
		}

		return $ret;
	}
}