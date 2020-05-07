<?php
// source: C:\xampp\htdocs\cleverCMS\app\Presenters/templates/Homepage/default.latte

use Latte\Runtime as LR;

final class Template5a52d03957 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'content' => 'html',
	];


	public function main(): array
	{
		extract($this->params);
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['detail' => '17, 162', 'section' => '4, 146', 'error' => '66', 'article' => '89', 'employee' => '208', 'imageAlbum' => '246', 'image' => '263', 'sponsor' => '295', 'client' => '323'], $this->params) as $_v => $_l) {
				trigger_error("Variable \$$_v overwritten in foreach on line $_l");
			}
		}
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	public function blockContent(array $_args): void
	{
		extract($_args);
?>
<div class="container">
    <div class="row">
<?php
		$iterations = 0;
		foreach ($sectionsAbout as $section) {
			?>            <section id="<?php echo LR\Filters::escapeHtmlAttr($section->section_type) /* line 5 */ ?>" class="col-sm-<?php
			echo LR\Filters::escapeHtmlAttr($section->section_width) /* line 5 */ ?> col-md-<?php echo LR\Filters::escapeHtmlAttr($section->section_width) /* line 5 */ ?> col-lg-<?php
			echo LR\Filters::escapeHtmlAttr($section->section_width) /* line 5 */ ?>" >
                <div class="container">
                    <header class="section-header">
                        <center><img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath . $section->section_image)) /* line 8 */ ?>" alt=" " class="img-fluid"></center>
                        <h3><?php echo LR\Filters::escapeHtmlText($section->section_title) /* line 9 */ ?></h3>
                    </header>
                    <div class="text-justify">
                        <?php echo $section->section_content /* line 12 */ ?>

                    </div>
                    <br>
                    <div class="row <?php echo LR\Filters::escapeHtmlAttr($section->section_type) /* line 15 */ ?>-cols">

<?php
			$iterations = 0;
			foreach ($section->related('sections_details') as $detail) {
				?>                            <div class="col-sm-<?php echo LR\Filters::escapeHtmlAttr($section->section_columns) /* line 18 */ ?> col-md-<?php
				echo LR\Filters::escapeHtmlAttr($section->section_columns) /* line 18 */ ?> col-lg-<?php echo LR\Filters::escapeHtmlAttr($section->section_columns) /* line 18 */ ?> wow fadeInUp">
                                <div class="<?php echo LR\Filters::escapeHtmlAttr($section->section_type) /* line 19 */ ?>-col">
                                    <div class="img">
                                        <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath . $detail->detail_image)) /* line 21 */ ?>" alt=" " class="img-fluid">
                                        <div class="icon"><i class="ion-bug"></i></div>
                                    </div>
                                    <?php
				if ($detail->detail_title) {
					?><h2><?php echo LR\Filters::escapeHtmlText($detail->detail_title) /* line 24 */ ?></h2><?php
				}
?>

                                    <?php
				if ($detail->detail_content) {
					echo $detail->detail_content /* line 25 */;
				}
?>

                                    <br>
<?php
				if ($user->isLoggedIn()) {
					if ($user->isInRole('Admin')) {
?>
                                            <hr>
                                            <p class="text-center">
                                                <a class="btn btn-info" title="Upravit" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Content:editDetail", [$section->id, $detail->id])) ?>"><i class="ion-edit"></i></a>
                                                <a class="btn btn-danger" title="Smazat" onclick="return confirm('Opravdu smazat?');" href="<?php
						echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Content:deleteDetail", [$section->id, $detail->id])) ?>"><i class="ion-trash-a"></i></a>
                                            </p>
<?php
					}
				}
?>
                                </div>
                            </div>
<?php
				$iterations++;
			}
?>
                    </div>
<?php
			if ($user->isLoggedIn()) {
				if ($user->isInRole('Admin')) {
?>
                            <hr>
                            <p class="text-center">
                                <a class="btn btn-info" title="Upravit" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Content:edit", [$section->id])) ?>"><i class="ion-edit"></i></a>
                                <a class="btn btn-danger" title="Smazat" onclick="return confirm('Opravdu smazat?');" href="<?php
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Content:delete", [$section->id])) ?>"><i class="ion-trash-a"></i></a>
                            </p>
<?php
				}
			}
?>
                </div>
            </section>
<?php
			$iterations++;
		}
?>
    </div>
</div>


<!-- News & Actions -->
<section id="news">
    <div class="container">
        <header class="section-header wow fadeInUp">
            <h3>Aktuality a připravované akce</h3>
            <p>Nejnovější zprávy a aktuality na jednom místě...</p>
            <center>
                <div class="col-lg-6">
                    <?php
		/* line 64 */
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $this->global->formsStack[] = $this->global->uiControl["newsletterForm"], []);
?>

<?php
		if ($form->hasErrors()) {
?>                        <ul class="errors">
<?php
			$iterations = 0;
			foreach ($form->errors as $error) {
				?>                            <li><?php echo LR\Filters::escapeHtmlText($error) /* line 66 */ ?></li>
<?php
				$iterations++;
			}
?>
                        </ul>
<?php
		}
?>
                        <div class="input-single">
                            <div class="input-group">
                                <?php echo end($this->global->formsStack)["email"]->getControl() /* line 70 */ ?><br>
                                <span class="input-group-btn"><?php echo end($this->global->formsStack)["send"]->getControl() /* line 71 */ ?></span>
                            </div>
                            <small>
                                <p>Váš email bude sloužit výhradně pro zasílání novinek z našeho webu.<br>
                                (Pozn. zkontrolujte "spam" a popř. označte zprávu, že není spam!)</p>
                            </small>
                        </div>
                    <?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
?>

                </div>
            </center>
            <hr>
<?php
		if ($user->isLoggedIn()) {
			if ($user->identity->role == 'Admin') {
				?>                    <p><a class="btn btn-warning col-md-12" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Articles:add")) ?>">Přidat</a></p>
<?php
			}
		}
?>
        </header>
        <div class="row news-cols">
<?php
		$iterations = 0;
		foreach ($articles as $article) {
?>

                <div class="col-md-4">
                    <div class="news-col">
                        <div class="img">
<?php
			if (isset($article->related('articles_gallery')->fetch()->gallery->url)) {
				?>                                <center><img src=<?php echo LR\Filters::escapeHtmlAttrUnquoted(LR\Filters::safeUrl($basePath . $article->related('articles_gallery')->fetch()->gallery->url)) /* line 95 */ ?> alt=<?php
				echo LR\Filters::escapeHtmlAttrUnquoted($article->related('articles_gallery')->fetch()->gallery->name) /* line 95 */ ?> class="img-fluid"></center>
<?php
			}
			else {
				?>                                <center><img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath . $organisation->logo)) /* line 97 */ ?>" width="40%" alt="logo" class="img-fluid"></center>
<?php
			}
?>
                            <div class="icon"><i class="ion-pin"></i></div>
                        </div>
                        <h2 class="title"><?php echo LR\Filters::escapeHtmlText($article->title) /* line 101 */ ?></h2>
                        <p><center><small>Napsal: <?php echo LR\Filters::escapeHtmlText($article->creator) /* line 102 */ ?> (<?php
			echo LR\Filters::escapeHtmlText(($this->filters->date)($article->created_at, 'd.m.Y')) /* line 102 */ ?>)</small></center></p>
                        <p><?php echo ($this->filters->truncate)($article->content, 200) /* line 103 */ ?></p>
                        <p><center><a class="btn btn-outline-primary" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Articles:show", [$article->id])) ?>">více</a></center></p>
                        <br>
<?php
			if ($user->isLoggedIn()) {
				if ($user->isInRole('Admin')) {
?>
                                <hr>
                                <p class="text-center">
                                    <a class="btn btn-info" title="Upravit" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Articles:editArticle", [$article->id])) ?>"><i class="ion-edit"></i></a>
                                    <a class="btn btn-danger" title="Smazat" onclick="return confirm('Opravdu smazat tento příspěvek?\n\nSouvisející obrázky budou zachovány!');" href="<?php
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Articles:deleteArticle", [$article->id])) ?>"><i class="ion-trash-a"></i></a>
                                </p>
<?php
				}
			}
?>
                    </div>
                </div>
<?php
			$iterations++;
		}
?>
        </div>
        <div class="pagination text-center">
            <b>
<?php
		if ($page > 1) {
			?>                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [1])) ?>">První stránka</a>
                &nbsp;|&nbsp;
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$page-1])) ?>">Předchozí články</a>
                &nbsp;|&nbsp;
<?php
		}
?>

            Stránka <?php echo LR\Filters::escapeHtmlText($page) /* line 128 */ ?> z <?php echo LR\Filters::escapeHtmlText($lastPage) /* line 128 */ ?>


<?php
		if ($page < $lastPage) {
?>
                &nbsp;|&nbsp;
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$page+1])) ?>">Další články</a>
                &nbsp;|&nbsp;
                <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$lastPage])) ?>">Poslední stránka</a>
<?php
		}
?>
            </b>
        </div>
    </div>
</section>

<!--=================
Univ section
==================-->
<div class="container">
    <div class="row">
<?php
		$iterations = 0;
		foreach ($sectionsUniv as $section) {
			?>            <section id="<?php echo LR\Filters::escapeHtmlAttr($section->section_type) /* line 147 */ ?>" class="col-sm-<?php
			echo LR\Filters::escapeHtmlAttr($section->section_width) /* line 147 */ ?> col-md-<?php echo LR\Filters::escapeHtmlAttr($section->section_width) /* line 147 */ ?> col-lg-<?php
			echo LR\Filters::escapeHtmlAttr($section->section_width) /* line 147 */ ?>" >
                <div class="container">
                    <header class="section-header">
                        <center>
                            <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath . $section->section_image)) /* line 151 */ ?>" alt=" " class="img img-fluid">
                        </center>
                        <br>
                        <h3><?php echo LR\Filters::escapeHtmlText($section->section_title) /* line 154 */ ?></h3>
                    </header>
                    <div class="text-justify">
                        <?php echo $section->section_content /* line 157 */ ?>

                    </div>
                    <br>
                    <div class="row <?php echo LR\Filters::escapeHtmlAttr($section->section_type) /* line 160 */ ?>-cols">

<?php
			$iterations = 0;
			foreach ($section->related('sections_details') as $detail) {
				?>                            <div class="col-sm-<?php echo LR\Filters::escapeHtmlAttr($section->section_columns) /* line 163 */ ?> col-md-<?php
				echo LR\Filters::escapeHtmlAttr($section->section_columns) /* line 163 */ ?> col-lg-<?php echo LR\Filters::escapeHtmlAttr($section->section_columns) /* line 163 */ ?> wow fadeInUp">
                                <div class="<?php echo LR\Filters::escapeHtmlAttr($section->section_type) /* line 164 */ ?>-col">
                                    <div class="img">
                                        <center>
                                            <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath . $detail->detail_image)) /* line 167 */ ?>" alt=" " class="img-fluid">
                                        </center>
                                    </div>
                                    <h2><?php echo LR\Filters::escapeHtmlText($detail->detail_title) /* line 170 */ ?></h2>
                                    <p><?php echo $detail->detail_content /* line 171 */ ?></p>
<?php
				if ($user->isLoggedIn()) {
					if ($user->isInRole('Admin')) {
?>
                                            <hr>
                                            <p class="text-center">
                                                <a class="btn btn-info" title="Upravit" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Content:editDetail", [$section->id, $detail->id])) ?>"><i class="ion-edit"></i></a>
                                                <a class="btn btn-danger" title="Smazat" onclick="return confirm('Opravdu smazat?');" href="<?php
						echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Content:deleteDetail", [$section->id, $detail->id])) ?>"><i class="ion-trash-a"></i></a>
                                            </p>
<?php
					}
				}
?>
                                </div>
                            </div>
<?php
				$iterations++;
			}
?>
                    </div>
<?php
			if ($user->isLoggedIn()) {
				if ($user->isInRole('Admin')) {
?>
                            <hr>
                            <p class="text-center">
                                <a class="btn btn-info" title="Upravit" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Content:edit", [$section->id])) ?>"><i class="ion-edit"></i></a>
                                <a class="btn btn-danger" title="Smazat" onclick="return confirm('Opravdu smazat?');" href="<?php
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Content:delete", [$section->id])) ?>"><i class="ion-trash-a"></i></a>
                            </p>
<?php
				}
			}
?>
                </div>
            </section>
<?php
			$iterations++;
		}
?>
    </div>
</div>
<!--==========================
Team Section
============================-->
<section id="team">
    <div class="container">
        <div class="section-header wow fadeInUp">
            <h3>Náš tým</h3>
        </div>
        <div class="row">
<?php
		$iterations = 0;
		foreach ($organisation->related('organisation_employees') as $employee) {
?>
                <div class="col-lg-3 col-md-6 wow fadeInUp">
                    <div class="member">
                        <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath . $employee->image)) /* line 211 */ ?>" alt="<?php
			echo LR\Filters::escapeHtmlAttr($employee->image) /* line 211 */ ?>" class="img-fluid">
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4><?php echo LR\Filters::escapeHtmlText($employee->firstname . ' ' . $employee->lastname) /* line 214 */ ?></h4>
                                <span><?php echo LR\Filters::escapeHtmlText($employee->position) /* line 215 */ ?></span>
                                <span><?php echo LR\Filters::escapeHtmlText($employee->email) /* line 216 */ ?></span>
                                <span><?php echo LR\Filters::escapeHtmlText($employee->gsm) /* line 217 */ ?></span>
<?php
			if ($user->isLoggedIn()) {
				if ($user->isInRole('Admin')) {
?>
                                        <br>
                                        <a class="btn btn-info" title="Upravit" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Employees:edit", [$organisation->id, $employee->id])) ?>"><i class="ion-edit"></i></a>
                                        <a class="btn btn-danger" title="Smazat" onclick="return confirm('Opravdu smazat?');" href="<?php
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Employees:delete", [$employee->id])) ?>"><i class="ion-trash-a"></i></a>
<?php
				}
			}
?>
                            </div>
                        </div>
                    </div>
                </div>
<?php
			$iterations++;
		}
?>
        </div>
    </div>
</section>
        
<!--==========================
  Portfolio Section
============================-->
<section id="portfolio">
    <div class="container">
        <header class="section-header">
            <h3 class="section-title">Fotogalerie</h3>
        </header>
        <div class="row">
            <div class="col-lg-12">
                <ul id="portfolio-flters">
                    <li data-filter="*" class="filter-active">Vše</li>
<?php
		$iterations = 0;
		foreach ($imageAlbums as $imageAlbum) {
			?>                        <li data-filter=".<?php echo LR\Filters::escapeHtmlAttr($imageAlbum->short_name) /* line 247 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($imageAlbum->name) /* line 247 */ ?></li>
<?php
			$iterations++;
		}
		if ($user->isLoggedIn()) {
			if ($user->isInRole('Admin')) {
				?>                            <a class="btn btn-warning" title="Přidat/Upravit kategorii fotografií/obrázků" href="<?php
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Gallery:addAlbum")) ?>"><i class="ion-plus"></i></a>
<?php
			}
		}
?>
                </ul>
            </div>
        </div>
<?php
		if ($user->isLoggedIn()) {
			if ($user->isInRole('Admin')) {
				?>                <p><a class="btn btn-warning col-lg-12" title="Přidat fotografie nebo obrázky" href="<?php
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Gallery:add")) ?>">Přidat obrázky</a></p>
<?php
			}
		}
?>
        <div class="row portfolio-container">
<?php
		$iterations = 0;
		foreach ($images as $image) {
			?>                <div class="col-lg-2 col-md-2 portfolio-item <?php echo LR\Filters::escapeHtmlAttr($image->ref('gallery_album','album_id')->short_name) /* line 264 */ ?> wow fadeInUp">
                    <div class="portfolio-wrap">
                        <figure>
                            <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath . $image->url)) /* line 267 */ ?>" class="img-fluid" alt="">
                            <a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath . $image->url)) /* line 268 */ ?>" class="link-preview" data-lightbox="portfolio" title="<?php
			echo LR\Filters::escapeHtmlAttr($image->description) /* line 268 */ ?>"><i class="ion ion-eye"></i></a>
<?php
			if ($user->isLoggedIn()) {
				if ($user->isInRole('Admin')) {
					?>                                    <a class="link-edit" title="Upravit" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Gallery:editImage", [$image->id])) ?>"><i class="ion-edit"></i></a>
                                    <a class="link-delete" title="Smazat" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Gallery:deleteImage", [$image->id])) ?>"><i class="ion-trash-a"></i></a>
<?php
				}
			}
?>
                        </figure>
                    </div>
                </div>
<?php
			$iterations++;
		}
?>
        </div>

    </div>
</section>
<!-- #portfolio -->

<!--  Sponzors Section-->
<?php
		if ($organisation->sponsors == "ANO") {
?>
    <section id="clients" class="wow fadeInUp">
        <div class="container">

            <header class="section-header">
                <h3>Děkujeme za podporu</h3>
            </header>

            <div class="owl-carousel clients-carousel">
<?php
			$iterations = 0;
			foreach ($sponsors as $sponsor) {
				?>                    <a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($sponsor->link)) /* line 296 */ ?>" ><img src=".<?php
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($sponsor->image_url)) /* line 296 */ ?>" alt=""></a>
<?php
				$iterations++;
			}
?>
            </div>

<?php
			if ($user->isLoggedIn()) {
				if ($user->isInRole('Admin')) {
?>
                    <div class="text-center">
                        <a class="btn btn-info" title="Upravit" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Organisation:edit", [$organisation->id])) ?>"><i class="ion-edit"></i></a>
                    </div>
<?php
				}
			}
?>

        </div>
    </section>
<?php
		}
?>
<!-- #Sponzors -->

<!--  Clients Section-->
<?php
		if ($organisation->clients == "ANO") {
?>
    <section id="clients" class="wow fadeInUp">
        <div class="container">

            <header class="section-header">
                <h3>Naši klienti</h3>
            </header>

            <div class="owl-carousel clients-carousel">
<?php
			$iterations = 0;
			foreach ($clients as $client) {
				?>                    <a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($client->link)) /* line 324 */ ?>"><img src=".<?php
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($client->image_url)) /* line 324 */ ?>" alt=""></a>
<?php
				$iterations++;
			}
?>
            </div>
<?php
			if ($user->isLoggedIn()) {
				if ($user->isInRole('Admin')) {
?>
                    <div class="text-center">
                        <a class="btn btn-info" title="Upravit" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Organisation:edit", [$organisation->id])) ?>"><i class="ion-edit"></i></a>
                    </div>
<?php
				}
			}
?>
        </div>
    </section>
<?php
		}
?>
<!-- #Clients -->

<!--==========================
  Contact Section
============================-->
<section id="contact" class="section-bg wow fadeInUp">
    <div class="container">
        <div class="section-header">
            <h3>Kontakt</h3>
        </div>
        <div class="row contact-info">
            <div class="col-md-3">
                <div class="contact-address">
                    <h3>Adresa</h3>
                    <i class="ion-ios-location-outline"></i>
                    <address>
                        <p><?php echo LR\Filters::escapeHtmlText($organisation->street) /* line 353 */ ?></p>
                        <p><?php echo LR\Filters::escapeHtmlText($organisation->city) /* line 354 */ ?></p>
                        <p><?php echo LR\Filters::escapeHtmlText($organisation->postal) /* line 355 */ ?></p>

                    </address>
                </div>
            </div>

            <div class="col-md-3">
                <div class="contact-phone">
                    <h3>Telefon</h3>
                    <i class="ion-ios-telephone-outline"></i>
                    <p><?php echo LR\Filters::escapeHtmlText($organisation->phone) /* line 365 */ ?></p>
                    <p><?php echo LR\Filters::escapeHtmlText($organisation->gsm) /* line 366 */ ?></p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="contact-email">
                    <h3>Email</h3>
                    <i class="ion-ios-email-outline"></i>
                    <p><a href=<?php echo LR\Filters::escapeHtmlAttrUnquoted(LR\Filters::safeUrl($organisation->email)) /* line 374 */ ?>><?php
		echo LR\Filters::escapeHtmlText($organisation->email) /* line 374 */ ?></a></p>
                </div>
            </div>
                
            <div class="col-md-3">
                <div class="contact-phone">
                    <h3>Facebook</h3><br>
                    <a href="https://www.facebook.com/" class="facebook"><i class="fa fa-facebook"></i></a>
                </div>
            </div>
        </div>
        <div class="text-center">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2547.9338533177433!2d16.17925561546546!3d50.3118264794566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470e70c48cb8e0b3%3A0x178ee5a8fd6da6de!2sVal%2014%2C%20518%2001%20Val!5e0!3m2!1sen!2scz!4v1585807571705!5m2!1sen!2scz" width="300" height="150" frameborder="0" style="box-shadow: 0px 2px 12px rgba(0, 0, 0, 0.8);" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <hr>
        <div class="text-center">
            <h3>Provozní doba:</h3>
            <p>6:30 – 16:00</p>
            <p>IČO: <?php echo LR\Filters::escapeHtmlText($organisation->ico) /* line 392 */ ?>

                <br>
                Bankovní spojení: <?php echo LR\Filters::escapeHtmlText($organisation->account) /* line 394 */ ?>

            </p>
        </div>
    </div>
</section>
<!-- #contact --><?php
	}

}
