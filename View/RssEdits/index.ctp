<?php
$this->extend('/Frame/block');
?>

<div>
	<?php echo $this->Form->create('Rss', array('data-pjax' => '#'.$id)); ?>
		<fieldset class="form">
			<ul class="lists">
				<li>
					<dl>
						<dt>
							<?php echo $this->Form->label('Rss.url', 'RDF/RSSの URL'); ?>
						</dt>
						<dd>
							<?php
								$options = array(
									'label' => false,
								);
								echo $this->Form->input('Rss.url', $options);
							?>
						</dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>
							<?php echo $this->Form->label('Rss.cache_time', 'キャッシュタイム'); ?>
						</dt>
						<dd>
							<?php
								$options = array(
									'label' => false,
									'options' => Rss::getCacheTimeOptions()
								);
								echo $this->Form->input('Rss.cache_time', $options);
							?>
						</dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>
							<?php echo $this->Form->label('Rss.visible_row', '表示件数'); ?>
						</dt>
						<dd>
							<?php
								$options = array(
									'label' => false,
									'options' => Rss::getVisibleRowOptions()
								);
								echo $this->Form->input('Rss.visible_row', $options);
							?>
						</dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>
							<?php echo $this->Form->label('Rss.site_name', 'サイト名'); ?>
						</dt>
						<dd>
							<?php
								$options = array(
									'label' => false,
								);
								echo $this->Form->input('Rss.site_name', $options);
							?>
						</dd>
					</dl>
				</li>
			</ul>
		</fieldset>
		<?php
			$ok_button = $this->Form->button(__('Ok'),
				array('name' => 'ok',
							'class' => 'common-btn',
							'type' => 'submit',
							)
			);
			$cancel_button = $this->Form->button(__('Cancel'),
				array('name' => 'ok',
							'class' => 'common-btn',
							'type' => 'button',
							'data-pjax' => '#'.$id,
							'data-ajax-url' => $this->Html->url(array('controller' => 'rss', '#' => $id)),
							)
			);
			echo $this->Html->div('submit', $ok_button.$cancel_button);
		?>
	<?php echo $this->Form->end(); ?>
</div>