<?

	define('PATH_MOD_GALLERY', PATH_APP . '/modules/gallery');
	
	class Gallery_Module extends Core_ModuleBase {
		const PATH = PATH_MOD_GALLERY;
		
		protected function get_info() {
			return new Core_ModuleInfo(
				"Gallery",
				"Management for your galleries",
				"Limewheel Creative Inc."
			);
		}
		
		public function subscribe_events() {

		}
		
		public function build_ui_permissions($host) {
			$host->add_field($this, 'manage_galleries', 'Manage galleries', 'left')->renderAs(frm_checkbox)->comment('View and manage the galleries.', 'above');
			$host->add_field($this, 'manage_settings', 'Manage settings', 'left')->renderAs(frm_checkbox)->comment('View and manage the settings.', 'above');
		}
		
		public function list_tabs($tab_collection) {
			$user = Phpr::$security->getUser();
			
			$tabs = array(
				'set_items' => array('set_items', 'Set Items', 'set_items'),
				'settings' => array('settings', 'Settings', 'settings')
			);

			$first_tab = null;
			
			foreach($tabs as $tab_id => $tab_info) {
				if(($tabs[$tab_id][3] = $user->get_permission('gallery', $tab_info[2])) && !$first_tab)
					$first_tab = $tab_info[0];
			}

			if($first_tab) {
				$tab = $tab_collection->tab('gallery', 'Gallery', $first_tab, 30);
				
				foreach($tabs as $tab_id => $tab_info) {
					if($tab_info[3])
						$tab->addSecondLevel($tab_id, $tab_info[1], $tab_info[0]);
				}
			}
		}
		
		public function list_html_editor_configs() {
			return array(
				'gallery_set_item_description' => 'Gallery description'
			);
		}
		
		/**
		 * Awaiting deprecation
		 */
		
		protected function createModuleInfo() {
			return $this->get_info();
		}
		
		public function subscribeEvents() {
			return $this->subscribe_events();
		}
		
		public function buildPermissionsUi($host) {
			return $this->build_ui_permissions($host);
		}
		
		public function listTabs($tab_collection) {
			return $this->list_tabs($tab_collection);
		}
		
		public function listHtmlEditorConfigs() {
			return $this->list_html_editor_configs();
		}
	}