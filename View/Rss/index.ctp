<?php
$this->extend('/Frame/block');
$this->Html->css('Rss.style');
echo $this->Html->script('Rss.Rss/index');

// RSSモジュール登録失敗時には $rss データが取得できないのでエラーを返す
if (empty($rss)) {
	echo 'RSSヘッドライン情報がありません。';
	return;
}
?>

<div class="rss-headline">
	<h2>ヘッドライン先情報</h2>
	<ul class="lists rss-lists">
		<li>
			<dl>
				<dt>サイト名</dt>
				<dd><?php echo h($rss['Rss']['site_name']); ?></dd>
			</dl>
		</li>
		<li>
			<dl>
				<dt>サイトの説明</dt>
				<dd><?php echo h($xml->description); ?></dd>
			</dl>
		</li>
		<li>
			<dl>
				<dt>サイトURL</dt>
				<dd><?php echo h($rss['Rss']['url']); ?></dd>
			</dl>
		</li>
	</ul>
</div>

<div class="rss-items">
	<?php foreach ($xml->items as $item): ?>
		<div class="rss-item">
			<div class="rss-head clearfix">
				<span class="rss-head-title"><?php echo h($item->title); ?></span>
				<span class="rss-head-time"><?php echo $this->Time->timeAgoInWords($item->pubDate); ?></span>
			</div>

			<div class="rss-detail">
				<h3><?php echo h($item->title); ?></h3>
				<p class="rss-pubDate">
					更新日：<?php echo $this->Time->format('Y/m/d H:i:s', $item->pubDate); ?>
				</p>
				<p class="rss-description">
					<?php echo h(nl2br($item->description)); ?>
				</p>
				<p class="rss-permalink">
					リンク元： <?php echo $item->link; ?><br />
					<?php echo $this->Html->link(__d('rss', 'More Read'), $item->link); ?>
				</p>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<script>
$(function(){
	$('#<?php echo($id); ?>').Rss('<?php echo($id); ?>');
});
</script>