<?php

namespace SbTest\Streams;

use Tumblr\StreamBuilder\EnumerationOptions\EnumerationOptions;
use Tumblr\StreamBuilder\Streams\Stream;
use Tumblr\StreamBuilder\StreamResult;
use Tumblr\StreamBuilder\StreamCursors\StreamCursor;
use Tumblr\StreamBuilder\StreamTracers\StreamTracer;
use Tumblr\StreamBuilder\StreamContext;
use GuzzleHttp\Client;

use SbTest\StreamElements\CatFactStreamElement;

class CatFactStream extends Stream {
	public function __construct() {
		parent::__construct('earthquake_stream');
	}

	protected static function get_fact( string $cat_name ) {
		$client = new Client();
		$response = $client->request('GET', "https://api.api-ninjas.com/v1/cats?name=$cat_name", [
			'headers' => [
				'X-Api-Key' => $_ENV['API_NINJAS_KEY']
			]
		]);

		$body     = (string) $response->getBody();
		$data     = json_decode( $body, true );

		return $data[0];
	}

	public static function get_facts() {
		$cat_names = array(
			'calico',
			'abyssinian',
			'siamese',
			'aegean',
			'balinese',
		);

		$cats = array();
		foreach( $cat_names as $cat_name ) {
			$cats[] = self::get_fact( $cat_name );
		}

		return $cats;
	}

	protected function _enumerate(int $count, StreamCursor $cursor = null, StreamTracer $tracer = null, ?EnumerationOptions $option = null): StreamResult {
        $cats = self::get_facts();
        $elements = [];
        foreach ($cats as $cat) {
            $elements[] = new CatFactStreamElement($earthquake, $this->get_identity(), new EarthquakeStreamCursor( ++$offset ) );
        }
		return new StreamResult( true, $elements);
    }

	/** @inheritDoc */
    public static function from_template(StreamContext $context) {
        return new self($context->get_current_identity());
    }
}