<?php
/**
 * Plugin name: Custom Users List block
 * Author: Ibrahim khalil
 * Author Url:
 * Description: Wordpress Test Project
 * Version: 1.0.0
 * Text Domain: custom-users-block
 *
 * @package custom-users-block
 */


defined('ABSPATH') || exit;

define('CUB_BLOCKS_PATH', untrailingslashit(plugin_dir_path(__FILE__)));
define('CUB_BLOCKS_URL', untrailingslashit(plugin_dir_url(__FILE__)));
// Require the user details class
require_once CUB_BLOCKS_PATH . '/inc/UserDetailsAjax.php';

/**
 * Class CustomUsersBlockRegister
 */
class  CustomUsersBlockRegister
{
    public $userDetailsAjax;
    /**
     * Custom_Users_Block_Register constructor.
     */
    public function __construct()
    {
        add_action('init', [$this, 'custom_users_resgiter_block']);
        add_action('enqueue_block_assets', [$this, 'custom_users_block_enqueue_editor_assets']);
        add_shortcode('culb_shortcode', [$this, 'user_list_shortcode']);
        //initialize the user details class
        $this->userDetailsAjax = new UserDetailsAjax();

    }

    /**
     * @return void
     * block assets
     */
    public function custom_users_block_enqueue_editor_assets(){
        // Block Editor Script.
        if ( is_admin() ) {
            wp_enqueue_script(
              'users-block-editor-js',
              CUB_BLOCKS_URL . '/assets/js/custom-users-block.js',
              array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
              true
            );
        }

        wp_enqueue_style(
          'users-list-shortcode',
          CUB_BLOCKS_URL . '/assets/css/shortcode.css',
        );
    }
    /**
     * Register block
     */
    public function custom_users_resgiter_block()
    {
        register_block_type(
          'custom-block/custom-users-list-block',
          array(
				'style'         => 'users-list-shortcode',
//				'editor_style'  => 'gtbw-block-editor-styles',
            'editor_script' => 'users-block-editor-js',
            'render_callback' => [$this, 'cub_show_user_data'],
            'attributes' => array(
              'userId' => array(
                'type' => 'init',
              ),
              'email' => array(
                'type' => 'string',
              ),
              'options' => array(
                'type' => 'array',
              ),
              'emailFilter' => array(
                'type' => 'string',
                'default' => '@orangetoolz.com',
              ),
            )
          )
        );

    }

    /**
     * @param $attributes
     * @param $content
     * @return string
     */
    public function cub_show_user_data($attributes, $content)
    {
        $content = '';
        $atts = $attributes['userId'];
        if ( is_user_logged_in() ){
            if (  0 !== (int) $atts ) {
                $content .= $this->user_list_shortcode($atts);
            }else{
                return 'Please select user';
            }
        }


        return $content;
    }

    /**
     * @param $atts
     * @param $content
     * @return string
     */
    public function user_list_shortcode($atts, $content = null)
    {

        $content = '<ul class="user-lists">';
            foreach ($atts as $user) {
                $userinfo = get_userdata((int)$user);
                $user_name = $userinfo->display_name;
                $avatar = get_avatar_url($user, ['size' => '60']);
                $email = $userinfo->user_email;
                $content .= "<li> ";
                $content .= "<div class='user-image'> <img src='" . $avatar . "'></div>";
                $content .= "<div class='user-name'> $user_name</div>";
                $content .= "<div class='user-email'> $email</div>";
                $content .= "<button type='button' data-details='" . $user . "' class='user-bio'> load user’s biography</button>";
                $content .= "</li>";

            }

        $content .= "</ul>";
        return $content;
    }
}

/**
 * Initial the class
 */
new CustomUsersBlockRegister();
