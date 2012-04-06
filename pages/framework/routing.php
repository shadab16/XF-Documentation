	<div class="titleBar">
		<h1>Routing Layer</h1>
	</div>
	<p>
		As you might have noticed while reading the Front Controller section, every request to the application is passed to the Front Controller;
		which calls a Controller/Action set most appropriate for the given request. So how does it know which Controller and Action to call?
		Front Controller leaves the task of deciding the controller and action names to the Routing Layer.
	</p>
	<p>
		The Routing Layer in XenForo is composed of the following components:
	</p>
	<dl class="pairsColumns alt">
		<dt>
			<strong>Router</strong><br />
			(<code>XenForo_Router</code>)
		</dt>
		<dd>
			Router is the main component responsible for matching a Request object (<code>Zend_Controller_Request_Http</code>)
			to a RouteMatch object, with the help of registered routing rules.
		</dd>
		<dt>
			<strong>Routing Rules</strong><br />
			(<code>XenForo_Route_Interface</code>)
		</dt>
		<dd>
			A routing rule is a class which implements the route interface. The <code>match()</code> method resolves the given Route Path
			to a RouteMatch object. If no match can be found, <code>false</code> is returned; so the Router can continue asking other
			registered routes for a valid RouteMatch object.
		</dd>
		<dt>
			<strong>Route Match</strong><br />
			(<code>XenForo_RouteMatch</code>)
		</dt>
		<dd>
			A route-match object denotes a matched Controller/Action set. In addition to storing the Controller name and Action name,
			a route-match object also stores the Response Type, Major Section &amp; Minor Section name for the matched route
			<em>(more on this later)</em>.
		</dd>
	</dl>
	<div class="titleBar">
		<h2>Components</h2>
	</div>
	<ul>
		<li>
			<p><strong><a href="./?page=routing-rules">Routing Rules</a></strong></p>
			<ul class="condensed columns c50_50">
				<li class="columnContainer c1">Introduction</li>
				<li class="columnContainer c2">Default Route-Path</li>
				<li class="columnContainer c1">Admin Routing Rules</li>
				<li class="columnContainer c2">Public Routing Rules</li>
			</ul>
		</li>
		<li>
			<p><strong><a href="./?page=route-prefix">Route Prefix</a></strong></p>
			<ul class="condensed columns c50_50">
				<li class="columnContainer c1">Introduction</li>
				<li class="columnContainer c2">XenForo_Route_Interface</li>
				<li class="columnContainer c1">XenForo_Route_BuilderInterface</li>
				<li class="columnContainer c2">Route-Path Matching Strategies</li>
			</ul>
		</li>
		<li>
			<p><strong><a href="./?page=route-match">Route Match</a></strong></p>
			<ul class="condensed columns c50_50">
				<li class="columnContainer c1">Introduction</li>
				<li class="columnContainer c2">Controller name &amp; Action name</li>
				<li class="columnContainer c1">Major &amp; Minor Sections</li>
				<li class="columnContainer c2">Response Types</li>
				<li class="columnContainer c1">Modified Route Path</li>
			</ul>
		</li>
	</ul>