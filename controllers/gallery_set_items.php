<?

	class Gallery_Set_Items extends Backend_Controller {
		public $implement = 'Db_ListBehavior, Db_FormBehavior';
		public $list_model_class = 'gallery_set_item';
		public $list_record_url = null;
		
		public $form_preview_title = 'Gallery';
		public $form_create_title = 'New Set Item';
		public $form_edit_title = 'Edit Set Item';
		public $form_model_class = 'Gallery_Set_Item';
		public $form_not_found_message = 'Record not found';
		public $form_redirect = null;
		
		public $form_edit_save_flash = 'The record has been successfully saved';
		public $form_create_save_flash = 'The record has been successfully added';
		public $form_edit_delete_flash = 'The record has been successfully deleted';
		public $form_edit_save_auto_timestamp = true;
		
		public $list_search_enabled = true;
		public $list_search_fields = array('@title');
		public $list_search_prompt = 'find set items by title';
		public $list_no_setup_link = false;
		public $list_no_interaction = false;
		public $list_no_sorting = false;
		public $list_columns = array();
		public $list_custom_body_cells = null;
		public $list_custom_head_cells = null;
		
		protected $required_permissions = array('gallery:manage_galleries');

		public function __construct() {
			parent::__construct();
			$this->app_tab = 'gallery';
			$this->app_module_name = 'Gallery';

			$this->list_record_url = url('/gallery/set_items/edit/');
			$this->form_redirect = url('/gallery/set_items/');
			$this->app_page = 'gallery_set_items';

			if(Phpr::$router->action == 'reorder') {
				$this->list_record_url = null;
				$this->list_search_enabled = false;
				$this->list_no_interaction = true;
				$this->list_columns = array('title', 'link', 'enabled');
				$this->list_custom_body_cells = PATH_APP.'/modules/gallery/controllers/gallery_set_items/_body_cells.htm';
				$this->list_custom_head_cells = PATH_APP.'/modules/gallery/controllers/gallery_set_items/_head_cells.htm';
			}
		}
		
		public function index() {
			$this->app_page_title = 'Gallery Set Items';
		}
		
		public function reorder() {
			$this->app_page_title = 'Manage Set Item Order';
		}
		
		public function listOverrideSortingColumn($sorting_column) {
			if(Phpr::$router->action === 'reorder') {
				$result = array('field' => 'sort_order', 'direction' => 'asc');
				
				return (object)$result;
			}

			return $sorting_column;
		}
		
		protected function reorder_onSetOrders() {
			try {
				Gallery_Set_Item::set_orders(post('item_ids'), post('sort_orders'));
			}
			catch(Exception $ex) {
				Phpr::$response->ajaxReportException($ex, true, true);
			}
		}
	}