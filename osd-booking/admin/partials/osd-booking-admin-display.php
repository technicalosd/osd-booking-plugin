<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <p>Shortcodes that can bs used to implement booking processes on pages.</p>

    <!-- ── Login Button ──────────────────────────────────────────── -->
    <div class="card" style="max-width: 600px; padding: 20px; margin-top: 20px;">
        <h2>Login Button</h2>
        <p>Use the following shortcode to display the booking login button on any page or post:</p>
        <code style="font-size: 1.2em; padding: 8px 12px; background: #f0f0f0; display: inline-block; border-radius: 4px; margin-bottom: 20px;">
            [osd_booking_login_button]<br>
            [osd_booking_login_button url="https://ict.osd.ie/login"]
        </code>
        <h3>Preview</h3>
        <div style="padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 4px;">
            <?php echo do_shortcode( '[osd_booking_login_button]' ); ?><br>
            <?php echo do_shortcode( '[osd_booking_login_button url="https://ict.osd.ie/login"]' ); ?>
        </div>
    </div>

    <!-- ── Search Field ──────────────────────────────────────────── -->
    <div class="card" style="max-width: 600px; padding: 20px; margin-top: 20px;">
        <h2>Search Field</h2>
        <p>Use the following shortcode to display the search field on any page or post:</p>
        <code style="font-size: 1.2em; padding: 8px 12px; background: #f0f0f0; display: inline-block; border-radius: 4px; margin-bottom: 20px;">
            [osd_search_box]<br>
            [osd_search_box placeholder="Search for a bus..." action="/concert-list/"]
        </code>
        <h3>Preview</h3>
        <div style="padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 4px;">
            <?php echo do_shortcode( '[osd_search_box]' ); ?><br>
            <?php echo do_shortcode( '[osd_search_box placeholder="Search for a bus..." action="/concert-list/"]' ); ?>
        </div>
    </div>

    <!-- ── Event Listing ─────────────────────────────────────────── -->
    <div class="card" style="max-width: 600px; padding: 20px; margin-top: 20px;">
        <h2>Event Listing</h2>
        <p>Use the following shortcode to display the event listing table on any page or post:</p>
        <code style="font-size: 1.2em; padding: 8px 12px; background: #f0f0f0; display: inline-block; border-radius: 4px; margin-bottom: 20px;">
            [osd_event_listing]
        </code>
        <p>
            Events are defined in <code>shortcodes/osd-event-listing.php</code>.<br>
            To supply events programmatically, use the <code>osd_booking_events</code> filter:
        </p>
        <pre style="background:#f0f0f0; padding: 12px; border-radius:4px; font-size:0.85em; overflow-x:auto;">
add_filter( 'osd_booking_events', function( $events ) {
    // Return your own array of event arrays here.
    return $events;
} );</pre>
        <h3>Preview</h3>
        <div style="padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 4px;">
            <?php echo do_shortcode( '[osd_event_listing]' ); ?>
        </div>
    </div>


</div>