	<div class="titleBar">
		<h1>Coding Conventions</h1>
	</div>
	<p>
		When it comes to variable-, class-, function-, cookie-, database table- and database field-names,
		XenForo uses the following naming conventions throughout the codebase:
	</p>
	<dl class="pairsColumns alt">
		<dt>Class</dt>
		<dd>
			<code>Foo_Bar_Baz</code>
			<p>
				Class names are title-case and separated with underscores. Each "word" starts with a capital letter, but not every word
				needs to be separated. An example of such a class name is: <code>XenForo_ControllerPublic_Index</code>.
			</p>
		</dd>
		<dt>Function</dt>
		<dd>
			<code>fooBarBaz()</code> and <code>_fooBarBaz()</code>
			<p>
				Function &amp; Method names are in camelcase format. Private &amp; protected member functions are prefixed
				with an additional underscore (_).
			</p>
		</dd>
		<dt>Variable</dt>
		<dd>
			<code>$fooBarBaz</code> and <code>$_fooBarBaz</code>
			<p>
				Variable names are in camelcase format as well. Private &amp; protected member fields of a class are prefixed
				with an additional underscore (_).
			</p>
		</dd>
		<dt>Database Table</dt>
		<dd>
			<code>foo_bar_baz</code>
			<p>
				Database Table names are all lowercase and separated with underscores. All core XenForo tables are prefixed with "xf_".
				The collation of every table is "utf8_general_ci" and InnoDB is used as a storage engine, unless absolutely required
				to have a different engine.
			</p>
		</dd>
		<dt>Database Field</dt>
		<dd>
			<code>foo_bar_baz</code>
		</dd>
	</dl>
	<div class="titleBar">
		<h2>Addon-ID Guidelines</h2>
	</div>
	<p>
		These guidelines are taken verbatim from the thread:
		<a href="http://xenforo.com/community/threads/add-on-id-guidelines.6394/">Add-on ID Guidelines</a> posted by
		<a href="http://xenforo.com/community/members/kier.2/">Kier</a>.
	</p>
	<ul>
		<li>
			Please don't use 'XenForo' in your add-on ID without specific prior consultation with XenForo Ltd.
			We would like to retain this for official use, and the use of it might imply some form of official status that is not the case.
		</li>
		<li>
			Don't be too generic with your add-on ID. Releasing an add-on with an ID of 'Blog' or 'Gallery' is almost like domain squatting.
			Please come up with a unique, descriptive ID that is not likely to be confused with other add-ons providing similar functionality.
		</li>
		<li>
			Your add-on ID should take the form <b>AbcdEfghiJklm</b> - no spaces, all words beginning with an uppercase letter.
			This is for autoloader purposes.
		</li>
		<li>
			Best practices suggest that you should use your add-on ID in your class names, so if your add-on ID is <b>'ExampleFoo'</b>,
			your classes should make use of that name to assist the autoloader. Examples could include
			<code>ExampleFoo_Route_Prefix_Bar</code> and <code>ExampleFoo_ControllerPublic_Bar</code>.
		</li>
	</ul>
	<div class="titleBar">
		<h2>The Class Autoloader</h2>
	</div>
	<p>
		When you want to use a class or an interface and it's defined in a separate file, you would typically <code>include</code>
		that file first and then go on to use it. This is not necessary if you follow the class naming convention described above.
	</p>
	<p>
		If your class name is: GeekPoint_Foo_Bar, the autoloader will try to load it using the following (simplified) process:
	</p>
	<ol class="condensed">
		<li>Convert underscore (_) to forward slash (/)</li>
		<li>Append <code>.php</code> to the name.</li>
		<li>Include the file using <code>library</code> as a base.</li>
	</ol>
	<p>
		So, when use the class <code>GeekPoint_Foo_Bar</code> for the first time, the autoloader will try to find the class in
		<code>/library/GeekPoint/Foo/Bar.php</code> and load it.
	</p>
	<p>
		Just place your class &amp; interface files according to their names;
		you'd never need to manually <code>include</code> them in your code.
	</p>