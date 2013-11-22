<?php
/**
 * RssAppController
 *
 * Rssモジュール用の AppController
 */
App::uses('AppPluginController', 'Controller');

class RssAppController extends AppPluginController
{
    // 利用するモデルの組込
    public $uses = array('Rss.Rss', 'Rss.RssLoader');
}