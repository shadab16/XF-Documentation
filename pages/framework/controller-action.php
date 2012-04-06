	<div class="titleBar">
		<h1>The Controller</h1>
	</div>
	<p>
		The Front Controller forwards the request to your Controller. This controller should contain the "Action" to handle the request.
		An action is just a specially named method in your Controller class, which gets called automatically depending upon the URL.
		Actions are prefixed with the word "action" and written in camelcase form.
	</p>
	<p>
		The following controller defines 2 actions: index, and list. The actions need to be <code>public</code>; any other visibility modifier
		(private, protected) prevents the Front Controller from calling that action.
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Hello extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		// Process the "index" action
	}

	public function actionList()
	{
		// Process the "list" action
	}
}
TEXT
)?>
	<p>
		Assuming a route prefix (eg. hello) has been set up as explained in the "Hello World" section; you can access the actions via URLs
		given below. When no action is specified in the URL, the <code>index</code> action is called.
	</p>
	<ul class="condensed">
		<li>http://localhost/hello/ <span class="muted">(index action called)</span></li>
		<li>http://localhost/hello/list/ <span class="muted">(list action called)</span></li>
	</ul>
	<div class="titleBar">
		<h2>Base Controller Classes</h2>
	</div>
	<p>
		Our controller class above inherits the class <code>XenForo_ControllerPublic_Abstract</code>. This is necessary for all controllers
		that handle requests to publicly accessible pages (ie, the frontend part). The abstract class contains methods which restrict
		public access in certain cases:
	</p>
	<ul>
		<li>If you are performing an upgrade, all visitors will see a "Board is currently being upgraded" message.</li>
		<li>Closed Forum: If you have explicitly closed the forum via Admin Panel.</li>
		<li>If the IP address or the logged-in User is banned; or guests don't have the permission of view anything.</li>
	</ul>
	<p>
		Just like a public controller inherits from <code>XenForo_ControllerPublic_Abstract</code>, an admin controller inherits from
		<code>XenForo_ControllerAdmin_Abstract</code>; both of which inherit from <code>XenForo_Controller</code> as shown in the graph:
	</p>
	<p>
		<img class="illustration" src="./resources/controller_1.png" />
	</p>
	<div class="titleBar">
		<h2>Pre-Dispatch &amp; Post-Dispatch</h2>
	</div>
	<p>
		If you notice that you have repetitive code at the top of every action in a Controller, you can group it in a separate protected method
		and call it in a "Pre-Dispatch" method for your Controller. Putting it in a pre-dispatch method ensures that it's called before every
		action in that particular Controller. For example:
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Hello extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		// Repetitive Code 1
		// Repetitive Code 2

		// Process the "index" action
	}

	public function actionList()
	{
		// Repetitive Code 1
		// Repetitive Code 2

		// Process the "list" action
	}
}
TEXT
)?>
	<p>
		can be refactored into:
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Hello extends XenForo_ControllerPublic_Abstract
{
	protected function _preDispatch(\$action)
	{
		// Repetitive Code 1
		// Repetitive Code 2
	}

	public function actionIndex()
	{
		// Process the "index" action
	}

	public function actionList()
	{
		// Process the "list" action
	}
}
TEXT
)?>
	<p>
		The <code>$action</code> variable passed to the _preDispatch method contains the name of the action which would be executed right
		after it. So you can selective run a piece of code in your _preDispatch method depending upon the action. And just for the record,
		the <code>$action</code> variable is <em>not</em> passed by reference to _preDispatch, so you can't change the "action" to be called.
	</p>
<?php _php(<<<TEXT
protected function _preDispatch(\$action)
{
	// Repetitive Code 1
	// Repetitive Code 2

	if (\$action !== 'Index')
	{
		// Repetitive code run for all actions except "Index"
	}
}
TEXT
)?>
	<p>
		The pre-dispatch methods are of great use for asserting certain conditions before your actions are called. The core framework classes
		make heavy use of such assertions. For example, <code>XenForo_ControllerPublic_Abstract</code> makes sure the following conditions
		are met before the control passes to your actions:
	</p>
	<p>
		<em>If any of these conditions is not met, an Exception is thrown which stops any further processing in the "Controller" layer.
		This Exception is caught at the "Front Controller" level, and is processed accordingly.</em>
	</p>
	<ul class="condensed">
		<li>Forum is not in "Upgrade" mode.</li>
		<li>Visitor's IP address is not banned.</li>
		<li>Visitor has the general viewing permission.</li>
		<li>Registered User is not banned.</li>
		<li>Forum is in "Active" mode.</li>
	</ul>
	<div class="titleBar">
		<h3>Pre-Pre-Dispatch</h3>
	</div>
	<p>
		There's another pre-dispatch method which you can implement in your concrete Controller classes: <code>_preDispatchFirst</code>.
		This method gets called before any of the other pre-dispatch methods. Think of it as a "pre-pre-dispatch". At this early point,
		the session is not set up and assertions for CSRF protection have not been made yet. To make it clear, this is the order in which
		these methods are called:
	</p>
	<ol class="condensed">
		<li>_preDispatchFirst</li>
		<li>User Session is set up.</li>
		<li>CSRF protection is enabled.</li>
		<li>Assertions by Abstract Public/Admin controller are made.</li>
		<li>_preDispatch</li>
	</ol>
	<div class="titleBar">
		<h3>Post-Dispatch</h3>
	</div>
	<p>
		Right after an action in your controller returns a response, the <strong>Post-Dispatch</strong> methods are called. Internally,
		the post-dispatch is used to finally update &amp; save the user's session information. For any similar purpose, you can implement a
		<code>_postDispatch</code> method in your Controller class, like:
	</p>
<?php _php(<<<TEXT
protected function _postDispatch(\$controllerResponse, \$controllerName, \$action)
{
	// Do any logging and/or post-processing here.
}
TEXT
)?>
	<p>
		<em>The $controllerResponse object contains the response which was just returned by the "action". The base class for this object is:
		<code>XenForo_ControllerResponse_Abstract</code>.</em>
	</p>
	<div class="titleBar">
		<h2>URL Canonicalization</h2>
	</div>
	<p>
		In XenForo, URL Canonicalization is the process which makes sure that a resource can be accessed from a single URL; redirecting
		the aliases (duplicate URLs) to the canonical URL for that resource. For example, the forum home (Forum List) has the following
		valid URLs; ...accessing any of which you get redirected to the shortest canonical URL: "/".
	</p>
	<ul class="condensed">
		<li>/</li>
		<li>/index</li>
		<li>/index/</li>
		<li>/index.html</li>
	</ul>
	<p>
		This is made possible by the <code>canonicalizeRequestUrl()</code> method. A reference URL is passed as an argument to this method,
		which is compared to the request URL of the current page. If they differ, an Exception is thrown immediately
		to redirect the user to the correct "canonical" URL.
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Hello extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		\$this->canonicalizeRequestUrl(\$this->_buildLink('hello'));

		// Process the "index" action
	}
}
TEXT
)?>
	<p>
		The above example supplies <code>canonicalizeRequestUrl()</code> with the url of the Controller/Action pair in which it's placed.
		"hello" is the route prefix and "index" (implicit) is the action name used to build the reference URL.
	</p>
	<div class="titleBar">
		<h2>Building Links</h2>
	</div>
	<p>
		If you notice the parameter being passed to canonicalizeRequestUrl(), we're not passing any hardcoded URL. The URL is dynamically built
		using the route prefix. Building links this way has an advantage of making modifications to the urls using the Routing System,
		without making any changes in the Controller Layer or the View/Template Layer.
	</p>
	<p>
		To build a link from inside the Controller, use the _buildLink() method:
	</p>
<?php _php(<<<TEXT
/*
 * Generates a relative url:
 * hello/
 */
\$url = \$this->_buildLink('hello/index');
TEXT
)?>
	<p>
		For creating an absolute URL (prefixed with the complete domain name), add "full:" before the route prefix:
	</p>
<?php _php(<<<TEXT
/*
 * Generates an absolute url:
 * http://localhost/xenforo/hello/
 */
\$url = \$this->_buildLink('full:hello/index');
TEXT
)?>
	<p>
		If you have a route which expects some external data to build a link, you'll need to pass that data as the 2<sup>nd</sup> parameter
		of _buildLink(). This parameter, if specified, needs to be an array of key-value pairs.
	</p>
	<p>
		Suppose you have a <code>$thread</code> array which contains the usual array keys of a thread: thread_id, title, etc.
		To create a link for that thread, just pass the $thread variable to _buildLink() method as shown below:
	</p>
<?php _php(<<<TEXT
/*
 * [thread_id] => 16
 * [title]     => The Thread Title ...!!!
 *
 * Generates an absolute url: http://localhost/xenforo/threads/the-thread-title.16/
 */
\$url = \$this->_buildLink('full:threads', \$thread);
TEXT
)?>
	<p>
		As you can see, the thread Title has been normalized and all punctuation removed to make it clean. If you have the
		"Include Content Title in URLs" setting disabled via Admin Panel, the URL generated will not include the thread title:
	</p>
	<p>
		<code>http://localhost/xenforo/threads/16/</code>
	</p>
	<div class="titleBar">
		<h2>Returning a Response</h2>
	</div>
	<p>
		After an action is done with the processing, it should return a response back to the front controller. This response is usually
		in the form of a "Controller Response" object, of type <code>XenForo_ControllerResponse_Abstract</code>.
	</p>
	<p>
		There are 6 concrete ControllerResponse classes, 5 of which inherit from <code>XenForo_ControllerResponse_Abstract</code>, and 1 inherits
		from <code>Exception</code>. Of all these classes, <code>XenForo_ControllerResponse_View</code> is the most widely used.
	</p>
	<p>
		Each one of these class have a corresponding <code>responseX()</code> method in the base Controller, which helps in creating the
		ControllerResponse object and setting up the appropriate object properties. Here's an example which returns a "View" classname,
		and a Template to be rendered, without specifying any View Parameters.
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Hello extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		// Process the "index" action

		return \$this->responseView('HelloWorld_ViewPublic_Hello', 'helloworld_view');
	}
}
TEXT
)?>
	<p>
		Data can be passed to the View layer using "View Parameters", which is just an array of variable names &amp; variable values passed
		as the 3<sup>rd</sup> argument for <code>responseView()</code> method.
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Hello extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		// Set the parameters to pass to the View layer
		\$viewParams = array(
			'myVar' => 16,
			'foo'   => 'Shadab',
			'bar'   => 8
		);

		return \$this->responseView('HelloWorld_ViewPublic_Hello', 'helloworld_view', \$viewParams);
	}
}
TEXT
)?>
	<p>
		These parameters can be accessed in the View layer using this format:
	</p>
	<table width="70%">
		<tr>
			<td width="30%">In the View Class:</td>
			<td><code>$this-&gt;_params['myVar']</code></td>
		</tr>
		<tr>
			<td>In the Template:</td>
			<td><code>{$myVar}</code></td>
		</tr>
	</table>
	<div class="titleBar">
		<h2>Throwing an Exception</h2>
	</div>
	<p>
		Throwing an Exception of type <code>XenForo_ControllerResponse_Exception</code> is the quickest and guaranteed way
		for any method to halt further processing in an action and return a ControllerResponse object immediately to the front controller.
		This exception is most commonly used in combination with <code>XenForo_ControllerResponse_Error</code> to return "errors".
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Hello extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		\$foo = 0;

		// Get \$foo from DB, Cache, Request Parameter or any other source
		// \$foo = 101;

		\$this->_assertFooValid(\$foo);

		return \$this->responseView('HelloWorld_ViewPublic_Hello', 'helloworld_view');
	}

	protected function _assertFooValid(\$foo)
	{
		if (\$foo < 0 || \$foo > 100)
		{
			// Ideally, this error "text" should come from a Phrase
			\$error = 'Foo is Invalid.';

			throw \$this->responseException(\$this->responseError(\$error));
		}
	}
}
TEXT
)?>
	<p>
		Given above is a very simplified use-case for <code>XenForo_ControllerResponse_Error</code> (created by responseError() method),
		and <code>XenForo_ControllerResponse_Exception</code> (created by responseException() method).
	</p>
	<p>
		If the value of $foo is valid (0 &lt;= $foo &lt;= 100), our assertion "_assertFooValid" does nothing and lets the index action
		return a response normally. But in case the value of $foo is out of range, an error response is created. But returning it back to
		actionIndex() would do no good. We have to return it back to the Front Controller.
	</p>
	<p>
		So we "wrap" our Error-Response with an Exception-Response and THROW this exception. The front controller CATCHES the exception,
		unwraps it to find an Error-Response and continues normally to render it.
	</p>
	<p>
		<img class="illustration" src="./resources/controller_2.png" />
	</p>
	<div class="titleBar">
		<h2>Using Controller-Helpers</h2>
	</div>
	<p>
		A controller-helper class contains methods that are designed to be reused across multiple controllers. These methods can be used to
		simplify a lot of repetitive tasks in multiple controllers.
	</p>
	<p>
		By default there are 6 helpers available in <code>/library/XenForo/ControllerHelper/</code>.
		All the helpers extend from a common base class: <code>XenForo_ControllerHelper_Abstract</code>.
		To fetch a helper, use the <code>getHelper()</code> method passing the helper name as an argument.
	</p>
<?php _php(<<<TEXT
public function actionIndex()
{
	// Same as getHelper('XenForo_ControllerHelper_Xml')
	\$xmlHelper = \$this->getHelper('Xml');

	// Process the "index" action
}
TEXT
)?>
	<p>
		If you are fetching any of the XenForo_ControllerHelper_XYZ helpers, you need not pass the "XenForo_ControllerHelper_" part.
		Just calling getHelper('XYZ') will work fine.
	</p>
	<div class="titleBar">
		<h2>Handling POST Requests</h2>
	</div>
	<p>
		POST Requests are handled just like a GET Request. There are two methods available in the parent XenForo_Controller class to help
		with handling POST Requests in controller actions: <code>_assertPostOnly()</code> and <code>isConfirmedPost()</code>.
	</p>
	<div class="titleBar">
		<h3>_assertPostOnly()</h3>
	</div>
	<p>
		Calling this method makes sure that the current request is coming from a submitted form, and not directly accessible via a plain GET
		request. If the assertion fails, an Exception <em>(ResponseError wrapped in ResponseException)</em> is thrown.
	</p>
<?php _php(<<<TEXT
public function actionIndex()
{
	\$this->_assertPostOnly();

	// Process the "index" action
}
TEXT
)?>
	<p>
		<img class="illustration" src="./resources/controller_3.png" />
	</p>
	<div class="titleBar">
		<h3>isConfirmedPost()</h3>
	</div>
	<p>
		This method makes sure that the current request is a POST request and that a parameter "_xfConfirm" is set to "1" (true).
		It's useful when you want the user to confirm the form submission before proceeding with any critical action.
		XenForo uses this same procedure when, for example, the user clicks a "Mark Forum Read" link or tries to "Unwatch" a thread.
	</p>
	<p>
		Heres some sample code which confirms the deletion of a "foo" entity (key: foo_id) before deleting it.
	</p>
<?php _php(<<<TEXT
public function actionDelete()
{
	\$fooId = \$this->_input->filterSingle('foo_id', XenForo_Input::UINT);

	if (\$this->isConfirmedPost())
	{
		// Delete FOO with the id of 'foo_id'

		\$url = \$this->_buildLink('hello/index');
		return \$this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, \$url);
	}
	else
	{
		// Confirm the action

		\$viewParams = array(
			'fooId' => \$fooId
		);

		return \$this->responseView('HelloWorld_ViewPublic_Delete', 'foo_delete', \$viewParams);
	}
}
TEXT
)?>
	<p>
		The form in the template used for confirmation (foo_delete) should contain "_xfConfirm" as a hidden field
		to indicate the confirmation:
	</p>
<?php _html(<<<TEXT
<input type="hidden" name="_xfConfirm" value="1" />
TEXT
)?>
	<div class="titleBar">
		<h2>Convenient Data-Handling Methods</h2>
	</div>
	<p>
		<code>&lt;!-- TODO --&gt;</code>
	</p>
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
			<td>Zend_Controller_Response_Http</td>
		</tr>
		<tr>
			<td>getInput()</td>
			<td>Returns the Input Filtering object.</td>
			<td>XenForo_Input</td>
		</tr>
		<tr>
			<td>getResponseType()</td>
			<td>Returns the type of response.</td>
			<td>string</td>
		</tr>
		<tr>
			<td>getRouteMatch()</td>
			<td>Gets the route-match object for the current request.</td>
			<td>XenForo_RouteMatch</td>
		</tr>
	</table>