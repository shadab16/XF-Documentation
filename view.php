<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>XenForo Developer Documentation</title>
	<meta name="description" content="Developer-oriented documentation for the XenForo Framework and Forum application.">
	<meta name="author" content="Shadab Ansari">
	<link rel="stylesheet" type="text/css" href="./../10/admin.php?_css/&css=public:xenforo,public:form,admin" />
	<link rel="stylesheet" type="text/css" href="./../10/admin.php?_css/&css=footer,header,splash" />
	<style type="text/css">
		body { font-family: 'Droid Sans', 'Trebuchet MS', Helvetica, Arial, sans-serif; font-size: 13px; }
		#title { font-size: 22px; line-height: 35px; height: 35px; }
		.pairsColumns { line-height: 1.6; }
		.pairsColumns.alt dt { width: 30%; margin-bottom: 1em; }
		.pairsColumns.alt dd { width: 65%; margin-bottom: 1em; }
		.text p { line-height: 1.6; margin: 1em 0; }
		.text dl p { margin-bottom: 0; }
		.text img.illustration { display: block; max-width: 700px; }
		.text > div.php, .text > div.html { background: #F9FDFF; border: 1px solid #D7EDFC; padding: 0.5em 0 0.5em 0.5em; margin: 1em 0; }
		.titleBar * { overflow: hidden; zoom: 1; margin: 0 !important; font-family: 'Droid Serif', Georgia, serif; }
		.titleBar h1 { font-size: 24px; text-transform: uppercase; }
		.titleBar h2 { font-size: 18px; }
		.titleBar h3 { font-size: 14px; }
		.baseHtml em { font-family: 'Droid Serif', Georgia, serif; }
		.baseHtml li { margin-bottom: 1em; line-height: 1.6; }
		.baseHtml th, .baseHtml td { border-color: #C8C8C8; padding: 0.75em 0.5em; }
		.baseHtml .condensed li { margin-bottom: 0.2em; }
		.baseHtml .condensed.nolist li li li { list-style: none; }
		.baseHtml .columns > li { list-style: none; }
		pre { line-height: 2; border-top: 1px solid #D7EDFC; padding-top: 1em; }
		pre, code, kbd, samp, tt { font-family: Consolas, monospace; }
	</style>
</head>
<body>
	<div id="header">
		<div id="logoLine">
			<div class="pageWidth">
				<h1 id="title"><a href="./" id="logo">XenForo Developer Documentation</a></h1>
				<h2 id="version">Revision: 38</h2>
			</div>
		</div>
		<div id="tabsNav">
			<div class="pad"></div>
		</div>
	</div>

	<div id="body" class="pageWidth">
		<div id="contentContainer">
			<div id="content" class="text baseHtml">
				<?php include $page; ?>
			</div>
			<div id="footer">
				<div id="debugInfo">
					<a href="http://xenforo.com" class="concealed">Forum software by XenForo&trade;</a>, &copy;2010 XenForo Ltd.
				</div>
				<div id="copyright">
					<a href="http://www.geekpoint.net/" class="concealed">Documentation by Shadab</a>, &copy;2010 Shadab.
				</div>
			</div>
		</div>
		<ul id="sideNav">
			<li class="sideNavSection"><a>Introduction</a>
				<ul>
					<li class="sideNavLink"><a href="./?page=architecture">MVC Architecture</a>
					</li><li class="sideNavLink"><a href="./?page=conventions">Coding Conventions</a>
					</li><li class="sideNavLink"><a href="./?page=resources">Helpful Resources</a>
				</ul>
			</li>
			<li class="sideNavSection"><a>The Framework</a>
				<ul>
					<li class="sideNavLink"><a href="./?page=hello-world">Hello World</a>
					</li><li class="sideNavLink"><a href="./?page=controller-layer">Controller Layer</a>
					</li><li class="sideNavLink"><a href="./?page=model">Model Layer</a>
					</li><li class="sideNavLink"><a href="./?page=view">View Layer</a>
					</li><li class="sideNavLink"><a href="./?page=templating">Templating System</a>
					</li><li class="sideNavLink"><a href="./?page=routing">Routing System</a>
					</li><li class="sideNavLink"><a href="./?page=session">Session Handling</a>
					</li><li class="sideNavLink"><a href="./?page=acl">Access Control</a></li>
				</ul>
			</li>
			<li class="sideNavSection"><a>Content Types</a>
				<ul>
					<li class="sideNavLink"><a href="./?page=content-type">Content Type</a>
					</li><li class="sideNavLink"><a href="./?page=thread">Thread</a>
					</li><li class="sideNavLink"><a href="./?page=post">Post</a>
					</li><li class="sideNavLink"><a href="./?page=profile-post">Profile Post</a>
					</li><li class="sideNavLink"><a href="./?page=conversation">Conversation</a></li>
				</ul>
			</li>
			<li class="sideNavSection"><a>Node Types</a>
				<ul>
					<li class="sideNavLink"><a href="./?page=node-type">Node Type</a>
					</li><li class="sideNavLink"><a href="./?page=category">Category</a>
					</li><li class="sideNavLink"><a href="./?page=forum">Forum</a>
					</li><li class="sideNavLink"><a href="./?page=link-forum">Link Forum</a>
					</li><li class="sideNavLink"><a href="./?page=page">Page</a></li>
				</ul>
			</li>
			<li class="sideNavSection"><a>Content Handlers</a>
				<ul>
					<li class="sideNavLink"><a href="./?page=alert">Alert</a>
					</li><li class="sideNavLink"><a href="./?page=attachment">Attachment</a>
					</li><li class="sideNavLink"><a href="./?page=like">Like</a>
					</li><li class="sideNavLink"><a href="./?page=moderation">Moderation</a>
					</li><li class="sideNavLink"><a href="./?page=news-feed">News Feed</a>
					</li><li class="sideNavLink"><a href="./?page=report-abuse">Report Abuse</a>
					</li><li class="sideNavLink"><a href="./?page=search-content">Search Content</a>
					</li><li class="sideNavLink"><a href="./?page=spam-cleaner">Spam Cleaner</a></li>
				</ul>
			</li>
		</ul>
	</div>
</body>
</html>