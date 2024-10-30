<?php
	// Do not allow direct access to the file.
	if( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	/**
		* Plugin Name: BG Map
		* Plugin URI: https://wp-maps.com/map-of-bulgaria-wordpress-plugin/
		* Contributors: seosbg
		* Author: seosbg
		* Author URI: https://wp-maps.com/map-of-bulgaria-wordpress-plugin/
		* Description: Bulgarien map by regions. Creating an interactive map of Bulgaria. Map of Bulgaria with 28 clickable provinces. Include with shortcode and display the map on your WordPress website in any widget, post and page. Suitable for news sites, real estate sites, weather, and all types of local businesses.
		* Version: 1.1.1
		* Tags: BG Map, Interactive Map of Bulgaria, Map WordPress Plugin
		* Requires at least: 1.1.1
		* Tested up to: 6.1
		* Stable tag: 1.1.1
		* Requires PHP: 7.0
		* Text Domain: bg-map
		* License: GPLv2 or later
		* License URI: https://www.gnu.org/licenses/gpl-2.0.html 
	*/
	
	require_once plugin_dir_path( __FILE__ ) . '/include/shortcode-bg_map.php';
	
	/******************************************************
		* Create setting link
	*******************************************************/
	function bg_map_settings_link_lite($links) { 
		$settings_link = '<a href="edit.php?page=bg-map">Settings</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	}
	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", 'bg_map_settings_link_lite' );
	
	/******************************************************
		* Load translation
	*******************************************************/
	function bg_map_language_load_lite() {
		load_plugin_textdomain('bg_map_language_load_lite', FALSE, basename(dirname(__FILE__)) . '/languages');
	}
	add_action('init', 'bg_map_language_load_lite');
	
	/******************************************************
		* Admin Styles
	*******************************************************/
	function bg_map_admin_scripts_lite() { 
		wp_enqueue_style( 'bg_map-admin-css', plugin_dir_url( __FILE__ ) . '/css/admin.css' );
		wp_enqueue_script( 'bg_map-admin-js', plugin_dir_url( __FILE__ ) . '/js/admin.js', array(), '', true );
		wp_enqueue_style( 'bg_map-admin-styles-css', plugin_dir_url( __FILE__ ) . '/css/style.css' );
	}
	add_action( 'admin_enqueue_scripts', 'bg_map_admin_scripts_lite' ); 
	
	/******************************************************
        * Styles
	*******************************************************/
	add_action( 'wp_enqueue_scripts', 'bg_map_scripts_lite' ); 
	
	function bg_map_scripts_lite() { 
		wp_enqueue_style( 'bg_map-styles-css', plugin_dir_url( __FILE__ ) . '/css/style.css' );
	}
	
	add_action('admin_menu', 'bg_map_add_pages');
	
	function bg_map_add_pages() {
		add_menu_page(__('BG MAP','bg-map'), __('BG Map','bg-map'), 'manage_options', 'bg-map', 'bg_map_settings_page_lite',plugin_dir_url( __FILE__ )."/images/map.webp", '50' );
		add_action( 'admin_init', 'bg_map_register_settingphoto' );
	}	
	function bg_map_register_settingphoto() {
		for($i=1;$i<=28;$i++) {
			register_setting( 'bg-map-settings', 'link_'.$i );
		}
	}
	
	function bg_map_settings_page_lite() {
	?>
	<div id="admin-fg-bg_map">
		<form id="loading" class="dent clear" method="post" action="options.php" accept-charset="UTF-8">	
			<?php settings_fields( 'bg-map-settings' ); ?>
			<?php do_settings_sections( 'bg-map-settings' ); ?>
			
			
			<h1><?php esc_html_e( 'Карта на България', 'bg-map' ) ?></h1>		
			
			<?php submit_button('SAVE CHANGES'); ?>
			<table class="table-options" class="s-fg_bg_map-options">
				<tr>	
					<td><b id="lang_1"><?php esc_html_e( 'Поставете с кратък код картата на желаното място', 'bg-map' ) ?></b></td>
					<td><textarea id="bg_map-copy" readonly onClick="this.select();"><?php echo "[bg_map_lite]"; ?></textarea><div id="lang_2" class="button copy-shortcode" onclick="bg_mapCopy()"><?php esc_html_e( 'Копирай кода', 'bg-map' ) ?></div></td>
				</tr>
			</table>
			<table class="table-slide" class="s-fg_bg_map-num">
				<tr class="tab-color">
					<td><b id="lang_15" class="reg-title"><?php esc_html_e( 'Благоевград', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_1"  type="url" name="link_1"  value="<?php echo esc_url( get_option( 'link_1') ); ?>" /></td>	
				</tr>
				<tr class="tab-color">
					<td><b id="lang_16" class="reg-title"><?php esc_html_e( 'Бургас', 'bg-map' ) ?></b></td>	
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_2"  type="url" name="link_2"  value="<?php echo esc_url( get_option( 'link_2') ); ?>" /></td>
				</tr>	
				<tr class="tab-color">
					<td><b id="lang_17" class="reg-title"><?php esc_html_e( 'Варна', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_3"  type="url" name="link_3"  value="<?php echo esc_url( get_option( 'link_3') ); ?>" /></td>								
				</tr>
				<tr class="tab-color">
					<td><b id="lang_18" class="reg-title"><?php esc_html_e( 'Велико Търново', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_4"  type="url" name="link_4"  value="<?php echo esc_url( get_option( 'link_4') ); ?>" /></td>			
					
				</tr>	
				<tr class="tab-color">
					<td><b id="lang_19" class="reg-title"><?php esc_html_e( 'Видин', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_5"  type="url" name="link_5"  value="<?php echo esc_url( get_option( 'link_5') ); ?>" /></td>			
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_20" class="reg-title"><?php esc_html_e( 'Враца', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_6"  type="url" name="link_6"  value="<?php echo esc_url( get_option( 'link_6') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_21" class="reg-title"><?php esc_html_e( 'Габрово', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_7"  type="url" name="link_7"  value="<?php echo esc_url( get_option( 'link_7') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_22" class="reg-title"><?php esc_html_e( 'Добрич', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_8"  type="url" name="link_8"  value="<?php echo esc_url( get_option( 'link_8') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_23" class="reg-title"><?php esc_html_e( 'Кърджали', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_9"  type="url" name="link_9"  value="<?php echo esc_url( get_option( 'link_9') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_24" class="reg-title"><?php esc_html_e( 'Кюстендил', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_10"  type="url" name="link_10"  value="<?php echo esc_url( get_option( 'link_10') ); ?>" /></td>				
				</tr>
				<tr class="tab-color">
					<td><b id="lang_25" class="reg-title"><?php esc_html_e( 'Ловеч', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_11"  type="url" name="link_11"  value="<?php echo esc_url( get_option( 'link_11') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_26" class="reg-title"><?php esc_html_e( 'Монтана', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_12"  type="url" name="link_12"  value="<?php echo esc_url( get_option( 'link_12') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_27" class="reg-title"><?php esc_html_e( 'Пазарджик', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_13"  type="url" name="link_13"  value="<?php echo esc_url( get_option( 'link_13') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_28" class="reg-title"><?php esc_html_e( 'Перник', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_14"  type="url" name="link_14"  value="<?php echo esc_url( get_option( 'link_14') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_29" class="reg-title"><?php esc_html_e( 'Плевен', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_15"  type="url" name="link_15"  value="<?php echo esc_url( get_option( 'link_15') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_30" class="reg-title"><?php esc_html_e( 'Пловдив', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_16"  type="url" name="link_16"  value="<?php echo esc_url( get_option( 'link_16') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_31" class="reg-title"><?php esc_html_e( 'Разград', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_17"  type="url" name="link_17"  value="<?php echo esc_url( get_option( 'link_17') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_32" class="reg-title"><?php esc_html_e( 'Русе', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_18"  type="url" name="link_18"  value="<?php echo esc_url( get_option( 'link_18') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_33" class="reg-title"><?php esc_html_e( 'Силистра', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_19"  type="url" name="link_19"  value="<?php echo esc_url( get_option( 'link_19') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_34" class="reg-title"><?php esc_html_e( 'Сливен', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_20"  type="url" name="link_20"  value="<?php echo esc_url( get_option( 'link_20') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_35" class="reg-title"><?php esc_html_e( 'Смолян', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_21"  type="url" name="link_21"  value="<?php echo esc_url( get_option( 'link_21') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_36" class="reg-title"><?php esc_html_e( 'София', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_23"  type="url" name="link_23"  value="<?php echo esc_url( get_option( 'link_23') ); ?>" /></td>				
				</tr>
				<tr class="tab-color">
					<td><b id="lang_37" class="reg-title"><?php esc_html_e( 'София-област', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_22"  type="url" name="link_22"  value="<?php echo esc_url( get_option( 'link_22') ); ?>" /></td>				
					
				</tr>
				<tr class="tab-color">
					<td><b id="lang_38" class="reg-title"><?php esc_html_e( 'Стара Загора', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_24"  type="url" name="link_24"  value="<?php echo esc_url( get_option( 'link_24') ); ?>" /></td>				
					
				</tr>		
				<tr class="tab-color">
					<td><b id="lang_39" class="reg-title"><?php esc_html_e( 'Търговище', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_25"  type="url" name="link_25"  value="<?php echo esc_url( get_option( 'link_25') ); ?>" /></td>				
					
				</tr>	
				<tr class="tab-color">
					<td><b id="lang_40" class="reg-title"><?php esc_html_e( 'Хасково', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_26"  type="url" name="link_26"  value="<?php echo esc_url( get_option( 'link_26') ); ?>" /></td>				
					
				</tr>	
				<tr class="tab-color">
					<td><b id="lang_41" class="reg-title"><?php esc_html_e( 'Шумен', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_27"  type="url" name="link_27"  value="<?php echo esc_url( get_option( 'link_27') ); ?>" /></td>				
					
				</tr>	
				<tr class="tab-color">
					<td><b id="lang_42" class="reg-title"><?php esc_html_e( 'Ямбол', 'bg-map' ) ?></b></td>
					<td><?php esc_html_e( 'URL','bg-map' ); ?> <input id="link_28"  type="url" name="link_28"  value="<?php echo esc_url( get_option( 'link_28') ); ?>" /></td>
				</tr>
			</table>
			<div class="pro">
				<a target="_blank" href="https://wp-maps.com/интерактивна-карта-на-българия-за-wordpress/"><h2><?php esc_html_e( 'PREVIEW PRO', 'bg-map' ) ?></h2></a>
				<table class="pro-feature">
					<tr class="tab-color">
						<td><b><?php esc_html_e( 'Option', 'bg-map' ) ?></b></td>
						<td><b><?php esc_html_e( 'Free Version', 'bg-map' ) ?></b></td>
						<td><b><?php esc_html_e( 'Premium Version', 'bg-map' ) ?></b></td>
					</tr>				
					<tr class="tab-color">
						<td><b><?php esc_html_e( 'Multiple Maps', 'bg-map' ) ?></b></td>
						<td><b><span class="dashicons dashicons-dismiss"></span></b></td>
						<td><b><span class="dashicons dashicons-yes-alt"></span></b></td>
					</tr>			
					<tr class="tab-color">
						<td><b><?php esc_html_e( 'Provinces Title', 'bg-map' ) ?></b></td>
						<td><b><span class="dashicons dashicons-dismiss"></span></b></td>
						<td><b><span class="dashicons dashicons-yes-alt"></span></b></td>
					</tr>				
					<tr class="tab-color">
						<td><b><?php esc_html_e( 'Meteorology', 'bg-map' ) ?></b></td>
						<td><b><span class="dashicons dashicons-dismiss"></span></b></td>
						<td><b><span class="dashicons dashicons-yes-alt"></span></b></td>
					</tr>
					<tr class="tab-color">
						<td><b><?php esc_html_e( 'Map Colors', 'bg-map' ) ?></b></td>
						<td><b><span class="dashicons dashicons-dismiss"></span></b></td>
						<td><b><span class="dashicons dashicons-yes-alt"></span></b></td>
					</tr>
					<tr class="tab-color">
						<td><b><?php esc_html_e( 'Map Info Icons', 'bg-map' ) ?></b></td>
						<td><b><span class="dashicons dashicons-dismiss"></span></b></td>
						<td><b><span class="dashicons dashicons-yes-alt"></span></b></td>
					</tr>
					<tr class="tab-color">
						<td><b><?php esc_html_e( 'Map Statistics', 'bg-map' ) ?></b></td>
						<td><b><span class="dashicons dashicons-dismiss"></span></b></td>
						<td><b><span class="dashicons dashicons-yes-alt"></span></b></td>
					</tr>
					<tr class="tab-color">
						<td><b><?php esc_html_e( 'Map Graphics', 'bg-map' ) ?></b></td>
						<td><b><span class="dashicons dashicons-dismiss"></span></b></td>
						<td><b><span class="dashicons dashicons-yes-alt"></span></b></td>
					</tr>	
					<tr class="tab-color">
						<td><b><?php esc_html_e( 'Provinces Links', 'bg-map' ) ?></b></td>
						<td><b><span class="dashicons dashicons-yes-alt"></span></b></td>
						<td><b><span class="dashicons dashicons-yes-alt"></span></b></td>
					</tr>
					
				</table>
			</div>				
		</form>
	</div>
	<?php
	}
	function bg_map_register_my_setting_lite() { ?>
	<style>
		#toplevel_page_bg-map img {
		height:20px
		}
	</style>
	<?php
	}
add_action( 'admin_head', 'bg_map_register_my_setting_lite' );