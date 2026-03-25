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
        <table class="tafe-table">
            <tbody>
            <?php foreach ( $events as $event ) :
                $name     = esc_html( $event['event_name'] );
                $dates    = osd_event_listing_format_dates( $event['dates'] );
                $more_url = esc_url( $event['more_info_url'] );
                $book_url = esc_url( $event['book_now_url'] );
                ?>
                <tr>
                    <td class="col-event"><?php echo $name; ?></td>
                    <td class="col-date"><?php echo $dates; ?></td>
                    <td class="col-actions">
                        <a href="<?php echo $more_url; ?>" class="btn btn-more">More Info</a>
                        <a href="<?php echo $book_url; ?>" class="btn btn-book">Book Now</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
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
    /* ── OSD Event Listing: tafe-table ──────────────────────────── */
    .tafe-table-wrap {
        max-width: 900px;
        margin: 0 auto;
        container-type: inline-size;
        container-name: tafe-listing;
    }

    .tafe-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .tafe-table tbody tr {
        background-color: #dce8f5;
        transition: background 0.2s ease;
    }

    .tafe-table tbody tr:hover {
        background-color: #cddff0;
    }

    .tafe-table tbody tr + tr td {
        border-top: 4px solid #f5f7fa;
    }

    .tafe-table td {
        padding: 16px 20px;
        vertical-align: middle;
        font-size: 0.95rem;
        color: #1a1a2e;
    }

    .tafe-table .col-event {
        font-weight: 600;
        font-size: 1rem;
        width: 38%;
    }

    .tafe-table .col-date {
        color: #374151;
        font-size: 0.92rem;
        width: 26%;
    }

    /* Actions cell: buttons sit right-aligned side by side on desktop */
    .tafe-table .col-actions {
        text-align: right;
        white-space: nowrap;
        width: 36%;
    }

    .tafe-table .btn {
        display: inline-block;
        padding: 11px 26px;
        border-radius: 50px;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        letter-spacing: 0.02em;
        cursor: pointer;
        border: none;
        transition: opacity 0.18s ease, transform 0.15s ease;
    }

    .tafe-table .btn + .btn {
        margin-left: 8px;
    }

    .tafe-table .btn:hover {
        opacity: 0.85;
        transform: translateY(-1px);
    }

    .tafe-table .btn-more {
        background-color: #0d1b3e;
        color: #ffffff;
    }

    .tafe-table .btn-book {
        background-color: #5cb85c;
        color: #ffffff;
    }

    /* ── Tablet (container ≤ 720px) ──────────────────────────── */
    @container tafe-listing (max-width: 720px) {
        .tafe-table .col-event { width: auto; }
        .tafe-table .col-date  { width: auto; }

        .tafe-table .btn {
            padding: 9px 16px;
            font-size: 0.82rem;
        }
    }

    /* ── Mobile cards (container ≤ 560px) ────────────────────── */
    @container tafe-listing (max-width: 560px) {

        /* Force the browser to abandon table layout entirely */
        .tafe-table         { display: block !important; width: 100% !important; }
        .tafe-table tbody   { display: block !important; width: 100% !important; }
        .tafe-table tr      { display: block !important; width: 100% !important; }
        .tafe-table td      { display: block !important; width: 100% !important; }

        .tafe-table tbody tr {
            border-radius: 10px;
            margin-bottom: 10px;
            overflow: hidden;
            padding: 0;
        }

        /* Drop the row-separator border — cards have their own gap */
        .tafe-table tbody tr + tr td {
            border-top: none;
        }

        .tafe-table td {
            padding: 10px 16px;
            text-align: left;
            white-space: normal;
            box-sizing: border-box;
        }

        .tafe-table .col-event {
            font-size: 1rem;
            padding-top: 14px;
        }

        .tafe-table .col-date {
            padding-top: 2px;
            padding-bottom: 10px;
            font-size: 0.85rem;
            color: #4b5563;
        }

        /* Actions cell: override back to flex for the two buttons */
        .tafe-table .col-actions {
            display: flex !important;
            gap: 10px;
            padding: 0 16px 14px;
            white-space: normal;
            width: 100% !important;
            box-sizing: border-box;
        }

        .tafe-table .col-actions .btn {
            flex: 1;
            text-align: center;
            padding: 11px 10px;
            font-size: 0.87rem;
            margin-left: 0;
        }

        .tafe-table .col-actions .btn + .btn {
            margin-left: 0;
        }
    }
    ';
}