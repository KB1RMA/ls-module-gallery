<?

	class Gallery_Set_Item extends Db_ActiveRecord {
		public $table_name = 'gallery_set_items';
		
		public $has_many = array(
			'images' => array('class_name' => 'Db_File', 'foreign_key' => 'master_object_id', 'conditions' => "master_object_class='Gallery_Set_Item' and field='images'", 'order' => 'sort_order, id', 'delete' => true)
		);
		
		protected $api_added_columns = array();
		
		public static function create() {
			return new self();
		}

		public function define_columns($context = null) {
			$this->define_column('title', 'Title')->order('asc')->validation()->fn('trim')->required("Please specify the title.");
			$this->define_column('link', 'Link')->validation()->fn('trim');
			$this->define_column('description', 'Description')->invisible()->validation()->fn('trim');
			$this->define_column('sort_order', 'Sort Order')->validation()->fn('trim')->unique("This sort order is already in use");
			$this->define_column('enabled', 'Enabled');
			$this->define_multi_relation_column('images', 'images', 'Images', '@name')->invisible();
			
			$this->defined_column_list = array();
			Backend::$events->fireEvent('gallery:onExtendSetItemModel', $this, $context);
			$this->api_added_columns = array_keys($this->defined_column_list);
		}

		public function define_form_fields($context = null)
		{
			$this->add_form_field('enabled', 'left')->tab('Set Item');
			$this->add_form_field('title', 'left')->tab('Set Item');
			$this->add_form_field('link', 'right')->tab('Set Item');

			$editor_config = System_HtmlEditorConfig::get('gallery', 'gallery_set_item_description');
			$field = $this->add_form_field('description')->tab('Set Item');
			$field->renderAs(frm_html)->size('small');
			$editor_config->apply_to_form_field($field);
			
			$this->add_form_field('images')->renderAs(frm_file_attachments)->renderFilesAs('image_list')->addDocumentLabel('Add image(s)')->tab('Images')->noAttachmentsLabel('There are no images uploaded')->noLabel()->imageThumbSize(555)->fileDownloadBaseUrl(url('ls_backend/files/get/'));
			
			Backend::$events->fireEvent('gallery:onExtendSetItemForm', $this, $context);
			
			foreach($this->api_added_columns as $column_name) {
				$form_field = $this->find_form_field($column_name);
				
				if($form_field)
					$form_field->optionsMethod('get_added_field_options');
			}
		}
		
		public static function set_orders($item_ids, $item_orders) {
			if(is_string($item_ids))
				$item_ids = explode(',', $item_ids);
				
			if(is_string($item_orders))
				$item_orders = explode(',', $item_orders);

			foreach ($item_ids as $index => $id) {
				$order = $item_orders[$index];
				Db_DbHelper::query('update gallery_set_items set sort_order=:sort_order where id=:id', array(
					'sort_order' => $order,
					'id' => $id
				));
			}

			Cms_Module::update_cms_content_version();
		}
		
		public function after_create() {
			Db_DbHelper::query('update gallery_set_items set sort_order=:sort_order where id=:id', array(
				'sort_order' => $this->id,
				'id' => $this->id
			));

			$this->sort_order = $this->id;
		}
	}