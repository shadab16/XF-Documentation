	<div class="titleBar">
		<h1>Front Controller</h1>
	</div>
	<p>
		Each request to a frontend page gets forwarded to the index.php file. This file, apart from setting up the Autoloader and Application
		Registry, initializes a front controller (XenForo_FrontController) object and calls the <code>run()</code> method on it.
	</p>
<?php _php(<<<TEXT
\$fc = new XenForo_FrontController(new XenForo_Dependencies_Public());
\$fc->run();
TEXT
)?>
	<p>
		This initiates a sequence of events outlined below:
	</p>
	<ol>
		<li>The Request (Zend_Controller_Request_Http) and Response (Zend_Controller_Response_Http) objects are created.</li>
		<li>
			Shared Data, available throughout the application, is preloaded using the dependency object passed to the Front Controller.
			For example: application settings, content types, languages, styles, route prefixes.
		</li>
		<li class="muted">
			Code Event fired: <strong>front_controller_pre_route</strong>
		</li>
		<li>
			The Request object is passed to the Router (XenForo_Router), which matches the URL to a Controller+Action pair.
			The matched rule is returned to the Front Controller in the form of a Route Match (XenForo_RouteMatch) object.
		</li>
		<li class="muted">
			Code Event fired: <strong>front_controller_pre_dispatch</strong>
		</li>
		<li>
			The Front Controller then dispatches the request to the matched Controller and Action. The action returns a response in the form
			of a ControllerResponse (XenForo_ControllerResponse_Abstract) object. This object contains the View classname, the Template name,
			and the parameters that would be passed to the View.
		</li>
		<li class="muted">
			Code Event fired: <strong>front_controller_pre_view</strong>
		</li>
		<li>
			Acting upon the response returned by Controller, the Front Controller now renders the View using the View class (if it exists)
			and the Template (if specified in the ControllerResponse).
		</li>
		<li class="muted">
			Code Event fired: <strong>front_controller_post_view</strong>
		</li>
		<li>
			The rendered view is returned as a string to the Front Controller. This string is compressed using gzip (if available on the server),
			and then output to the browser.
		</li>
	</ol>
	<div class="titleBar">
		<h2>Dependency Objects</h2>
	</div>
	<p>
		The class constructor takes 1 argument of type XenForo_Dependencies_Abstract. 3 dependency classes are present in the library:
		XenForo_Dependencies_Public (for publicly accessible pages), XenForo_Dependencies_Admin (for the admin panel), and
		XenForo_Dependencies_Install (for the installer/upgrade process).
	</p>
	<p>
		The dependency object is used by the Front Controller for preloading data for use from anywhere inside the application and
		for delegating various tasks like getting a RouteMatch object corresponding to a Request object, creating a template object,
		etc.
	</p>
	<p>
		./index.php
	</p>
<?php _php(<<<TEXT
\$fc = new XenForo_FrontController(new XenForo_Dependencies_Public());
TEXT
)?>
	<p>
		./admin.php
	</p>
<?php _php(<<<TEXT
\$fc = new XenForo_FrontController(new XenForo_Dependencies_Admin());
TEXT
)?>
	<p>
		./install/index.php
	</p>
<?php _php(<<<TEXT
\$fc = new XenForo_FrontController(new XenForo_Dependencies_Install());
TEXT
)?>
	<div class="titleBar">
		<h2>Injecting Request &amp; Response Objects</h2>
	</div>
	<p>
		If the Request and Response objects are not injected into the Front Controller object, it creates these two objects automatically
		for itself. This happens when the <code>setup()</code> method is called (either internally or publicly). If you want the
		Front Controller to use your already-created request and/or response objects, you'll have to pass them to the Front Controller using
		<code>setRequest()</code> and <code>setResponse()</code> methods.
	</p>
	<p>
		These methods expect an object of type <code>Zend_Controller_Request_Http</code>, and <code>Zend_Controller_Response_Http</code>
		respectively.
	</p>
	<p>
		In the example given below, <code>$request</code> needs to be of type Zend_Controller_Request_Http. This might be useful if you have
		a custom Request class that extends from Zend_Controller_Request_Http and need to use it in the XenForo Framework.
	</p>
<?php _php(<<<TEXT
\$fc->setRequest(\$request);
TEXT
)?>
	<p>
		The $response object needs to be of type Zend_Controller_Response_Http. Same as the setRequest() method, this would only be useful
		if you have a custom response class extending from Zend_Controller_Request_Http.
	</p>
<?php _php(<<<TEXT
\$fc->setResponse(\$response);
TEXT
)?>
	<div class="titleBar">
		<h2>Dispatching a Request</h2>
	</div>
	<p>
		The dispatching of a request is done by the <code>dispatach()</code> method. It takes in an object of type <code>XenForo_RouteMatch</code>,
		and calls the Controller/Action pair specified in the RouteMatch object, which returns a controller-response object. This object
		in turn is returned by the <code>dispatach()</code> method.
	</p>
<?php _php(<<<TEXT
/*
 * \$routeMatch would contain the Controller/Action pair
 *
 * For example:
 * \$routeMatch = new XenForo_RouteMatch('Foo_Bar_Controller', 'myaction');
 */

\$controllerResponse = \$fc->dispatch(\$routeMatch);
TEXT
)?>
	<div class="titleBar">
		<h2>Rendering a ControllerResponse</h2>
	</div>
	<p>
		Rendering of View returned by a Controller in the form of a ControllerResponse is done by the <code>renderView()</code> method
		using a ViewRenderer. The ViewRenderer contains different methods for rendering different types of ControllerResponses. This
		method takes 2 parameters of type: XenForo_ControllerResponse_Abstract and XenForo_ViewRenderer_Abstract; and an optional
		3<sup>rd</sup> parameter: an array of key-value pairs to be used when rendering a "container" View.
	</p>
	<div class="titleBar">
		<h2>Return Output as a String</h2>
	</div>
	<p>
		<code>setSendResponse()</code> method takes 1 argument of boolean type. This internally sets a flag which is used to determine
		if the rendered output should be sent to the browser or returned as a string by the XenForo_FrontController::run() method.
		The default value of this flag is <code>true</code>.
	</p>
	<p>
		Sample usage:
	</p>
<?php _php(<<<TEXT
\$fc = new XenForo_FrontController(new XenForo_Dependencies_Public());
\$fc->setSendResponse(false);

\$output = \$fc->run(); // will return the rendered view instead of echo'ing it.
TEXT
)?>
	<div class="titleBar">
		<h2>Method Summary</h2>
	</div>
	<table width="100%">
		<tr class="muted">
			<td width="30%"><strong>Method Name</strong></td>
			<td width="40%"><strong>What it does?</strong></td>
			<td width="30%"><strong>Return Data-type</strong></td>
		</tr>
		<tr>
			<td>getRequest()</td>
			<td>Returns the request object.</td>
			<td>Zend_Controller_Request_Http</td>
		</tr>
		<tr>
			<td>getResponse()</td>
			<td>Returns the response object.</td>
			<td>Zend_Controller_Response_Http</td>
		</tr>
		<tr>
			<td>getDependencies()</td>
			<td>Returns the dependency object that was supplied to the class constructor.</td>
			<td>XenForo_Dependencies_Abstract</td>
		</tr>
		<tr>
			<td>setup()</td>
			<td>Instantiates the internal Request and Response objects.</td>
			<td class="muted">void</td>
		</tr>
		<tr>
			<td>setRequestPaths()</td>
			<td>Sets the "requestPaths" key in the Application Registry. setup() needs to be called before this.</td>
			<td class="muted">void</td>
		</tr>
		<tr>
			<td>route()</td>
			<td>Performs routing and returns the Controller+Action pair. setup() needs to be called before this.</td>
			<td>XenForo_RouteMatch</td>
		</tr>
	</table>