	<div class="titleBar">
		<h1>Hello-World Addon</h1>
	</div>
	<p>
		As with everything else related to programming, we'll start with a little 'Hello World' addon. This would help get you familiarized
		with the framework fundamentals; like creating a route, controller, view, template and phrase. Just the basics are covered here. For
		detailed explanations and advanced usage, check the respective sections.
	</p>
	<p class="importantMessage"><em>
		Before you begin... Make sure you have enabled the <strong><a href="#">Debug Mode</a></strong>.
	</em></p>
	<div class="titleBar">
		<h2>What Do We Want?</h2>
	</div>
	<p>
		We'll be creating a page accessible from the <code>./hello/</code> url. This page would output the text 'Hello World' wrapped with a
		standard page container (header, navigation &amp; footer). We'll be putting all our class files in <code>/library/HelloWorld/</code>,
		and because of the way autoloading works, our class names will be prefixed with <code>HelloWorld_</code>.
	</p>
	<div class="titleBar">
		<h2>The Controller</h2>
	</div>
	<p>
		Create file <code class="muted">/library/HelloWorld/ControllerPublic/Hello.php</code>
	</p>
	<?php _php(<<<TEXT
class HelloWorld_ControllerPublic_Hello extends XenForo_ControllerPublic_Abstract
{
	public function actionIndex()
	{
		return \$this->responseView('HelloWorld_ViewPublic_Hello');
	}
}
TEXT
) ?>
	<p>
		Here we are creating a new controller and defining 1 action. The <code>index</code> action is a bit special. It works similar
		to how a <code>index.php</code> or <code>index.html</code> file in a directory work. If there is no action specified,
		while calling the controller, the default action (index) gets called automatically.
	</p>
	<p>
		Our <code>index</code> action, for now, does nothing but returns a View as a response.
	</p>
	<div class="titleBar">
		<h2>The View</h2>
	</div>
	<p>
		Create file <code class="muted">/library/HelloWorld/ViewPublic/Hello.php</code>
	</p>
	<?php _php(<<<TEXT
class HelloWorld_ViewPublic_Hello extends XenForo_ViewPublic_Base
{
	public function renderHtml()
	{
		return '<p>Hello World!</p>';
	}
}
TEXT
)?>
	<p>
		Our View class consists of a <code>renderHtml()</code> method, which returns the desired text. Since our View doesn't utilize
		any 'template' at this point, we'll just have to <code>return</code> the HTML code that we want to display.
	</p>
	<div class="titleBar">
		<h2>Route Prefix</h2>
	</div>
	<p>
		Now that our Controller &amp; View are in place, we'll need to tell XenForo how to map the <code>./hello/</code> URL to our controller.
		This is achieved by creating and registering a Route Prefix.
	</p>
	<p>
		Create file: <code class="muted">/library/HelloWorld/Route/Prefix/Hello.php</code>
	</p>
	<?php _php(<<<TEXT
class HelloWorld_Route_Prefix_Hello implements XenForo_Route_Interface
{
	public function match(\$routePath, Zend_Controller_Request_Http \$request, XenForo_Router \$router)
	{
		return \$router->getRouteMatch(
			'HelloWorld_ControllerPublic_Hello', \$routePath, 'forums'
		);
	}
}
TEXT
)?>
	<p>
		This creates a route which is used to forward the request to your controller (HelloWorld_ControllerPublic_Hello).
		Next, you'll have to register this Route Prefix with XenForo via the Admin Panel.
	</p>
	<p>
		Go to: Admin Panel &raquo; Development &raquo; Route Prefixes &raquo; Create New Route Prefix.
		Enter the following values and save.
	</p>
	<table width="70%">
		<tr>
			<td width="30%">Route Prefix:</td>
			<td>hello</td>
		</tr>
		<tr>
			<td>Route Type:</td>
			<td>Public</td>
		</tr>
		<tr>
			<td>Route Class:</td>
			<td>HelloWorld_Route_Prefix_Hello</td>
		</tr>
	</table>
	<div class="titleBar">
		<h2>Preview&hellip;</h2>
	</div>
	<p>
		Assuming you have your forum installed at: http://127.0.0.1/xenforo/; you can now visit:
		http://127.0.0.1/xenforo/index.php?hello/ or if you have enabled friendly urls: http://127.0.0.1/xenforo/hello/
	</p>
	<p>
		You'll see the output <i>Hello World!</i> wrapped within the standard page container.
	</p>
	<p>
		<img class="illustration" src="./resources/hello_world_1.png" />
	</p>
	<p>
		This is the desired output. But we are not done yet! Hardcoding the html &amp; text strings in the View file is not the ideal way
		of developing an addon. We'll now move the HTML to a "template" and the text to a separate "phrase"...
	</p>
	<div class="titleBar">
		<h2>Template</h2>
	</div>
	<p>
		Go to: Admin Panel &raquo; Appearance &raquo; Templates. Make sure the <em>Master Style</em> is selected, and then
		<em>Create New Template</em>. Enter the following values and save.
	</p>
	<table width="70%">
		<tr>
			<td width="30%">Template Name:</td>
			<td>helloworld_view</td>
		</tr>
		<tr>
			<td>Template HTML:</td>
			<td><?php _html(<<<TEXT
<p>{xen:phrase hello_world}</p>
TEXT
) ?></td>
		</tr>
	</table>
	<p>
		This creates a new template "helloworld_view" which we can use in the View layer. Now lets go back to the <b>Controller</b> and change
		the return statement to reference this new template we have created:
	</p>
	<?php _php(<<<TEXT
return \$this->responseView('HelloWorld_ViewPublic_Hello', 'helloworld_view');
TEXT
) ?>
	<p>
		And since we have moved our html to the template, we can remove the hardcoded html from the View file.
		Change the return statement in the View file to this:
	</p>
	<?php _php(<<<TEXT
return null;
TEXT
) ?>
	<p>
		At this point, the View file (/ViewPublic/Hello.php) can be removed completely without breaking any functionality;
		since we are not doing any processing in that file. This is explained in detail in the "View Layer" section.
	</p>
	<div class="titleBar">
		<h2>Phrase</h2>
	</div>
	<p>
		Notice the <code>xen:phrase</code> construct in the template we have just created. This construct is used to fetch a phrase
		from the Language/Phrase system of XenForo. Using the Phrasing system has its own benefits... the end-user can change the
		text easily without editing any template, multiple translations can be provided for the phrases, and a single phrase can be reused
		in multiple locations.
	</p>
	<p>
		Go to: Admin Panel &raquo; Appearance &raquo; Phrases. Make sure the <em>Master Language</em> is selected, and then
		<em>Create New Phrase</em>. Enter the following values and save.
	</p>
	<table width="70%">
		<tr>
			<td width="30%">Title:</td>
			<td>hello_world</td>
		</tr>
		<tr>
			<td>Phrase text:</td>
			<td>Hello World!</td>
		</tr>
	</table>
	<div class="titleBar">
		<h2>The Result&hellip;</h2>
	</div>
	<ul class="condensed">
		<li>3 PHP Classes: HelloWorld_ControllerPublic_Hello, HelloWorld_Route_Prefix_Hello, HelloWorld_ViewPublic_Hello</li>
		<li>1 Public Route Prefix: hello</li>
		<li>1 HTML Template: helloworld_view</li>
		<li>1 Phrase: hello_world</li>
	</ul>
	<p>
		So now you know briefly how a request is matched to a Controller and how the controller returns a View,
		which may or may not contain a Template. To learn more about the Controller &amp; its API, and the rich Template syntax available
		to you, read the relevant "Framework" sections: The Controller Layer, and The Templating System.
	</p>