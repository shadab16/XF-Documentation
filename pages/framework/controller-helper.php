	<div class="titleBar">
		<h1>Controller Helpers</h1>
	</div>
	<p>
		A controller-helper class contains methods that are designed to be reused across multiple controllers.
		These methods can be used to simplify a lot of repetitive tasks in multiple controllers.
		All controller-helpers inherit from a common abstract base class: <code>XenForo_ControllerHelper_Abstract</code>.
	</p>
	<table width="100%">
		<tr class="muted">
			<td width="30%"><strong>Helper Title</strong></td>
			<td width="50%"><strong>Class</strong></td>
			<td width="20%"><strong>Alias</strong></td>
		</tr>
		<tr>
			<td>User Account Helper</td>
			<td>XenForo_ControllerHelper_Account</td>
			<td><em>Account</em></td>
		</tr>
		<tr>
			<td>User Profile Helper</td>
			<td>XenForo_ControllerHelper_UserProfile</td>
			<td><em>UserProfile</em></td>
		</tr>
		<tr>
			<td>Cache Rebuild Helper</td>
			<td>XenForo_ControllerHelper_CacheRebuild</td>
			<td><em>CacheRebuild</em></td>
		</tr>
		<tr>
			<td>Forum/Thread/Post Helper</td>
			<td>XenForo_ControllerHelper_ForumThreadPost</td>
			<td><em>ForumThreadPost</em></td>
		</tr>
		<tr>
			<td>WYSIWYG Editor Helper</td>
			<td>XenForo_ControllerHelper_Editor</td>
			<td><em>Editor</em></td>
		</tr>
		<tr>
			<td>XML File Helper</td>
			<td>XenForo_ControllerHelper_Xml</td>
			<td><em>Xml</em></td>
		</tr>
	</table>
	<p>
		Controller helpers can be fetched using the <code>getHelper()</code> method. Since this method is part of the abstract base
		<code>XenForo_Controller</code> class, you can only use these helpers from inside the controller layer.
	</p>
	<div class="titleBar">
		<h2>WYSIWYG Editor Helper</h2>
	</div>
	<p>
		This helper contains a single method, <code>getMessageText()</code>, for processing input text submitted via a WYSIWYG Editor.
		Internally it converts the HTML tags to their BbCode equivalents; and returns the processed string.
	</p>
<?php _php(<<<TEXT
public function actionIndex()
{
	\$editorHelper = \$this->getHelper('Editor');
	\$message = \$editorHelper->getMessageText('message', \$this->_input);

	// Process the submitted message
}
TEXT
)?>
	<p>
		<strong>Form Field</strong>: The first parameter is the name of the form field which contains the message.
	</p>
	<p>
		<strong>Input Object</strong>: An object of type <code>XenForo_Input</code> should be passed which would act as a data source.
	</p>
	<p>
		<strong>Character Limit</strong>: This is an optional parameter; used to explicitly specify a maximum character limit for the
		submitted message. If the submitted field contains text longer than the specified limit, an exception (<code>XenForo_Exception</code>)
		is thown. If no limit is specified, the board option <em>messageMaxLength</em> is used instead.
	</p>
	<div class="titleBar">
		<h2>XML File Helper</h2>
	</div>
	<p>
		This helper contains a single method, <code>getXmlFromFile()</code>, for reading a given XML file and converting it into a
		<code>SimpleXMLElement</code> object. If the file is unreadable or is not a valid XML document, an exception
		<em>(Response Error wrapped in a Response Exception)</em> is thrown immediately.
	</p>
<?php _php(<<<TEXT
public function actionIndex()
{
	// Get an uploaded file (XenForo_Upload) or a complete file path

	\$xmlHelper = \$this->getHelper('Xml');
	\$document = \$xmlHelper->getXmlFromFile(\$file);

	// Process the xml document
}
TEXT
)?>
	<p>
		<strong>File</strong>: The file can either be a string, containing the absolute path to an XML file,
		or an object of type <code>XenForo_Upload</code>.
	</p>