<?php
/**
 *
 * Created by: Tim Sippel <sippel(at)amicaldo.de>
 * Date: 23.03.2018
 *
 * Copyright 2018 amicaldo GmbH.
 *
 */

namespace amc_spark;

if ( !class_exists( 'AMC_Shortcodes' ) ) {
    class AMC_Shortcodes {

        /** @var \Smarty */
        private $_smarty;

        /**
         * AMC_Shortcodes constructor.
         * @param $smarty \Smarty
         */
        public function __construct($smarty) {
            $this->_smarty = $smarty;
            add_shortcode( 'amc_spark_magic_login', [ $this, 'add_magic_login_shortcode' ] );

        }

        /**
         * Echoes a login form to enter the mail adress. Nothing will be returned, if current user is logged in.
         */
        public function add_magic_login_shortcode() {
            if(!is_user_logged_in()) {
                $this->_smarty->assign(['current_url' => get_permalink()]);
                return $this->_get_magic_login_form();
            } else {
                return '';
            }
        }

        /**
         * @return string
         */
        private function _get_magic_login_form() {
            try {
                return $this->_smarty->fetch( 'shortcodes/magic-login-form.tpl' );
            } catch ( \SmartyException $e ) {
                return false;
            } catch ( \Exception $e ) {
                return false;
            }
        }
    }
}
