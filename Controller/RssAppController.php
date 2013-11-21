<?php
App::uses('AppPluginController', 'Controller');

/**
 *
 */
class RssAppController extends AppPluginController
{
    public $uses = array('Rss.Rss', 'Rss.RssReader');
}