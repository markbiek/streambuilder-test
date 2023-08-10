<?php

require_once __DIR__ . '/vendor/autoload.php';

use Tumblr\StreamBuilder\DependencyBag;
use Tumblr\StreamBuilder\StreamBuilder;
use Tumblr\StreamBuilder\TransientCacheProvider;
use Tumblr\StreamBuilder\StreamSerializer;
use Tumblr\StreamBuilder\TemplateProvider;
use Tumblr\StreamBuilder\StreamContext;

use SbTest\InterfaceImplementations\Credentials;
use SbTest\InterfaceImplementations\ContextProvider;
use SbTest\InterfaceImplementations\StreamBuilderLog;
use SbTest\Streams\EarthquakeStream;

$dependency_bag = new DependencyBag( 
	new StreamBuilderLog(),
	new TransientCacheProvider(),
	new Credentials(),
	new ContextProvider()
 );

StreamBuilder::init( $dependency_bag );

$template = 'awesome_trending.20230811';
$meta = [];
$stream = StreamSerializer::from_template(new StreamContext(
   TemplateProvider::get_template('trending', $template),
   $meta,
   StreamBuilder::getDependencyBag()->getCacheProvider(),
   $template
));
$results = $stream->enumerate(10);

echo '<pre>' . print_r($results, true) . '</pre>';

echo '<hr />done';