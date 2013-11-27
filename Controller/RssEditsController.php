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
		$errors = false;
		if ($this->request->is(array('post', 'put'))) {
			// 元のデータと入力データをマージ
			// 古いデータは old に確保
			//
			$old = $rss;
			$rss['Rss'] = array_merge($rss['Rss'], $this->request->data['Rss']);

			// validation
			$this->Rss->set($rss);
			if (!$this->Rss->validates()) {
				$errors = $this->Rss->validationErrors;
			}

			// URLに変更があるときは RSS情報を再取得
			// 新規登録時は常に取得する
			// $xml = false で、xml取得失敗となる。
			//
			$xml = true;
			if (!$errors) {
				if (!isset($rss['Rss']['id']) or $old['Rss']['url'] != $this->request->data['Rss']['url']) {
					$xml = $this->RssLoader->get($this->request->data['Rss']['url']);
				}
				if ($xml == false) {
					$this->Rss->invalidate('url', 'RSSが正しく読み込みできませんでした。');
					$errors = true;
				}
			}

			// RSSの取得に成功したときのみデータ更新処理を行う。
			// RSSの取得に失敗しているときは更新処理を行わずにエラーとして対処する(TODO)
			//
			if (!$errors) {
				// $rssデータ配列にキャッシュ情報と XMLデータを付加する
				$rss = $this->RssCommon->buildCache($rss, $xml);

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
		$this->set('errors', $errors);
	}
}