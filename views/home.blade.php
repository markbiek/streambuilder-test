<!DOCTYPE html>

<!--[if IEMobile 7 ]> <html lang="en-US" prefix="og: http://ogp.me/ns#"class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js ie6 oldie"> <![endif]-->
<!--[if IE 7 ]> <html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js ie7 oldie"> <![endif]-->
<!--[if IE 8 ]> <html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js ie8 oldie"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js"><!--<![endif]-->
	<link rel="stylesheet" href="styles/styles.css" />
<head>
</head>
<body>
	<main>
		<h1>All Earthquakes in the past week</h1>
		<p>Pulled from the <a href="https://earthquake.usgs.gov/fdsnws/event/1/">USGS Earthquake feed</a>.</p>
		<nav>
			<ul>
				<li> <a href="/">Home</a> </li>
				<li> <a href="/?filter=large">Hide small earthquakes</a> </li>
				<li> <a href="/?cursor={{ $next_cursor }}&filter={{ $filter }}">Next Page</a>	</li>
			</ul>
		</nav>
		<ul class="earthquakes">
			@foreach( $earthquakes as $earthquake )
				<li>
					<div>{{ $earthquake }}</div>
					<div><a href="{{ $earthquake->get_original_element()->get_url() }}" target="_blank" class="details-link">(Details)</a></div>
				</li>
			@endforeach
		</ul>
	</main>
</body>
</html>
