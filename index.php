<?php

/*
 * Source: XenForo_BbCode_Formatter_Base::renderTagPhp()
 */
function _php($content)
{
	$tagAdded = false;

	if (strpos($content, '<?') == false)
	{
		$tagAdded = true;
		$content = "<?php\n$content";
	}

	$content = highlight_string(trim($content), true);

	if ($tagAdded)
	{
		$content = preg_replace('#&lt;\?php<br\s*/?>#', '', $content, 1);
	}

	echo sprintf('<div class="php">%s</div>', $content);
}

function _html($content)
{
	$content = htmlspecialchars($content);

	echo sprintf('<div class="html"><code>%s</code></div>', $content);
}

$mapping = array(
	'intro' => 'intro',
	'error' => 'error',

	'architecture'        => 'introduction/architecture',
	'conventions'         => 'introduction/conventions',
	'resources'           => 'introduction/resources',

	'hello-world'         => 'framework/hello-world',

	'controller-layer'    => 'framework/controller-layer',
	'front-controller'    => 'framework/controller-front',
	'controller'          => 'framework/controller-action',
	'controller-response' => 'framework/controller-response',
	'controller-helper'   => 'framework/controller-helper',
	'input-handling'      => 'framework/input-handling',

	'model'               => 'framework/model',
	'view'                => 'framework/view',
	'templating'          => 'framework/templating',

	'routing'             => 'framework/routing',
	'routing-rules'       => 'framework/routing-rules',
	'route-prefix'        => 'framework/route-prefix',
	'route-match'         => 'framework/route-match',

	'session'             => 'framework/session',
	'acl'                 => 'framework/acl',

	'content-type'        => 'cms/content-type',
	'thread'              => 'cms/thread',
	'post'                => 'cms/post',
	'profile-post'        => 'cms/profile-post',
	'conversation'        => 'cms/conversation',
	'node-type'           => 'cms/node-type',
	'category'            => 'cms/category',
	'forum'               => 'cms/forum',
	'link-forum'          => 'cms/link-forum',
	'page'                => 'cms/page',

	'alert'               => 'handlers/alert',
	'attachment'          => 'handlers/attachment',
	'like'                => 'handlers/like',
	'news-feed'           => 'handlers/news-feed',
	'report-abuse'        => 'handlers/report-abuse',
	'search-content'      => 'handlers/search-content',
	'spam-cleaner'        => 'handlers/span-cleaner',
);

$page = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 'intro';
$page = isset($mapping[$page]) ? $mapping[$page] : 'error';

if (!preg_match('/^[a-z\-\/]+$/', $page) || !is_file("./pages/$page.php"))
{
	header('HTTP/1.0 404 Not Found');
	$page = 'error';
}

$page = "./pages/$page.php";

include './view.php';