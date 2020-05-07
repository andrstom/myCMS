<?php
// source: C:\xampp\htdocs\cleverCMS\app\Presenters/templates/@layout.latte

use Latte\Runtime as LR;

final class Template39ea120939 extends Latte\Runtime\Template
{
	public $blocks = [
		'scripts' => 'blockScripts',
	];

	public $blockTypes = [
		'scripts' => 'html',
	];


	public function main(): array
	{
		extract($this->params);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    
    <meta charset="utf-8">
    <title><?php
		if (isset($this->blockQueue["title"])) {
			$this->renderBlock('title', $this->params, function ($s, $type) {
				$_fi = new LR\FilterInfo($type);
				return LR\Filters::convertTo($_fi, 'html', $this->filters->filterContent('striphtml', $_fi, $s));
			});
			?> | <?php
		}
?>Mateřská školka Val</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 19 */ ?>/favicon.png" rel="icon">
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 20 */ ?>/favicon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 26 */ ?>/lib/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 29 */ ?>/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 30 */ ?>/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 31 */ ?>/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 32 */ ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 33 */ ?>/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 36 */ ?>/css/style.css" rel="stylesheet">
    <!-- =======================================================
      Theme Name: BizPage
      Theme URL: https://bootstrapmade.com/bizpage-bootstrap-business-template/
      Author: BootstrapMade.com
      License: https://bootstrapmade.com/license/
    =============================================================-->
    
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 44 */ ?>/lib/jquery/jquery.min.js"></script>
    
    <!-- Nette js -->
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 47 */ ?>/js/nette.ajax.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 48 */ ?>/js/netteForms.js"></script>
    
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 50 */ ?>/lib/tinymce/tinymce.min.js"></script>
    
    <!-- Datatables -->
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 53 */ ?>/lib/data-tables-1.10.2/media/css/dataTables.bootstrap4.css" rel="stylesheet">
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 54 */ ?>/lib/data-tables-1.10.2/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 55 */ ?>/lib/data-tables-1.10.2/media/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 56 */ ?>/lib/data-tables-1.10.2/media/js/table-nastaveni.js"></script>
</head>

<body>
    
    <script>
    tinymce.init({
        selector: 'textarea',
        language: 'cs_CZ',
        plugins: 'a11ychecker advcode casechange formatpainter linkchecker lists checklist pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker emoticons image link wordcount',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | forecolor backcolor | emoticons | image | link | wordcount',
        toolbar_drawer: 'floating',
        insertdatetime_formats: ["%H:%M:%S", "%d.%m.%Y"]
    });
    </script>
    
    <!--==========================
    Header
    ============================-->
    <header id="header">
        <div class="container-fluid">

            <div id="logo" class="pull-left" style="color: #fff">
                <!-- Uncomment below if you prefer to use an image logo -->
                <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 80 */ ?>/organisations/1/main_logo.png" width="40px" alt="logo" title="logo">
                cleverCMS
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li><a class="scroll menu-active" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:default")) ?>">Hlavní stránka</a></li>
                    <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:default#about")) ?>">O nás</a></li>
                    <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:default#team")) ?>">Team</a></li>
                    <!--<li><a n:href="Download:default#">Ke stažení</a></li>-->
                    <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:default#portfolio")) ?>">Fotogalerie</a></li>
                    <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Food:default")) ?>">Jídelníček</a></li>
                    <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:default#contact")) ?>">Kontakt</a></li>
<?php
		if ($user->isLoggedIn()) {
?>
                        <li class="menu-has-children">
                            <a href="#">Nastavení</a>
                            <ul>
                                <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Sign:edit", [$user->getIdentity()->id])) ?>"><i class="fa fa-user-o"></i> <?php
			echo LR\Filters::escapeHtmlText($user->getIdentity()->email) /* line 97 */ ?></a></li>
<?php
			if ($user->isInRole('Admin')) {
				?>                                    <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Articles:default")) ?>">Aktuality</a></li>
                                    <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Gallery:default")) ?>">Fotogalerie</a></li>
                                    <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Organisation:default")) ?>">Organizace</a></li>
                                    <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Content:default")) ?>">Obsah webu</a></li>
                                    <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Sign:default")) ?>">Uživatelé</a></li>
<?php
			}
			?>                                <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Sign:out")) ?>">Odhlásit</a></li>
                            </ul>
                        </li>
<?php
		}
?>
                    
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header><!-- #header -->

    <!-- #main section-->
    <main id="main">
        <div class="container">
<?php
		$iterations = 0;
		foreach ($flashes as $flash) {
			?>            <div<?php
			echo ($_tmp = array_filter(['alert', 'alert-' . $flash->type])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))) . '"' : "";
			?>><br><?php echo LR\Filters::escapeHtmlText($flash->message) /* line 118 */ ?></div>
<?php
			$iterations++;
		}
?>
        </div>
        
        <!-- include content -->
<?php
		$this->renderBlock('content', $this->params, 'html');
?>
        <footer id="footer">
        <div class="container">
            <div class="copyright">
                <p><i>cleverCMS | &copy; 2020 |
<?php
		if ($user->isLoggedIn()) {
			if ($user->isInRole('Admin')) {
				?>                            <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Sign:out")) ?>">Odhlásit</a>
<?php
			}
		}
		else {
			?>                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Sign:in")) ?>">Administrace</a>
                        <!--<li><a n:href="Sign:up">Registrovat</a></li>-->
<?php
		}
?>
                </i></p>
                Thanx to &copy;<strong>BizPage</strong>. All Rights Reserved | Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
        </footer>
    </main>
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
<?php
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('scripts', get_defined_vars());
?>
</body>
</html>
<?php
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['flash' => '118'], $this->params) as $_v => $_l) {
				trigger_error("Variable \$$_v overwritten in foreach on line $_l");
			}
		}
		$this->createTemplate('components/form.latte', $this->params, "import")->render();
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	public function blockScripts(array $_args): void
	{
		extract($_args);
?>
    
      <!-- JavaScript Libraries -->
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 145 */ ?>/lib/jquery/jquery-migrate.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 146 */ ?>/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 147 */ ?>/lib/easing/easing.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 148 */ ?>/lib/superfish/hoverIntent.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 149 */ ?>/lib/superfish/superfish.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 150 */ ?>/lib/wow/wow.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 151 */ ?>/lib/waypoints/waypoints.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 152 */ ?>/lib/counterup/counterup.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 153 */ ?>/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 154 */ ?>/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 155 */ ?>/lib/lightbox/js/lightbox.min.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 156 */ ?>/lib/touchSwipe/jquery.touchSwipe.min.js"></script>

    <!-- Template Main Javascript File -->
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 159 */ ?>/js/main.js"></script>
<?php
	}

}
