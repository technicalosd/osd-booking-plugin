<?php
/**
 * Shortcode: [osd_upcoming_cards]
 *
 * Renders a responsive grid of upcoming event cards.
 *
 * Usage:
 *   [osd_upcoming_cards]
 *
 * Events are supplied via the filter 'osd_booking_upcoming_events'.
 *
 * Each event array shape:
 *   [
 *     'event_name'  => string,       // Full event title
 *     'date'        => string,       // 'YYYY-MM-DD'
 *     'image_url'   => string,       // Full URL to card image
 *     'learn_more_url' => string,    // URL for Learn More button
 *   ]
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_shortcode( 'osd_upcoming_cards', 'osd_upcoming_cards_shortcode' );

/**
 * Shortcode callback.
 *
 * @return string HTML output.
 */
function osd_upcoming_cards_shortcode(): string {

    // ── Data ────────────────────────────────────────────────────────────
    $events = [
        [
            'event_name'     => 'Bus to Calum Scott – 3Arena – 19th November 2025',
            'date'           => '2025-11-19',
            'image_url'      => 'https://ict.osd.ie/wp-content/uploads/2025/12/image-1-1.png',
            'learn_more_url' => '#',
        ],
        [
            'event_name'     => 'Bus to Metallica – Slane Castle – 14th June 2026',
            'date'           => '2026-06-14',
            'image_url'      => 'https://ict.osd.ie/wp-content/uploads/2025/12/M72-2026_social-1024x576.jpeg',
            'learn_more_url' => '#',
        ],
        [
            'event_name'     => 'Bus to Coldplay – Croke Park – 5th July 2026',
            'date'           => '2026-07-05',
            'image_url'      => 'https://ict.osd.ie/wp-content/uploads/2025/12/image-1-1.png',
            'learn_more_url' => '#',
        ],
        [
            'event_name'     => 'Bus to Electric Picnic – Stradbally – 22nd August 2026',
            'date'           => '2026-08-22',
            'image_url'      => 'https://ict.osd.ie/wp-content/uploads/2025/12/image-1-1.png',
            'learn_more_url' => '#',
        ],
        [
            'event_name'     => 'Bus to Taylor Swift – Aviva Stadium – 6th September 2026',
            'date'           => '2026-09-06',
            'image_url'      => 'https://ict.osd.ie/wp-content/uploads/2025/12/M72-2026_social-1024x576.jpeg',
            'learn_more_url' => '#',
        ],
        [
            'event_name'     => 'Bus to Oasis – RDS Arena – 11th October 2026',
            'date'           => '2026-10-11',
            'image_url'      => 'https://ict.osd.ie/wp-content/uploads/2025/12/image-1-1.png',
            'learn_more_url' => '#',
        ],
        [
            'event_name'     => 'Bus to Bruce Springsteen – 3Arena – 25th October 2026',
            'date'           => '2026-10-25',
            'image_url'      => 'https://ict.osd.ie/wp-content/uploads/2025/12/M72-2026_social-1024x576.jpeg',
            'learn_more_url' => '#',
        ],
        [
            'event_name'     => 'Bus to Ed Sheeran – Marlay Park – 30th November 2026',
            'date'           => '2026-11-30',
            'image_url'      => 'https://ict.osd.ie/wp-content/uploads/2025/12/image-1-1.png',
            'learn_more_url' => '#',
        ],
    ];

    /**
     * Filter: osd_booking_upcoming_events
     * Allows themes or plugins to modify the upcoming events list.
     *
     * @param array $events Default events array.
     */
    $events = apply_filters( 'osd_booking_upcoming_events', $events );

    // ── Styles ──────────────────────────────────────────────────────────
    osd_upcoming_cards_enqueue_styles();

    // ── Render ──────────────────────────────────────────────────────────
    if ( empty( $events ) ) {
        return '<p class="osd-no-events">No upcoming events. Please check back soon.</p>';
    }

    ob_start();
    ?>
    <div class="osd-cards-wrap">
        <?php foreach ( $events as $event ) :
            $name     = esc_html( $event['event_name'] );
            $img      = esc_url( $event['image_url'] );
            $url      = esc_url( $event['learn_more_url'] );
            $ts       = strtotime( $event['date'] );
            $month    = strtoupper( date( 'M', $ts ) );
            $day      = date( 'j', $ts );
            ?>
            <div class="osd-card">
                <div class="osd-card__image-wrap">
                    <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>" class="osd-card__image" loading="lazy">
                    <div class="osd-card__date-badge">
                        <span class="osd-card__month"><?php echo $month; ?></span>
                        <span class="osd-card__day"><?php echo $day; ?></span>
                    </div>
                </div>
                <div class="osd-card__body">
                    <p class="osd-card__title"><?php echo $name; ?></p>
                    <a href="<?php echo $url; ?>" class="osd-card__btn">Learn More</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}

// ── Styles ───────────────────────────────────────────────────────────────

function osd_upcoming_cards_enqueue_styles(): void {
    if ( wp_style_is( 'osd-upcoming-cards', 'enqueued' ) ) {
        return;
    }
    wp_register_style( 'osd-upcoming-cards', false, [], OSD_BOOKING_VERSION );
    wp_enqueue_style( 'osd-upcoming-cards' );
    wp_add_inline_style( 'osd-upcoming-cards', osd_upcoming_cards_css() );
}

function osd_upcoming_cards_css(): string {
    return '
    /* ── OSD Upcoming Cards ──────────────────────────────────────────── */
    .osd-cards-wrap {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 16px !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box !important;
        height: auto !important;
        min-height: 0 !important;
    }

    .osd-card {
        display: flex !important;
        flex-direction: column !important;
        border-radius: 8px !important;
        overflow: hidden !important;
        background: #fff !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12) !important;
        height: auto !important;
        min-height: 0 !important;
        margin: 0 !important;
    }

    .osd-card__image-wrap {
        position: relative !important;
        width: 100% !important;
        aspect-ratio: 16 / 9 !important;
        overflow: hidden !important;
        flex-shrink: 0 !important;
    }

    .osd-card__image {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        display: block !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
    }

    .osd-card__date-badge {
        position: absolute !important;
        top: 10px !important;
        left: 10px !important;
        background: #011F3D !important;
        color: #fff !important;
        border-radius: 4px !important;
        padding: 4px 8px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        line-height: 1.2 !important;
        min-width: 36px !important;
    }

    .osd-card__month {
        font-size: 0.6rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.05em !important;
        color: #fff !important;
        text-transform: uppercase !important;
        display: block !important;
    }

    .osd-card__day {
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        color: #fff !important;
        display: block !important;
        line-height: 1 !important;
    }

    .osd-card__body {
        padding: 12px 14px 14px !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 10px !important;
        flex: 1 !important;
        background: #fff !important;
        min-height: 0 !important;
        height: auto !important;
        box-sizing: border-box !important;
    }

    .osd-card__title {
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        color: #011F3D !important;
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1.35 !important;
    }

    .osd-card__btn {
        display: block !important;
        width: 100% !important;
        text-align: center !important;
        padding: 10px 12px !important;
        background: #011F3D !important;
        color: #fff !important;
        border-radius: 50px !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        border: none !important;
        cursor: pointer !important;
        box-sizing: border-box !important;
        line-height: 1.2 !important;
        margin: 0 !important;
    }

    .osd-card__btn:hover {
        background: #0d2f5e !important;
        color: #fff !important;
        text-decoration: none !important;
    }

    /* ── Single column on narrow screens ─────────────────────── */
    @media (max-width: 480px) {
        .osd-cards-wrap {
            grid-template-columns: 1fr !important;
        }
    }
    ';
}