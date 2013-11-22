<?php
/**
 * RssCommonComponent
 *
 */
class RssCommonComponent extends Component
{
	protected $controller;

	public function startup(Controller $controller)
	{
		$this->controller = $controller;
	}

	/**
	 * RSSのキャッシュが有効かどうかの判別
	 */
	public function isEnableCache($rss)
	{
		return ($rss['Rss']['cache_time'] + $rss['Rss']['update_time_sec']) > time();
	}
}