<?php

require_once __DIR__ . '/vendor/autoload.php';

use Tumblr\StreamBuilder\DependencyBag;
use Tumblr\StreamBuilder\StreamBuilder;
use Tumblr\StreamBuilder\TransientCacheProvider;
use Tumblr\StreamBuilder\StreamSerializer;
use Tumblr\StreamBuilder\TemplateProvider;
use Tumblr\StreamBuilder\StreamContext;
use Jenssegers\Blade\Blade;

use SbTest\InterfaceImplementations\Credentials;
use SbTest\InterfaceImplementations\ContextProvider;
use SbTest\InterfaceImplementations\StreamBuilderLog;
use SbTest\Streams\EarthquakeStream;

$blade = new Blade('views', 'cache');

$dependency_bag = new DependencyBag( 
	new StreamBuilderLog(),
	new TransientCacheProvider(),
	new Credentials(),
	new ContextProvider()
 );

StreamBuilder::init( $dependency_bag );

$cursor = $_REQUEST['cursor'] ?? null;
if ( is_string( $cursor ) ) {
    $cursor = \Tumblr\StreamBuilder\StreamCursors\StreamCursor::decode( $cursor, ['secret'], ['key'] );
} else {
    $cursor = null;
}

$template = 'default.20230811';
$meta = [];
$stream = StreamSerializer::from_template( new StreamContext(
   TemplateProvider::get_template( 'earthquakes', $template ),
   $meta,
   StreamBuilder::getDependencyBag()->getCacheProvider(),
   $template
) );
$results = $stream->enumerate( 25, $cursor )->get_elements();

$last_cursor = end( $results )->get_cursor();
$next_cursor_string = \Tumblr\StreamBuilder\StreamCursors\StreamCursor::encode($last_cursor, 'secret', 'key');

echo $blade->make( 'home', array(
	'earthquakes' => $results,
	'cursor' => $next_cursor_string,
) )->render();