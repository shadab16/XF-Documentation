	<div class="titleBar">
		<h1>Controller Response</h1>
	</div>
	<p>
		When an action in a controller is done with the processing, it has to return a "response" to the Front Controller.
		This response is in the form of a "Controller Response" object, which contains either the text itself or a View name &amp; Template
		name which can be rendered to obtain the output. Optionally, an array of parameters (key-value pairs) is passed which can be
		used by the View/Template when rendering the output.
	</p>
	<p>
		The base controller class contains methods for conveniently creating an object of each of the response type.
	</p>
	<div class="titleBar">
		<h2>View Response</h2>
	</div>
	<p>
		<code>XenForo_ControllerResponse_View</code>: <em>View controller response.
		This should be used when there is advanced behavior that needs to be handled to render the page.</em>
	</p>
	<p>
		<strong>Class Properties:</strong>
	</p>
	<table width="70%">
		<tr>
			<td width="30%">View Name:</td>
			<td width="70%">Name of the View class which would be used for rendering the View.</td>
		</tr>
		<tr>
			<td>Template Name:</td>
			<td>Name of the Template which stores the html markup.</td>
		</tr>
		<tr>
			<td>View Parameters:</td>
			<td>Parameters to be passed to the View/Template.</td>
		</tr>
		<tr>
			<td>Container Parameters:</td>
			<td>Parameters to be used for rendering the Page Container (wrapper).</td>
		</tr>
	</table>
	<p>
		The view reponse is the most commonly used "Controller Response". When constructing this response a View class and a Template name
		is specified; and optionally parameters are passed to the View layer. The "View Parameters" are used when rendering the
		View/Template; while the "Container Parameters" are used when rendering the page wrapper. This page container consists of
		Header, Footer and Navigation areas.
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Controller1 extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		return \$this->responseView('HelloWorld_ViewPublic_Hello', 'helloworld_view');
	}
}
TEXT
)?>
	<p>
		If the specified view class "HelloWorld_ViewPublic_Hello" does not exist, the base View class
		(<code>XenForo_ViewPublic_Base</code>, for public pages) is implicitly used in its place.
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Controller1 extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		// Parameters for 'HelloWorld_ViewPublic_Hello' & 'helloworld_view'
		\$viewParams = array(
			'var1' => 'Foo',
			'var2' => 'Bar'
		);

		// Parameters for the page container
		\$containerParams = array(
			'varA' => 'Baz'
		);

		return \$this->responseView(
			'HelloWorld_ViewPublic_Hello', 'helloworld_view', \$viewParams, \$containerParams
		);
	}
}
TEXT
)?>
	<div class="titleBar">
		<h2>Message Response</h2>
	</div>
	<p>
		<code>XenForo_ControllerResponse_Message</code>: <em>General message page controller response.
		Use this for really basic pages that just want to display a message of some sort, with no template/view.</em>
	</p>
	<p>
		<strong>Class Properties:</strong>
	</p>
	<table width="70%">
		<tr>
			<td width="30%">Message:</td>
			<td width="70%">The message to be displayed.</td>
		</tr>
	</table>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Controller1 extends XenForo_ControllerPublic_Abstract
{
	public function actionFoo()
	{
		return \$this->responseMessage('Your Text Here');
	}
}
TEXT
)?>
	<p>
		Returning a message response completely bypasses the View layer. This can be useful when you want to quickly test
		that a controller is fetching the correct data, but have not yet developed the View/Template to display it.
	</p>
	<div class="titleBar">
		<h2>Redirect Response</h2>
	</div>
	<p>
		<code>XenForo_ControllerResponse_Redirect</code>: <em>Redirect controller response. This indicates that we want to
		externally redirect the user to another page. Depending on the output type, this may not actually redirect.
		This may tell the user that we created the resource and give them the URL.</em>
	</p>
	<p>
		<strong>Class Properties:</strong>
	</p>
	<table width="70%">
		<tr>
			<td width="30%">Redirect Type:</td>
			<td width="70%">
				One of the following class constants:
				<ul class="condensed">
					<li><code>RESOURCE_CREATED</code></li>
					<li><code>RESOURCE_UPDATED</code></li>
					<li><code>RESOURCE_CANONICAL</code></li>
					<li><code>RESOURCE_CANONICAL_PERMANENT</code></li>
					<li><code>SUCCESS</code></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>Redirect Target:</td>
			<td>The target URL to which the user might be redirected.</td>
		</tr>
		<tr>
			<td>Redirect Message:</td>
			<td>Optional message to be displayed. <br /><em>(Used only when rendered as XML or JSON)</em></td>
		</tr>
		<tr>
			<td>Redirect Parameters:</td>
			<td>Optional parameters to be returned with the response. <br /><em>(Used only when rendered as XML or JSON)</em></td>
		</tr>
	</table>
	<p>
		The explanation for each Redirect Type is given in the API page for XenForo_ControllerResponse_Redirect class:
		<a href="./api/XenForo_Mvc/XenForo_ControllerResponse_Redirect.html#class_constss">XenForo_ControllerResponse_Redirect - Class Constants</a>.
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Controller1 extends XenForo_ControllerPublic_Abstract
{
	public function actionFoo()
	{
		// Process the request

		// Then redirect user to the forum index

		\$type = XenForo_ControllerResponse_Redirect::SUCCESS;
		\$url = \$this->_buildLink('index');

		return \$this->responseRedirect(\$type, \$url);
	}
}
TEXT
)?>
	<p>
		The Redirect Message and extra Parameters are only sent to the client when the response type is either XML or JSON.
		If the form being submitted is classed as "AutoValidator", the redirect message will be displayed in a slide-down fashion.
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Controller1 extends XenForo_ControllerPublic_Abstract
{
	public function actionFoo()
	{
		// Process the request

		return \$this->responseRedirect(
			XenForo_ControllerResponse_Redirect::SUCCESS, // Successfully processed
			\$this->_buildLink('index'),                   // Redirect to Forum Index
			'Foo has been saved successfully!'            // Message to show to the end user
		);
	}
}
TEXT
)?>
	<p>
		<img class="illustration" src="./resources/controller_4.png" />
	</p>
	<div class="titleBar">
		<h2>Reroute Response</h2>
	</div>
	<p>
		<code>XenForo_ControllerResponse_Reroute</code>: <em>Reroute controller response.
		This will cause the request to internally be redirected to the named controller/action.
		The user will not be made aware of this redirection.</em>
	</p>
	<p>
		<strong>Class Properties:</strong>
	</p>
	<table width="70%">
		<tr>
			<td width="30%">Controller Name:</td>
			<td width="70%">The controller to which you want to forward the request.</td>
		</tr>
		<tr>
			<td>Action:</td>
			<td>Name of the specific action in that controller.</td>
		</tr>
	</table>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Controller1 extends XenForo_ControllerPublic_Abstract
{
	public function actionFoo()
	{
		// Get \$foo from somewhere

		if (\$foo === 1608)
		{
			return \$this->responseReroute('HelloWorld_ControllerPublic_Controller2', 'bar');
		}

		// Continue processing as usual
	}
}
TEXT
)?>
	<p>
		In the sample code above, if the given criteria for $foo is satisfied, the request is internally forwarded to the <code>bar</code>
		action in <code>HelloWorld_ControllerPublic_Controller2</code>. If you want to reroute to an action in the same controller,
		replace the controller name with just the constant: <code>__CLASS__</code>.
	</p>
<?php _php(<<<TEXT
return \$this->responseReroute(__CLASS__, 'baz');
TEXT
)?>
	<div class="titleBar">
		<h2>Error Response</h2>
	</div>
	<p>
		<code>XenForo_ControllerResponse_Error</code>: <em>Error page controller response. Note that this represents an expected error
		more than a server/PHP error. It should be used for generating application error pages.</em>
	</p>
	<p>
		<strong>Class Properties:</strong>
	</p>
	<table width="70%">
		<tr>
			<td width="30%">Error Text:</td>
			<td width="70%">The error to be shown to the end user.</td>
		</tr>
		<tr>
			<td>Response Code:</td>
			<td>HTTP response code. Default value is <code>200</code>.</td>
		</tr>
		<tr>
			<td>Container Parameters:</td>
			<td>Parameters to be used when rendering the page container. An empty array is passed by default.</td>
		</tr>
	</table>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Controller1 extends XenForo_ControllerPublic_Abstract
{
	public function actionFoo()
	{
		return \$this->responseError('Your Error Text Here');
	}
}
TEXT
)?>
	<p>
		<img class="illustration" src="./resources/controller_5.png" />
	</p>
	<div class="titleBar">
		<h2>Exception Response</h2>
	</div>
	<p>
		<code>XenForo_ControllerResponse_Exception</code>: <em>Class that represents a controller response via an exception.
		This type of exception is caught by the front controller and handled as if it were returned by the controller as normal.</em>
	</p>
	<p>
		<strong>Class Properties:</strong>
	</p>
	<table width="70%">
		<tr>
			<td width="30%">Controller Response:</td>
			<td width="70%">The controller response which would be wrapped with an Exception before being thrown.</td>
		</tr>
	</table>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Controller1 extends XenForo_ControllerPublic_Abstract
{
	public function actionFoo()
	{
		// \$controllerResponse

		throw \$this->responseException(\$controllerResponse);
	}
}
TEXT
)?>
	<p>
		The <code>responseException</code> method takes in a single argument of type <code>XenForo_ControllerResponse_Abstract</code>.
		So the <code>$controllerResponse</code> variable can be any of the controller response types described above:
		View, Message, Redirect, Reroute and Error. "Error Response" is the most commonly used type, though.
	</p>
	<p>
		<strong>When to use an Exception?</strong>
	</p>
	<p>
		Throw an Exception when you are not in a position to normally <code>return</code> a controller response to the Front Controller.
		If you are in any of the <code>action*()</code> methods, you can simply <code>return</code> the controller response. But that's not
		the case when you are in a non-action method; since returning any value would just transfer the control back to the "action",
		and not to the Front Controller. Throwing an exception solves this problem.
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Controller1 extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		// Get \$foo from any data source

		if (\$foo === false)
		{
			return \$this->responseError('Foo is Invalid.');
		}

		return \$this->responseView('HelloWorld_ViewPublic_Hello', 'helloworld_view');
	}
}
TEXT
)?>
	<p>
		In the code snippet shown above, error-checking is performed in the action method itself. So returning an error is quite easy.
		No exceptions are needed. But when the same error-checking is delegated to a separate method, you need to throw an exception.
	</p>
<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Controller1 extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		// Get \$foo from any data source

		\$this->_assertFooValid(\$foo);

		return \$this->responseView('HelloWorld_ViewPublic_Hello', 'helloworld_view');
	}

	protected function _assertFooValid(\$foo)
	{
		if (\$foo === false)
		{
			// Create an Error response
			\$controllerResponse = \$this->responseError('Foo is Invalid.');

			// Wrap 'n Throw
			throw \$this->responseException(\$controllerResponse);
		}
	}
}
TEXT
)?>
	<p>
		<em>Sure you can just return the Error response to <code>actionIndex</code> and have it return that response to the Front Controller.
		But this means an extra couple of lines of code for each such assertion in <code>actionIndex</code>; which would defeat the purpose
		of moving the error-checking to a separate method in the first place.</em>
	</p>