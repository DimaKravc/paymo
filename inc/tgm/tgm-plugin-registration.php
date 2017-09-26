<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.5.2 for parent theme Rococo for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/tgm/tgm-plugin-activation.php';

add_action('tgmpa_register', 'paymo_register_required_plugins');
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function paymo_register_required_plugins()
{
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        array(
            'name' => 'Ajaxify site',
            'slug' => 'ajaxify-site',
            'source' => 'https://github.com/DimaKravc/plugins/archive/master.zip',
            'required' => true,
            'version' => '1.0',
            'force_activation' => false,
            'force_deactivation' => false,
        ),
        array(
            'name' => 'Cyr to Lat enhanced',
            'slug' => 'cyr3lat',
            'required' => true,
        ),
        array(
            'name' => 'TinyMCE Advanced',
            'slug' => 'tinymce-advanced',
            'required' => true,
        ),
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id' => 'paymo',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'has_notices' => true,                    // Show admin notices or not.
        'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message' => '',                      // Message to output right before the plugins table.
        'strings' => array(
            'page_title' => esc_html__('Install Required Plugins', 'tgm'),
            'menu_title' => esc_html__('Install Plugins', 'tgm'),
            'installing' => esc_html__('Installing Plugin: %s', 'tgm'), // %s = plugin name.
            'oops' => esc_html__('Something went wrong with the plugin API.', 'tgm'),
            'notice_can_install_required' => wp_kses_data(_n_noop(
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'tgm'
            )), // %1$s = plugin name(s).
            'notice_can_install_recommended' => wp_kses_data(_n_noop(
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'tgm'
            )), // %1$s = plugin name(s).
            'notice_cannot_install' => wp_kses_data(_n_noop(
                'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
                'tgm'
            )), // %1$s = plugin name(s).
            'notice_ask_to_update' => wp_kses_data(_n_noop(
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                'tgm'
            )), // %1$s = plugin name(s).
            'notice_ask_to_update_maybe' => wp_kses_data(_n_noop(
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'tgm'
            )), // %1$s = plugin name(s).
            'notice_cannot_update' => wp_kses_data(_n_noop(
                'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
                'tgm'
            )), // %1$s = plugin name(s).
            'notice_can_activate_required' => wp_kses_data(_n_noop(
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'tgm'
            )), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => wp_kses_data(_n_noop(
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'tgm'
            )), // %1$s = plugin name(s).
            'notice_cannot_activate' => wp_kses_data(_n_noop(
                'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
                'tgm'
            )), // %1$s = plugin name(s).
            'install_link' => wp_kses_data(_n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'tgm'
            )),
            'update_link' => wp_kses_data(_n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'tgm'
            )),
            'activate_link' => wp_kses_data(_n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'tgm'
            )),
            'return' => esc_html__('Return to Required Plugins Installer', 'tgm'),
            'plugin_activated' => esc_html__('Plugin activated successfully.', 'tgm'),
            'activated_successfully' => esc_html__('The following plugin was activated successfully:', 'tgm'),
            'plugin_already_active' => esc_html__('No action taken. Plugin %1$s was already active.', 'tgm'),  // %1$s = plugin name(s).
            'plugin_needs_higher_version' => esc_html__('Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'tgm'),  // %1$s = plugin name(s).
            'complete' => esc_html__('All plugins installed and activated successfully. %1$s', 'tgm'), // %s = dashboard link.
            'contact_admin' => esc_html__('Please contact the administrator of this site for help.', 'tgm'),
            'nag_type' => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        ),

    );

    tgmpa($plugins, $config);
}
