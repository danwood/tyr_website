<?php require_once('_prelude.php'); require_once('phmagick.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<base href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/" />
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep — We’re Sorry!';
$description='';
include('_head.php');
?>
	<style>



	</style>
</head>
<body id="error-page" class="lightgray-block">
	<div class="clearfix outside-sticky-footer">
		<!-- Specify grid system. All boxes must be clearfix. Specify layout direction. -->
		<div class="contain-sticky-footer fullwidth">
			<div class="clearfix">
				<!-- Nested groups of boxes inside; must outdent boxes since they indent for gutters -->
				<div class="before-sticky-footer">

<?php
$fullHeader = FALSE;
include('_header.php'); ?>
					<main>
						<section id="volunteer" class="clearfix capped-width">
							<div class="inlinebox">

<?php
$requestedPage = $_SERVER["REQUEST_URI"];
if (0 === strpos($requestedPage, '/')) $requestedPage = substr($requestedPage, 1);	// kill first slash
$n = 0 + $_SERVER["REDIRECT_STATUS"];

/*
ErrorDocument 400 /ApacheError.php
ErrorDocument 401 /ApacheError.php
ErrorDocument 402 /ApacheError.php
ErrorDocument 403 /ApacheError.php
ErrorDocument 404 /ApacheError.php
ErrorDocument 405 /ApacheError.php
ErrorDocument 406 /ApacheError.php
ErrorDocument 407 /ApacheError.php
ErrorDocument 408 /ApacheError.php
ErrorDocument 409 /ApacheError.php
ErrorDocument 410 /ApacheError.php
ErrorDocument 411 /ApacheError.php
ErrorDocument 412 /ApacheError.php
ErrorDocument 413 /ApacheError.php
ErrorDocument 414 /ApacheError.php
ErrorDocument 415 /ApacheError.php
ErrorDocument 416 /ApacheError.php
ErrorDocument 417 /ApacheError.php
ErrorDocument 500 /ApacheError.php
ErrorDocument 501 /ApacheError.php
ErrorDocument 502 /ApacheError.php
ErrorDocument 503 /ApacheError.php
ErrorDocument 504 /ApacheError.php
ErrorDocument 505 /ApacheError.php
*/

switch($n) {
	case 400: $e = "Bad Request"; $x ="There was a syntax error in the client request"; break;
	case 401: $e = "Unauthorized"; $x ="You were not authorized to view this site. Please contact us if you should be authorized."; break;
	case 402: $e = "Payment Required"; $x =""; break;
	case 403: $e = "Forbidden"; $x ="It is forbidden to view this URL. There's nothing here to see anyhow."; break;
	case 404: $e = "Not Found"; $x = '"' . $requestedPage . '" could not be found. Try navigating using the menus above.'; break;
	case 405: $e = "Method Not Allowed"; $x ="Requested method is not acceptable"; break;
	case 406: $e = "Not Acceptable"; $x ="Requested resource is not available in a format the client cannot accept."; break;
	case 407: $e = "Proxy Authentication Required"; $x ="Unauthorized access request to a proxy server. Server sends a Proxy Authenticate header."; break;
	case 408: $e = "Request Time Out"; $x ="The request timed out, client can reissue the request"; break;
	case 409: $e = "Conflict"; $x ="The client requests conflict with each other."; break;
	case 410: $e = "Gone"; $x ="The requested resource has permanently been gone from the server"; break;
	case 411: $e = "Length Required"; $x ="Content-Length must be required"; break;
	case 412: $e = "Precondition Failed"; $x ="This is in response to one or more IF ... Headers send by the client, indicating one or more conditions specified is FALSE."; break;
	case 413: $e = "Request Entity too large"; $x ="The request body is too large, server refuses to process it"; break;
	case 414: $e = "Request-URI too Long"; $x ="The server refuses to process the request because the URI is too large."; break;
	case 415: $e = "Unsupported Media Type"; $x ="Content body is unsupported by the server."; break;
	case 416: $e = "Requested Range Not Satisfiable"; $x ="Request range out of bounds."; break;
	case 417: $e = "Expectation Failed"; $x ="Server failed to meet the requirements of the Expect Header Request."; break;
	case 500: $e = "Internal Server Error"; $x ="There was an error on the server. It's probably our fault. Please contact us if you would like it to be fixed, just in case we don't know about the problem."; break;
	case 501: $e = "Not Implemented"; $x ="Server does not have the functionality to fulfill request"; break;
	case 502: $e = "Bad Gateway"; $x ="The Server encountered an invalid response from an upstream server or proxy"; break;
	case 503: $e = "Service Unavailable"; $x ="Service is temporarily unavailable."; break;
	case 504: $e = "Gateway Time-Out"; $x ="Gateway / Proxy timed out"; break;
	case 505: $e = "HTTP Version Not Supported"; $x ="HTTP version used by the client is not supported"; break;
	default:  $e = "Unknown Error"; $x = "An unknown error occured."; break;
}
?>
								<h2>Error: <?php echo $n . ' — ' . htmlspecialchars($e); ?></h2>
								<p><?php echo htmlspecialchars($x); ?></p>
							</div>
						</section>
					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('_footer.php'); ?>
	</div>
<?php $includePinterest = FALSE; include('_body.end.php'); ?>
	<script>
		$('.single').click(function() {
			$('#fileinput').removeAttr('multiple');
			$('#fileinput').removeAttr('disabled');
		});
		$('.multi').click(function() {
			$('#fileinput').attr('multiple', 'multiple');
			$('#fileinput').removeAttr('disabled');
		});

		$("#fileinput").change(function (){
			$('#submit').removeAttr('disabled');
		});

		$("#uploader").submit(function (){
			$('#submit').attr('disabled', 'disabled');
			$('#status').text('Uploading...');
		});

	</script>
</body>
</html>