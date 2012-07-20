<?php
/*
 Plugin Name: Offer Calc
 Plugin URI: http://devrix.com/offercalc
 Description: Offer Calc is a simple plugin letting your site visitors to calculate your services at final cost.
 Version: 0.8
 Stable tag: 0.8
 Author: mpeshev
 Author URI: http://freelancer.peshev.net
 License: GPL2

 Copyright 2011 mpeshev (email : mpeshev@devrix.com)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 2, as
 published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

class OfferCalc {
	private $adminOptionsName = "Offer Calc";
	private $version = '0.6';

	public function OfferCalc($options=NULL) {
		// constructor

		$this->addJSdeps();
		$this->addCSSdeps();
		// run plugin specific data
		$this->createDB();	
		$this->register_widget();
		$this->register_shortcode();
	}

	/**
	 * Add Javascripts required for the plugin to work
	 * Both admin and backend (could be separated in future)
	 * 
	 */
	private function addJSdeps() {
		wp_enqueue_script('jquery');
		// load custom JSes and put them in footer
		wp_register_script('offercalc', plugins_url( 'offercalc.js' , __FILE__ ), array('jquery'), '1.0', true);
		wp_enqueue_script('offercalc');
	}
	
	/**
	 * Add CSS styling for the plugin
	 * for both admin and backend 
	 *  
	 */
	private function addCSSdeps() {
		wp_register_style('offercalc', plugins_url('offercalc.css', __FILE__), array(), '1.0', 'screen');
		wp_enqueue_style('offercalc');
	}
	
	/**
	 * 
	 * Creates tables for offer calculators
	 */
	private function createDB() {
		if(get_option('ofc_version') != $this->version) {
			global $wpdb;
			
			$sql_offers = "CREATE TABLE `offercalc_offers` (
				id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(255) NOT NULL,
				slug VARCHAR(255) NOT NULL UNIQUE,
				number_fields int NOT NULL
			);";
			
			$sql_items = "CREATE TABLE `offercalc_fields` (
				id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(255) NOT NULL,
				price double NOT NULL,
				offer_slug VARCHAR(255) NOT NULL
			);";
			
			$wpdb->query($sql_offers);
			$wpdb->query($sql_items);
			$wpdb->flush();

			update_option('ofc_version', $this->version);
		}
	}
	
	/**
	 * Function for admin panel behavior
	 */
	public function add_admin() {
		add_menu_page('Offer Calc', 'Offer Calc', 'edit_themes', 'offer-calc', array(&$this, 'offercalc_list'), '', 45);		
		add_submenu_page( 'offer-calc', 'Add Offer', 'Add Offer', 'edit_themes', 'add-offer', array(&$this, 'offercalc_options'));
	}

	/**
	 * Load options in the admin
	 */
	public function offercalc_options() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		
		include_once('add_offer.php');
	}
	
	/**
	 * 
	 * Listing. 
	 */
	public function offercalc_list() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		
		include_once('offer_list.php');
	}


	/**
	 * Function registering the widget
	 */
	private function register_widget() {
			include_once('widget.php');
	}
	

	/**
	 * Function registering the shortcode via the widget
	 */
	private function register_shortcode() {	
			include_once('shortcode.php');
	}
}
$offerCalc = new OfferCalc();

add_action( 'admin_menu', array(&$offerCalc, 'add_admin') );

