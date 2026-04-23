<?php
/**
 * Shortcode: [osd_event_listing]
 *
 * Renders a responsive event listing table from a $events array.
 *
 * Usage:
 *   [osd_event_listing]
 *
 * The $events data is passed via the filter 'osd_booking_events' so other
 * plugins/themes can supply or override the list without editing this file.
 *
 * Each event array shape:
 *   [
 *     'event_name'    => string,        // Display name
 *     'dates'         => string[],      // One or more dates as 'YYYY-MM-DD'
 *     'more_info_url' => string,        // URL for More Info button
 *     'book_now_url'  => string,        // URL for Book Now button
 *   ]
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_shortcode( 'osd_event_listing', 'osd_event_listing_shortcode' );

/**
 * Shortcode callback.
 *
 * @return string  HTML output.
 */
function osd_event_listing_shortcode(): string {

    // ── Data ────────────────────────────────────────────────────────────
    // Define your events here, or supply them via the filter below.
    $events = [
            [
                    'event_name'    => 'Bus to - Ewan McVicar – 3Arena',
                    'dates'         => [ '2026-06-30', '2026-07-01' ],
                    'more_info_url' => '#',
                    'book_now_url'  => '#',
            ],
            [
                    'event_name'    => 'Bus to - Tyler Childers – 3Arena',
                    'dates'         => [ '2026-07-30' ],
                    'more_info_url' => '#',
                    'book_now_url'  => '#',
            ],
            [
                    'event_name'    => 'Bus to - Laufey – 3Arena',
                    'dates'         => [ '2026-08-30' ],
                    'more_info_url' => '#',
                    'book_now_url'  => '#',
            ],
    ];

    /**
     * Filter: osd_booking_events
     *
     * Allows themes or other plugins to modify or replace the events list.
     *
     * @param array $events  Default events array.
     */
    $events = apply_filters( 'osd_booking_events', $events );

    // ── Styles (output once per page) ───────────────────────────────────
    osd_event_listing_enqueue_styles();

    // ── Render ──────────────────────────────────────────────────────────
    if ( empty( $events ) ) {
        return '<p class="osd-no-events">No events currently available. Please check back soon.</p>';
    }

    ob_start();
    ?>
    <div class="tafe-table-wrap">
        <div class="tafe-table" role="table">
            <?php foreach ( $events as $event ) :
                $name     = esc_html( $event['event_name'] );
                $dates    = osd_event_listing_format_dates( $event['dates'] );
                $more_url = esc_url( $event['more_info_url'] );
                $book_url = esc_url( $event['book_now_url'] );
                ?>
                <div class="tafe-row" role="row">
                    <div class="col-event" role="cell"><?php echo $name; ?></div>
                    <div class="col-date" role="cell"><?php echo $dates; ?></div>
                    <div class="col-actions" role="cell">
                        <a href="<?php echo $more_url; ?>" class="btn btn-more">More Info</a>
                        <a href="<?php echo $book_url; ?>" class="btn btn-book">Book Now</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// ── Helper: Date Formatting ──────────────────────────────────────────────

/**
 * Format an array of YYYY-MM-DD strings to "30th June 2026 & 1st July 2026".
 *
 * @param  string[] $dates
 * @return string
 */
function osd_event_listing_format_dates( array $dates ): string {
    $formatted = array_map( 'osd_event_listing_format_single_date', $dates );
    return implode( ' &amp; ', $formatted );
}

/**
 * Format a single YYYY-MM-DD string to "30th June 2026".
 *
 * @param  string $date_string
 * @return string
 */
function osd_event_listing_format_single_date( string $date_string ): string {
    $timestamp = strtotime( $date_string );
    $day       = (int) date( 'j', $timestamp );

    $suffix = match ( true ) {
        $day >= 11 && $day <= 13 => 'th',
        $day % 10 === 1          => 'st',
        $day % 10 === 2          => 'nd',
        $day % 10 === 3          => 'rd',
        default                  => 'th',
    };

    return $day . $suffix . ' ' . date( 'F Y', $timestamp );
}

// ── Helper: Inline Styles (printed once) ────────────────────────────────

/**
 * Register and enqueue the event listing stylesheet.
 * Uses wp_add_inline_style attached to the plugin's public CSS handle
 * so styles are output in <head> rather than inline in the shortcode markup.
 */
function osd_event_listing_enqueue_styles(): void {
    // Guard: only add once per page load
    if ( wp_style_is( 'osd-event-listing', 'enqueued' ) ) {
        return;
    }

    // Register a dummy handle with no src so we can attach inline CSS cleanly
    wp_register_style( 'osd-event-listing', false, [], OSD_BOOKING_VERSION );
    wp_enqueue_style( 'osd-event-listing' );

    wp_add_inline_style( 'osd-event-listing', osd_event_listing_css() );
}

/**
 * Returns the CSS string for the event listing table.
 *
 * @return string
 */
function osd_event_listing_css(): string {
    return '
    /* ── OSD Event Listing ───────────────────────────────────────────────
     * Pure div layout — immune to Elementor table/td overrides.
     * All properties explicitly set to prevent Elementor global kit
     * (frontend.min.css, global.css) from affecting layout or sizing.
     * ──────────────────────────────────────────────────────────────────── */

    .tafe-table-wrap {
        max-width: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        container-type: inline-size;
        container-name: tafe-listing;
        background: transparent;
    }

    .tafe-table {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
    }

    /* ── Row: 3-column grid ─────────────────────────────────────────── */
    .tafe-table .tafe-row {
        display: grid !important;
        grid-template-columns: 2fr 1.4fr auto !important;
        align-items: center !important;
        background-color: #dce8f5 !important;
        transition: background 0.2s ease;
        box-sizing: border-box !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        border-radius: 0 !important;
    }

    .tafe-table .tafe-row:hover {
        background-color: #cddff0 !important;
    }

    .tafe-table .tafe-row + .tafe-row {
        margin-top: 4px !important;
    }

    /* ── Cells: reset everything Elementor might set on divs ──────── */
    .tafe-table .tafe-row .col-event,
    .tafe-table .tafe-row .col-date,
    .tafe-table .tafe-row .col-actions {
        padding: 16px 20px !important;
        margin: 0 !important;
        box-sizing: border-box !important;
        font-size: 0.95rem !important;
        color: #1a1a2e !important;
        line-height: 1.4 !important;
        background: transparent !important;
        border: none !important;
        float: none !important;
    }

    .tafe-table .tafe-row .col-event {
        font-weight: 600 !important;
        font-size: 1rem !important;
    }

    .tafe-table .tafe-row .col-date {
        color: #374151 !important;
        font-size: 0.92rem !important;
    }

    .tafe-table .tafe-row .col-actions {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 8px !important;
        padding: 12px 16px !important;
        white-space: nowrap !important;
        background: transparent !important;
    }

    /* ── Buttons: reset all Elementor a-tag and button global styles ─ */
    .tafe-table .tafe-row .col-actions .btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 11px 22px !important;
        margin: 0 !important;
        border-radius: 50px !important;
        font-size: 1rem !important;
        font-weight: 600 !important;
        line-height: 1.5 !important;
        text-decoration: none !important;
        letter-spacing: 0.02em !important;
        cursor: pointer !important;
        border: none !important;
        outline: none !important;
        white-space: nowrap !important;
        box-shadow: none !important;
        transition: opacity 0.18s ease, transform 0.15s ease !important;
        min-height: 0 !important;
        height: auto !important;
        width: 200px !important;
        float: none !important;
        vertical-align: middle !important;
    }

    .tafe-table .tafe-row .col-actions .btn:hover {
        opacity: 0.85 !important;
        transform: translateY(-1px) !important;
        text-decoration: none !important;
    }

    .tafe-table .tafe-row .col-actions .btn-more {
        background-color: #0d1b3e !important;
        color: #ffffff !important;
        font-weight: 600 !important;
    }

    .tafe-table .tafe-row .col-actions .btn-book {
        background-color: #5cb85c !important;
        color: #011F3D !important;
        font-weight: 600 !important;
    }

    /* ── Tablet (container ≤ 700px) ──────────────────────────────────── */
    @container tafe-listing (max-width: 700px) {
        .tafe-table .tafe-row {
            grid-template-columns: 1.6fr 1.2fr auto !important;
        }

        .tafe-table .tafe-row .col-actions .btn {
            padding: 9px 14px !important;
            font-size: 1rem !important;
        }
    }

    /* ── Elementor ancestor chain reset ─────────────────────────────────
     * The gap below the rows is caused by Elementor applying min-height
     * to the widget, column, or section wrapping the shortcode.
     * Walk the full ancestor chain — widget → column → section — and
     * force every level to shrink-wrap its content at all viewports.
     * We target both the known data-id and generic Elementor class names
     * so this works regardless of which level holds the excess height.
     * ──────────────────────────────────────────────────────────────────── */

    /* Widget level — the shortcode widget itself */
    [data-id="3b5c2a5"],
    [data-id="3b5c2a5"] > .elementor-widget-container {
        min-height: 0 !important;
        height: auto !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    /* Column level — the column containing the widget */
    [data-id="3b5c2a5"] closest .elementor-column,
    :has(> [data-id="3b5c2a5"]) {
        min-height: 0 !important;
        height: auto !important;
    }

    /* Broad reset — any Elementor widget/column/section that directly
       contains our .tafe-table-wrap shrinks to fit its content */
    .elementor-widget:has(.tafe-table-wrap),
    .elementor-widget:has(.tafe-table-wrap) > .elementor-widget-container,
    .elementor-column:has(.tafe-table-wrap) > .elementor-column-wrap,
    .elementor-column:has(.tafe-table-wrap) > .elementor-column-wrap > .elementor-widget-wrap,
    .e-con:has(.tafe-table-wrap) {
        min-height: 0 !important;
        height: auto !important;
        flex-basis: auto !important;
    }

    /* Mobile-specific reset — Elementor often sets min-height only at ≤767px */
    @media (max-width: 1024px) {
        [data-id="3b5c2a5"],
        [data-id="3b5c2a5"] > .elementor-widget-container,
        .elementor-widget:has(.tafe-table-wrap),
        .elementor-widget:has(.tafe-table-wrap) > .elementor-widget-container,
        .elementor-column:has(.tafe-table-wrap) > .elementor-column-wrap,
        .elementor-column:has(.tafe-table-wrap) > .elementor-column-wrap > .elementor-widget-wrap,
        .e-con:has(.tafe-table-wrap) {
            min-height: 0 !important;
            height: auto !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            flex-basis: auto !important;
        }
    }

    /* ── Mobile cards (container ≤ 560px) ────────────────────────────── */
    @container tafe-listing (max-width: 560px) {

        .tafe-table .tafe-row {
            grid-template-columns: 1fr !important;
            border-radius: 10px !important;
            overflow: hidden !important;
            margin-top: 8px !important;
        }

        .tafe-table .tafe-row:first-child {
            margin-top: 0 !important;
        }

        .tafe-table .tafe-row .col-event,
        .tafe-table .tafe-row .col-date,
        .tafe-table .tafe-row .col-actions {
            padding: 8px 16px !important;
        }

        .tafe-table .tafe-row .col-event {
            padding-top: 14px !important;
            font-size: 1rem !important;
        }

        .tafe-table .tafe-row .col-date {
            font-size: 0.85rem !important;
            color: #4b5563 !important;
            padding-bottom: 4px !important;
        }

        .tafe-table .tafe-row .col-actions {
            justify-content: flex-start !important;
            padding: 6px 16px 14px !important;
            gap: 10px !important;
            white-space: normal !important;
        }

        .tafe-table .tafe-row .col-actions .btn {
            flex: 1 !important;
            text-align: center !important;
            justify-content: center !important;
            padding: 15px 8px !important;
            font-size: 1rem !important;
            width: auto !important;
            min-height: 48px !important;
        }
    }
    ';
}