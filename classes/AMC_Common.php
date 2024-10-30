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

if ( !class_exists( 'AMC_Common' ) ) {
    class AMC_Common {

        /**
         * Checks, if a given user is existing
         * @param $user string email
         * @return bool
         */
        public static function verify_user( $user ) {
            return email_exists( $user );
        }

        /**
         * Generates a cryptographic secure random UUID version 4
         * @return string UUIDv4
         */
        public static function generate_key() {
            return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                            random_int( 0, 0xffff ), random_int( 0, 0xffff ),
                            random_int( 0, 0xffff ),
                            random_int( 0, 0x0fff ) | 0x4000,
                            random_int( 0, 0x3fff ) | 0x8000,
                            random_int( 0, 0xffff ), random_int( 0, 0xffff ), random_int( 0, 0xffff )
            );
        }

        /**
         * Loads the user id for a given username
         * @param $user
         * @return int
         */
        public static function get_user_id_by_name( $user ) {
            return get_user_by( 'email', $user )->ID;
        }
    }
}
