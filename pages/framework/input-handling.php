	<div class="titleBar">
		<h1>Input Handling</h1>
	</div>
	<p>
		Input Filtering is an essential part of any web application which accepts user-fed data. Filtering the data before any other part
		of the application can use it ensures the data being processed is of correct/expected type. For example, making sure a particular parameter
		is an Integer instead of a String.
	</p>
	<p>
		<code>XenForo_Input</code> class allows you to filter data either statically or via a class instance. When filtering data
		via a class instance, the data source has to be passed to the constructor. Two types of data sources are supported: A plain Array,
		and an object of class <code>Zend_Controller_Request_Http</code>.
	</p>
	<div class="titleBar">
		<h2>Data Types</h2>
	</div>
	<p>
		The input filtering class, by default, supports filtering for 10 data types.
		The class constants, and the default value for each data type is listed in the table below:
	</p>
	<table width="100%">
		<tr>
			<td width="30%">String</td>
			<td width="40%"><code>XenForo_Input::STRING</code></td>
			<td width="30%" class="muted">empty</td>
		</tr>
		<tr>
			<td>Number</td>
			<td><code>XenForo_Input::NUM</code></td>
			<td>0</td>
		</tr>
		<tr>
			<td>Unsigned Number</td>
			<td><code>XenForo_Input::UNUM</code></td>
			<td>0</td>
		</tr>
		<tr>
			<td>Integer</td>
			<td><code>XenForo_Input::INT</code></td>
			<td>0</td>
		</tr>
		<tr>
			<td>Unsigned Integer</td>
			<td><code>XenForo_Input::UINT</code></td>
			<td>0</td>
		</tr>
		<tr>
			<td>Float</td>
			<td><code>XenForo_Input::FLOAT</code></td>
			<td>0.0</td>
		</tr>
		<tr>
			<td>Binary</td>
			<td><code>XenForo_Input::BINARY</code></td>
			<td class="muted">empty</td>
		</tr>
		<tr>
			<td>Array</td>
			<td><code>XenForo_Input::ARRAY_SIMPLE</code></td>
			<td class="muted">empty array</td>
		</tr>
		<tr>
			<td>JSON Array</td>
			<td><code>XenForo_Input::JSON_ARRAY</code></td>
			<td class="muted">empty array</td>
		</tr>
		<tr>
			<td>Date/Time</td>
			<td><code>XenForo_Input::DATE_TIME</code></td>
			<td>0</td>
		</tr>
	</table>
	<div class="titleBar">
		<h2>Filtering Request Parameters</h2>
	</div>
	<p>
		Filtering the request parameters from inside a controller is the most common use-case. For this purpose, the controller already contains
		a XenForo_Input object initialized using the Request (<code>Zend_Controller_Request_Http</code>) object. It is accessible directly via
		<code>$this-&gt;_input</code> or using the getter function: <code>$this-&gt;getInput()</code>.
	</p>
	<div class="titleBar">
		<h3>Single Parameter</h3>
	</div>
	<p>
		The <code>filterSingle()</code> method should be used when filtering a single parameter. This method takes in three arguments:
		the Parameter name, Filter name, and optionally an array of Options.
	</p>
<?php _php(<<<TEXT
public function actionIndex()
{
	\$fooId = \$this->_input->filterSingle('foo_id', XenForo_Input::UINT);
	\$fooTitle = \$this->_input->filterSingle('foo_title', XenForo_Input::STRING);

	// Process the index action using \$fooId & \$fooTitle
}
TEXT
)?>
	<p>
		If foo_id or foo_title is not of the expected data type (Unsigned Integer and String, respectively), it would be replaced
		with a default value. This default value can be specified in the array of Options, or else the value listed in the table above is used.
	</p>
	<div class="titleBar">
		<h3>Multiple Parameters</h3>
	</div>
	<p>
		If you have a lot of parameters to filter, you can use the <code>filter()</code> method which takes in an array of of parameter names
		and filter names in a key-value format.
	</p>
<?php _php(<<<TEXT
public function actionIndex()
{
	\$data = \$this->_input->filter(array(
		'foo_id'      => XenForo_Input::UINT,
		'foo_title'   => XenForo_Input::STRING,
		'description' => XenForo_Input::STRING,
		'bar'         => XenForo_Input::INT
	));

	// \$data['foo_id'], \$data['foo_title'], \$data['description'], \$data['bar']
}
TEXT
)?>
	<div class="titleBar">
		<h3>String Options</h3>
	</div>
	<p>
		<strong>noTrim</strong>: The 'noTrim' option is used to preserve the whitespace before and after a string. If this option is false
		or not specified, the whitespace is trimmed while filtering the string.
	</p>
<?php _php(<<<TEXT
\$fooTitle = \$this->_input->filterSingle(
	'foo_title', XenForo_Input::STRING, array('noTrim' => true)
);
TEXT
)?>
	<p>
		<strong>default</strong>: The 'default' option is used to specify a defalt value to be used in case the input data is not a valid
		utf-8 string. If this option is not specified, an empty string is used.
	</p>
<?php _php(<<<TEXT
\$fooTitle = \$this->_input->filterSingle(
	'foo_title', XenForo_Input::STRING, array('default' => 'Foo Bar Baz')
);
TEXT
)?>
	<div class="titleBar">
		<h3>Numeric Data Options</h3>
	</div>
	<p>
		<strong>default</strong>: The 'default' option is used to specify a defalt value to be used in case the input value is out-of-range.
		So in effect, this option is useful only for unsigned numeric types. If not specified, 0 is set as the default value.
	</p>
<?php _php(<<<TEXT
\$fooCount = \$this->_input->filterSingle(
	'foo_count', XenForo_Input::UINT, array('default' => 16)
);
TEXT
)?>
	<div class="titleBar">
		<h3>Date/Time Options</h3>
	</div>
	<p>
		<strong>dayEnd</strong>: The 'dayEnd' option is used to alter the time portion of input data to end of the day
		(ie, 1 second before midnight: 23 hrs, 59 min, 59 sec).
		This option doesn't affect input values that are already in the form of a UNIX Timestamp.
	</p>
<?php _php(<<<TEXT
\$timestamp = \$this->_input->filterSingle(
	'foo_time', XenForo_Input::DATE_TIME, array('dayEnd' => true)
);
TEXT
)?>
	<div class="titleBar">
		<h3>Array Option</h3>
	</div>
	<p>
		<strong>array</strong>: The array option is used to filter an array of parameters having the same data-type. It should not be confused
		with the <code>ARRAY_SIMPLE</code> data type. This option makes sure that each element in the array is of the same expected data-type;
		while the <code>ARRAY_SIMPLE</code> data type makes sure that the parameter is an array, without checking the data type of each element.
	</p>
<?php _php(<<<TEXT
\$fruits = \$this->_input->filterSingle(
	'fruit', XenForo_Input::UINT, array('array' => true)
);
TEXT
)?>
	<p>
		<em>Each element of the <code>fruit</code> array is coerced to be an unsigned integer.</em>
	</p>
	<div class="titleBar">
		<h2>Filtering Other Data</h2>
	</div>
	<p>
		Create a new instance of the XenForo_Input class if your data source is not accessible directly via the request parameters.
		And once the object is created, you can filter the data from it just like you would filter a request parameter.
	</p>
<?php _php(<<<TEXT
// Get the fruit data as a plain array
\$fruit = \$this->_input->filterSingle('fruit', XenForo_Input::ARRAY_SIMPLE);

// Create a new input-filter instance using array as a source
\$fruitInput = new XenForo_Input(\$fruit);

// Filter individual elements from the data source
\$fruitData = \$fruitInput->filter(array(
	'name'        => XenForo_Input::STRING,
	'description' => XenForo_Input::STRING,
	'quantity'    => XenForo_Input::UINT
));
TEXT
)?>
	<div class="titleBar">
		<h3>Array data-type vs. Array option</h3>
	</div>
	<p>
		When do you use what? Use the array <em>option</em> if <strong>all</strong> the elements in your input array are of same
		data-type. The most common use-case for this is when you're filtering checkbox fields; ie, multiple fields having same name
		and same data-type.
	</p>
	<p>
		And use the array <em>data-type</em> if the types of individual elements <strong>differ</strong>. Use this way of filtering if you
		have grouped many form elements under the same field name; ie, multiple fields having same name but different data-type.
		Filtering such an array would be a 2-step process as explained in the example above.
	</p>
	<div class="titleBar">
		<h2>Custom Validators</h2>
	</div>
	<p>
		<code class="muted">&lt;!-- TODO --&gt;</code>
		<!-- URL Coming Soon ;) -->
	</p>
	<div class="titleBar">
		<h2>File Uploads</h2>
	</div>
	<p>
		File uploads are handled by the <code>XenForo_Upload</code> class. It contains two static methods for fetching the uploaded files:
		<code>getUploadedFiles()</code> and <code>getUploadedFile()</code>. Both methods accept the (form) field name as a parameter.
		Optionally, an alternative source for the uploaded files can be supplied as an array via the second parameter.
	</p>
<?php _php(<<<TEXT
// Fetch a single uploaded file
\$file = XenForo_Upload::getUploadedFile('field_name');

// Fetch all files uploaded for 'field_name'
\$files = XenForo_Upload::getUploadedFiles('field_name');
TEXT
)?>
	<p>
		<code>getUploadedFile()</code> returns a single object of type <code>XenForo_Upload</code>; while <code>getUploadedFiles()</code>
		returns an array of <code>XenForo_Upload</code> objects. The latter static method is useful when uploading multiple files
		using the same field name.
	</p>
	<div class="titleBar">
		<h3>Set File Constraints</h3>
	</div>
	<p>
		File constraints can be set using the <code>setConstraints()</code> method which takes in an array as a parameter. Currently only 4
		constraints are supported: extensions, size, width and height. The constraints need to be set immediately after fetching / constructing
		the object, before any other method is called.
	</p>
	<ul class="condensed">
		<li><strong>extensions</strong>: List of valid file extensions.</li>
		<li><strong>size</strong>: Maximum file size in bytes.</li>
		<li><strong>width</strong>: Maximum width of an image file.</li>
		<li><strong>height</strong>: Maximum height of an image file.</li>
	</ul>
	<p>
		Once the constraints are set, call the <code>isValid()</code> method to check the uploaded file's validity. The method returns a
		boolean value. If the file is not valid, the validation errors or messages can be fetched via <code>getErrors()</code> method.
	</p>
<?php _php(<<<TEXT
\$file = XenForo_Upload::getUploadedFile('field_name');

if (!\$file)
{
	// The file was not uploaded. Process accordingly.
}

\$file->setConstraints(array(
	'extension' => array('txt', 'pdf'), // Allow only Text files and PDFs
	'size'      => 10240                // Maximum file size of 10 KB
));

if (!\$file->isValid())
{
	// Invalid file uploaded. Grab the errors...
	// Then throw an exception or return a normal response
	\$errors = \$file->getErrors();
}

// The file is valid? Rejoice!
TEXT
)?>
	<div class="titleBar">
		<h3>Image Files</h3>
	</div>
	<p>
		You can check if an uploaded file is an image using the <code>isImage()</code> method; which returns the result as a boolean.
		If the file is indeed an image, you can fetch certain file-specific information via <code>getImageInfoField()</code>. This method
		returns <code>false</code> if the file is not an image or the given field is not available. Three fields are supported:
	</p>
	<ul class="condensed">
		<li><strong>type</strong>: Type of the image file (<code>IMAGETYPE_GIF</code>, <code>IMAGETYPE_JPEG</code>, <code>IMAGETYPE_PNG</code>).</li>
		<li><strong>width</strong>: Width of the uploaded image file.</li>
		<li><strong>height</strong>: Height of the uploaded image file.</li>
	</ul>
<?php _php(<<<TEXT
if (\$file->isImage())
{
	// Width of the image in pixels
	\$width = \$file->getImageInfoField('width');

	// Height of the image in pixels
	\$height = \$file->getImageInfoField('height');

	// Type of the image. Check against the constants: IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG.
	\$imageType = \$file->getImageInfoField('type');
}
TEXT
)?>
	<div class="titleBar">
		<h2>Suggested Readings</h2>
	</div>
	<ul>
		<li>
			<a href="http://framework.zend.com/manual/en/zend.filter.html">Zend_Filter Component</a><br />
			<em class="muted">Advanced filters for transforming data after basic input filtering by XenForo_Input.</em>
		</li>
		<li>
			<a href="http://framework.zend.com/manual/en/zend.validate.html">Zend_Validate Component</a><br />
			<em class="muted">Advanced data validation classes supported natively by XenForo_Input.</em>
		</li>
		<li>
			<a href="http://framework.zend.com/manual/en/zend.file.html">Zend_File_Transfer</a><br />
			<em class="muted">Class for filtering and validating uploaded files. An alternative to XenForo_Upload.</em>
		</li>
	</ul>