<?php

namespace view;

class HTMLPage {

	public function getPage(String $title, String $body) : String {
		return '<!DOCTYPE HTML>
						<html>
  						<head>
    						<title>' . $title . '</title>
    						<meta http-equiv="content-type" content="text/html" charset="utf8">
  						</head>
  						<body>
  							' . $body . '
  						</body>
						</html>';
	}
}