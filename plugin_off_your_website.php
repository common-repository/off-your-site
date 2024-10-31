<?php
/**
* Plugin Name: [Enqtran] Off Your Site
* Plugin URI: http://enqtran.com/
* Description: Off your website front-end width client
* Author: enqtran
* Version: 1.0
* Author URI: http://enqtran.com/
* Donate link: http://enqtran.com/
* License: GPLv3 or later
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Tags: enqtran, enq, enqpro, status , off your site
*/

/*
* Plugin status
* Last update: 17/11/2015
*/

add_action( 'admin_menu', 'register_plugins_status_page' );
function register_plugins_status_page() {
    add_menu_page( 'status option', 'Off Your Site', 'manage_options', 'status-option', 'status_setting_page', 'dashicons-megaphone' /*get_template_directory_uri().'/images/options.png'*/,150 );
    // add_theme_page( 'status option', 'Status Option', 'manage_options', 'status-option', 'status_setting_page' );
}

add_action( 'admin_init' , 'plugin_register_page' );
function plugin_register_page() {
    //Turn Off Website Maintenance
    register_setting( 'status-group' , 'turn_off_web' );
    register_setting( 'status-group' , 'noti_maintenance' );
    register_setting( 'status-group' , 'custom_maintenance' );
}

function status_setting_page() { ?>
    <div class="wrap">
        <?php echo get_screen_icon(); ?>
        <div>
            <h1>Off Your Site</h1>
        </div>
        <div class="box-form-option">
            <form action="options.php" method="post" id="theme_setting">
            <?php settings_fields( 'status-group' ); ?>
            <?php submit_button( 'Save Changes','primary' ); ?>
            <style>
                .fix-width {
                    width:150px;
                }
                .pad {
                    padding:10px 20px;
                }
            </style>

            <!-- Maintenance -->
            <h2> Maintenance </h2>
            <table class="theme_page widefat" >
                <tr>
                    <th class="fix-width">Turn Off Website</th>
                    <td>
                        <input type="checkbox" name="turn_off_web" <?php checked( get_option( 'turn_off_web' ), 'on');?> /> Maintenance width Client
                    </td>
                </tr>
                <tr>
                    <th class="fix-width">Noti Maintenance</th>
                    <td>
                        <input class="widefat pad" type="text" name="noti_maintenance"
                    value="<?php echo get_option( 'noti_maintenance' ); ?>" placeholder="Content ....">
                    </td>
                </tr>
                <tr>
                    <th class="fix-width">Custom (html/css/iframes/js)</th>
                    <td>
                        <textarea class="widefat pad" name="custom_maintenance" placeholder=""><?php echo get_option( 'custom_maintenance' ); ?>
                        </textarea>
                    </td>
                </tr>
            </table>
            <?php submit_button( 'Save Changes','primary' ); ?>
        </form>
        </div>
    </div>
<?php }

/**
* Turn off website
*/
if ( get_option( 'turn_off_web' ) == 'on' ) {
    add_action('get_header', 'enq_maintenance');
	function enq_maintenance()
	{
	    if ( !current_user_can('edit_themes') || !is_user_logged_in() ) {
	    	if ( get_option( 'noti_maintenance' ) != '' ) {
	    		$noti_main = get_option( 'noti_maintenance' );
	    	} else {
	    		$noti_main = 'The site temporarily being maintenance !';
	    	}
	        wp_die('<h1 style="text-align:center;">'.$noti_main.'</h1><br><div style="text-align:center;">'.get_option( 'custom_maintenance' ).'</div>');
	    }
	}
}
