<?php

/**
 * Get Status Meta
 *
 * @param string $status_key
 * @return array Status
 */

use Illuminate\Support\Facades\DB;

const RPCAddressRootAdmin = "195.85.19.218:20020";
const RPCAddressGlobalData = "195.85.19.218:20010";

function get_status_meta( $status_key = '' ) {
    $metas = [
        'active'   => [
            'label' => 'Active',
            'class' => 'success',
        ],
        'inactive' => [
            'label' => 'Inactive',
            'class' => 'warning',
        ],
        'blocked'  => [
            'label' => 'Blocked',
            'class' => 'danger',
        ],
    ];

    if ( empty( $status_key ) ) {
        return $metas;
    }

    if ( in_array( $status_key, array_keys( $metas ) ) ) {
        return $metas[ $status_key ];
    }

    return [];
}

function validatePassword(string $email, string $password) {
    $res = DB::select('SELECT id, phone, nama, password FROM mt_user_reseller WHERE is_active = true and email = "' . $email . '"');

}

/**
 * Get Status Class
 *
 * @param string $status_key
 * @return string Status Class
 */
function get_status_class( $status_key = '' ) {

    $status_meta = get_status_meta( $status_key );

    if ( empty( $status_meta['class'] ) ) {
        return '';
    }

    return $status_meta['class'];
}

/**
 * Get Status label
 *
 * @param string $status_key
 * @return string Status label
 */
function get_status_label( $status_key = '' ) {
    $status_meta = get_status_meta( $status_key );

    if ( empty( $status_meta['label'] ) ) {
        return '';
    }

    return $status_meta['label'];
}
