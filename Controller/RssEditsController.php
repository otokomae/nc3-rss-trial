<?php
/**
 * RssEditsController
 *
 * Rss編集画面用のコントローラー
 */
class RssEditsController extends RssAppController
{
	public $components = array(
		'Security',
		'CheckAuth' => array(
			'allowAuth' => NC_AUTH_CHIEF
		),
	);

	/**
	 * Rss編集画面表示アクション
	 */
	public function index() {
		// 編集する RSSデータを取得する
		// content_id に該当するデータがないときはデフォルト値を取得
		//
		$rss = $this->Rss->findByContentId($this->content_id);
		$rss = !empty($rss) ? $rss : $this->Rss->getDefault($this->content_id);

		// 登録（新規・更新）処理
		//
		if ($this->request->is(array('post', 'put'))) {
			// 元のデータと入力データをマージ
			// 古いデータは old に確保
			//
			$old = $rss;
			$rss['Rss'] = array_merge($rss['Rss'], $this->request->data['Rss']);

			// validation

			// URLに変更があるときは RSS情報を再取得
			// 新規登録時は常に取得する
			//
			$rss_loader = true;
			if (!isset($rss['Rss']['id']) or $old['Rss']['url'] != $this->request->data['Rss']['url']) {
				$rss_loader = $this->RssLoader->get($this->request->data['Rss']['url']);

				// 正しくデータが取得出来たときは、
				// サイト名・文字コード・XML　を更新させる
				//
				if ($rss_loader) {
					$rss['Rss']['site_name'] = $rss_loader->channel->title;
					$rss['Rss']['encoding'] = $rss_loader->encoding;
					$rss['Rss']['xml'] = $rss_loader->body;
					$rss['Rss']['update_time_sec'] = time();
				}
			}

			// RSSの取得に成功したときのみデータ更新処理を行う。
			// RSSの取得に失敗しているときは更新処理を行わずにエラーとして対処する(TODO)
			//
			if ($rss_loader) {
				// データの更新処理
				if (!$this->Rss->save($rss)) {
					throw new InternalErrorException(
						__('Failed to register the database, (%s)', 'rsses')
					);
				}

				// データ更新を行ったらリダイレクトする
				$this->redirect(array('controller' => 'rss', '#' => $this->id));
				return;
			}
		}

		// フォームに表示する値をセットする
		$this->request->data = $this->request->data ?: $rss;
	}
}