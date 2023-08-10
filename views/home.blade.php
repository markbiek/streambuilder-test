<!DOCTYPE html>

<!--[if IEMobile 7 ]> <html lang="en-US" prefix="og: http://ogp.me/ns#"class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js ie6 oldie"> <![endif]-->
<!--[if IE 7 ]> <html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js ie7 oldie"> <![endif]-->
<!--[if IE 8 ]> <html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js ie8 oldie"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js"><!--<![endif]-->

<head>
</head>
<body>
	<ul>
		@foreach( $results->get_elements() as $element )
			<li>
				{{ $element }}
			</li>
		@endforeach
	</ul>
</body>
</html>
