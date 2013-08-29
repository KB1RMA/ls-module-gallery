<?

	class Gallery_Actions extends Cms_ActionScope {
		public function set() {
			$this->data['set'] = null;

			$slug = $this->request_param(0);

			if(!$slug)
				return;

			$this->data['set'] = Gallery_Set_Item::create()->find_by_slug($slug);
		}

		public function sets() {
			$sets = Gallery_Set_Item::create()->order('sort_order')->where('parent_set_id is NULL')->find_all();

			if(!$sets || !$sets->enabled) {
				$this->data['sets'] = array();
				return;
			}

			$this->data['sets'] = $sets;
		}
	}