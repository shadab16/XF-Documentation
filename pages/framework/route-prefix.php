	<div class="titleBar">
		<h1>Route Prefix</h1>
	</div>
	<p>
		The concept of a route prefix is central to XenForo's Routing system. A route prefix is a static string which appears in a
		route-path before the first slash (/). Any route-path that is prefixed with this static string will be handled by
		the single routing rule associated with that route prefix. This allows all related paths to be handled by a single class.
	</p>
	<p>
		Suppose a public route-prefix "hello" is associated with the class <code>HelloWorld_Route_Prefix_Hello</code>.
		Accessing the URI <code>http://127.0.0.1/xenforo/hello/</code> will automatically invoke
		the <code>match()</code> method of this class, to find out the correct Controller name &amp; Action name.
	</p>
	<table width="100%">
		<tr class="muted">
			<td width="50%"><strong>URI</strong></td>
			<td width="25%"><strong>Route Prefix</strong></td>
			<td width="25%"><strong>Route Path for Sub-Rule</strong></td>
		</tr>
		<tr>
			<td><code>http://127.0.0.1/xenforo/hello/</code></td>
			<td>hello</td>
			<td>index <span class="muted">(default)</span></td>
		</tr>
		<tr>
			<td><code>http://127.0.0.1/xenforo/hello/shadab</code></td>
			<td>hello</td>
			<td>shadab</td>
		</tr>
		<tr>
			<td><code>http://127.0.0.1/xenforo/hello/shadab.html</code></td>
			<td>hello</td>
			<td>shadab</td>
		</tr>
		<tr>
			<td><code>http://127.0.0.1/xenforo/hello/shadab/page-2</code></td>
			<td>hello</td>
			<td>shadab/page-2</td>
		</tr>
	</table>
	<div class="titleBar">
		<h2>XenForo_Route_Interface</h2>
	</div>
	<p>
		The route interface consists of a single method: <code>match()</code>, which is supposed to match a route-path to a route-match object.
		In addition to the route-path, the request object and the router are also available. This allows for extraction of parameters
		from the route-path <em>(for example: Thread ID, Forum Title, etc.)</em>, which can be added to the request object.
	</p>
	<p>
		The exact method prototype is given as:
	</p>
<?php _php(<<<TEXT
public function match(\$routePath, Zend_Controller_Request_Http \$request, XenForo_Router \$router)
TEXT
)?>
	<div class="titleBar">
		<h2>XenForo_Route_BuilderInterface</h2>
	</div>
	<p>
		The builder interface consists of a single method: <code>buildLink()</code>, which is used to convert a given set of route-prefix,
		route-path and parameters into a URI. The method returns the link in the form of a plain string or a <code>XenForo_Link</code>
		object; or <code>false</code> if a link cannot be generated from the provided data.
	</p>
	<p>
		The exact method prototype is given as:
	</p>
<?php _php(<<<TEXT
public function buildLink(\$originalPrefix, \$outputPrefix, \$action, \$ext, \$data, array &\$extraParams)
TEXT
)?>
	<p>
		Method parameters are described in the table below, taken from the docblock:
	</p>
	<table width="100%">
		<tr class="muted">
			<td width="25%"><strong>Parameter</strong></td>
			<td width="25%"><strong>Data Type</strong></td>
			<td width="50%"><strong>Description</strong></td>
		</tr>
		<tr>
			<td><code>$originalPrefix</code></td>
			<td>string</td>
			<td>Original prefix for the type of link to be generated. This is a known value, but shouldn't be displayed to the user.</td>
		</tr>
		<tr>
			<td><code>$outputPrefix</code></td>
			<td>string</td>
			<td>The configured output that means the same thing as the original prefix but is user configured.</td>
		</tr>
		<tr>
			<td><code>$action</code></td>
			<td>string</td>
			<td>Action to take on the data.</td>
		</tr>
		<tr>
			<td><code>$extension</code></td>
			<td>string</td>
			<td>Specified extension for the link.</td>
		</tr>
		<tr>
			<td><code>$data</code></td>
			<td>array|ArrayAccess</td>
			<td>Info about data to link to specifically <span class="muted">(eg, info about a thread)</span>.</td>
		</tr>
		<tr>
			<td><code>$extraParams</code></td>
			<td>array</td>
			<td>Extra parameters that modify how the link is built.</td>
		</tr>
	</table>
	<div class="titleBar">
		<h2>Route-Path Matching Strategies</h2>
	</div>
	<p>
		Various in-built route-path matching and URI building strategies are available. You are not restricted to using only these
		strategies in your Route Classes; but using the methods offered natively allows for predictable URI structures that are
		consistent with other core URIs, and increases the chances of code being forward compatible.
	</p>
	<div class="titleBar">
		<h3>Non-Parameterized</h3>
	</div>
	<p>
		The non-parameterized way of matching and building URIs is the most simple strategy available. The route-path is matched directly
		to an action name; ie, a 1-to-1 mapping of route-path to the actions in your Controller. This is the default setup for many popular
		MVC frameworks, including CodeIgniter and Symfony.
	</p>
<?php _php(<<<TEXT
class HelloWorld_Route_Prefix_Hello implements XenForo_Route_Interface
{
	/**
	 * Match a specific route for an already matched prefix.
	 * @see XenForo_Route_Interface::match()
	 */
	public function match(\$routePath, Zend_Controller_Request_Http \$request, XenForo_Router \$router)
	{
		return \$router->getRouteMatch('HelloWorld_ControllerPublic_Hello', \$routePath, 'forums');
	}
}
TEXT
)?>
	<p>
		This one-liner in the <code>match()</code> method instructs the router to create a new Route Match object storing our controller name:
		<code>HelloWorld_ControllerPublic_Hello</code>, Action name: <code>$routePath</code> and the Major Section: <code>forums</code>.
		Setting the major section to <code>forums</code> selects the "Forums" navigation tab when viewing this page.
	</p>
	<p>
		Notice that we've not implemented the <code>buildLink()</code> method in the Route Class above. Absence of a <code>buildLink()</code>
		method directs the link building process to fall back to a non-parameterized URI anyway; so implementing <code>buildLink()</code>
		in this class would be redundant.
	</p>
	<table width="100%">
		<tr class="muted">
			<td width="50%"><strong>URI</strong></td>
			<td width="50%"><strong>Controller/Action Called</strong></td>
		</tr>
		<tr>
			<td><code>http://127.0.0.1/xenforo/hello/</code></td>
			<td><code>HelloWorld_ControllerPublic_Hello::actionIndex()</code></td>
		</tr>
		<tr>
			<td><code>http://127.0.0.1/xenforo/hello/world</code></td>
			<td><code>HelloWorld_ControllerPublic_Hello::actionWorld()</code></td>
		</tr>
	</table>
	<table width="100%">
		<tr class="muted">
			<td width="50%"><strong>Link Builder</strong></td>
			<td width="50%"><strong>URI Generated</strong></td>
		</tr>
		<tr>
			<td><code>XenForo_Link::buildPublicLink('hello')</code></td>
			<td><code>hello/</code></td>
		</tr>
		<tr>
			<td><code>XenForo_Link::buildPublicLink('hello/index')</code></td>
			<td><code>hello/</code></td>
		</tr>
		<tr>
			<td><code>XenForo_Link::buildPublicLink('hello/world')</code></td>
			<td><code>hello/world</code></td>
		</tr>
	</table>
	<div class="titleBar">
		<h3>Integer Parameter</h3>
	</div>
	<p>
		Using this strategy, you can match and build URI paths that include an integer parameter. Matching of such paths is done
		with the help of <code>resolveActionWithIntegerParam()</code> method of the Router. This method extracts an integer parameter
		from the route path, and inserts it into the Request object with the supplied parameter name.
	</p>
<?php _php(<<<TEXT
public function resolveActionWithIntegerParam(\$routePath, Zend_Controller_Request_Http \$request, \$paramName)
TEXT
)?>
	<p>
		After extraction, this method returns the modified route path, which would usually contain the action name.
	</p>
<?php _php(<<<TEXT
class HelloWorld_Route_Prefix_Hello implements XenForo_Route_Interface
{
	/**
	 * Match a specific route for an already matched prefix.
	 * @see XenForo_Route_Interface::match()
	 */
	public function match(\$routePath, Zend_Controller_Request_Http \$request, XenForo_Router \$router)
	{
		\$action = \$router->resolveActionWithIntegerParam(\$routePath, \$request, 'user_id');
		return \$router->getRouteMatch('HelloWorld_ControllerPublic_Hello', \$action, 'forums');
	}

	/**
	 * Method to build a link to the specified page/action with the provided data and params.
	 * @see XenForo_Route_BuilderInterface::buildLink()
	 */
	public function buildLink(\$originalPrefix, \$outputPrefix, \$action, \$extension, \$data, array &\$extraParams)
	{
		return XenForo_Link::buildBasicLinkWithIntegerParam(\$outputPrefix, \$action, \$extension, \$data, 'user_id', 'username');
	}
}
TEXT
)?>
	<div class="titleBar">
		<h3>String Parameter</h3>
	</div>
	<p>

	</p>
	<div class="titleBar">
		<h3>Integer or String Parameter</h3>
	</div>
	<p>

	</p>
	<div class="titleBar">
		<h3>Page Numbers</h3>
	</div>
	<p>

	</p>