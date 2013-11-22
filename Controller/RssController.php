<?php
/**
 * RssController
 *
 * Rss表示コントローラー
 */
class RssController extends RssAppController
{
	/**
	 * RSS内容を表示するアクション
	 */
	public function index() {
		// RSSデータを取得する
		$rss = $this->Rss->findByContentId($this->content_id);
		$xml = $this->RssLoader->build($rss['Rss']['xml']);

		$this->set('rss', $rss);
		$this->set('xml', $xml);
	}
}