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
        $rss = !empty($rss) ?: $this->Rss->getDefault();


        // フォームに表示する値をセットする
        $this->request->data = $this->request->data ?: $rss;
    }
}