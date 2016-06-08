<?php
/**
 * -----------------------------------------------------------------------------
 * Post Type Generator Script
 * -----------------------------------------------------------------------------
 */

/**
 * -----------------------------------------------------------------------------
 * stop direct access
 * -----------------------------------------------------------------------------
 */

/**
 * -----------------------------------------------------------------------------
 * require files
 * -----------------------------------------------------------------------------
 */

/**
 * -----------------------------------------------------------------------------
 * The class
 * -----------------------------------------------------------------------------
 */
class CORM_CustomPostTypeGenerator
{
	/**
	 * ---------------------------------------------------------------------------
	 * Vars
	 * ---------------------------------------------------------------------------
	 */
	public $labels;
	public $title;
	public $name;
	public $plural;
	public $args;

	public function __construct() {}

	/**
	 * ---------------------------------------------------------------------------
	 *
	 * ---------------------------------------------------------------------------
	 * [init description]
	 * @return [type] [description]
	 * ---------------------------------------------------------------------------
	 */
	public function init($params)
	{
		if(is_array($params['name'])) {
			$this->name = CORM_GeneralHelpers::ugliyString($params['name'][0], 'param');
			$this->title = CORM_GeneralHelpers::handsomeString($params['name'][0]);
			$this->plural = CORM_GeneralHelpers::handsomeString($params['name'][1]);
		} else {
			$this->name = CORM_GeneralHelpers::ugliyString($params['name'], 'param');
			$this->title = CORM_GeneralHelpers::handsomeString($params['name']);
			$this->plural = CORM_GeneralHelpers::puralise(CORM_GeneralHelpers::handsomeString($params['name']));
		}

		if (!post_type_exists($this->name)) {
			$this->createLabels();
			$this->createArgs($params);
      $this->registerPostType();
    }
	}

	/**
	 * ---------------------------------------------------------------------------
	 * Register post type
	 * ---------------------------------------------------------------------------
	 */
	private function registerPostType()
	{
		register_post_type($this->name, $this->args);
	}

	/**
	 * ---------------------------------------------------------------------------
	 * 
	 * ---------------------------------------------------------------------------
	 * @return [type] [description]
	 * ---------------------------------------------------------------------------
	 */
	private function createLabels()
	{
		$this->labels = array(
      'name' 								=> sprintf(_x('%s', 'post type general name', 'cohesion') , $this->plural) ,
      'singular_name' 			=> sprintf(_x('%s', 'post type singular title', 'cohesion') , $this->title) ,
      'menu_name' 					=> sprintf(__('%s', 'cohesion') , $this->plural) ,
      'all_items' 					=> sprintf(__('All %s', 'cohesion') , $this->plural) ,
      'add_new' 						=> sprintf(_x('Add New', '%s', 'cohesion') , $this->title) ,
      'add_new_item' 				=> sprintf(__('Add New %s', 'cohesion') , $this->title) ,
      'edit_item' 					=> sprintf(__('Edit %s', 'cohesion') , $this->title) ,
      'new_item' 						=> sprintf(__('New %s', 'cohesion') , $this->title) ,
      'view_item' 					=> sprintf(__('View %s', 'cohesion') , $this->title) ,
      'items_archive' 			=> sprintf(__('%s Archive', 'cohesion') , $this->title) ,
      'search_items' 				=> sprintf(__('Search %s', 'cohesion') , $this->plural) ,
      'not_found' 					=> sprintf(__('No %s found', 'cohesion') , $this->plural) ,
      'not_found_in_trash' 	=> sprintf(__('No %s found in trash', 'cohesion') , $this->plural) ,
      'parent_item_colon' 	=> sprintf(__('%s Parent', 'cohesion') , $this->title) ,
  	);
	}

	private function createArgs($params)
	{
		$this->args = array(
			'label'									=> sprintf(__('%s', 'cohesion') , $this->title),
			'labels'								=> $this->labels,
			'exclude_from_search'   => false,
			'rewrite'								=> array('slug' => $this->name)
		);

		if(CORM_GeneralHelpers::inArray('description', $params)) {
			$this->args['description'] = __($params['description'], 'cohesion');
		}

		if(CORM_GeneralHelpers::inArray('supports', $params)) {
			$this->args['supports'] = $params['supports'];
		} else {
			$this->args['supports'] = array(
				'title',
				'editor',
				'excerpt',
				'author',
				'thumbnail',
				'comments',
				'revisions',
				'page-attributes',
				'post-formats'
			);
		}

		if(CORM_GeneralHelpers::inArray('taxonomies', $params)) {
			$this->args['taxonomies'] = $params['taxonomies'];
		}

		if($params['type'] == 'page') {
			$this->args['hierarchical'] = true;
			$this->args['capability_type'] = 'page';
		} else {
			$this->args['hierarchical'] = false;
			$this->args['capability_type'] = 'post';
		}

		if($params['public'] == true) {
			$this->args['public'] = true;
			$this->args['publicly_queryable'] = true;
		} else {
			$this->args['public'] = false;
			$this->args['publicly_queryable'] = false;
		}

		if($params['show_in_admin'] == true) {
			$this->args['show_in_menu'] = true;
		} else {
			$this->args['show_in_menu'] = false;
		}

		$this->args = array_merge($this->args);
	}
}//