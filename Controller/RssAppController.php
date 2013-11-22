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
}