	<div class="titleBar">
		<h1>Controller Layer</h1>
	</div>
	<p>
		The controller layer is responsible for handling the Request and sending an appropriate Response. In XenForo, this layer is further
		broken down into two sub-layers: Front Controller and Controller Actions. Every request to the application gets passed to the
		Front Controller. It then decides which "Controller" and it's "Action" to call, using a Router. Upon getting a response from the
		Controller, the Front Controller renders a View and sends it to the browser.
	</p>
	<p class="importantMessage"><em>
		The methods described in "Front Controller" might not be useful for an addon developer. Manipulating a Front Controller or Dependency class
		is not something you would do on a regular basis. If you are not interested in knowing the internals of XenForo Framework,
		you can safely skip to the next sub-topic: <strong>The Controller</strong>.
	</em></p>
	<ul>
		<li>
			<p><strong><a href="./?page=front-controller">Front Controller</a></strong></p>
			<ul class="condensed columns c50_50">
				<li class="columnContainer c1">Introduction</li>
				<li class="columnContainer c2">Dependency Objects</li>
				<li class="columnContainer c1">Injecting Request &amp; Response Objects</li>
				<li class="columnContainer c2">Dispatching a Request</li>
				<li class="columnContainer c1">Rendering a ControllerResponse</li>
			</ul>
		</li>
		<li>
			<p><strong><a href="./?page=controller">The Controller</a></strong></p>
			<ul class="condensed columns c50_50">
				<li class="columnContainer c1">Introduction</li>
				<li class="columnContainer c2">Base Controller Classes</li>
				<li class="columnContainer c1">Pre-Dispatch &amp; Post-Dispatch</li>
				<li class="columnContainer c2">URL Canonicalization</li>
				<li class="columnContainer c1">Building Links</li>
				<li class="columnContainer c2">Returning a Response</li>
				<li class="columnContainer c1">Throwing an Exception</li>
				<li class="columnContainer c2">Using Helpers</li>
				<li class="columnContainer c1">Handling POST Requests</li>
				<li class="columnContainer c2">Convenient Data-Handling Methods</li>
			</ul>
		</li>
		<li>
			<p><strong><a href="./?page=controller-response">Controller Response</a></strong></p>
			<ul class="condensed columns c50_50">
				<li class="columnContainer c1">Introduction</li>
				<li class="columnContainer c2">Error Response</li>
				<li class="columnContainer c1">Exception Response</li>
				<li class="columnContainer c2">Message Response</li>
				<li class="columnContainer c1">Redirect Response</li>
				<li class="columnContainer c2">Reroute Response</li>
				<li class="columnContainer c1">View Response</li>
			</ul>
		</li>
		<li>
			<p><strong><a href="./?page=controller-helper">Controller Helpers</a></strong></p>
			<ul class="condensed columns c50_50">
				<li class="columnContainer c1">Introduction</li>
				<li class="columnContainer c2">User-Account Helper</li>
				<li class="columnContainer c1">User-Profile Helper</li>
				<li class="columnContainer c2">WYSIWYG Editor Helper</li>
				<li class="columnContainer c1">Forum/Thread/Post Helper</li>
				<li class="columnContainer c2">XML File Helper</li>
			</ul>
		</li>
		<li>
			<p><strong><a href="./?page=input-handling">Input Handling</a></strong></p>
			<ul class="condensed columns c50_50">
				<li class="columnContainer c1">Introduction</li>
				<li class="columnContainer c2">Data Types</li>
				<li class="columnContainer c1">Filtering Request Parameters</li>
				<li class="columnContainer c2">Filtering Other Data</li>
				<li class="columnContainer c1">Custom Validators</li>
				<li class="columnContainer c2">File Uploads</li>
			</ul>
		</li>
	</ul>
	<div class="titleBar">
		<h2>Suggested Readings</h2>
	</div>
	<ul>
		<li>
			<a href="http://framework.zend.com/manual/en/zend.controller.request.html">Zend_Controller_Request_Http</a><br />
			<em class="muted">The Request class from Zend Framework that is used by XenForo in its Controller Layer.</em>
		</li>
		<li>
			<a href="http://framework.zend.com/manual/en/zend.controller.response.html">Zend_Controller_Response_Http</a><br />
			<em class="muted">The Response class from Zend Framework that is used by XenForo in its Controller Layer.</em>
		</li>
	</ul>