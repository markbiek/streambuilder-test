<?php

namespace SbTest\StreamElements;

use Tumblr\StreamBuilder\StreamElements\LeafStreamElement;
use Tumblr\StreamBuilder\StreamCursors\StreamCursor;
use Tumblr\StreamBuilder\StreamContext;

class AdStreamElement extends LeafStreamElement {

    /** @var string The underlying ad, as a string */
    private string $ad;

    /**
     * @param string $ad The ad details
     * @param string $provider_identity The identity
     * @param StreamCursor|null $cursor The cursor
     * @param string|null $element_id An unique id used to trace the entire lifecycle of this element.
     */
    public function __construct(string $ad, string $provider_identity, ?StreamCursor $cursor = null, ?string $element_id = null) {
        parent::__construct($provider_identity, $cursor, $element_id);
        $this->ad = $ad;
    }

    /** @inheritDoc */
    public function get_cache_key() {
        return $this->ad;
    }

    /** @inheritDoc */
    protected function to_string(): string {
        return $this->ad;
    }

    /** @inheritDoc */
    public static function from_template(StreamContext $context) {
        return new self(
            $context->get_required_property('ad'),
            $context->get_optional_property('provider_id', ''),
            $context->deserialize_optional_property('cursor'),
            $context->get_optional_property('element_id', null)
        );
    }

    /** @inheritDoc **/
    public function to_template(): array {
        $base = parent::to_template();
        $base['ad'] = $this->ad;
        return $base;
    }

	public function get_url(): string {
		return 'https://example.com';
	}

	public function is_ad(): bool {
		return true;
	}
}