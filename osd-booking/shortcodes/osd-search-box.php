<?php
/**
 * Shortcode: [osd_search_box]
 * Outputs a styled concert/event search box.
 *
 * Usage:
 *   [osd_search_box]
 *   [osd_search_box placeholder="Search for a bus..." action="/concert-list/"]
 *
 * Attributes:
 *   placeholder  – Input placeholder text.   Default: "Search concert or event"
 *   action       – Form action URL.           Default: home_url( '/' )
 *   param        – Query parameter name.      Default: "s"
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_shortcode( 'osd_search_box', 'osd_search_box_shortcode' );

function osd_search_box_shortcode( $atts ) {

    $atts = shortcode_atts(
        array(
            'placeholder' => 'Search concert or event',
            'action'      => home_url( '/' ),
            'param'       => 's',
        ),
        $atts,
        'osd_search_box'
    );

    $placeholder = esc_attr( $atts['placeholder'] );
    $action      = esc_url( $atts['action'] );
    $param       = esc_attr( $atts['param'] );

    ob_start();
    ?>
    <div class="elementor-element-6970279 osd-search-box-wrap" data-id="6970279">
        <form class="osd-search-form" action="<?php echo $action; ?>" method="get" role="search">

            <span class="osd-search-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7"/>
                    <line x1="16.5" y1="16.5" x2="22" y2="22"/>
                </svg>
            </span>

            <input
                class="osd-search-input"
                type="search"
                name="<?php echo $param; ?>"
                placeholder="<?php echo $placeholder; ?>"
                aria-label="<?php echo $placeholder; ?>"
                value="<?php echo esc_attr( get_search_query() ); ?>"
                autocomplete="off"
            />

            <button class="osd-search-submit" type="submit" aria-label="<?php esc_attr_e( 'Submit search', 'osd-booking' ); ?>">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </button>

        </form>
    </div>

    <style>
        .osd-search-box-wrap {
            width: 100%;
            max-width: 520px;
        }
        .osd-search-form {
            display: flex;
            align-items: center;
            background: #ffffff;
            border-radius: 50px;
            padding: 10px 20px;
            gap: 10px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
            transition: box-shadow 0.2s ease;
        }
        .osd-search-form:focus-within {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            outline: 2px solid rgba(255, 255, 255, 0.25);
            outline-offset: 2px;
        }
        .osd-search-icon {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            color: #6b7280;
            transition: color 0.2s;
        }
        .osd-search-form:focus-within .osd-search-icon {
            color: #0d1b2e;
        }
        .osd-search-input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 15px;
            color: #1a202c;
            letter-spacing: 0.01em;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .osd-search-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }
        /* Remove the browser's default clear (×) button on search inputs */
        .osd-search-input::-webkit-search-cancel-button {
            -webkit-appearance: none;
        }
        .osd-search-submit {
            flex-shrink: 0;
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            color: #6b7280;
            transition: color 0.2s;
        }
        .osd-search-submit:hover {
            color: #0d1b2e;
        }
    </style>
    <?php
    return ob_get_clean();
}