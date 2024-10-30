<?php
/**
 *
 * Created by: Tim Sippel <sippel(at)amicaldo.de>
 * Date: 28.03.2018
 *
 * Copyright 2018 amicaldo GmbH.
 *
 */

namespace amc_spark;


if ( !class_exists( 'AMC_Login_Form' ) ) {
    class AMC_Login_Form {

        /** @var \Smarty */
        private $_smarty;

        /** @var string */
        private $_plugin_url;

        /**
         * AMC_Login_Form constructor.
         * @param $smarty \Smarty
         * @param $plugin_url
         */
        public function __construct( $smarty, $plugin_url ) {
            $this->_smarty     = $smarty;
            $this->_plugin_url = $plugin_url;

            add_action( 'login_form', [ $this, 'add_button_to_wp_login' ] );
            add_action( 'login_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        }

        /**
         * Enqueue custom login css
         */
        public function enqueue_styles() {
            wp_enqueue_style( 'amc-spark-login', $this->_plugin_url . 'css/login.css' );
            wp_enqueue_script( 'amc-spark-login', $this->_plugin_url . 'js/login.js' );

        }

        /**
         * Echos a custom login with magic link button to default wp-login.php
         */
        public function add_button_to_wp_login() {
            ?>
            <p style="text-align: center" class="amc-magic-login-button">
                <a href="#"><?= __( 'Magic Login', 'amc-spark' ) ?></a>
            </p>
            <p style="display:none;" id="amc-spark-mail-input-wrapper">
                <label for="amc-spark-mail-input"><?=__('your email address', 'amc-spark')?></label>
                <input type="email" name="amc-spark-mail-input" id="amc-spark-mail-input" class="input">
            </p>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var loginform = document.querySelector('#loginform,#front-login-form'),
                        magicWrapper = document.querySelector('#amc-spark-mail-input-wrapper'),
                        magicLoginLink = document.querySelector('p.amc-magic-login-button');

                    var seperator = document.createElement('h3');
                    seperator.className += " amc-spark-or";
                    seperator.innerText = "<?= __( 'or', 'amc-spark' ) ?>";
                    loginform.prepend(magicWrapper);
                    loginform.prepend(seperator);
                    loginform.prepend(magicLoginLink);
                });

            </script>
            <?php
        }
    }
}
