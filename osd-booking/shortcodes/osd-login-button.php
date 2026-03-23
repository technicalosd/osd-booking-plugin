<?php
/**
 * Shortcode: [osd_booking_login_button]
 * Outputs a styled login button.
 *
 * Attributes:
 *   url  - The URL the login button links to. Defaults to '#' if not specified.
 *
 * Usage:
 *   [osd_booking_login_button]
 *   [osd_booking_login_button url="https://ict.osd.ie/login"]
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_shortcode( 'osd_booking_login_button', 'osd_booking_login_button_shortcode' );

function osd_booking_login_button_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'url' => '#',
        ),
        $atts,
        'osd_booking_login_button'
    );

    $url = esc_url( $atts['url'] );

    return '<a href="' . $url . '" class="ict-login-btn">Login</a>
<style>
.ict-login-btn {
  display: inline-block;
  padding: 12px 24px;
  background-color: #71BC63;
  color: #011F3D;
  font-family: \'Inter\', sans-serif;
  font-size: 19px;
  font-weight: 500;
  text-decoration: none;
  text-transform: none;
  letter-spacing: 0px;
  border: 2px solid #ffffff;
  border-radius: 100px;
  transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
  cursor: pointer;
  line-height: 1;
}
.ict-login-btn:hover {
  background-color: #71BC63;
  color: #011F3D;
}
</style>';

}