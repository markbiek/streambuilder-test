<?php

namespace SbTest\StreamElements;

use Tumblr\StreamBuilder\StreamElements\LeafStreamElement;
use Tumblr\StreamBuilder\StreamCursors\StreamCursor;
use Tumblr\StreamBuilder\StreamContext;

class EarthquakeStreamElement extends LeafStreamElement {

    /** @var string The underlying earthquake, as a string */
    private array $earthquake;

    /**
     * @param string $earthquake The earthquake details
     * @param string $provider_identity The identity
     * @param StreamCursor|null $cursor The cursor
     * @param string|null $element_id An unique id used to trace the entire lifecycle of this element.
     */
    public function __construct(array $earthquake, string $provider_identity, ?StreamCursor $cursor = null, ?string $element_id = null) {
        parent::__construct($provider_identity, $cursor, $element_id);
        $this->earthquake = $earthquake;
    }

    /** @inheritDoc */
    public function get_cache_key() {
        return $this->earthquake;
    }

    /** @inheritDoc */
    protected function to_string(): string {
        return $this->earthquake['properties']['title'];
    }

    /** @inheritDoc */
    public static function from_template(StreamContext $context) {
        return new self(
            $context->get_required_property('earthquake'),
            $context->get_optional_property('provider_id', ''),
            $context->deserialize_optional_property('cursor'),
            $context->get_optional_property('element_id', null)
        );
    }

    /** @inheritDoc **/
    public function to_template(): array {
        $base = parent::to_template();
        $base['earthquake'] = $this->earthquake;
        return $base;
    }

	public function get_url(): string {
		return $this->earthquake['properties']['url'];
	}

	public function get_magnitude(): float {
		return $this->earthquake['properties']['mag'];
	}
}