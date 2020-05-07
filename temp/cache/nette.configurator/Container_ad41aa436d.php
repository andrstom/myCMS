<?php
// source: C:\xampp\htdocs\cleverCMS\app/config/common.neon
// source: C:\xampp\htdocs\cleverCMS\app/config/local.neon
// source: array

/** @noinspection PhpParamsInspection,PhpMethodMayBeStaticInspection */

declare(strict_types=1);

class Container_ad41aa436d extends Nette\DI\Container
{
	protected $tags = [
		'nette.inject' => [
			'application.1' => true,
			'application.10' => true,
			'application.11' => true,
			'application.12' => true,
			'application.2' => true,
			'application.3' => true,
			'application.4' => true,
			'application.5' => true,
			'application.6' => true,
			'application.7' => true,
			'application.8' => true,
			'application.9' => true,
		],
	];

	protected $types = ['container' => 'Nette\DI\Container'];

	protected $aliases = [
		'application' => 'application.application',
		'cacheStorage' => 'cache.storage',
		'database.default' => 'database.default.connection',
		'httpRequest' => 'http.request',
		'httpResponse' => 'http.response',
		'nette.cacheJournal' => 'cache.journal',
		'nette.database.default' => 'database.default',
		'nette.database.default.context' => 'database.default.context',
		'nette.httpRequestFactory' => 'http.requestFactory',
		'nette.latteFactory' => 'latte.latteFactory',
		'nette.mailer' => 'mail.mailer',
		'nette.presenterFactory' => 'application.presenterFactory',
		'nette.templateFactory' => 'latte.templateFactory',
		'nette.userStorage' => 'security.userStorage',
		'router' => 'routing.router',
		'session' => 'session.session',
		'user' => 'security.user',
	];

	protected $wiring = [
		'Nette\DI\Container' => [['container']],
		'Nette\Application\Application' => [['application.application']],
		'Nette\Application\IPresenterFactory' => [['application.presenterFactory']],
		'Nette\Application\LinkGenerator' => [['application.linkGenerator']],
		'Nette\Caching\Storages\IJournal' => [['cache.journal']],
		'Nette\Caching\IStorage' => [['cache.storage']],
		'Nette\Database\Connection' => [['database.default.connection']],
		'Nette\Database\IStructure' => [['database.default.structure']],
		'Nette\Database\Structure' => [['database.default.structure']],
		'Nette\Database\IConventions' => [['database.default.conventions']],
		'Nette\Database\Conventions\DiscoveredConventions' => [['database.default.conventions']],
		'Nette\Database\Context' => [['database.default.context']],
		'Nette\Http\RequestFactory' => [['http.requestFactory']],
		'Nette\Http\IRequest' => [['http.request']],
		'Nette\Http\Request' => [['http.request']],
		'Nette\Http\IResponse' => [['http.response']],
		'Nette\Http\Response' => [['http.response']],
		'Nette\Bridges\ApplicationLatte\ILatteFactory' => [['latte.latteFactory']],
		'Nette\Application\UI\ITemplateFactory' => [['latte.templateFactory']],
		'Nette\Mail\Mailer' => [['mail.mailer']],
		'Nette\Routing\RouteList' => [['routing.router']],
		'Nette\Routing\Router' => [['routing.router']],
		'Nette\Application\IRouter' => [['routing.router']],
		'ArrayAccess' => [
			2 => [
				'routing.router',
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Countable' => [2 => ['routing.router']],
		'IteratorAggregate' => [2 => ['routing.router']],
		'Traversable' => [2 => ['routing.router']],
		'Nette\Application\Routers\RouteList' => [['routing.router']],
		'Nette\Security\Passwords' => [['security.passwords']],
		'Nette\Security\IUserStorage' => [['security.userStorage']],
		'Nette\Security\User' => [['security.user']],
		'Nette\Http\Session' => [['session.session']],
		'Tracy\ILogger' => [['tracy.logger']],
		'Tracy\BlueScreen' => [['tracy.blueScreen']],
		'Tracy\Bar' => [['tracy.bar']],
		'Nette\Security\IAuthenticator' => [['01']],
		'App\Model\UserManager' => [['01']],
		'App\Model\ArticlesManager' => [['02']],
		'App\Model\OrganisationManager' => [['03']],
		'App\Model\EmployeesManager' => [['04']],
		'App\Model\ClientsManager' => [['05']],
		'App\Model\SponsorsManager' => [['06']],
		'App\Model\FileManager' => [['07']],
		'App\Model\EmailManager' => [['08']],
		'App\Model\DbHandler' => [['09']],
		'App\Model\PdfManager' => [['010']],
		'App\Model\ContentManager' => [['011']],
		'App\Model\GalleryManager' => [['012']],
		'App\Model\FoodManager' => [['013']],
		'App\Forms\FormFactory' => [['014']],
		'App\Forms\SignInFormFactory' => [['015']],
		'App\Forms\SignUpFormFactory' => [['016']],
		'App\Forms\SignEditFormFactory' => [['017']],
		'App\Forms\SignEditPasswordFormFactory' => [['018']],
		'App\Forms\ArticlesFormFactory' => [['019']],
		'App\Forms\NewsletterFormFactory' => [['020']],
		'App\Forms\OrganisationFormFactory' => [['021']],
		'App\Forms\OrganisationDetailFormFactory' => [['022']],
		'App\Forms\OrganisationClientsFormFactory' => [['023']],
		'App\Forms\OrganisationSponsorsFormFactory' => [['024']],
		'App\Forms\EmployeesFormFactory' => [['025']],
		'App\Forms\SectionFormFactory' => [['026']],
		'App\Forms\SectionDetailFormFactory' => [['027']],
		'App\Forms\GalleryFormFactory' => [['028']],
		'App\Forms\GalleryEditFormFactory' => [['029']],
		'App\Forms\GalleryAlbumFormFactory' => [['030']],
		'App\Forms\AlergenFormFactory' => [['031']],
		'App\Forms\FoodFormFactory' => [['032']],
		'App\Forms\FoodEditFormFactory' => [['033']],
		'App\Presenters\BasePresenter' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\Application\UI\Presenter' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\Application\UI\Control' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\Application\UI\Component' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\ComponentModel\Container' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\ComponentModel\Component' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\ComponentModel\IComponent' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\ComponentModel\IContainer' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\Application\UI\ISignalReceiver' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\Application\UI\IStatePersistent' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\Application\UI\IRenderable' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
			],
		],
		'Nette\Application\IPresenter' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
				'application.12',
			],
		],
		'App\Presenters\ArticlesPresenter' => [2 => ['application.1']],
		'App\Presenters\ContentPresenter' => [2 => ['application.2']],
		'App\Presenters\EmployeesPresenter' => [2 => ['application.3']],
		'App\Presenters\Error4xxPresenter' => [2 => ['application.4']],
		'App\Presenters\ErrorPresenter' => [2 => ['application.5']],
		'App\Presenters\FoodPresenter' => [2 => ['application.6']],
		'App\Presenters\GalleryPresenter' => [2 => ['application.7']],
		'App\Presenters\HomepagePresenter' => [2 => ['application.8']],
		'App\Presenters\OrganisationPresenter' => [2 => ['application.9']],
		'App\Presenters\SignPresenter' => [2 => ['application.10']],
		'NetteModule\ErrorPresenter' => [2 => ['application.11']],
		'NetteModule\MicroPresenter' => [2 => ['application.12']],
	];


	public function __construct(array $params = [])
	{
		parent::__construct($params);
		$this->parameters += [
			'appDir' => 'C:\xampp\htdocs\cleverCMS\app',
			'wwwDir' => 'C:\xampp\htdocs\cleverCMS\www',
			'vendorDir' => 'C:\xampp\htdocs\cleverCMS\vendor',
			'debugMode' => true,
			'productionMode' => false,
			'consoleMode' => false,
			'tempDir' => 'C:\xampp\htdocs\cleverCMS\app/../temp',
		];
	}


	public function createService01(): App\Model\UserManager
	{
		return new App\Model\UserManager(
			$this->getService('database.default.context'),
			$this->getService('security.passwords'),
			$this->getService('08')
		);
	}


	public function createService02(): App\Model\ArticlesManager
	{
		return new App\Model\ArticlesManager(
			$this->getService('database.default.context'),
			$this->getService('07'),
			$this->getService('08'),
			$this->getService('012')
		);
	}


	public function createService03(): App\Model\OrganisationManager
	{
		return new App\Model\OrganisationManager($this->getService('database.default.context'), $this->getService('07'));
	}


	public function createService04(): App\Model\EmployeesManager
	{
		return new App\Model\EmployeesManager($this->getService('database.default.context'), $this->getService('07'));
	}


	public function createService05(): App\Model\ClientsManager
	{
		return new App\Model\ClientsManager($this->getService('database.default.context'), $this->getService('07'));
	}


	public function createService06(): App\Model\SponsorsManager
	{
		return new App\Model\SponsorsManager($this->getService('database.default.context'), $this->getService('07'));
	}


	public function createService07(): App\Model\FileManager
	{
		return new App\Model\FileManager;
	}


	public function createService08(): App\Model\EmailManager
	{
		return new App\Model\EmailManager(
			$this->getService('database.default.context'),
			$this->getService('mail.mailer'),
			$this->getService('application.linkGenerator'),
			$this->getService('latte.latteFactory')
		);
	}


	public function createService09(): App\Model\DbHandler
	{
		return new App\Model\DbHandler($this->getService('database.default.context'));
	}


	public function createService010(): App\Model\PdfManager
	{
		return new App\Model\PdfManager($this->getService('database.default.context'), $this->getService('security.user'));
	}


	public function createService011(): App\Model\ContentManager
	{
		return new App\Model\ContentManager($this->getService('database.default.context'), $this->getService('07'));
	}


	public function createService012(): App\Model\GalleryManager
	{
		return new App\Model\GalleryManager($this->getService('database.default.context'), $this->getService('07'));
	}


	public function createService013(): App\Model\FoodManager
	{
		return new App\Model\FoodManager($this->getService('database.default.context'), $this->getService('07'));
	}


	public function createService014(): App\Forms\FormFactory
	{
		return new App\Forms\FormFactory;
	}


	public function createService015(): App\Forms\SignInFormFactory
	{
		return new App\Forms\SignInFormFactory($this->getService('014'), $this->getService('security.user'));
	}


	public function createService016(): App\Forms\SignUpFormFactory
	{
		return new App\Forms\SignUpFormFactory(
			$this->getService('014'),
			$this->getService('01'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createService017(): App\Forms\SignEditFormFactory
	{
		return new App\Forms\SignEditFormFactory($this->getService('014'), $this->getService('01'), $this->getService('security.user'));
	}


	public function createService018(): App\Forms\SignEditPasswordFormFactory
	{
		return new App\Forms\SignEditPasswordFormFactory(
			$this->getService('014'),
			$this->getService('01'),
			$this->getService('security.user')
		);
	}


	public function createService019(): App\Forms\ArticlesFormFactory
	{
		return new App\Forms\ArticlesFormFactory(
			$this->getService('database.default.context'),
			$this->getService('014'),
			$this->getService('security.user'),
			$this->getService('02'),
			$this->getService('08')
		);
	}


	public function createService020(): App\Forms\NewsletterFormFactory
	{
		return new App\Forms\NewsletterFormFactory(
			$this->getService('014'),
			$this->getService('security.user'),
			$this->getService('02'),
			$this->getService('09')
		);
	}


	public function createService021(): App\Forms\OrganisationFormFactory
	{
		return new App\Forms\OrganisationFormFactory(
			$this->getService('014'),
			$this->getService('03'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createService022(): App\Forms\OrganisationDetailFormFactory
	{
		return new App\Forms\OrganisationDetailFormFactory(
			$this->getService('014'),
			$this->getService('03'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createService023(): App\Forms\OrganisationClientsFormFactory
	{
		return new App\Forms\OrganisationClientsFormFactory(
			$this->getService('014'),
			$this->getService('05'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createService024(): App\Forms\OrganisationSponsorsFormFactory
	{
		return new App\Forms\OrganisationSponsorsFormFactory(
			$this->getService('014'),
			$this->getService('06'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createService025(): App\Forms\EmployeesFormFactory
	{
		return new App\Forms\EmployeesFormFactory(
			$this->getService('014'),
			$this->getService('04'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createService026(): App\Forms\SectionFormFactory
	{
		return new App\Forms\SectionFormFactory(
			$this->getService('014'),
			$this->getService('011'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createService027(): App\Forms\SectionDetailFormFactory
	{
		return new App\Forms\SectionDetailFormFactory(
			$this->getService('014'),
			$this->getService('011'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createService028(): App\Forms\GalleryFormFactory
	{
		return new App\Forms\GalleryFormFactory(
			$this->getService('09'),
			$this->getService('014'),
			$this->getService('security.user'),
			$this->getService('012')
		);
	}


	public function createService029(): App\Forms\GalleryEditFormFactory
	{
		return new App\Forms\GalleryEditFormFactory(
			$this->getService('09'),
			$this->getService('014'),
			$this->getService('security.user'),
			$this->getService('012')
		);
	}


	public function createService030(): App\Forms\GalleryAlbumFormFactory
	{
		return new App\Forms\GalleryAlbumFormFactory(
			$this->getService('014'),
			$this->getService('security.user'),
			$this->getService('012')
		);
	}


	public function createService031(): App\Forms\AlergenFormFactory
	{
		return new App\Forms\AlergenFormFactory(
			$this->getService('014'),
			$this->getService('013'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createService032(): App\Forms\FoodFormFactory
	{
		return new App\Forms\FoodFormFactory(
			$this->getService('014'),
			$this->getService('013'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createService033(): App\Forms\FoodEditFormFactory
	{
		return new App\Forms\FoodEditFormFactory(
			$this->getService('014'),
			$this->getService('013'),
			$this->getService('security.user'),
			$this->getService('09')
		);
	}


	public function createServiceApplication__1(): App\Presenters\ArticlesPresenter
	{
		$service = new App\Presenters\ArticlesPresenter($this->getService('019'), $this->getService('09'), $this->getService('02'));
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__10(): App\Presenters\SignPresenter
	{
		$service = new App\Presenters\SignPresenter(
			$this->getService('database.default.context'),
			$this->getService('security.passwords'),
			$this->getService('015'),
			$this->getService('016'),
			$this->getService('017'),
			$this->getService('018')
		);
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__11(): NetteModule\ErrorPresenter
	{
		return new NetteModule\ErrorPresenter($this->getService('tracy.logger'));
	}


	public function createServiceApplication__12(): NetteModule\MicroPresenter
	{
		return new NetteModule\MicroPresenter($this, $this->getService('http.request'), $this->getService('routing.router'));
	}


	public function createServiceApplication__2(): App\Presenters\ContentPresenter
	{
		$service = new App\Presenters\ContentPresenter($this->getService('09'), $this->getService('026'), $this->getService('027'));
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__3(): App\Presenters\EmployeesPresenter
	{
		$service = new App\Presenters\EmployeesPresenter($this->getService('09'), $this->getService('025'));
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__4(): App\Presenters\Error4xxPresenter
	{
		$service = new App\Presenters\Error4xxPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__5(): App\Presenters\ErrorPresenter
	{
		return new App\Presenters\ErrorPresenter($this->getService('tracy.logger'));
	}


	public function createServiceApplication__6(): App\Presenters\FoodPresenter
	{
		$service = new App\Presenters\FoodPresenter(
			$this->getService('09'),
			$this->getService('031'),
			$this->getService('032'),
			$this->getService('033')
		);
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__7(): App\Presenters\GalleryPresenter
	{
		$service = new App\Presenters\GalleryPresenter(
			$this->getService('09'),
			$this->getService('028'),
			$this->getService('029'),
			$this->getService('030')
		);
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__8(): App\Presenters\HomepagePresenter
	{
		$service = new App\Presenters\HomepagePresenter($this->getService('02'), $this->getService('09'), $this->getService('020'));
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__9(): App\Presenters\OrganisationPresenter
	{
		$service = new App\Presenters\OrganisationPresenter(
			$this->getService('09'),
			$this->getService('021'),
			$this->getService('025'),
			$this->getService('023'),
			$this->getService('024')
		);
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__application(): Nette\Application\Application
	{
		$service = new Nette\Application\Application(
			$this->getService('application.presenterFactory'),
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('http.response')
		);
		$service->catchExceptions = false;
		$service->errorPresenter = 'Error';
		Nette\Bridges\ApplicationTracy\RoutingPanel::initializePanel($service);
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\ApplicationTracy\RoutingPanel(
			$this->getService('routing.router'),
			$this->getService('http.request'),
			$this->getService('application.presenterFactory')
		));
		return $service;
	}


	public function createServiceApplication__linkGenerator(): Nette\Application\LinkGenerator
	{
		return new Nette\Application\LinkGenerator(
			$this->getService('routing.router'),
			$this->getService('http.request')->getUrl()->withoutUserInfo(),
			$this->getService('application.presenterFactory')
		);
	}


	public function createServiceApplication__presenterFactory(): Nette\Application\IPresenterFactory
	{
		$service = new Nette\Application\PresenterFactory(new Nette\Bridges\ApplicationDI\PresenterFactoryCallback(
			$this,
			5,
			'C:\xampp\htdocs\cleverCMS\app/../temp/cache/nette.application/touch'
		));
		$service->setMapping(['*' => 'App\*Module\Presenters\*Presenter']);
		return $service;
	}


	public function createServiceCache__journal(): Nette\Caching\Storages\IJournal
	{
		return new Nette\Caching\Storages\SQLiteJournal('C:\xampp\htdocs\cleverCMS\app/../temp/cache/journal.s3db');
	}


	public function createServiceCache__storage(): Nette\Caching\IStorage
	{
		return new Nette\Caching\Storages\FileStorage('C:\xampp\htdocs\cleverCMS\app/../temp/cache', $this->getService('cache.journal'));
	}


	public function createServiceContainer(): Container_ad41aa436d
	{
		return $this;
	}


	public function createServiceDatabase__default__connection(): Nette\Database\Connection
	{
		$service = new Nette\Database\Connection('mysql:host=127.0.0.1;dbname=clevercms', 'root', null, ['lazy' => true]);
		$this->getService('tracy.blueScreen')->addPanel(['Nette\Bridges\DatabaseTracy\ConnectionPanel', 'renderException']);
		Nette\Database\Helpers::createDebugPanel($service, true, 'default');
		return $service;
	}


	public function createServiceDatabase__default__context(): Nette\Database\Context
	{
		return new Nette\Database\Context(
			$this->getService('database.default.connection'),
			$this->getService('database.default.structure'),
			$this->getService('database.default.conventions'),
			$this->getService('cache.storage')
		);
	}


	public function createServiceDatabase__default__conventions(): Nette\Database\Conventions\DiscoveredConventions
	{
		return new Nette\Database\Conventions\DiscoveredConventions($this->getService('database.default.structure'));
	}


	public function createServiceDatabase__default__structure(): Nette\Database\Structure
	{
		return new Nette\Database\Structure($this->getService('database.default.connection'), $this->getService('cache.storage'));
	}


	public function createServiceHttp__request(): Nette\Http\Request
	{
		return $this->getService('http.requestFactory')->fromGlobals();
	}


	public function createServiceHttp__requestFactory(): Nette\Http\RequestFactory
	{
		$service = new Nette\Http\RequestFactory;
		$service->setProxy([]);
		return $service;
	}


	public function createServiceHttp__response(): Nette\Http\Response
	{
		return new Nette\Http\Response;
	}


	public function createServiceLatte__latteFactory(): Nette\Bridges\ApplicationLatte\ILatteFactory
	{
		return new class ($this) implements Nette\Bridges\ApplicationLatte\ILatteFactory {
			private $container;


			public function __construct(Container_ad41aa436d $container)
			{
				$this->container = $container;
			}


			public function create(): Latte\Engine
			{
				$service = new Latte\Engine;
				$service->setTempDirectory('C:\xampp\htdocs\cleverCMS\app/../temp/cache/latte');
				$service->setAutoRefresh();
				$service->setContentType('html');
				Nette\Utils\Html::$xhtml = false;
				Contributte\FormMultiplier\Macros\MultiplierMacros::install($service->getCompiler());
				return $service;
			}
		};
	}


	public function createServiceLatte__templateFactory(): Nette\Application\UI\ITemplateFactory
	{
		return new Nette\Bridges\ApplicationLatte\TemplateFactory(
			$this->getService('latte.latteFactory'),
			$this->getService('http.request'),
			$this->getService('security.user'),
			$this->getService('cache.storage')
		);
	}


	public function createServiceMail__mailer(): Nette\Mail\Mailer
	{
		return new Nextras\MailPanel\FileMailer('C:\xampp\htdocs\cleverCMS\app/../temp/mail-panel-mails');
	}


	public function createServiceRouting__router(): Nette\Application\Routers\RouteList
	{
		return App\Router\RouterFactory::createRouter();
	}


	public function createServiceSecurity__passwords(): Nette\Security\Passwords
	{
		return new Nette\Security\Passwords;
	}


	public function createServiceSecurity__user(): Nette\Security\User
	{
		$service = new Nette\Security\User($this->getService('security.userStorage'), $this->getService('01'));
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\SecurityTracy\UserPanel($service));
		return $service;
	}


	public function createServiceSecurity__userStorage(): Nette\Security\IUserStorage
	{
		return new Nette\Http\UserStorage($this->getService('session.session'));
	}


	public function createServiceSession__session(): Nette\Http\Session
	{
		$service = new Nette\Http\Session($this->getService('http.request'), $this->getService('http.response'));
		$service->setExpiration('10 days');
		return $service;
	}


	public function createServiceTracy__bar(): Tracy\Bar
	{
		return Tracy\Debugger::getBar();
	}


	public function createServiceTracy__blueScreen(): Tracy\BlueScreen
	{
		return Tracy\Debugger::getBlueScreen();
	}


	public function createServiceTracy__logger(): Tracy\ILogger
	{
		return Tracy\Debugger::getLogger();
	}


	public function initialize()
	{
		// di.
		(function () {
			$this->getService('tracy.bar')->addPanel(new Nette\Bridges\DITracy\ContainerPanel($this));
		})();
		// http.
		(function () {
			$response = $this->getService('http.response');
			$response->setHeader('X-Powered-By', 'Nette Framework 3');
			$response->setHeader('Content-Type', 'text/html; charset=utf-8');
			$response->setHeader('X-Frame-Options', 'SAMEORIGIN');
			$response->setCookie('nette-samesite', '1', 0, '/', null, null, true, 'Strict');
		})();
		// session.
		(function () {
			$this->getService('session.session')->start();
		})();
		// tracy.
		(function () {
			Tracy\Debugger::getLogger()->mailer = [new Tracy\Bridges\Nette\MailSender($this->getService('mail.mailer')), 'send'];
			$this->getService('tracy.bar')->addPanel(new Nextras\MailPanel\MailPanel(
				'C:\xampp\htdocs\cleverCMS\app/../temp/mail-panel-latte',
				$this->getService('http.request'),
				$this->getService('mail.mailer')
			));
			$this->getService('session.session')->start();
			Tracy\Debugger::dispatch();
		})();
		Contributte\FormMultiplier\Multiplier::register('addMultiplier');
	}
}
