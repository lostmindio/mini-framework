<!DOCTYPE html>

<html>
<head>
    <title>mini-framework</title>
    <link href="cl/style.css" rel="stylesheet" />
</head>
<body>
    <h1>mini-framework</h1>
    <h2>dirt simple and elegant PHP framework</h2>
    <div class="content">
		<div class="codesample">
			<span class="questionphp">&lt;php</span> <span class="keyword">require</span> <span class="string">"lib/init.php"</span>;<br />
			<span class="identifier">view</span>(<span class="string">"my_fancy_view"</span>, <span class="keyword">array</span>(<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="identifier">title</span> <span class="operator">=></span> <span class="string">"Hello World"</span>,<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="identifier">content</span> <span class="operator">=></span> <span class="string">"Welcome to the site!"</span><br />
			&nbsp;&nbsp;&nbsp;&nbsp;));
		</div>
        Welcome to charliesome's <strong>mini-framework</strong>. You can easily get started by creating your own <em>action</em> by adding this to a new PHP file in the site root:
		<div style="clear:both;"></div>
    </div>
    <div class="content">
		<div class="codesample">
			&lt;h1><span class="questionphp">&lt;?=</span> <span class="identifier">$title</span> <span class="questionphp">?></span>&lt;/h2><br />
			&lt;p><br />
			&nbsp;&nbsp;&nbsp;&nbsp;<span class="questionphp">&lt;?=</span> <span class="identifier">$content</span> <span class="questionphp">?></span><br />
			&lt;/p>
		</div>
		Then create the view by saving this snippet of code in the <strong>views/</strong> folder as <strong>my_fancy_view.php</strong>
		<div style="clear:both;"></div>
    </div>
    <div class="content">
		<div class="codesample">
			<span class="questionphp">&lt;?php</span><br />
			<span class="identifier">ob_start</span>(<span class="keyword">function</span>($buff) {<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<span class="keyword">foreach</span>(<span class="identifier">explode</span>(<span class="string">"\n"</span>, <span class="identifier">$buff</span>) <span class="keyword">as</span> <span class="identifier">$line</span>) {<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="identifier">$out</span> <span class="operator">.=</span> <span class="identifier">trim</span>(<span class="identifier">$line</span>);<br />
			&nbsp;&nbsp;&nbsp;&nbsp;}<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<span class="keyword">return</span> <span class="identifier">$out</span>;<br/>
			});
		</div>
		mini-framework also supports filters. These are executed during the processing of a request. Save the code snippet to the right in the <strong>lib/filters/</strong> directory as <strong>minify.php</strong> to minify the HTML outputted by your actions.
		<div style="clear:both;"></div>
    </div>
</body>
</html>
