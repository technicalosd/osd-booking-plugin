<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class OSD_Booking {

    protected $plugin_name = 'osd-booking';
    protected $version;

    public function __construct() {
        $this->version = OSD_BOOKING_VERSION;
    }

    public function run() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_assets' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
    }

    public function enqueue_public_assets() {
        wp_enqueue_style(
            $this->plugin_name,
            OSD_BOOKING_PLUGIN_URL . 'public/css/osd-booking-public.css',
            array(),
            $this->version
        );
        wp_enqueue_script(
            $this->plugin_name,
            OSD_BOOKING_PLUGIN_URL . 'public/js/osd-booking-public.js',
            array( 'jquery' ),
            $this->version,
            true
        );
    }

    public function enqueue_admin_assets() {
        wp_enqueue_style(
            $this->plugin_name . '-admin',
            OSD_BOOKING_PLUGIN_URL . 'admin/css/osd-booking-admin.css',
            array(),
            $this->version
        );
        wp_enqueue_script(
            $this->plugin_name . '-admin',
            OSD_BOOKING_PLUGIN_URL . 'admin/js/osd-booking-admin.js',
            array( 'jquery' ),
            $this->version,
            true
        );
    }
}