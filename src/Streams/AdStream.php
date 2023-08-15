<?php

namespace SbTest\Streams;

use Tumblr\StreamBuilder\EnumerationOptions\EnumerationOptions;
use Tumblr\StreamBuilder\Streams\Stream;
use Tumblr\StreamBuilder\StreamResult;
use Tumblr\StreamBuilder\StreamCursors\StreamCursor;
use Tumblr\StreamBuilder\StreamTracers\StreamTracer;
use Tumblr\StreamBuilder\StreamContext;

use SbTest\StreamElements\AdStreamElement;

class AdStream extends Stream {
	public static function get_ads() {
		return array(
			'BUY THIS THING',
			'ACT NOW',
			'LIMITED TIME OFFER',
		);
	}

	protected function _enumerate(int $count, StreamCursor $cursor = null, StreamTracer $tracer = null, ?EnumerationOptions $option = null): StreamResult {
		$ads = self::get_ads();

		$elements = [];
		foreach ( $ads as $ad ) {
			$elements[] = new AdStreamElement($ad, $this->get_identity());
		}

		return new StreamResult( true, $elements );
    }

	/** @inheritDoc */
    public static function from_template(StreamContext $context) {
        return new self($context->get_current_identity());
    }
}