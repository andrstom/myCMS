<?php
// source: C:\xampp\htdocs\msval\vendor\nextras\mail-panel\src\MailPanel.body.latte

use Latte\Runtime as LR;

final class Templateed36809c4e extends Latte\Runtime\Template
{

	public function main(): array
	{
		extract($this->params);
		if ($message->htmlBody !== NULL) {
			?>	<?php echo $message->htmlBody /* line 3 */ ?>

<?php
		}
		else {
?>
	<!doctype html>
	<meta charset="utf-8">
	<style>
		html, body {
			margin: 0;
			padding: 0;
			border: none;
			font-family: sans-serif;
			font-size: 12px;
			white-space: pre;
		}

		body {
			padding: 10px;
		}
	</style>
	<body><?php echo LR\Filters::escapeHtmlText(($this->filters->plaintext)($message)) /* line 21 */ ?></body>
<?php
		}
		return get_defined_vars();
	}

}
