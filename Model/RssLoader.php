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
	 * RSSの type
	 * rdf, rss, atom のどれかの判別
	 */
	public $type;

	/**
	 * 文字コード
	 * get() で URLから取得したときのみそのエンコーディングがセットされる
	 */
	public $encoding;

    /* RSS情報 */
    public $title;
    public $description;
    public $url;
    public $items;

    private $xml;

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

			// URLセット
			$this->url = $url;

			// XMLからデータ構築
			$this->build($response->body);

		} catch (SocketException $e) {
			return false;
		} catch (XmlException $e) {
			return false;
		}

		return $this;
	}

	/**
	 * 読み込んだ URL のタイプの取得
	 */
	public function getType()
	{
		// XMLのタイプを取得してそれに泡えてパースする
		$this->type = Inflector::camelize(strtolower($this->xml->getName()));
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
			$this->xml = Xml::build($input);

			// RSSの種別を解析
			$this->getType();

			// RDF / RSS / Atom 以外は受け付けない
			if (!in_array($this->type, array('Rdf', 'Rss', 'Feed'))) {
				return false;
			}

			// それぞれの方法でパースする
			$this->{'parse'.$this->type}();

		} catch (XmlException $e) {
			return false;
		}

		return $this;
	}

	/**
	 * rdf のパース
	 */
	public function parseRdf()
	{
		$this->title 		= $this->xml->channel->title;
		$this->description 	= $this->xml->channel->description;

		$this->items = array();
		foreach ($this->xml->item as $item) {
			$item->pubDate = $item->children('dc', true)->date;
			$this->items[] = $item;
		}
	}

	/**
	 * rss のパース
	 */
	public function parseRss()
	{
		$this->title 		= $this->xml->channel->title;
		$this->description 	= $this->xml->channel->description;

		$this->items = array();
		foreach ($this->xml->channel->item as $item) {
			$this->items[] = $item;
		}
	}

	/**
	 * atom のパース
	 */
	public function parseFeed()
	{
		$this->title 		= $this->xml->title;
		$this->description 	= $this->xml->tagline;

		$this->items = array();
		foreach ($this->xml->entry as $entry) {
			$item = new stdClass;
			$item->title = (String)$entry->title;
			$item->description = (String)$entry->summary;
			$item->link = (String)$entry->link->attributes()->href;
			$item->pubDate = (String)$entry->issued;

			$this->items[] = $item;
		}
	}

	/**
	 * 自分自身の json 形式を返す
	 */
	public function jsonEncode()
	{
		return json_encode($this);
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
			if ($i >= $limit) {
				break;
			}

			$ret[] = $item;
			$i++;
		}

		return $ret;
	}
}