<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" rel="stylesheet" href="{DIR}styles.css" />
		<script type="text/javascript" src="{DIR}jquery-1.4.2.min.js"></script>
		
		<script type="text/javascript" src="{DIR}scripts.js"></script>

		<title>ShoutBox</title>
	</head>
	<body>
		<div id="center">	<!-- Center Div -->
			<div id="frame">	<!-- Frame Div -->
				<div id="topic_who">{topic_who}</div>	<!-- Topic_who Div -->
				<div id="topic_change" title="Double click to change the topic"></div>
				<div id="topic">
				<form id="topic_change_form" method="post" action="ajax.php"><p><input id="topic_input" name="topic_input" type="text" value="{topic}"/></p></form>
				<p id="topic_text">{topic}</p>
				</div>	<!-- Topic Div -->
				
				<div id="content_top"></div>	<!-- Content_top Div -->
				<div id="content">	<!-- Content Div -->
					<div id="text_div">	<!-- Text Div -->
					<div class="content_text">{text}</div>
					</div>	<!-- Text Div -->
				</div>	<!-- Content Div --> 
				<div id="content_form">	<!-- Form Div -->
				<div class="infobar">
				{sendform}
				</div>
				</div> <!-- Form Div -->
			</div>	<!-- Frame Div -->
			<div id="frame_bottom">Contact | {logout} <a href="http://validator.w3.org/check?uri=referer">XHTML 1.1 Valid</a></div> <!-- Frame_bottom Div -->
		</div>	<!-- Center Div -->
	</body>
</html>
