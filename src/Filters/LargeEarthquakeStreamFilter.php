<?php

namespace SbTest\Filters;

use Tumblr\StreamBuilder\StreamFilters\StreamElementFilter;
use Tumblr\StreamBuilder\StreamElements\StreamElement;

use SbTest\StreamElements\EarthquakeStreamElement;

class LargeEarthquakeStreamFilter extends StreamElementFilter {
    /** @inheritDoc */
    protected function should_release(StreamElement $e): bool
    {
        $e = $e->get_original_element();
        if ($e instanceof EarthquakeStreamElement) {
			// Drop earthquakes that are less than magnitude 4.0
			return $e->get_magnitude() < 4.0;
        }

        // ignore other types of stream elements
        return false;
    }
}