<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

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



</div>