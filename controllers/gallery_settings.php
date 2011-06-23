<?

	class Gallery_Settings extends Backend_Controller {
		public $implement = 'Db_FormBehavior, Db_ListBehavior';
		protected $required_permissions = array('gallery:manage_licenses');

		public function __construct() {
			parent::__construct();
			$this->app_tab = 'gallery';
			$this->app_page = 'settings';
			$this->app_module_name = 'Gallery';
		}

		public function index() {
			$this->app_page_title = 'Settings';
		}
	}