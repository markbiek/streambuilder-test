<?php

namespace SbTest\StreamElements;

use Tumblr\StreamBuilder\StreamElements\LeafStreamElement;
use Tumblr\StreamBuilder\StreamCursors\StreamCursor;
use Tumblr\StreamBuilder\StreamContext;

class EarthquakeStreamElement extends LeafStreamElement {

    /** @var string The underlying earthquake, as a string */
    private string $earthquake_details;

    /**
     * @param string $earthquake_details The earthquake details
     * @param string $provider_identity The identity
     * @param StreamCursor|null $cursor The cursor
     * @param string|null $element_id An unique id used to trace the entire lifecycle of this element.
     */
    public function __construct(string $earthquake_details, string $provider_identity, ?StreamCursor $cursor = null, ?string $element_id = null) {
        parent::__construct($provider_identity, $cursor, $element_id);
        $this->earthquake_details = $earthquake_details;
    }

    /** @inheritDoc */
    public function get_cache_key()
    {
        return $this->earthquake_details;
    }

    /** @inheritDoc */
    protected function to_string(): string
    {
        return "Earthquake: $this->earthquake_details";
    }

    /** @inheritDoc */
    public static function from_template(StreamContext $context)
    {
        return new self(
            $context->get_required_property('earthquake_details'),
            $context->get_optional_property('provider_id', ''),
            $context->deserialize_optional_property('cursor'),
            $context->get_optional_property('element_id', null)
        );
    }

    /** @inheritDoc **/
    public function to_template(): array
    {
        $base = parent::to_template();
        $base['earthquake_details'] = $this->earthquake_details;
        return $base;
    }
}