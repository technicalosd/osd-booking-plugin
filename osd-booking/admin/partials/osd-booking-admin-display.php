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
    <div class="card" style="max-width: 960px; padding: 20px; margin-top: 20px;">
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

        <!-- ── Resizable Preview ──────────────────────────────────── -->
        <h3 style="margin-top: 20px;">Preview</h3>

        <div style="margin-bottom: 8px; display: flex; align-items: center; gap: 12px;">
            <label for="osd-preview-width-slider" style="font-size: 0.85em; white-space: nowrap;">
                Preview width:
            </label>
            <input
                    type="range"
                    id="osd-preview-width-slider"
                    min="280"
                    max="900"
                    value="900"
                    step="10"
                    style="flex: 1; max-width: 340px; cursor: pointer;"
            >
            <span id="osd-preview-width-label" style="font-size: 0.85em; min-width: 52px; color: #555;">
                900px
            </span>

            <!-- Quick-pick breakpoint buttons -->
            <button type="button" class="button button-small osd-bp-btn" data-width="360"  title="Mobile (360px)">📱 360</button>
            <button type="button" class="button button-small osd-bp-btn" data-width="560"  title="Mobile breakpoint (560px)">560</button>
            <button type="button" class="button button-small osd-bp-btn" data-width="720"  title="Tablet breakpoint (720px)">720</button>
            <button type="button" class="button button-small osd-bp-btn" data-width="900"  title="Full width (900px)">↔ Full</button>
        </div>

        <!-- Outer wrapper constrains width; inner wrapper clips overflow cleanly -->
        <div id="osd-preview-outer" style="width: 100%; overflow: hidden; border: 1px solid #ddd; border-radius: 4px; background: #fff;">
            <div id="osd-preview-inner" style="width: 900px; padding: 20px; transition: width 0.2s ease;">
                <?php echo do_shortcode( '[osd_event_listing]' ); ?>
            </div>
        </div>

        <script>
            ( function () {
                var slider   = document.getElementById( 'osd-preview-width-slider' );
                var label    = document.getElementById( 'osd-preview-width-label' );
                var inner    = document.getElementById( 'osd-preview-inner' );
                var outer    = document.getElementById( 'osd-preview-outer' );
                var bpBtns   = document.querySelectorAll( '.osd-bp-btn' );

                function setWidth( px ) {
                    var maxPx   = outer.offsetWidth;
                    var clamped = Math.min( Math.max( parseInt( px, 10 ), 280 ), maxPx );
                    inner.style.width  = clamped + 'px';
                    label.textContent  = clamped + 'px';
                    slider.value       = clamped;
                }

                // Keep slider max in sync if the admin panel is resized
                function syncSliderMax() {
                    var maxPx = outer.offsetWidth;
                    slider.max = maxPx;
                }

                slider.addEventListener( 'input', function () {
                    setWidth( this.value );
                } );

                bpBtns.forEach( function ( btn ) {
                    btn.addEventListener( 'click', function () {
                        setWidth( this.dataset.width );
                    } );
                } );

                window.addEventListener( 'resize', function () {
                    syncSliderMax();
                    // If inner is wider than outer after a window shrink, clamp it
                    if ( parseInt( inner.style.width, 10 ) > outer.offsetWidth ) {
                        setWidth( outer.offsetWidth );
                    }
                } );

                syncSliderMax();
            } )();
        </script>
    </div>

    <!-- ── Upcoming Cards ────────────────────────────────────────── -->
    <div class="card" style="max-width: 1200px; padding: 20px; margin-top: 20px;">
        <h2>Upcoming Cards</h2>
        <p>Use the following shortcode to display a responsive grid of upcoming event cards on any page or post:</p>
        <code style="font-size: 1.2em; padding: 8px 12px; background: #f0f0f0; display: inline-block; border-radius: 4px; margin-bottom: 20px;">
            [osd_upcoming_cards]
        </code>
        <p>
            Events are defined in <code>shortcodes/osd-upcoming-cards.php</code>.<br>
            Each record requires: <code>image</code>, <code>img_width</code>, <code>img_height</code>,
            <code>img_srcset</code>, <code>img_sizes</code>, <code>img_class</code>,
            <code>date_month</code>, <code>date_day</code>, <code>title</code>, <code>cta_url</code>.
        </p>
        <p style="margin-bottom: 20px;">
            Grid breakpoints: <strong>4 col</strong> ≥ 1100px &nbsp;·&nbsp;
            <strong>3 col</strong> ≤ 1100px &nbsp;·&nbsp;
            <strong>2 col</strong> ≤ 768px &nbsp;·&nbsp;
            <strong>2 col</strong> ≤ 480px &nbsp;·&nbsp;
            <strong>2 col</strong> ≤ 360px
        </p>

        <h3>Preview</h3>

        <div style="margin-bottom: 8px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <label for="osd-uc-width-slider" style="font-size: 0.85em; white-space: nowrap;">
                Preview width:
            </label>
            <input
                    type="range"
                    id="osd-uc-width-slider"
                    min="280"
                    max="1160"
                    value="1160"
                    step="10"
                    style="flex: 1; max-width: 340px; cursor: pointer;"
            >
            <span id="osd-uc-width-label" style="font-size: 0.85em; min-width: 52px; color: #555;">
                1160px
            </span>

            <!-- Quick-pick breakpoint buttons matching grid @media rules -->
            <button type="button" class="button button-small osd-uc-bp-btn" data-width="360"  title="Mobile (360px)">📱 360</button>
            <button type="button" class="button button-small osd-uc-bp-btn" data-width="480"  title="1-col breakpoint (480px)">480</button>
            <button type="button" class="button button-small osd-uc-bp-btn" data-width="768"  title="2-col breakpoint (768px)">768</button>
            <button type="button" class="button button-small osd-uc-bp-btn" data-width="1100" title="3-col breakpoint (1100px)">1100</button>
            <button type="button" class="button button-small osd-uc-bp-btn" data-width="full" title="Full width">↔ Full</button>
        </div>

        <!-- Outer wrapper clips; inner drives the rendered width -->
        <div id="osd-uc-preview-outer" style="width: 100%; overflow: hidden; border: 1px solid #ddd; border-radius: 4px; background: #f0f3f7;">
            <div id="osd-uc-preview-inner" style="width: 100%; padding: 20px; box-sizing: border-box; transition: width 0.2s ease;">
                <?php echo do_shortcode( '[osd_upcoming_cards]' ); ?>
            </div>
        </div>

        <script>
            ( function () {
                var slider  = document.getElementById( 'osd-uc-width-slider' );
                var label   = document.getElementById( 'osd-uc-width-label' );
                var inner   = document.getElementById( 'osd-uc-preview-inner' );
                var outer   = document.getElementById( 'osd-uc-preview-outer' );
                var bpBtns  = document.querySelectorAll( '.osd-uc-bp-btn' );

                function setWidth( val ) {
                    var maxPx = outer.offsetWidth;
                    var px    = ( val === 'full' )
                        ? maxPx
                        : Math.min( Math.max( parseInt( val, 10 ), 280 ), maxPx );
                    inner.style.width = px + 'px';
                    label.textContent = px + 'px';
                    slider.value      = px;
                }

                function syncSliderMax() {
                    slider.max = outer.offsetWidth;
                }

                slider.addEventListener( 'input', function () {
                    setWidth( this.value );
                } );

                bpBtns.forEach( function ( btn ) {
                    btn.addEventListener( 'click', function () {
                        setWidth( this.dataset.width );
                    } );
                } );

                window.addEventListener( 'resize', function () {
                    syncSliderMax();
                    if ( parseInt( inner.style.width, 10 ) > outer.offsetWidth ) {
                        setWidth( outer.offsetWidth );
                    }
                } );

                syncSliderMax();
                setWidth( 'full' );
            } )();
        </script>
    </div>

</div>