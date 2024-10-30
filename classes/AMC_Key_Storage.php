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

if(!class_exists('AMC_Key_Storage')) {

    class AMC_Key_Storage {

        /**
         * Stores the magic login key in user metadata
         * Also, the timestamp of issue date will be stored in user metadata
         * @param $user
         * @param $key
         */
        public function store_key( $user, $key ) {
            $user_id = AMC_Common::get_user_id_by_name( $user );
            update_user_meta( $user_id, 'amc_spark_magic_login_key', $key );
            update_user_meta( $user_id, 'amc_spark_magic_login_key_issued_at', time() );

        }

        /**
         * Loads the uuid of a specific user
         * If the key is not available or the key is expired, an empty string will be returned
         * @param $user
         * @return mixed
         */
        public function load_key( $user ) {
            $user_id    = AMC_Common::get_user_id_by_name( $user );
            $stored_key = get_user_meta( $user_id, 'amc_spark_magic_login_key', true );
            $issued_at  = get_user_meta( $user_id, 'amc_spark_magic_login_key_issued_at', true );
            $expiration = apply_filters( 'amc_spark_key_expiration_time', 600);
            if ( time() - $issued_at <= $expiration ) {
                return $stored_key;
            } else {
                return '';
            }
        }

        /**
         * Deletes the magic login key to prevent multiple usages
         * @param $user
         */
        public function remove_key( $user ) {
            $user_id = AMC_Common::get_user_id_by_name( $user );
            delete_user_meta( $user_id, 'amc_spark_magic_login_key' );
            delete_user_meta( $user_id, 'amc_spark_magic_login_key_issued_at' );
        }

    }
}
