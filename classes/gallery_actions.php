<?

	class Gallery_Actions extends Cms_ActionScope {
		public function sets() {
			$sets = Gallery_Set_Item::create()->order('sort_order')->find_all();
			
			if(!$sets || !$sets->enabled) {
				$this->data['sets'] = array();
				return;
			}

			$this->data['sets'] = $sets;
		}
	}