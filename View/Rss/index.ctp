<?php
$this->extend('/Frame/block');
?>

<div id="rss-headline">
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
				<dd><?php echo h($xml->channel->description); ?></dd>
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

<div id="rss-items">
	<?php foreach ($xml->limit($rss['Rss']['visible_row']) as $item): ?>
		<div class="rss-item">
			<h3><?php echo $this->Html->link($item->title, '', array('escape' => true)); ?></h3>
			<div class="rss-detail">
				<p class="rss-description">
					<?php echo h($item->description); ?>
				</p>
				<p class="rss-pubDate">
					<?php echo $item->pubDate; ?><br />
					<?php echo $this->Time->format('Y/m/d H:i:s', $item->pubDate); ?>
				</p>
				<p class="rss-more">
					<?php echo $this->Html->link(__d('rss', 'More Read'), $item->link); ?>
				</p>
			</div>
		</div>
	<?php endforeach; ?>
</div>