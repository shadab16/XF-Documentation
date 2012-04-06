	<div class="titleBar">
		<h1>Application Architecture</h1>
	</div>
	<p>
		The XenForo Framework is based on the MVC (Model-View-Controller) design pattern. This is not a new approach in software development.
		It was conceived way back in 1979; although it's usage in the PHP world has become popular only in the recent 5 years. The MVC approach
		consists of breaking down your application code into 3 broad layers:
	</p>
	<ol>
		<li>
			<strong>Controller</strong>: The application Controller takes a request, does some logical work and returns a View.
			In the process, it could access a Model to fetch or store the data. The Controller doesn't know &amp; care how the data is stored;
			and how the View would display it.
		</li>
		<li>
			<strong>Model</strong>: The business logic and data processing is done by the Model. It knows what data is stored, where it's
			stored and how to fetch &amp; manipulate it. Data validation is also performed in this part of your application. But the Model
			doesn't know which Controller is calling it or in what View the data would be displayed. That's none of it's concerns.
		</li>
		<li>
			<strong>View</strong>: The View is that part of your application which deals with the presentation of data. What data is displayed
			where. Similar to how the Model layer doesn't care which View displays it's data; the View layer just doesn't care from which
			Model the data is being fetched. The View layer acts dumb.
		</li>
	</ol>
	<div class="titleBar">
		<h2>XenForo's Implementation</h2>
	</div>
	<p>
		XenForo's implementation of MVC consists of a small set of abstract classes as well as some concrete classes. The important ones are
		briefly described below:
	</p>
	<dl class="pairsColumns alt">
		<dt>XenForo_Controller</dt>
		<dd>
			The base controller class stores the Request, Response and Input (filtering) objects amongst other things. It contains methods for
			CSRF protection, URL Canonicalization, initializing the Session, Response handling.
		</dd>
		<dt>XenForo_Model</dt>
		<dd>
			The base model, apart from caching all the Models used, contains convenience methods for building SQL queries and fetching data from
			the database via a separate database object.
		</dd>
		<dt>XenForo_View</dt>
		<dd>
			The base view class stores the Response and View Renderer objects. Optionally, a template name has to be specified if the HTML
			is stored as a template in the database.
		</dd>
		<dt>XenForo_FrontController</dt>
		<dd>
			The front controller is a special object that handles all requests to your application.
			The complete workflow of how the FrontController works is given in the "Controller Layer" section.
		</dd>
		<dt>XenForo_Router</dt>
		<dd>
			The Router object determines which Controller (and its Action) needs to be called,
			depending upon the URL &amp; other Request parameters.
		</dd>
	</dl>
	<div class="titleBar">
		<h2>Directory Structure</h2>
	</div>
	<div>
		<p>
			The root directory contains just 7 publicly accessible PHP files and 6 directories, the most important of which is the
			<code>library</code> directory which contains the actual PHP code for your application.
		</p>
		<p>
			The publicly accessible PHP files, like <code>admin.php</code> and <code>index.php</code> contain just a few lines of code
			to setup the Autoloader, Initialize the Application class and run the Front Controller.
		</p>
	</div>
	<ul class="condensed">
		<li>data/</li>
		<li>install/</li>
		<li>internal_data/</li>
		<li>js/</li>
		<li>
			library/
			<ul>
				<li>Lgpl/</li>
				<li>Sabre/</li>
				<li>XenForo/</li>
				<li>Zend/</li>
				<li>config.php</li>
			</ul>
		</li>
		<li>styles/</li>
		<li>admin.php</li>
		<li>admindav.php</li>
		<li>cron.php</li>
		<li>css.php</li>
		<li>index.php</li>
		<li>payment_callback.php</li>
		<li>rgba.php</li>
	</ul>
	<div class="titleBar">
		<h2>Third-Party Libraries</h2>
	</div>
	<p>
		Instead of reinventing the wheel and writing a component from scratch, XenForo utilizes third-party libraries when it suits the needs
		exactly. Here is a list of such libraries that are included in the stock XenForo installation:
	</p>
	<dl class="pairsColumns alt">
		<dt>Zend Framework</dt>
		<dd>
			<a href="http://framework.zend.com/">Zend Framework</a> is a library of loosely-coupled PHP classes.
			XenForo uses the Core, Web and Database components only. Zend Framework is licensed under the New BSD License.
		</dd>
		<dt>SabreDAV</dt>
		<dd>
			Available at <a href="http://code.google.com/p/sabredav/">Google Code</a>, SabreDAV is used by XenForo
			to enable editing of style templates via a WebDAV interface. SabreDAV is licensed under the New BSD License.
		</dd>
		<dt>UTF8 Helper Functions</dt>
		<dd>
			Authored by Andreas Gohr (<a href="http://www.splitbrain.org/">splitbrain.org</a>).
			These helper functions are licensed under the LGPL License.
		</dd>
		<dt>jQuery</dt>
		<dd>
			XenForo uses the jQuery javascript library (version 1.4.4) for all its DOM interactions and AJAX.
			jQuery is used in XenForo under the MIT license.
		</dd>
		<dt>jQuery Plugins</dt>
		<dd>
			In addition to the base jQuery library, the following plugins are utilized:
			jQuery Tools 1.2.4, jQuery Easing v1.3, hoverIntent r5, Color Animations.
		</dd>
		<dt>TinyMCE Editor</dt>
		<dd>
			XenForo uses the TinyMCE as the WYSIWYG editor. TinyMCE is licensed under the LGPL License.
		</dd>
		<dt>SWFUpload</dt>
		<dd>
			SWFUpload is used for enabling multiple-file-uploads. SWFUpload is licensed under the MIT License.
		</dd>
	</dl>