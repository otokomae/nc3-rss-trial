<?php
App::uses('AppPluginController', 'Controller');

/**
 * RssAppController
 *
 * Rssモジュール用の AppController
 */
class RssAppController extends AppPluginController
{
	// 利用するモデルの組込
	public $uses = array('Rss.Rss', 'Rss.RssLoader');

	// 利用するコンポーネントの組込
	public $components = array('Rss.RssCommon');

	// RSSモデルから取得した rssデータ配列
	public $rss;
}