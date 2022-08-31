<?php

/**
 *  Class UserDetailsAjax
 */
class UserDetailsAjax
{
    /**
     *  Construtor
     */
  public function __construct()
  {
      add_action( 'wp_enqueue_scripts', [$this,'user_details_ajax_asset' ]);
      add_action( 'wp_ajax_user_details_callback', [$this,'user_details_callback'] );
      add_action( 'wp_ajax_nopriv_user_details_callback', [$this,'user_details_callback'] );
  }

    /**
     * @return void
     * ajax asset
     */
    public function user_details_ajax_asset()
    {
        wp_enqueue_script(
          'user-details-ajax',
          CUB_BLOCKS_URL . '/assets/js/user-details-ajax.js',

          true
        );
        wp_localize_script('user-details-ajax', 'userDetailsObj', array(
          'ajax_url' => admin_url( 'admin-ajax.php' ),
          'nonce'    => wp_create_nonce('user-details-nonce')
        ));
    }

    /**
     * @return void
     * User deatails callback
     */
    public function user_details_callback()
    {

        if(!check_ajax_referer( 'user-details-nonce', 'security', false)){
            echo 'Nonce not varified';
            wp_die();
        }else{
            if (isset( $_POST['id'] )){
                $data_id = $_POST['id'];
               // $userinfo = get_userdata((int)$data_id);
                $user_meta = get_user_meta((int) $data_id );
                $user_desc = $user_meta['description'];
                if (!empty($user_desc[0])){
                    echo json_encode(array('Status'=>true, 'data'=> $user_desc));
                } else{
                    echo json_encode(array('Status'=>false, 'data'=> 'NO user details found'));
                }
                wp_die();

            }
        }


    }
}
