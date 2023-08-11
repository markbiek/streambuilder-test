<?php

namespace SbTest\Streams;

use Tumblr\StreamBuilder\EnumerationOptions\EnumerationOptions;
use Tumblr\StreamBuilder\Streams\Stream;
use Tumblr\StreamBuilder\StreamResult;
use Tumblr\StreamBuilder\StreamCursors\StreamCursor;
use Tumblr\StreamBuilder\StreamTracers\StreamTracer;
use Tumblr\StreamBuilder\StreamContext;
use GuzzleHttp\Client;

use SbTest\StreamElements\EarthquakeStreamElement;
use SbTest\Cursors\EarthquakeStreamCursor;

class EarthquakeStream extends Stream {
	public function __construct() {
		parent::__construct('earthquake_stream');
	}

	public static function get_earthquakes( int $offset, int $limit) {
		$url = 'https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/all_week.geojson';

		$client   = new Client();
		$response = $client->get( $url );
		$body     = (string) $response->getBody();
		$data     = json_decode( $body, true );

		return array_slice( $data['features'], $offset, $limit );
	}

	protected function _enumerate(int $count, StreamCursor $cursor = null, StreamTracer $tracer = null, ?EnumerationOptions $option = null): StreamResult {
		// if we have no cursor, assume it should start over at 0
        if (!($cursor instanceof EarthquakeStreamCursor)) {
            $cursor = new EarthquakeStreamCursor(0);
        }

		$offset = $cursor->getOffset();
        $earthquakes = self::get_earthquakes( $offset, $count );
        $elements = [];
        foreach ($earthquakes as $earthquake) {
            $elements[] = new EarthquakeStreamElement($earthquake, $this->get_identity(), new EarthquakeStreamCursor( ++$offset ) );
        }
		return new StreamResult(count($elements) < $count, $elements);
    }

	/** @inheritDoc */
    public static function from_template(StreamContext $context) {
        return new self($context->get_current_identity());
    }
}