<?php

namespace SbTest\Rankers;

use Tumblr\StreamBuilder\StreamContext;
use Tumblr\StreamBuilder\StreamElements\StreamElement;
use Tumblr\StreamBuilder\StreamTracers\StreamTracer;
use Tumblr\StreamBuilder\StreamRankers\StreamRanker;

class MagnitudeRanker extends StreamRanker {
    /** @inheritDoc */
    protected function rank_inner(array $stream_elements, StreamTracer $tracer = null): array {
		usort( $stream_elements, function( StreamElement $a, StreamElement $b ) {
			$magnitude_a = $a->get_original_element()->get_magnitude();
			$magnitude_b = $b->get_original_element()->get_magnitude();

			if ( $magnitude_a == $magnitude_b ) {
				return 0;
			}

			return ( $magnitude_a > $magnitude_b ) ? -1 : 1;
		} );

        return $stream_elements;
    }

    /** @inheritDoc */
    public function to_template(): array {
        return [ '_type' => get_class($this) ];
    }

    /** @inheritDoc */
    public static function from_template(StreamContext $context) {
        return new self($context->get_current_identity());
    }

    /** @inheritDoc */
    protected function pre_fetch(array $elements) {
        // No need to do any prefetching in this example
    }
}