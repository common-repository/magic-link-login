<?php
/**
 *
 * Created by: Tim Sippel <sippel(at)amicaldo.de>
 * Date: 21.03.2018
 *
 * Copyright 2018 amicaldo GmbH.
 *
 */

namespace amc_spark;

if ( !class_exists( 'AMC_Main' ) ) {

    class AMC_Main {

        /** @var AMC_Installer */
        private $_installer;

        /** @var AMC_Key_Storage */
        private $_key_storage;

        /** @var AMC_Shortcodes */
        private $_shortcodes;

        /** @var AMC_Mailer */
        private $_mailer;

        /** @var AMC_Login_Form */
        private $_login_form;

        /** @var \Smarty */
        private $_smarty;

        /** @var string */
        private $_plugin_path;

        /** @var string */
        private $_plugin_url;

        /**
         * AMC_Main constructor.
         * @param $plugin_path
         * @param $plugin_url
         */
        public function __construct( $plugin_path, $plugin_url ) {

            require_once $plugin_path . 'vendor/autoload.php';

            $this->_plugin_path = $plugin_path;
            $this->_plugin_url  = $plugin_url;
            $this->bootstrap();
        }

        /**
         * Bootstraps the plugin
         */
        public function bootstrap() {

            $this->_smarty      = $this->_init_smarty();
            $this->_installer   = new AMC_Installer();
            $this->_key_storage = new AMC_Key_Storage();
            $this->_shortcodes  = new AMC_Shortcodes( $this->_smarty );
            // Disabled to prevent plugin from showing a not finished yet feature
            // $this->_login_form  = new AMC_Login_Form( $this->_smarty, $this->_plugin_url );
            $this->_mailer = new AMC_Mailer( $this->_smarty );

            add_action( 'wp_ajax_nopriv_amc_send_magic_mail', [ $this, 'send_link' ] );

            add_action( 'plugins_loaded', [ $this, 'maybe_login_user_with_link' ], 5 );
        }

        /**
         * Called, when a user asks for a login link
         */
        public function send_link() {
            if ( !empty( $_REQUEST[ 'user' ] ) ) {
                $user = $_REQUEST[ 'user' ];
                if ( AMC_Common::verify_user( $user ) ) {
                    $key = AMC_Common::generate_key();
                    $this->_key_storage->store_key( $user, $key );
                    $redirect = $_REQUEST[ 'magic-redirect' ];
                    if ( $this->_mailer->send_mail( $user, $key, $redirect ) ) {
                        wp_send_json_success( __( 'The link was sent successfully.', 'amc-spark' ) );
                    }
                }
            }
            wp_send_json_error( __( 'The link could not be sent.', 'amc-spark' ) );
        }

        /**
         * Called, when user tries to access site with login link
         */
        public function maybe_login_user_with_link() {
            if ( !empty( $_REQUEST[ 'magic-key' ] ) && !empty( $_REQUEST[ 'magic-user' ] ) ) {
                $user       = urldecode( $_REQUEST[ 'magic-user' ] );
                $key        = $_REQUEST[ 'magic-key' ];
                $stored_key = $this->_key_storage->load_key( $user );
                if ( $key == $stored_key ) {
                    do_action( 'amc_spark_before_login_user' );
                    wp_set_auth_cookie( AMC_Common::get_user_id_by_name( $user ) );
                    $this->_key_storage->remove_key( $user );
                    do_action( 'amc_spark_after_login_user' );
                    add_action( 'init', [ $this, 'maybe_redirect' ] );
                }
            }
        }

        /**
         * Redirects to front page
         */
        public function maybe_redirect() {
            $location = explode( '?', $_SERVER[ 'REQUEST_URI' ] );
            header( 'Location: ' . get_site_url() . $location[0] );
        }

        /**
         * Initializes smarty template engine
         * @return \Smarty
         */
        private function _init_smarty() {
            $smarty = new \Smarty();
            $smarty->setTemplateDir( $this->_plugin_path . '/templates' );
            $smarty->setCompileDir( $this->_plugin_path . '/templates_c' );
            $smarty->setCacheDir( $this->_plugin_path . '/cache' );

            return $smarty;
        }
    }
}