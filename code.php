<?php
	if ( isset($_GET['n']) ){
		require './config.php';
		$the_SQL = mySQLi_connect($SQL_host, $SQL_user, $SQL_passwd, $SQL_name);
		if (!$the_SQL) show_error_exit('Could not connect to MySQL, fuck this world.');

		$the_id = $_GET['n'];

		if ( preg_match('/^[A-Za-z0-9]+$/', $the_id) ){
			$result = mysqli_query($the_SQL,"SELECT id, code, lang FROM codes WHERE id='$the_id'");
			$the_result = mysqli_fetch_array($result);
			$the_code = $the_result[1];
			$the_lang = $the_result[2];
		} elseif ( preg_match('/^[A-Za-z0-9]+\.[A-Za-z0-9]+$/', $the_id) ) {
			$result = mysqli_query($the_SQL,"SELECT id, code FROM codes WHERE id='$the_id'");
			$the_code = mysqli_fetch_array($result)[1];
			echo $the_code;
			exit(0);
		}
	}

	function raw_link(){
		global $the_id, $ReWrite;
		if($ReWrite){
			return $the_id.'.raw';
		}else{
			return 'code.php?n='.$the_id.'.raw';
		}
	}
?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Code Paste › #<?php echo $the_id; ?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<script src="//cdn.bootcss.com/ace/1.1.9/ace.js"></script>
		<script src="//cdn.bootcss.com/prism/0.0.1/prism.min.js"></script>
		<link href="//cdn.bootcss.com/prism/0.0.1/prism.min.css" rel="stylesheet">
		<style type="text/css">
			body{
				font-size: 16px;
				font-family: Microsoft Yahei,Hiragino Sans GB,WenQuanYi Micro Hei,sans-serif;
				line-height: 18px;
				background: #eee;
				margin: 0px auto 10px auto;
				color: #34495E;
			}
			a{
				color: #3498DB;
				text-decoration: none;
			}
			img{
				max-width: 100%;
			}
			p{
				margin:0;
			}
			a,input,button{
			    outline: none !important;
			    -webkit-appearance: none;
			    border-radius: 0;
			}
			button::-moz-focus-inner,input::-moz-focus-inner{
			    border-color:transparent !important;
			}
			:focus {
			    border: none;
			    outline: 0;
			}
			::selection {
				background:#3498DB;
				color:#fff;
			}
			::-moz-selection {
				background:#3498DB;
				color:#fff;
			}
			::-webkit-selection {
				background:#3498DB;
				color:#fff;
			}
			/* 设置滚动条的样式 */
			::-webkit-scrollbar {
				width: 10px;
			}
			/* 滚动槽 */
			::-webkit-scrollbar-track {
				background-color: #eee;
			}
			/* 滚动条滑块 */
			::-webkit-scrollbar-thumb {
				background: rgba(0,0,0,0.1);
			}
			::-webkit-scrollbar-thumb:hover {
				background: rgba(0,0,0,0.3);
			}
			h1,h2,h3,h4,h4,h5,h6{
				font-weight:100;
				margin: 0;
			}
			pre{
				border-left: 5px solid #558ABB;
				margin: 5px 0;
				padding: 5px;
				background-color: #F2F2F5;
				font-family: Consolas,Monaco,"Andale Mono",monospace,Microsoft Yahei,Hiragino Sans GB,WenQuanYi Micro Hei,sans-serif !important;
			}
			pre code{
				background-color: #F2F2F5;
				overflow: auto !important;
				font-size: 14px;
				max-height: none !important;
			}
			pre[class*=language-]>code[data-language]::before{
				border-radius: 0 !important;
			}

			#header{
				background-color: #34495E;
				width: 100%;
				height: 48px;
				color: #fff;
				font-size: 24px;
			}
			#content{
				box-shadow: 0px 2px 6px rgba(100, 100, 100, 0.3);
				margin: 50px auto 15px auto;
				max-width: 1100px;
				background: #fff;
				padding: 10px 20px 20px;
			}
			@media screen and (max-width: 1180px){
				#content{
					margin: 50px 20px 15px 20px;
					width: auto;
				}
			}
			#raw{
				float:right;
				display:inline-block;
				margin: 0px 0 0 0;
				background-color: #3498DB;
				color: #fff;
				border: 0;
				padding: 5px 15px;
				font-size: 16px;
				box-shadow: 0px 2px 6px rgba(100, 100, 100, 0.3);
				transition: background-color 0.2s;
				cursor: pointer;
			}
			#raw:hover{
				background: #45A9EC;
			}

		</style>


	</head>


	<body>
		<div id="header">
			<div style="padding:12px">
				<h1 style="font-size:24px;">Code Paste</h1>
			</div>
		</div>
		<div id="content">
			<p style="font-size:20px;margin:6px 0;display:inline-block;" >Code #<?php echo $the_id; ?></p>
			<a href="<?php echo raw_link(); ?>" ><button onclick="submit();" id="raw">Raw</button></a>
			<pre><code class="language-<?php echo $the_lang; ?>"><?php echo $the_code; ?></code></pre>
		</div>
	</body>
</html>
