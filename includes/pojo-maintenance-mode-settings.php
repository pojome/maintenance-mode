<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_Maintenance_Mode_Settings extends Pojo_Settings_Page_Base {
	
	public function __construct( $priority = 10 ) {
		$this->_page_id = 'pojo-maintenance';
		$this->_page_title = __( 'Maintenance Mode Settings', 'pojo-maintenance-mode' );
		$this->_page_menu_title = __( 'Maintenance Mode', 'pojo-maintenance-mode' );
		$this->_page_type = 'submenu';
		$this->_page_parent = 'pojo-home';
		
		

		parent::__construct( $priority );
	}
	
}