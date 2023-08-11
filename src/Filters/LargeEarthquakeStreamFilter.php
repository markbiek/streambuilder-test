<?php

namespace SbTest\Filters;

use Tumblr\StreamBuilder\StreamFilters\StreamElementFilter;
use Tumblr\StreamBuilder\StreamElements\StreamElement;
use Tumblr\StreamBuilder\StreamContext;

use SbTest\StreamElements\EarthquakeStreamElement;

class LargeEarthquakeStreamFilter extends StreamElementFilter {
	public function __construct( string $identity ) {
		parent::__construct( $identity );
	}

    /** @inheritDoc */
    protected function should_release(StreamElement $e): bool {
        $e = $e->get_original_element();
        if ($e instanceof EarthquakeStreamElement) {
			// Drop earthquakes that are less than magnitude 2.0
			return $e->get_magnitude() < 2.0;
        }

        // ignore other types of stream elements
        return false;
    }

	public function pre_fetch( array $elements ) {
		// Do nothing
	}

	public function get_cache_key() {
        return null;
    }

	public function can_filter(): bool {
		return isset( $_GET['filter'] ) && $_GET['filter'] === 'large' ? true : false;
	}

	public static function from_template(StreamContext $context) {
		return new self( $context->get_current_identity() );
	}
}