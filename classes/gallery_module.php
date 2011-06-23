<?

	class Gallery_Module extends Core_ModuleBase {
		protected function createModuleInfo() {
			return new Core_ModuleInfo(
				"Gallery",
				"Management for your galleries",
				"Limewheel Creative Inc."
			);
		}
		
		public function subscribeEvents() {

		}
		
		public function buildPermissionsUi($host_obj) {
			$host_obj->add_field($this, 'galleries', 'Manage galleries', 'left')->renderAs(frm_checkbox)->comment('View and manage the update.', 'above');

		}
		
		public function listTabs($tabCollection) {
			$user = Phpr::$security->getUser();
			$tabs = array(
				'set_items' => array('set_items', 'Set Items', 'set_items'),
				'settings' => array('settings', 'Settings', 'settings')
			);

			$first_tab = null;
			foreach($tabs as $tab_id=>$tab_info) {
				if(($tabs[$tab_id][3] = $user->get_permission('gallery', $tab_info[2])) && !$first_tab)
					$first_tab = $tab_info[0];
			}

			if($first_tab) {
				$tab = $tabCollection->tab('gallery', 'Gallery', $first_tab, 30);
				foreach($tabs as $tab_id=>$tab_info) {
					if($tab_info[3])
						$tab->addSecondLevel($tab_id, $tab_info[1], $tab_info[0]);
				}
			}
		}
		
		public function listHtmlEditorConfigs() {
			return array(
				'gallery_description' => 'Gallery description'
			);
		}
	}