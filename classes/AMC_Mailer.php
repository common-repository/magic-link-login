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

if ( !class_exists( 'AMC_Mailer' ) ) {
    class AMC_Mailer {

        /** @var \Smarty */
        private $_smarty;

        /**
         * AMC_Mailer constructor.
         * @param $smarty \Smarty
         */
        public function __construct( $smarty ) {
            $this->_smarty = $smarty;
        }

        /**
         * Sends an email with verification data to user
         * @param $user string email adress
         * @param $key string verification key
         * @param $redirect
         * @return bool
         */
        public function send_mail( $user, $key, $redirect ) {
            $user_id = AMC_Common::get_user_id_by_name( $user );
            $wp_user = get_userdata( $user_id );

            $email = $wp_user->user_email;
            $name  = $wp_user->display_name;

            $subject      = __( 'Your magic login link', 'amc-spark' );
            $subject      = apply_filters( 'amc_spark_magic_mail_subject', $subject );
            $redirect_url = parse_url( $redirect, PHP_URL_PATH );
            $link         = get_site_url( null, $redirect_url ) . '?magic-user=' . urlencode( $user ) . '&magic-key=' . $key;

            $message = $this->_generate_mail_template( [ 'name' => $name, 'link' => $link, 'site_name' => get_bloginfo( 'name' ) ] );

            $message = apply_filters( 'amc_spark_magic_mail_message', $message );

            /**
             * Fires immediately before mail is send to customer
             */
            do_action( 'amc_spark_before_send_mail' );

            return wp_mail( $email, $subject, $message, [ 'Content-Type: text/html' ] );
        }

        /**
         * Generates a template for the magic login mail
         * @param $data array
         * @return string|bool
         */
        private function _generate_mail_template( $data ) {
            $this->_smarty->assign( $data );
            try {
                return $this->_smarty->fetch( 'email/login-link.tpl' );
            } catch ( \SmartyException $e ) {
                return false;
            } catch ( \Exception $e ) {
                return false;
            }
        }

    }
}
