<?php
//load time counter start
 $cgss_load_time = microtime();
 $cgss_load_time = explode( ' ', $cgss_load_time );
 $cgss_load_time = $cgss_load_time[1] + $cgss_load_time[0];
 $cgss_load_start = $cgss_load_time;

 if ( isset( $_POST[ 'submit-cgss-page' ] ) ) {
  $cgss_raw_url = $_POST[ 'cgss-page' ];
 } elseif ( isset( $_POST[ 'submit-cgss-post' ] ) ) {
  $cgss_raw_url = $_POST[ 'cgss-post' ];
 } elseif ( isset( $_POST[ 'submit-cgss-url' ] ) ) {
  $cgss_raw_url = $_POST[ 'cgss-url' ];
 } 
 
 $cgss_url_check = esc_url_raw( $cgss_raw_url );

 //invalid url
 if ( ! filter_var( $cgss_url_check, FILTER_VALIDATE_URL ) or ! strpos( $cgss_url_check, '.' ) ) {
  echo '<div class="error"><p><strong>' . __( 'The url you have entered is invalid. Please enter a valid url of any webpage of your website', 'cgss' ) . ' ' . home_url() . '</strong></p></div>';
  require_once( 'cgss-scan-form.php' );
  exit;
 }
 //different domain url
 if ( substr( $cgss_url_check, 0, strlen( home_url() ) ) != home_url() ) {
  echo '<div class="error"><p>' . __( 'We can not allow you send our scaning robot (user agent) to websites of other people. Because,', 'cgss' ) . '</p><p>' . __( 'It may give extra load on their server or it may be illegal according to their usage policy or', 'cgss' ) . ' <strong>' . __( 'they might think you reached the door way to hack their site, which is wrong.', 'cgss' ) . '</strong></p><p>' . __( 'We request you to scan webpages from your website only. If you have other WordPress websites, install this plugin on those websites and check them too.', 'cgss' ) . '</p></div>';
  require_once( 'cgss-scan-form.php' );
  exit;
 }
 //checking headers
 $cgss_headers_check = get_headers( $cgss_url_check, 1 );
 //404 error handle
 if ( strpos( $cgss_headers_check[0], '404 Not Found' ) ) {
  echo '<div class="error"><p><strong>' . __( 'The url returns error : 404 Not Found, That means there is no webpage present and search engines will not index it. Enter existing webpage url of your website.', 'cgss' ) . '</strong></p></div>';
  require_once( 'cgss-scan-form.php' );
  exit;
 }
 if ( strpos( $cgss_headers_check[0], 'Moved Permanently' ) ) {
  if ( $cgss_headers_check['Location'] == null ) {
   echo '<div class="error"><p>' . __( 'This url re-directs to a page with no location. This is confusing and we request you to re-enter a proper url.', 'cgss' ) . '</p></div>';
   require_once( 'cgss-scan-form.php' );
   exit;
  }
  if ( substr( $cgss_headers_check['Location'], 0, strlen( home_url() ) ) != home_url() ) {
   echo '<div class="error"><p>' . __( 'This url re-directs to a url', 'cgss' ) . '&nbsp;<a href="' . $cgss_headers_check['Location'] . '" target="_blank">' . $cgss_headers_check['Location'] . '</a> ' . __( 'We can not allow you send our scaning robot (user agent) to websites of other people. Because,', 'cgss' ) . '</p><p>' . __( 'It may give extra load on their server or it may be illegal according to their usage policy or', 'cgss' ) . ' <strong>' . __( 'they might think you reached the door way to hack their site, which is wrong.', 'cgss' ) . '</strong></p><p>' . __( 'We request you to scan webpages from your website only. If you have other WordPress websites, install this plugin on those websites and check them too.', 'cgss' ) . '</p></div>';
   require_once( 'cgss-scan-form.php' );
   exit;
  }
  $cgss_headers = get_headers( $cgss_headers_check['Location'], 1 );
  if ( strpos( $cgss_headers[0], 'Moved Permanently' ) ) {
   echo '<div class="error"><p>' . __( 'This url have already re-directed to a new url', 'cgss' ) . '&nbsp;<a href="' . $cgss_headers_check['Location'] . '" target="_blank">' . $cgss_headers_check['Location'] . '</a> ' . __( 'From that it is now redirected to.', 'cgss' ) . '&nbsp;<a href="' . $cgss_headers['Location'] . '" target="_blank">' . $cgss_headers['Location'] . '</a>' . __( 'We do not allow that kind of redirects. Please try with a good url.', 'cgss' ) . '</p></div>';
   require_once( 'cgss-scan-form.php' );
   exit;
  }
  if ( strpos( $cgss_headers[0], '404 Not Found' ) ) {
   echo '<div class="error"><p>' . __( 'This url have already re-directed to a new url', 'cgss' ) . '&nbsp;<a href="' . $cgss_headers_check['Location'] . '" target="_blank">' . $cgss_headers_check['Location'] . '</a> ' . '<strong>' . __( 'The new url returns error : 404 Not Found, That means there is no indexable webpage and search engines will not index it. Enter existing webpage url of your website.', 'cgss' ) . '</strong></p></div>';
   require_once( 'cgss-scan-form.php' );
   exit;
  }
  $cgss_url = $cgss_headers_check['Location'];
 } else {
  //pass url normally
  $cgss_url = $cgss_url_check;
  $cgss_headers = $cgss_headers_check;
 }
?>
