<?

	class Gallery_Actions extends Cms_ActionScope {
		public function sets() {
			$sets = Gallery_Set_Item::create()->find_all();
			
			if(!$sets || !$sets->enabled) {
				$this->data['sets'] = array();
				return;
			}

			$this->data['sets'] = $sets;
		}
	}