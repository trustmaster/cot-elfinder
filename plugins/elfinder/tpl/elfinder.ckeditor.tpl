<!-- BEGIN: MAIN -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>File Manager</title>

	<base href="{PHP.cfg.mainurl}/">
	<!-- jQuery and jQuery UI (REQUIRED) -->
	<link rel="stylesheet" type="text/css" media="screen" href="lib/jquery-ui/css/smoothness/jquery-ui-1.10.2.custom.min.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="lib/jquery-ui/js/jquery-ui-1.10.2.custom.min.js"></script>

	<!-- elFinder CSS (REQUIRED) -->
	<link rel="stylesheet" type="text/css" media="screen" href="{PHP.cfg.plugins_dir}/elfinder/css/elfinder.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="{PHP.cfg.plugins_dir}/elfinder/css/theme.css">

	<!-- elFinder JS (REQUIRED) -->
	<script type="text/javascript" src="{PHP.cfg.plugins_dir}/elfinder/js/elfinder.min.js"></script>

	<!-- IF {PHP.lang} != 'en' -->
	<!-- elFinder Locale -->
	<script type="text/javascript" src="{PHP.cfg.plugins_dir}/elfinder/js/i18n/elfinder.{PHP.lang}.js"></script>
	<!-- ENDIF -->

	<!-- elFinder initialization (REQUIRED) -->
	<script type="text/javascript" charset="utf-8">
	/* Helper function to get parameters from the query string. */
	function getUrlParam(paramName) {
		var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i') ;
		var match = window.location.search.match(reParam) ;

		return (match && match.length > 1) ? match[1] : '' ;
	}

	$().ready(function() {
		var funcNum = getUrlParam('CKEditorFuncNum');
		var mode = '{PHP._GET.mode}';

		var elf = $('#elfinder').elfinder({
			lang: '{PHP.lang}',
			url : 'index.php?r=elfinder&_ajax=1&x={PHP.sys.xk}&mode=' + mode, /* connector URL (REQUIRED) */
			getFileCallback : function(file) {
					window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
					window.close();
			},
			resizable: false
		}).elfinder('instance');
	});
	</script>

</head>
<body>
	<!-- Element where elFinder will be created (REQUIRED) -->
	<div id="elfinder"></div>
</body>
</html>
<!-- END: MAIN -->