<?php
// source: C:\xampp\htdocs\cleverCMS\app\Presenters\templates\components\form.latte

use Latte\Runtime as LR;

final class Templatedefa1d793e extends Latte\Runtime\Template
{
	public $blocks = [
		'form' => 'blockForm',
		'bootstrap-form' => 'blockBootstrap_form',
	];

	public $blockTypes = [
		'form' => 'html',
		'bootstrap-form' => 'html',
	];


	public function main(): array
	{
		extract($this->params);
		if ($this->getParentName()) {
			return get_defined_vars();
		}
?>


<?php
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['error' => '4, 23', 'input' => '7, 26', 'name' => '26'], $this->params) as $_v => $_l) {
				trigger_error("Variable \$$_v overwritten in foreach on line $_l");
			}
		}
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	public function blockForm(array $_args): void
	{
		extract($this->params);
		[$formName] = $_args + [null, ];
		$form = $_form = $this->global->formsStack[] = is_object($formName) ? $formName : $this->global->uiControl[$formName];
		?><form<?php echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), [], false) ?>>
<?php
		if ($form->hasErrors()) {
?>    <ul class="errors">
<?php
			$iterations = 0;
			foreach ($form->errors as $error) {
				?>        <li><?php echo LR\Filters::escapeHtmlText($error) /* line 4 */ ?></li>
<?php
				$iterations++;
			}
?>
    </ul>
<?php
		}
?>
    <table>
<?php
		$iterations = 0;
		foreach ($form->controls as $input) {
			if (!$input->getOption('rendered') && $input->getOption('type') !== 'hidden') {
				?>        <tr<?php
				echo ($_tmp = array_filter([$input->required ? 'required' : null])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))) . '"' : "";
?>>

            <th><?php
				$_input = is_object($input) ? $input : end($this->global->formsStack)[$input];
				if ($_label = $_input->getLabel()) echo $_label ?></th>
            <td><?php
				$_input = is_object($input) ? $input : end($this->global->formsStack)[$input];
				echo $_input->getControl() /* line 12 */ ?> <?php
				ob_start(function () {});
				?><span class=error><?php
				ob_start();
				echo LR\Filters::escapeHtmlText($input->error) /* line 12 */;
				$this->global->ifcontent = ob_get_flush();
				?></span><?php
				if (rtrim($this->global->ifcontent) === "") {
					ob_end_clean();
				}
				else {
					echo ob_get_clean();
				}
?>
</td>
        </tr>
<?php
			}
			$iterations++;
		}
?>
    </table>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), false);
?></form>
<?php
	}


	public function blockBootstrap_form(array $_args): void
	{
		extract($this->params);
		[$formName] = $_args + [null, ];
		$form = $_form = $this->global->formsStack[] = is_object($formName) ? $formName : $this->global->uiControl[$formName];
		?><form class=form-horizontal<?php echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), ['class' => null], false) ?>>
<?php
		if ($form->hasErrors()) {
?>    <ul class="errors">
<?php
			$iterations = 0;
			foreach ($form->errors as $error) {
				?>        <li><?php echo LR\Filters::escapeHtmlText($error) /* line 23 */ ?></li>
<?php
				$iterations++;
			}
?>
    </ul>
<?php
		}
?>

<?php
		$iterations = 0;
		foreach ($form->controls as $name => $input) {
			if (!$input->getOption('rendered') && $input->getOption('type') !== 'hidden') {
				?>    <div<?php
				echo ($_tmp = array_filter(['form-group', $input->required ? 'required' : null, $input->error ? 'has-error' : null])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))) . '"' : "";
?>>

        <div class="col-sm-12 control-label"><?php
				$_input = is_object($input) ? $input : end($this->global->formsStack)[$input];
				if ($_label = $_input->getLabel()) echo $_label ?></div>

        <div class="col-sm-12">
<?php
				if (in_array($input->getOption('type'), ['text', 'select', 'textarea'], true)) {
					?>                <?php
					$_input = is_object($input) ? $input : end($this->global->formsStack)[$input];
					echo $_input->getControl()->addAttributes(['class' => 'form-control']) /* line 34 */ ?>

<?php
				}
				elseif ($input->getOption('type') === 'button') {
					?>                <?php
					$_input = is_object($input) ? $input : end($this->global->formsStack)[$input];
					echo $_input->getControl()->addAttributes(['class' => "col-sm-12 btn btn-primary"]) /* line 36 */ ?>

<?php
				}
				elseif ($input->getOption('type') === 'checkbox') {
					?>                <div class="checkbox"><?php
					$_input = is_object($input) ? $input : end($this->global->formsStack)[$input];
					echo $_input->getControl() /* line 38 */ ?></div>
<?php
				}
				elseif ($input->getOption('type') === 'radio') {
					?>                <div class="radio"><?php
					$_input = is_object($input) ? $input : end($this->global->formsStack)[$input];
					echo $_input->getControl() /* line 40 */ ?></div>
<?php
				}
				else {
					?>                <?php
					$_input = is_object($input) ? $input : end($this->global->formsStack)[$input];
					echo $_input->getControl() /* line 42 */ ?>

<?php
				}
?>

<?php
				ob_start(function () {});
				?>            <span class=help-block><?php
				ob_start();
				echo LR\Filters::escapeHtmlText($input->error ?: $input->getOption('description')) /* line 45 */;
				$this->global->ifcontent = ob_get_flush();
?></span>
<?php
				if (rtrim($this->global->ifcontent) === "") {
					ob_end_clean();
				}
				else {
					echo ob_get_clean();
				}
?>
        </div>
    </div>
<?php
			}
			$iterations++;
		}
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), false);
?></form>
<?php
	}

}
