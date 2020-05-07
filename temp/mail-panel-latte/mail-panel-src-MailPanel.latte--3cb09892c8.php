<?php
// source: C:\xampp\htdocs\msval\vendor\nextras\mail-panel\src/MailPanel.latte

use Latte\Runtime as LR;

final class Template3cb09892c8 extends Latte\Runtime\Template
{

	public function main(): array
	{
		extract($this->params);
?>
<style>
	#tracy-debug .tracy-panel.tracy-mode-peek .nextras-mail-panel,
	#tracy-debug .tracy-panel.tracy-mode-float .nextras-mail-panel {
		overflow-y: scroll; /* reserve space for scrollbar */
	}

	#tracy-debug .tracy-panel.tracy-mode-peek .nextras-mail-panel table,
	#tracy-debug .tracy-panel.tracy-mode-float .nextras-mail-panel table {
		margin-right: 10px;
		width: 600px;
	}

	#tracy-debug .tracy-panel.tracy-mode-window .nextras-mail-panel table {
		width: 100%;
	}

	#tracy-debug .tracy-panel .nextras-mail-panel table {
		margin-bottom: 10px;
	}

	#tracy-debug .tracy-panel .nextras-mail-panel table:last-child {
		margin-bottom: 0;
	}

	#tracy-debug .tracy-panel .nextras-mail-panel th {
		width: 80px;
	}

	#tracy-debug .tracy-panel .nextras-mail-panel-actions {
		float: right;
	}

	#tracy-debug .tracy-panel .nextras-mail-panel-actions a {
		margin-left: 7px;
	}

	#tracy-debug .tracy-panel .nextras-mail-panel-preview-txt td {
		white-space: pre-wrap;
	}

	#tracy-debug .tracy-panel .nextras-mail-panel-preview-html td {
		padding: 0;
	}

	#tracy-debug .tracy-panel .nextras-mail-panel-preview-html iframe {
		display: block;
		width: 100%;
		background: #FFF;
	}
</style>

<h1>Sent emails</h1>

<?php
		if (count($messages) > 0) {
?>

	<div class="tracy-inner nextras-mail-panel" id="nextras-mail-panel-<?php echo LR\Filters::escapeHtmlAttr($panelId) /* line 56 */ ?>">
		<table>
			<tr>
				<th colspan="2">
					<div class="nextras-mail-panel-actions">
						<a href="<?php echo LR\Filters::escapeHtmlAttr(call_user_func($getLink, "delete-all", [])) ?>">Delete all</a>
					</div>
				</th>
			</tr>
		</table>

<?php
			$iterations = 0;
			foreach ($iterator = $this->global->its[] = new LR\CachingIterator($messages) as $messageId => $message) {
?>
			<table class="nextras-mail-message">
				<tr>
					<th colspan="2">
						<div class="nextras-mail-panel-actions">
							<a class="tracy-toggle tracy-collapsed" data-tracy-ref="^table .nextras-mail-panel-preview-txt">Preview TXT</a>
							<a class="tracy-toggle tracy-collapsed" data-tracy-ref="^table .nextras-mail-panel-preview-html">Preview HTML</a>
							<a target="_blank" href="<?php echo LR\Filters::escapeHtmlAttr(call_user_func($getLink, "detail", ['message-id' => $messageId])) ?>">Open</a>
							<a target="_blank" href="<?php echo LR\Filters::escapeHtmlAttr(call_user_func($getLink, "source", ['message-id' => $messageId])) ?>">Source</a>
							<a href="<?php echo LR\Filters::escapeHtmlAttr(call_user_func($getLink, "delete-one", ['message-id' => $messageId])) ?>">Delete</a>
						</div>
						<div class="nextras-mail-panel-subject" title="Sent at <?php echo LR\Filters::escapeHtmlAttr($message->getHeader('Date')) /* line 78 */ ?>"><?php
				echo LR\Filters::escapeHtmlText($message->subject) /* line 78 */ ?></div>
					</th>
				</tr>

<?php
				$iterations = 0;
				foreach ($iterator = $this->global->its[] = new LR\CachingIterator(['From', 'To', 'Cc', 'Bcc']) as $headerName) {
					$header = $message->getHeader($headerName);
					if (isset($header)) {
?>					<tr>
						<th><?php echo LR\Filters::escapeHtmlText($headerName) /* line 85 */ ?></th>
						<td>
<?php
						$iterations = 0;
						foreach ($iterator = $this->global->its[] = new LR\CachingIterator($header) as $email => $name) {
							?>								<a href="mailto:<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($email)) /* line 88 */ ?>"><?php
							echo LR\Filters::escapeHtmlText($name ?: $email) /* line 88 */ ?></a><?php
							if (!$iterator->isLast()) {
								?>, <?php
							}
?>

<?php
							$iterations++;
						}
						array_pop($this->global->its);
						$iterator = end($this->global->its);
?>
						</td>
					</tr>
<?php
					}
					$iterations++;
				}
				array_pop($this->global->its);
				$iterator = end($this->global->its);
?>

<?php
				$attachments = $message->getAttachments();
				if ($attachments) {
?>				<tr>
					<th>Attachments</th>
					<td>
<?php
					$iterations = 0;
					foreach ($iterator = $this->global->its[] = new LR\CachingIterator($attachments) as $attachmentId => $attachment) {
						?>							<a target="_blank" href="<?php echo LR\Filters::escapeHtmlAttr(call_user_func($getLink, "attachment", ['message-id' => $messageId, 'attachment-id' => $attachmentId])) ?>"><?php
						echo LR\Filters::escapeHtmlText(($this->filters->attachmentlabel)($attachment)) /* line 99 */ ?></a>
							<?php
						if (!$iterator->isLast()) {
							?><br><?php
						}
?>

<?php
						$iterations++;
					}
					array_pop($this->global->its);
					$iterator = end($this->global->its);
?>
					</td>
				</tr>
<?php
				}
?>


				<tr class="nextras-mail-panel-preview-txt tracy-collapsed">
					<td colspan="2"><?php echo LR\Filters::escapeHtmlText(($this->filters->plaintext)($message)) /* line 107 */ ?></td>
				</tr>

				<tr class="nextras-mail-panel-preview-html tracy-collapsed">
					<?php
				ob_start(function () {});
				/* line 111 */
				$this->createTemplate("MailPanel.body.latte", ['message' => $message] + $this->params, 'include')->renderToContentType('html');
				$_fi = new LR\FilterInfo('html');
				$htmlPreview = ob_get_length() ? new LR\Html(ob_get_clean()) : ob_get_clean();
?>

					<td colspan="2" data-content="<?php echo LR\Filters::escapeHtmlAttr($htmlPreview) /* line 112 */ ?>"></td>
				</tr>
			</table>
<?php
				$iterations++;
			}
			array_pop($this->global->its);
			$iterator = end($this->global->its);
?>

		<script>
			(function () {

				var panel = document.getElementById('nextras-mail-panel-' + <?php echo LR\Filters::escapeJs($panelId) /* line 120 */ ?>);
				var messages = panel.querySelectorAll('table.nextras-mail-message');

				for (var i = 0; i < messages.length; i++) {
					(function (message) {

						var actions = message.querySelector('.nextras-mail-panel-actions');
						var preview = message.querySelector('.nextras-mail-panel-preview-html td');

						var initHtmlPreview = function () {
							var iframe = document.createElement('iframe');
							preview.appendChild(iframe);

							iframe.contentWindow.document.write(preview.dataset.content);
							iframe.contentWindow.document.close();
							delete preview.dataset.content;

							var baseTag = iframe.contentWindow.document.createElement('base');
							baseTag.target = '_parent';
							iframe.contentWindow.document.body.appendChild(baseTag);

							var fixHeight = function (ev) {
								iframe.style.height = 0;
								iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
								iframe.contentWindow.removeEventListener(ev.type, fixHeight);
							};

							iframe.contentWindow.addEventListener('load', fixHeight);
							iframe.contentWindow.addEventListener('resize', fixHeight);
							actions.removeEventListener('tracy-toggle', initHtmlPreview);
							actions.removeEventListener('click', initHtmlPreview);
						};

						actions.addEventListener('tracy-toggle', initHtmlPreview);
						actions.addEventListener('click', initHtmlPreview);

					})(messages.item(i));
				}

			})();
		</script>
	</div>
<?php
		}
		else {
?>
	<p>No emails.</p>
<?php
		}
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['email' => '87', 'name' => '87', 'headerName' => '82', 'attachmentId' => '98', 'attachment' => '98', 'messageId' => '67', 'message' => '67'], $this->params) as $_v => $_l) {
				trigger_error("Variable \$$_v overwritten in foreach on line $_l");
			}
		}
		
	}

}
