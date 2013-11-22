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

		if (!empty($rss)) {
			// RSSデータキャッシュが有効かどうかを調べる
			if (!$this->RssCommon->isEnableCache($rss)) {
				// キャッシュが無効の時は URLからデータを再取得
				$xml = $this->RssLoader->get($rss['Rss']['url']);

				// xml の取得にエラーがあったときは何らかエラー処理
				if (!$xml) {
					# code...
				} else {
					$rss = $this->RssCommon->buildCache($rss, $xml);
					$this->Rss->update($rss);
				}
			}

			// 再度取得した XMLデータからパースして xml として利用する
			$xml = $this->RssLoader->build($rss['Rss']['xml']);
			$this->set('xml', $xml);
		}

		$this->set('rss', $rss);
	}
}