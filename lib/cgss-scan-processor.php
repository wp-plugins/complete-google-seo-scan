<?php
 echo '<div class="updated"><p>' . __( 'Google Search Engine Optimization Scan for your web page is complete. Here are the results.', 'cgss' ) . '</p>' . '</div>';

 $cgss_theme = wp_get_theme();
 $cgss_theme_name = wp_get_theme()->Name;

 $cgss_body = file_get_contents( $cgss_url, FILE_USE_INCLUDE_PATH );

 if ( $cgss_robot_command == 'cgss-robots-command' ) {
  $cgss_robot_file_headers = get_headers( home_url() . '/robots.txt/', 1 );
  if ( ! strpos( $cgss_robot_file_headers[0], '404 Not Found' ) ) {
  $cgss_robot_file = file_get_contents( home_url() . '/robots.txt/', FILE_USE_INCLUDE_PATH );
  }
 }

 if ( $cgss_sitemap_input != null ) {
  $cgss_sitemap_file_headers = get_headers( $cgss_sitemap_input, 1 );
  if ( ! strpos( $cgss_sitemap_file_headers[0], '404 Not Found' ) ) {
  $cgss_sitemap_file = file_get_contents( $cgss_sitemap_input, FILE_USE_INCLUDE_PATH );
  }
 }

 $cgss_style_body = file_get_contents( get_stylesheet_uri(), FILE_USE_INCLUDE_PATH );

 //load time counter stop
 $cgss_load_time = microtime();
 $cgss_load_time = explode(' ', $cgss_load_time);
 $cgss_load_time = $cgss_load_time[1] + $cgss_load_time[0];
 $cgss_load_finish = $cgss_load_time;
 $total_load_time = round(($cgss_load_finish - $cgss_load_start), 2);
 $cgss_load_time_consumed = $total_load_time;

 //scan time counter start
 $cgss_scan_time = microtime();
 $cgss_scan_time = explode( ' ', $cgss_scan_time );
 $cgss_scan_time = $cgss_scan_time[1] + $cgss_scan_time[0];
 $cgss_scan_start = $cgss_scan_time;

 //declare dom
 $cgss_dom = new DOMDocument;
 libxml_use_internal_errors( true );
 $cgss_dom->loadHTML( $cgss_body );
 $cgss_doc_errors = array();
 foreach ( libxml_get_errors() as $cgss_html_error ) {
  $cgss_doc_errors[] = $cgss_html_error->message . __( 'at line', 'cgss' ) . '&nbsp' . $cgss_html_error->line . '<br />';
  libxml_clear_errors();
 }
 $cgss_doc_error_count = count( $cgss_doc_errors );

 //get link details from dom document
 $cgss_links = $cgss_dom->getElementsByTagName( 'a' );
 $cgss_link_anchor_text = '';
 $cgss_link_href = array();
 $cgss_outgoing_link = array();
 $cgss_link_rel = array();
 $cgss_nofollow_link = array();
 $cgss_link_title = array();
 $cgss_link_text_value = '';
 $cgss_link_text_length = 0;
 foreach ( $cgss_links as $cgss_link ) {
  $cgss_link_href_value = $cgss_link->getAttribute( 'href' );
  $cgss_link_rel_value = $cgss_link->getAttribute( 'rel' );
  $cgss_link_title_value = $cgss_link->getAttribute( 'title' );
  $cgss_link_text = $cgss_link->nodeValue;
  $cgss_link_text_value .= '&nbsp;' . $cgss_link_text;
  $cgss_link_text_length = $cgss_link_text_length + mb_strlen( $cgss_link_text, '8bit' );
  if ( $cgss_link_href_value != null ) {
   $cgss_link_href[] = $cgss_link_href_value;
   if ( substr( $cgss_link_href_value, 0, strlen( home_url() ) ) != home_url() ) {
    $cgss_outgoing_link[] = $cgss_link_href_value;
   }
   if ( $cgss_link_rel_value != null ) {
    $cgss_link_rel[] = $cgss_link_rel_value;
    if ( strpos( $cgss_link_rel_value, 'nofollow' ) ) {
     $cgss_nofollow_link[] = $cgss_link_rel_value;
    }
   }
   if ( $cgss_link_title_value != null ) {
    $cgss_link_title[] = $cgss_link_title_value;
   }
  }
 }
 $cgss_link_count = count( $cgss_link_href );
 $cgss_outgoing_link_count = count( $cgss_outgoing_link );
 $cgss_link_rel_count = count( $cgss_link_rel );
 $cgss_nofollow_link_count = count( $cgss_nofollow_link );
 $cgss_link_title_count = count( $cgss_link_title );
 $cgss_link_anchor_text_size = strlen( $cgss_link_anchor_text );

 //get image details from dom document
 $cgss_images = $cgss_dom->getElementsByTagName( 'img' );
 $cgss_image_src = array();
 $cgss_image_alt = array();
 $cgss_image_height = array();
 $cgss_image_width = array();
 $cgss_alt_text_value = '';
 $cgss_alt_text_length = 0;
 foreach ( $cgss_images as $cgss_image ) {
  $cgss_image_src_value = $cgss_image->getAttribute( 'src' );
  $cgss_image_alt_value = $cgss_image->getAttribute( 'alt' );
  $cgss_image_height_value = $cgss_image->getAttribute( 'height' );
  $cgss_image_width_value = $cgss_image->getAttribute( 'width' );
  if ( $cgss_image_src_value != null ) {
   $cgss_image_src[] = $cgss_image_src_value;
   if ( $cgss_image_alt_value != null ) {
    $cgss_image_alt[] = $cgss_image_alt_value;
    $cgss_alt_text_value .= '&nbsp;' . $cgss_image_alt_value;
    $cgss_alt_text_length = $cgss_alt_text_length + mb_strlen( $cgss_image_alt_value, '8bit' );
   }
   if ( $cgss_image_height_value != null ) {
    $cgss_image_height[] = $cgss_image_height_value;
   }
   if ( $cgss_image_width_value != null ) {
    $cgss_image_width[] = $cgss_image_width_value;
   }
  }
 }
 $cgss_image_count = count( $cgss_image_src );
 $cgss_image_alt_count = count( $cgss_image_alt );
 $cgss_image_height_count = count( $cgss_image_height );
 $cgss_image_width_count = count( $cgss_image_width );

 //get script details from dom document
 $cgss_js_all = $cgss_dom->getElementsByTagName( 'script' );
 $cgss_js_src = array();
 $cgss_js_text_value = '';
 $cgss_js_text_length = 0;
 foreach ( $cgss_js_all as $cgss_js ) {
  $cgss_js_src_value = $cgss_js->getAttribute( 'src' );
  $cgss_js_text = $cgss_js->nodeValue;
  $cgss_js_text_value .= $cgss_js_text;
  $cgss_js_text_length = $cgss_js_text_length + mb_strlen( $cgss_js_text, '8bit' );
  if ( $cgss_js_src_value != null ) {
   $cgss_js_src[] = $cgss_js_src_value;
  }
 }
 $cgss_js_count = count( $cgss_js_src );
 
 //get style details from dom document
 $cgss_style_all = $cgss_dom->getElementsByTagName( 'style' );
 $cgss_style_text_value = '';
 $cgss_style_text_length = 0;
 foreach ( $cgss_style_all as $cgss_style ) {
  $cgss_style_text = $cgss_style->nodeValue;
  $cgss_style_text_value .= '&nbsp;' . $cgss_style_text;
  $cgss_style_text_length = $cgss_style_text_length + mb_strlen( $cgss_style_text, '8bit' );
 }

 //get css, canonical url, favicon details from dom document
 $cgss_css_all = $cgss_dom->getElementsByTagName( 'link' );
 $cgss_css_href = array();
 foreach ( $cgss_css_all as $cgss_css ) {
  if ( strpos( $cgss_css->getAttribute( 'rel' ), 'stylesheet' ) or $cgss_css->getAttribute( 'rel' ) == 'stylesheet' ) {
   $cgss_css_href_value = $cgss_css->getAttribute( 'href' );
   if ( $cgss_css_href_value != null ) {
    $cgss_css_href[] = $cgss_css_href_value;
   }
  }
  if ( $cgss_css->getAttribute( 'rel' ) == 'canonical' ) {
   $cgss_meta_cano = $cgss_css->getAttribute( 'href' );
   if ( $cgss_meta_cano != null ) {
    if ( $cgss_meta_cano != $cgss_url ) {
     $cgss_meta_cano_pointer = 0.5;
     $cgss_meta_cano_result = '<p class="cgss-warn">' . $cgss_meta_cano . '</p><p>' . __( 'It\'s different from scanned web page url', 'cgss' ) . '</p>';
     $cgss_meta_cano_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Be sure you want your page to be indexed by this canonical url', 'cgss' ) . '">' . __( 'Recheck it', 'cgss' ) . '</abbr>';
    } else {
     $cgss_meta_cano_pointer = 1;
     $cgss_meta_cano_result = '<p class="cgss-ok">' . $cgss_meta_cano . '</p>';
     $cgss_meta_cano_action = __( 'OK', 'cgss' );
    }
   } else {
    $cgss_meta_cano_pointer = 0;
    $cgss_meta_cano_result = '<p class="cgss-bad">' . __( 'NOT FOUND', 'cgss' ) . '</p>';
    $cgss_meta_cano_action = __( 'Put a canonical link', 'cgss' );
   }
  }
  if ( $cgss_css->getAttribute( 'rel' ) == 'Shortcut Icon' or $cgss_css->getAttribute( 'rel' ) == 'shortcut icon' ) {
   $cgss_meta_favicon = $cgss_css->getAttribute( 'href' );
   if ( $cgss_meta_favicon != null ) {
    $cgss_meta_favicon_pointer = 1;
    $cgss_meta_favicon_result = '<table><tr><td><p class="cgss-ok">' . $cgss_meta_favicon . '</p></td><td><p><img src="' . $cgss_meta_favicon . '" width="16px" height="16px" /></p></td></tr></table>';
    $cgss_meta_favicon_action = __( 'OK', 'cgss' ) . '</abbr>';
   } else {
    $cgss_meta_favicon_pointer = 0;
    $cgss_meta_favicon_result = '<p class="cgss-bad">' . __( 'NOT FOUND', 'cgss' ) . '</p>';
    $cgss_meta_favicon_action = __( 'Enter Favicon', 'cgss' );
   }
  }
 }
 $cgss_css_count = count( $cgss_css_href );

 //analysis style attribute of tags
 $html_major_tags = array( 'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'article', 'aside', 'audio', 'b', 'big', 'body', 'br', 'button', 'caption', 'i', 'input', 'form', 'label', 'ul', 'li', 'ol', 'table', 'td', 'tr', 'textarea', 'section', 'small', 'iframe', 'img', 'em', 'footer', 'div', 'p', 'span', 'code', 'pre', 'blockquote', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'cite' );
 $html_tags_style_att_present = array();
 foreach ( $html_major_tags as $html_major_tag ) {
  $html_existing_tag_nodes = $cgss_dom->getElementsByTagName( $html_major_tag );
  if ( $html_existing_tag_nodes->length != 0 ) {
   foreach ( $html_existing_tag_nodes as $html_existing_tag_node ) {
    if ( $html_existing_tag_node->getAttribute( 'style' ) != null ) {
     $html_tags_style_att_present[] = $html_major_tag;
     break;
    }
   }
  }
 }

 //get heading tags details from dom document
 $text_head_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );
 $text_name_head_tags_present = array();
 foreach ( $text_head_tags as $text_head_tag ) {
  $text_head_tags_node = $cgss_dom->getElementsByTagName( $text_head_tag );
  if ( $text_head_tags_node->length != 0 ) {
   $text_name_head_tags_present[] = $text_head_tag;
  }
 }
 $text_head_tag_count = count( $text_name_head_tags_present );
 $text_name_head_tags_result_string = '';
 foreach ( $text_name_head_tags_present as $text_name_head_tag_present ) {
  $text_name_head_tags_result_string .= $text_name_head_tag_present . '&nbsp;';
 }

 //declare xpath and format it to get content
 $cgss_xpath = new DomXPath( $cgss_dom );
 $cgss_html_text_node = $cgss_xpath->query('//html');
 $cgss_total_size_measure = $cgss_dom->saveHTML( $cgss_html_text_node->item(0) );
 $cgss_html_text_node_size = mb_strlen( $cgss_total_size_measure, '8bit' );

 //analyze head for http from scripts and css
 $cgss_head_node = $cgss_dom->getElementsByTagName( 'head' )->item(0);
 $cgss_head_node_html = $cgss_dom->saveHTML( $cgss_head_node );
 $cgss_head_node_dom = new DOMDocument;
 libxml_use_internal_errors( true );
 $cgss_head_node_dom->loadHTML( $cgss_head_node_html );
 $cgss_head_js_all = $cgss_head_node_dom->getElementsByTagName( 'script' );
 $cgss_head_js_src = array();
 foreach ( $cgss_head_js_all as $cgss_head_js ) {
  if ( $cgss_head_js->getAttribute( 'type' ) == 'text/javascript' and $cgss_head_js->getAttribute( 'src' ) != null ) {
   $cgss_head_js_src[] = $cgss_head_js->getAttribute( 'src' );
  }
 }
 $cgss_head_js_src_count = count( $cgss_head_js_src );
 $cgss_head_css_all = $cgss_head_node_dom->getElementsByTagName( 'link' );
 $cgss_head_css_href = array();
 foreach ( $cgss_head_css_all as $cgss_head_css ) {
  if ( strpos( $cgss_head_css->getAttribute( 'rel' ), 'stylesheet' ) or $cgss_head_css->getAttribute( 'rel' ) == 'stylesheet' ) {
   if ( $cgss_head_css->getAttribute( 'href' ) != null ) {
    $cgss_head_css_href[] = $cgss_head_css->getAttribute( 'href' );
   }
  }
 }
 $cgss_head_css_href_count = count( $cgss_head_css_href );

 //analyze body xpath for text
 foreach ( $cgss_xpath->query( '//script' ) as $entry ) {
  $entry->parentNode->removeChild( $entry );
 }
 foreach ( $cgss_xpath->query( '//style' ) as $entry ) {
  $entry->parentNode->removeChild( $entry );
 }
 $cgss_only_text_node = $cgss_xpath->query( '//body[text()]' )->item(0);
 $cgss_only_text = $cgss_only_text_node->nodeValue;

 //get title with dom document
 $cgss_title_node = $cgss_dom->getElementsByTagName( 'title' );
 $cgss_title_pre = $cgss_title_node->item(0);
 $cgss_title = $cgss_title_pre->nodeValue;

 //text html ratio
 $cgss_only_text_length = mb_strlen( $cgss_only_text, '8bit' );
 $cgss_html_text_ratio_value = ( ( $cgss_only_text_length / ( $cgss_html_text_node_size - $cgss_only_text_length ) ) * 100 );
 $cgss_html_text_ratio = round( $cgss_html_text_ratio_value, 2 );


 /*
 *
 * Web Page Data Analysis
 *
 */
 //title result
 if ( $cgss_title != null ) {
  if ( strlen( $cgss_title ) <= 70 ) {
   $cgss_title_pointer = 1;
   $cgss_title_result = '<p class="cgss-ok">' . $cgss_title . '</p><small>&nbsp;' . __( 'Length&nbsp;', 'cgss' ) . strlen( $cgss_title ) . __( '&nbsp;characters ( Maximum allowed 70 Characters )', 'cgss' ) . '</small>';
   $cgss_title_action = __( 'OK', 'cgss' );
  } else {
   $cgss_title_pointer = 0.5;
   $cgss_title_result = '<p class="cgss-warn">' . $cgss_title . '</p>' . __( 'Length', 'cgss' ) . strlen( $cgss_title ) . __( '&nbsp;characters ( Maximum allowed 70 Characters )', 'cgss' );
   $cgss_title_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'As more than 70 characters will not be shown in search result', 'cgss' ) . '">' . __( 'Give shorter title', 'cgss' ) . '</abbr>';
  }
 } else {
  $cgss_title_pointer = 0;
  $cgss_title_result = '<p class="cgss-bad">' . __( 'NOT FOUND', 'cgss' ) . '</p>';
  $cgss_title_action = __( 'Give a title.', 'cgss' );
 }

 //meta data extraction
 $cgss_meta_all = $cgss_dom->getElementsByTagName( 'meta' );
 foreach ( $cgss_meta_all as $cgss_meta ) {

  //meta description, keywords, robots results
  if ( $cgss_meta->getAttribute( 'name' ) == 'description' ) {
   if ( $cgss_meta->getAttribute( 'content' ) != null ) {
    $cgss_meta_desc = $cgss_meta->getAttribute( 'content' );
    if ( strlen( $cgss_meta_desc ) <= 155) {
     $cgss_meta_desc_pointer = 1;
     $cgss_meta_desc_result = '<p class="cgss-ok">' . $cgss_meta_desc . '</p>&nbsp;<small>&nbsp;' . __( 'Length', 'cgss' ) . strlen( $cgss_meta_desc ) . __( '&nbsp;characters ( Maximum allowed 155 Characters )', 'cgss' ) . '</small>';
     $cgss_meta_desc_action = __( 'OK', 'cgss' );
    } else {
     $cgss_meta_desc_pointer = 0.5;
     $cgss_meta_desc_result = '<p class="cgss-warn">' . $cgss_meta_desc . '</p><small>' . __( 'Length', 'cgss' ) . strlen( $cgss_meta_desc ) . __( '&nbsp;characters ( Maximum allowed 155 Characters )', 'cgss' ) . '</small>';
     $cgss_meta_desc_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Write some meta description within 155 characters. Although it does not hamper ranking but it looks bad in search engine page result. Hence, may reduce click through rate (CTR)', 'cgss' ) . '">' . __( 'Make it Shorter.', 'cgss' ) . '</abbr>';
    }
   } else {
    $cgss_meta_desc_pointer = 0;
    $cgss_meta_desc = '<p class="cgss-bad">' . __( 'NOT FOUND', 'cgss' ) . '</p>';
    $cgss_meta_desc_result = $cgss_meta_desc . '&nbsp;' . __( 'This is not good.', 'cgss' );
    $cgss_meta_desc_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'The tag is in place, now Write some meta description', 'cgss' ) . '">' . __( 'Give a description', 'cgss' ) . '</abbr>';
   }
  }
  if ( $cgss_meta->getAttribute( 'name' ) == 'keywords' ) {
   if ( $cgss_meta->getAttribute( 'content' ) != null ) {
    $cgss_meta_keys = $cgss_meta->getAttribute( 'content' );
    $cgss_meta_keys_pointer = 1;
    $cgss_meta_keys_result = $cgss_meta_keys;
    $cgss_meta_keys_action = __( 'OK', 'cgss' );
   } else {
    $cgss_meta_keys_pointer = 0;
    $cgss_meta_keys_result = __( 'NOT FOUND.', 'cgss' );
    $cgss_meta_keys_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Enter keywords suitable for your web page content, many search engines use it but not Google', 'cgss' ) . '">' . __( 'Enter keywords.', 'cgss' ) . '</abbr>';
   }
  }
  if ( $cgss_meta->getAttribute( 'name' ) == 'robots' ) {
   $cgss_meta_robot_value = $cgss_meta->getAttribute( 'content' );
   if ( strpos( $cgss_meta_robot_value, 'noindex' ) or strpos( $cgss_meta_robot_value, 'noindex' ) or strpos( $cgss_meta_robot_value, 'nofollow' ) ) {
    $cgss_meta_robots_pointer = 0;
    $cgss_meta_robot_result = '<p class="cgss-bad">' . $cgss_meta_robot_value . '</p><p>' . __( 'Meta robot is having noindex nofollow value. This is not good.', 'cgss' ) . '</p>';
    $cgss_meta_robot_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Change the robots meta value from no-index and/or no-follow', 'cgss' ) . '">' . __( 'Fix this.', 'cgss' ) . '</abbr>';
   } else {
    $cgss_meta_robots_pointer = 1;
    $cgss_meta_robot_result = '<p class="cgss-ok">' . $cgss_meta_robot_value . '</p>';
    $cgss_meta_robot_action = __( 'OK', 'cgss' );
   }
  }

  //meta property ogp results
  if ( $cgss_meta->getAttribute( 'property' ) == 'og:locale' ) {
   if ( $cgss_meta->getAttribute( 'content' ) != null ) {
    $cgss_ogp_meta_locale_content = $cgss_meta->getAttribute( 'content' );
    $cgss_ogp_meta_locale_signal = '1';
    $cgss_ogp_meta_ln_result = '<p class="cgss-ok">' . $cgss_ogp_meta_locale_content . '</p>';
    $cgss_ogp_meta_ln_action = __( 'OK', 'cgss' );
    $cgss_ogp_meta_ln_pointer = 1;
   } else {
    $cgss_ogp_meta_locale_content = 'NOT FOUND';
    $cgss_ogp_meta_locale_signal = '0';
    $cgss_ogp_meta_ln_result = '<p class="cgss-bad">' . $cgss_ogp_meta_locale_content . '</p>';
    $cgss_ogp_meta_ln_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put proper value to this og:locale meta tag', 'cgss' ) . '">' . __( 'Fill it', 'cgss' ) . '</abb>';
    $cgss_ogp_meta_ln_pointer = 0;
   }
  }
  if ( $cgss_meta->getAttribute( 'property' ) == 'og:site_name' ) {
   if ( $cgss_meta->getAttribute( 'content' ) != null ) {
    $cgss_ogp_meta_site_name_content = $cgss_meta->getAttribute( 'content' );
    $cgss_ogp_meta_site_name_signal = '1';
    $cgss_ogp_meta_site_name_result = '<p class="cgss-ok">' . $cgss_ogp_meta_site_name_content . '</p>';
    $cgss_ogp_meta_site_name_action = __( 'OK', 'cgss' );
    $cgss_ogp_meta_site_name_pointer = 1;
   } else {
    $cgss_ogp_meta_site_name_content = 'NOT FOUND';
    $cgss_ogp_meta_site_name_signal = '0';
    $cgss_ogp_meta_site_name_result = '<p class="cgss-bad">' . $cgss_ogp_meta_site_name_content . '</p>';
    $cgss_ogp_meta_site_name_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put proper value to this og:site_name meta tag', 'cgss' ) . '">' . __( 'Fill it', 'cgss' ) . '</abb>';
    $cgss_ogp_meta_site_name_pointer = 0;
   }
  }
  if ( $cgss_meta->getAttribute( 'property' ) == 'og:type' ) {
   if ( $cgss_meta->getAttribute( 'content' ) != null ) {
    $cgss_ogp_meta_type_content = $cgss_meta->getAttribute( 'content' );
    $cgss_ogp_meta_type_signal = '1';
    $cgss_ogp_meta_type_result = '<p class="cgss-ok">' . $cgss_ogp_meta_type_content . '</p>';
    $cgss_ogp_meta_type_action = __( 'OK', 'cgss' );
    $cgss_ogp_meta_type_pointer = 1;
   } else {
    $cgss_ogp_meta_type_signal = '0';
    $cgss_ogp_meta_type_result = '<p class="cgss-bad">' . 'NOT FOUND' . '</p>';
    $cgss_ogp_meta_type_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put proper value to this og:type meta tag', 'cgss' ) . '">' . __( 'Fill it', 'cgss' ) . '</abb>';
    $cgss_ogp_meta_type_pointer = 0;
   }
  }
  if ( $cgss_meta->getAttribute( 'property' ) == 'og:url' ) {
   if ( $cgss_meta->getAttribute( 'content' ) != null ) {
    $cgss_ogp_meta_url_content = $cgss_meta->getAttribute( 'content' );
    $cgss_ogp_meta_url_signal = '1';
    $cgss_ogp_meta_url_result = '<p class="cgss-ok">' . $cgss_ogp_meta_url_content . '</p>';
    $cgss_ogp_meta_url_action = __( 'OK', 'cgss' );
    $cgss_ogp_meta_url_pointer = 1;
   } else {
    $cgss_ogp_meta_site_name_content = 'NOT FOUND';
    $cgss_ogp_meta_url_signal = '0';
    $cgss_ogp_meta_url_result = '<p class="cgss-bad">' . $cgss_ogp_meta_url_content . '</p>';
    $cgss_ogp_meta_url_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put proper value to this og:url meta tag', 'cgss' ) . '">' . __( 'Fill it', 'cgss' ) . '</abb>';
    $cgss_ogp_meta_url_pointer = 0;
   }
  }
  if ( $cgss_meta->getAttribute( 'property' ) == 'og:title' ) {
   if ( $cgss_meta->getAttribute( 'content' ) != null ) {
    $cgss_ogp_meta_title_content = $cgss_meta->getAttribute( 'content' );
    $cgss_ogp_meta_title_signal = '1';
    $cgss_ogp_meta_title_result = '<p class="cgss-ok">' . $cgss_ogp_meta_title_content . '</p>';
    $cgss_ogp_meta_title_action = __( 'OK', 'cgss' );
    $cgss_ogp_meta_title_pointer = 1;
   } else {
    $cgss_ogp_meta_site_name_content = 'NOT FOUND';
    $cgss_ogp_meta_title_signal = '0';
    $cgss_ogp_meta_title_result = '<p class="cgss-bad">' . $cgss_ogp_meta_title_content . '</p>';
    $cgss_ogp_meta_title_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put proper value to this og:title meta tag', 'cgss' ) . '">' . __( 'Fill it', 'cgss' ) . '</abb>';
    $cgss_ogp_meta_title_pointer = 0;
   }
  }
  if ( $cgss_meta->getAttribute( 'property' ) == 'og:description' ) {
   if ( $cgss_meta->getAttribute( 'content' ) != null ) {
    $cgss_ogp_meta_desc_content = $cgss_meta->getAttribute( 'content' );
    $cgss_ogp_meta_desc_signal = '1';
    $cgss_ogp_meta_desc_result = '<p class="cgss-ok">' . $cgss_ogp_meta_desc_content . '</p>';
    $cgss_ogp_meta_desc_action = __( 'OK', 'cgss' );
    $cgss_ogp_meta_desc_pointer = 1;
   } else {
    $cgss_ogp_meta_site_name_content = 'NOT FOUND';
    $cgss_ogp_meta_desc_signal = '0';
    $cgss_ogp_meta_desc_result = '<p class="cgss-bad">' . $cgss_ogp_meta_desc_content . '</p>';
    $cgss_ogp_meta_desc_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put proper value to this og:description meta tag', 'cgss' ) . '">' . __( 'Fill it', 'cgss' ) . '</abb>';
    $cgss_ogp_meta_desc_pointer = 0;
   }
  }
  if ( $cgss_meta->getAttribute( 'property' ) == 'og:image' ) {
   if ( $cgss_meta->getAttribute( 'content' ) != null ) {
    $cgss_ogp_meta_image_content = $cgss_meta->getAttribute( 'content' );
    $cgss_ogp_meta_image_signal = '1';
    $cgss_ogp_meta_image_result = '<p class="cgss-ok">' . $cgss_ogp_meta_image_content . '</p>';
    $cgss_ogp_meta_image_action = __( 'OK', 'cgss' );
    $cgss_ogp_meta_image_pointer = 1;
   } else {
    $cgss_ogp_meta_site_name_content = 'NOT FOUND';
    $cgss_ogp_meta_image_signal = '0';
    $cgss_ogp_meta_image_result = '<p class="cgss-bad">' . $cgss_ogp_meta_image_content . '</p>';
    $cgss_ogp_meta_image_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put proper value to this og:image meta tag', 'cgss' ) . '">' . __( 'Fill it', 'cgss' ) . '</abb>';
    $cgss_ogp_meta_image_pointer = 0;
   }
  }
 }
 
 //meta description, canonical, robots, favicon results refined
 if ( $cgss_meta_desc_result == null or $cgss_meta_desc_action == null ) {
  $cgss_meta_desc_pointer = 0;
  $cgss_meta_desc_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_meta_desc_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'You can use any free SEO plugins available to get options to enter descriptions', 'cgss' ) . '">' . __( 'Put the tag', 'cgss' ) . '</abbr>';
 }
 if ( $cgss_meta_keys_result == null or $cgss_meta_keys_action == null ) {
  $cgss_meta_keys_pointer = 0;
  $cgss_meta_keys_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_meta_keys_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Enter keywords suitable for your web page content, many search engines use it but not Google. You can use any free SEO plugins available to get options to enter this tag', 'cgss' ) . '">' . __( 'Put the tag', 'cgss' ) . '</abbr>';
 }
 if ( $cgss_meta_cano_result == null or $cgss_meta_cano_action == null ) {
  $cgss_meta_cano_pointer = 0;
  $cgss_meta_cano_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_meta_cano_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'You can use any free SEO plugins available to get options to enter desired meta canonical link', 'cgss' ) . '">' . __( 'Put the tag', 'cgss' ) . '</abbr>';
 }
 if ( $cgss_meta_robot_result == null or $cgss_meta_robot_action == null ) {
  $cgss_meta_robots_pointer = 0.5;
  $cgss_meta_robot_result = '<p class="cgss-warn">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_meta_robot_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'It is better to put a tag. Otherwise no great worries', 'cgss' ) . '">' . __( 'Put the tag', 'cgss' ) . '</abbr>';
 }
 if ( $cgss_meta_favicon_result == null or $cgss_meta_favicon_action == null ) {
  $cgss_meta_favicon_pointer = 0;
  $cgss_meta_favicon_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_meta_favicon_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put a favicon ico image using a shortcut icon link tag', 'cgss' ) . '">' . __( 'Put the tag', 'cgss' ) . '</abbr>';
 }
 
 //meta property ogp results refined
 if ( $cgss_ogp_meta_locale_signal == null ) {
  $cgss_ogp_meta_ln_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_ogp_meta_ln_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put this og:locale meta tag in head section with proper value', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
  $cgss_ogp_meta_ln_pointer = 0;
 }
 if ( $cgss_ogp_meta_site_name_signal == null ) {
  $cgss_ogp_meta_site_name_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_ogp_meta_site_name_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put this og:site_name meta tag in head section with proper value', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
  $cgss_ogp_meta_site_name_pointer = 0;
 }
 if ( $cgss_ogp_meta_type_signal == null ) {
  $cgss_ogp_meta_type_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_ogp_meta_type_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put this og:type meta tag in head section with proper value', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
  $cgss_ogp_meta_type_pointer = 0;
 }
 if ( $cgss_ogp_meta_title_signal == null ) {
  $cgss_ogp_meta_title_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_ogp_meta_title_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put this og:title meta tag in head section with proper value', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
  $cgss_ogp_meta_title_pointer = 0;
 }
 if ( $cgss_ogp_meta_desc_signal == null ) {
  $cgss_ogp_meta_desc_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_ogp_meta_desc_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put this og:description meta tag in head section with proper value', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
  $cgss_ogp_meta_desc_pointer = 0;
 }
 if ( $cgss_ogp_meta_url_signal == null ) {
  $cgss_ogp_meta_url_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_ogp_meta_url_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put this og:url meta tag in head section with proper value', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
  $cgss_ogp_meta_url_pointer = 0;
 }
 if ( $cgss_ogp_meta_image_signal == null ) {
  $cgss_ogp_meta_image_result = '<p class="cgss-bad">' . __( 'TAG NOT FOUND', 'cgss' ) . '</p>';
  $cgss_ogp_meta_image_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put this og:image meta tag in head section with proper value', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
  $cgss_ogp_meta_image_pointer = 0;
 }
 if ( $cgss_ogp_meta_site_name_signal == '1' and $cgss_ogp_meta_url_signal == '1' and $cgss_ogp_meta_type_signal == '1' and $cgss_ogp_meta_title_signal == '1' and $cgss_ogp_meta_desc_signal == '1' and $cgss_ogp_meta_desc_signal == '1' and $cgss_ogp_meta_image_signal == '1' ) {
  $cgss_meta_ogp_pointer = 1;
 } elseif ( $cgss_ogp_meta_site_name_signal != '1' and $cgss_ogp_meta_url_signal != '1' and $cgss_ogp_meta_type_signal != '1' and $cgss_ogp_meta_title_signal != '1' and $cgss_ogp_meta_desc_signal != '1' and $cgss_ogp_meta_desc_signal != '1' and $cgss_ogp_meta_image_signal != '1' ) {
  $cgss_meta_ogp_pointer = 0;
 } else {
  $cgss_meta_ogp_pointer = 0;
 }

 //web page data points
 $cgss_page_data_points = ( $cgss_title_pointer + $cgss_meta_desc_pointer + $cgss_meta_keys_result + $cgss_meta_cano_pointer + $cgss_meta_robots_pointer + $cgss_meta_favicon_pointer );
 //social data points
 $cgss_page_social_points = ( $cgss_ogp_meta_ln_pointer + $cgss_ogp_meta_type_pointer + $cgss_ogp_meta_site_name_pointer + $cgss_ogp_meta_title_pointer + $cgss_ogp_meta_desc_pointer + $cgss_ogp_meta_url_pointer + $cgss_ogp_meta_image_pointer );

 //web page data result array
 $cgss_page_data_results = array(
  array( __( 'Title Tag', 'cgss' ), __( 'Title of the website. This should be descriptive and within 70 characters.', 'cgss' ), $cgss_title_result, $cgss_title_action, $cgss_title_pointer ),
  array( __( 'Meta Description', 'cgss' ), __( 'Describes the web page. Optimal length is 155 characters and is not a ranking factor.', 'cgss' ), $cgss_meta_desc_result, $cgss_meta_desc_action, $cgss_meta_desc_pointer ),
  array( __( 'Meta Keywords', 'cgss' ), __( 'Mentions used keywords in web page. It is not a ranking factor.', 'cgss' ), $cgss_meta_keys_result, $cgss_meta_keys_action, $cgss_meta_keys_pointer ),
  array( __( 'Canonical Link', 'cgss' ), __( 'Canonicalization is the process of picking the best url when there are several choices. This canonical meta tag helps search engine crawlers to index a page which can be approached from different urls (like http://www.example.com/ and http://example.com/).', 'cgss' ), $cgss_meta_cano_result, $cgss_meta_cano_action, $cgss_meta_cano_pointer ),
  array( __( 'Meta Robots', 'cgss' ), __( 'Meta robots tag requests search engine robots to crawl or leave the web page. If given a value of noindex and nofollow, web page will not be indexed.', 'cgss' ), $cgss_meta_robot_result, $cgss_meta_robot_action, $cgss_meta_robot_pointer ),
  array( __( 'Favicon Link', 'cgss' ), __( 'Displays an unique image beside title at the top of browser. Good SEO practice', 'cgss' ), $cgss_meta_favicon_result, $cgss_meta_favicon_action, $cgss_meta_favicon_pointer ),
 );

 //social data result array
 $cgss_social_data_results = array(
  array( __( 'Language', 'cgss' ), __( 'Sharing language you will use', 'cgss' ), $cgss_ogp_meta_ln_result, $cgss_ogp_meta_ln_action, $cgss_ogp_meta_ln_pointer ),
  array( __( 'Type', 'cgss' ), __( 'Type of application you are sharing. Here it is website', 'cgss' ), $cgss_ogp_meta_type_result, $cgss_ogp_meta_type_action, $cgss_ogp_meta_type_pointer ),
  array( __( 'Site Name', 'cgss' ), __( 'Name of the website. Here it is', 'cgss' ) . '&nbsp;' . get_bloginfo( 'name' ), $cgss_ogp_meta_site_name_result, $cgss_ogp_meta_site_name_action, $cgss_ogp_meta_site_name_pointer ),
  array( __( 'Title', 'cgss' ), __( 'Title of the shared content. May or may not be same as web page title', 'cgss' ), $cgss_ogp_meta_title_result, $cgss_ogp_meta_title_action, $cgss_ogp_meta_title_pointer ),
  array( __( 'Description', 'cgss' ), __( 'Body of the shared content. Usually this text is seen on shared contents in social media networks', 'cgss' ), $cgss_ogp_meta_desc_result, $cgss_ogp_meta_desc_action, $cgss_ogp_meta_desc_pointer ),
  array( __( 'URL', 'cgss' ), __( 'Specify web page link, this url is shared and will have link benefits. But be honest.', 'cgss' ), $cgss_ogp_meta_url_result, $cgss_ogp_meta_url_action, $cgss_ogp_meta_url_pointer ),
  array( __( 'Image', 'cgss' ), __( 'Very important because this gets users attention t your shared content on social media.', 'cgss' ), $cgss_ogp_meta_image_result, $cgss_ogp_meta_image_action, $cgss_ogp_meta_image_pointer ),
 );


 /*
 *
 * Web Page Content Analysis
 *
 */
 //image result
 $cgss_image_result = __( 'Total number of images', 'cgss' ) . '&nbsp;' . $cgss_image_count . '<br />' . __( 'Use of "alt" attribute', 'cgss' ) . '&nbsp;' . $cgss_image_alt_count . '<br />' . __( 'Use of "height" attribute', 'cgss' ) . '&nbsp;' . $cgss_image_height_count . '<br />' . __( 'Use of "width" attribute', 'cgss' ) . '&nbsp;' . $cgss_image_width_count;
 if ( $cgss_image_alt_count != $cgss_image_count or $cgss_image_height_count != $cgss_image_count or $cgss_image_width_count != $cgss_image_count ) {
  $cgss_image_pointer = 0;
  $cgss_image_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Insert the missing attributes.', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 } else {
  $cgss_image_pointer = 1;
  $cgss_image_action = __( 'OK', 'cgss' );
 }

 //Text hierarchy result
 if ( $text_head_tag_count == 0 ) {
  $cgss_head_tag_pointer = 0;
  $cgss_text_hierarchy_result = __( 'No heads tags found. Hence no text hierarchy is present.', 'cgss' );
  $cgss_text_hierarchy_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Write text in proper hierarchy.', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 } elseif ( $text_head_tag_count == 6 ) {
  $cgss_head_tag_pointer = 1;
  $cgss_text_hierarchy_result = '<p>' . __( 'All head tags are present', '' ) . '</p>' . __( 'So, there is text hierarchy present.', 'cgss' );
  $cgss_text_hierarchy_action = __( 'OK', 'cgss' );
 } elseif ( $text_head_tag_count == 1 ) {
  $cgss_head_tag_pointer = 0;
  $cgss_text_hierarchy_result = '<p>' . __( 'One head tag is present', 'cgss' ) . '</p>' . $text_name_head_tags_result_string;
  $cgss_text_hierarchy_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Write text in proper hierarchy.', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 } elseif ( $text_head_tag_count > 1 and $text_head_tag_count < 6 ) {
  $cgss_head_tag_pointer = 0.5;
  $cgss_text_hierarchy_result = '<p>' . __( 'Some head tags are present', 'cgss' ) . '</p>' . $text_name_head_tags_result_string;
  $cgss_text_hierarchy_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Make sure your text is in hierarchy. If it is not please make it so.', 'cgss' ) . '">' . __( 'Check again', 'cgss' ) . '</abbr>';
 }

 //Text HTML ratio results
 $cgss_text_html_ratio_result = __( 'Text to HTML ratio for this web page is', 'cgss' ) . '&nbsp;' . $cgss_html_text_ratio . '&nbsp;%' . '</br>';
 if ( $cgss_html_text_ratio < 20 ) {
  $cgss_html_text_pointer = 0;
  $cgss_text_html_ratio_result .= __( 'Too much HTML in your web page.', 'cgss' );
  $cgss_text_html_ratio_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Write more text, atleast', 'cgss' ) . '&nbsp;' . ( 20 - $cgss_html_text_ratio ) . '&nbsp;% more' . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 } elseif ( $cgss_html_text_ratio > 70 ) {
  $cgss_html_text_pointer = 0;
  $cgss_text_html_ratio_result .= __( 'Too much text in your web page.', 'cgss' );
  $cgss_text_html_ratio_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Make this page more appealing with more HTML. Or write less text, atleast', 'cgss' ) . '&nbsp;' . ( $cgss_html_text_ratio - 70 ) . '&nbsp;% less' . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 } else {
  $cgss_html_text_pointer = 1;
  $cgss_text_html_ratio_result .= __( 'This ratio for this web page is normal.', 'cgss' );
  $cgss_text_html_ratio_action = __( 'OK', 'cgss' );
 }

 //link numbers result
 $cgss_link_numbers_result = __( 'Number of Links', 'cgss' ) . '&nbsp;' . $cgss_link_count . '<br />' . __( 'Outgoing Links', 'cgss' ) . '&nbsp;' . $cgss_outgoing_link_count;
 if ( $cgss_link_count <= 50 ) {
  $cgss_link_pointer = 1;
  $cgss_link_numbers_action = __( 'OK', 'cgss' );
 } elseif ( $cgss_link_count > 50 and $cgss_link_count < 100 ) {
  $cgss_link_pointer = 0;
  $cgss_link_numbers_result .= '<br />' . __( 'Number of Links are large.', 'cgss' );
  $cgss_link_numbers_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Please try to reduce number of links.', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 } elseif ( $cgss_link_count >= 100 ) {
  $cgss_link_pointer = 0;
  $cgss_link_numbers_result .= '<br />' . __( 'Number of Links are too much.', 'cgss' );
  $cgss_link_numbers_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Number of Links should be lowered', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 }

 //link attribute result
 $cgss_link_attr_result = __( 'Links with rel attribute', 'cgss' ) . '&nbsp;' . $cgss_link_rel_count . '<br />' . __( 'Links with title attribute', 'cgss' ) . '&nbsp;' . $cgss_link_title_count . '<br />' . __( 'Links with nofollow rel attribute', 'cgss' ) . '&nbsp;' . $cgss_nofollow_link_count;
 $cgss_rel_percent = ( $cgss_link_rel_count / $cgss_link_count ) * 100;
 $cgss_title_percent = ( $cgss_link_title_count / $cgss_link_count ) * 100;
 if ( $cgss_rel_percent <= 25 or $cgss_title_percent <= 25 ) {
  $cgss_link_attr_pointer = 0;
  $cgss_link_attr_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Put rel and title attributes to links', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 } else {
  $cgss_link_attr_pointer = 1;
  $cgss_link_attr_action = __( 'OK', 'cgss' );
 }

 

 //content data points
 $cgss_content_data_points = ( $cgss_image_pointer + $cgss_head_tag_pointer + $cgss_html_text_pointer + $cgss_link_pointer + $cgss_link_attr_pointer );

 $cgss_content_results = array (
	array( __( 'Images', 'cgss' ), __( 'Optimal Use of images should have height, width and alt attribute. Images should not be resized at browser.', 'cgss' ), $cgss_image_result, $cgss_image_action, $cgss_image_pointer ),
	array( __( 'Text Hierarchy', 'cgss' ), __( 'Text presentation is better in a hierarchy of titles and body tags. Use h1, h2, h3, h4, h5, h6 tags properly.', 'cgss' ), $cgss_text_hierarchy_result, $cgss_text_hierarchy_action,  $cgss_head_tag_pointer ),
	array( __( 'text/html Ratio', 'cgss' ), __( 'This ratio determines if the web page is optimal content rich and visually presentable. This is not a ranking factor and should be between 20 % to 70 %.',  'cgss' ), $cgss_text_html_ratio_result, $cgss_text_html_ratio_action ),
	array( __( 'Link Numbers', 'cgss' ), __( 'Number of links plays an significant role in deciding pagerank. The numbers should be optimized and should not be very high.', 'cgss' ), $cgss_link_numbers_result, $cgss_link_numbers_action ),
 array( __( 'Link Attributes', 'cgss' ), __( 'There are 2 attributes rel and title for any web page links. They defines the link and it\'s function.', 'cgss' ), $cgss_link_attr_result, $cgss_link_attr_action ),
);


 /*
 *
 * Web Page Design Analysis
 *
 */
 //http results
 $total_http_reqests = $cgss_image_count + $cgss_js_count + $cgss_css_count;
 $cgss_http_request_result = '<p>' . __( 'This web page makes total&nbsp;', 'cgss' ) . $total_http_reqests . __( '&nbsp;HTTP requests.', 'cgss' ) . '</p><small>' . __( 'Types are&nbsp;', 'cgss' ) . $cgss_image_count . __( '&nbsp;for image&nbsp;', 'cgss' ) . $cgss_js_count . __( '&nbsp;for javascript&nbsp;', 'cgss' ) . $cgss_css_count . __( '&nbsp;for stylesheet.', 'cgss' ) . '</small>';
 if ( $total_http_reqests <= 50 ) {
  $cgss_http_reqests_pointer = 1;
  $cgss_http_request_action = __( 'OK', 'cgss' );
 } elseif ( $total_http_reqests > 50 and $total_http_reqests <= 100 ) {
  $cgss_http_reqests_pointer = 0.5;
  $cgss_http_request_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Try to make less HTTP requests because this is high. Use optimized theme and widgets', 'cgss' ) . '">' . __( 'Reduce it', 'cgss' ) . '</abbr>';
 } elseif ( $total_http_reqests > 100 ) {
  $cgss_http_reqests_pointer = 0;
  $cgss_http_request_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Try to make less HTTP requests because this is very high. Use optimized theme and widgets', 'cgss' ) . '">' . __( 'Must Reduce', 'cgss' ) . '</abbr>';
 }

 //analize main stylesheet
 if ( strpos( $cgss_style_body, '@import' ) ) {
  $cgss_style_import_pointer = 0;
  $cgss_style_import_result = __( 'Stylesheet is making HTTP requests through @import', 'cgss' );
  $cgss_style_import_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Remove the @import url and place it inside head tag through link with stylesheet rel attribute', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 } else {
  $cgss_style_import_pointer = 1;
  $cgss_style_import_result = __( 'Stylesheet is not making any HTTP request internally', 'cgss' );
  $cgss_style_import_action = __( 'OK', 'cgss' );
 }

 //style attributes in tags
 if ( count( $html_tags_style_att_present ) != 0 ) {
  $html_style_finder = '<p>';
  foreach ( $html_tags_style_att_present as $html_style_finder_present ) {
   $html_style_finder .= $html_style_finder_present . ',&nbsp;';
  }
  $html_style_finder .= '</p>';
  $cgss_style_attr_pointer = 0;
  $cgss_style_attr_result = $html_style_finder . '<small>' . __( 'Style attribute is present in above tags at some or all occurances.', 'cgss' ) . '</small>';
  $cgss_style_attr_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Find and remove style attributes with class attributes and put the style in main css file', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 } else {
  $cgss_style_attr_pointer = 1;
  $cgss_style_attr_result = __( 'No style attribute is present in any tag.', 'cgss' );
  $cgss_style_attr_action = __( 'OK', 'cgss' );
 }

 //browser results
 if ( $cgss_doc_error_count == 0 ) {
  $cgss_browser_pointer = 1;
  $cgss_browser_result = __( 'There is no html error in this web page.', 'cgss' );
  $cgss_browser_action = __( 'OK', 'cgss' );
 } else {
  if ( $cgss_doc_error_count > 0 and $cgss_doc_error_count <= 5 ) {
   $cgss_browser_pointer = 0.5;
  } elseif ( $cgss_doc_error_count > 5 ) {
   $cgss_browser_pointer = 0;
  }
  $cgss_doc_error_result = '';
  for ( $cgss_doc_errors_printing = 0; $cgss_doc_errors_printing < ( $cgss_doc_error_count + 1 ); $cgss_doc_errors_printing++ ) {
   $cgss_doc_error_result .= '<small>' . $cgss_doc_errors[$cgss_doc_errors_printing] . '</small>';
  }
  $cgss_browser_result = __( 'There are&nbsp;', 'cgss' ) . count( $cgss_doc_errors ) . __( '&nbsp;errors in html of your web page:', 'cgss' ) . '<div class="box-errors"><div style="padding: 5px;">' . $cgss_doc_error_result . '</div></div>';
  $cgss_browser_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Dig into the errors and find out what is causing the errors, your theme or any plugin and resolve it', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 }

 //visual complition in loading
 $cgss_js_diff = ( $cgss_js_count - $cgss_head_js_src_count );
 $cgss_css_diff = ( $cgss_css_count - $cgss_head_css_href_count );
 $cgss_http_diff = round( ( ( $cgss_head_css_href_count + $cgss_head_js_src_count ) / ( $cgss_js_count + $cgss_css_count ) * 100 ), 2 );
 $cgss_visual_comp_result = '<p>' . $cgss_http_diff . __( '&nbsp;% of stylesheets and javascripts are loaded in head section.', 'cgss' ) . '</p>';
 if ( $cgss_http_diff <= 25 ) {
  $cgss_visual_comp_pointer = 1;
  $cgss_visual_comp_action = __( 'OK', 'cgss' );
 } else {
  if ( $cgss_http_diff < 75 ) {
   $cgss_visual_comp_pointer = 0.5;
  } elseif ( $cgss_http_diff >= 75 ) {
   $cgss_visual_comp_pointer = 0;
  }
  $cgss_visual_comp_result .= '<small>' . __( 'This is high', 'cgss' ) . '</small>';
  $cgss_visual_comp_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Add more scripts in footer section and remove them from header section', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 }

 //rich snippet results
 $cgss_htmls = $cgss_dom->getElementsByTagName( 'html' );
 foreach ( $cgss_htmls as $cgss_html ) {
  $cgss_html_rich_snippet_itemtype = $cgss_html->getAttribute( 'itemtype' );
  if ( substr( $cgss_span_rich_snippet_itemtype, 0, strlen( 'http://schema.org/' ) ) == 'http://schema.org/' ) {
   $cgss_rich_snippet_pointer = 1;
   $cgss_type_c = substr( $cgss_html_rich_snippet_itemtype, strlen( 'http://schema.org/' ) );
   $cgss_rich_snippet_result = __( 'Microdata rich snippet is present at this web page.', 'cgss' ) . '<br />' . __( 'Type of rich snippet is', 'cgss' ) . '&nbsp;' . $cgss_type_rich_snippet;
   $cgss_rich_snippet_action = __( 'OK', 'cgss' );
   break;
  }
 }
 if ( $cgss_type_rich_snippet == null ) {
  $cgss_bodys = $cgss_dom->getElementsByTagName( 'body' );
  foreach ( $cgss_bodys as $cgss_body ) {
   $cgss_body_rich_snippet_itemtype = $cgss_body->getAttribute( 'itemtype' );
   if ( substr( $cgss_span_rich_snippet_itemtype, 0, strlen( 'http://schema.org/' ) ) == 'http://schema.org/' ) {
    $cgss_rich_snippet_pointer = 1;
    $cgss_type_rich_snippet = substr( $cgss_body_rich_snippet_itemtype, strlen( 'http://schema.org/' ) );
    $cgss_rich_snippet_result = __( 'Microdata rich snippet is present at this web page.', 'cgss' ) . '<br />' . __( 'Type of rich snippet is', 'cgss' ) . '&nbsp;' . $cgss_type_rich_snippet;
    $cgss_rich_snippet_action = __( 'OK', 'cgss' );
    break;
   }
  }
 }
 if ( $cgss_type_rich_snippet == null ) {
  $cgss_divs = $cgss_dom->getElementsByTagName( 'div' );
  foreach ( $cgss_divs as $cgss_div ) {
   $cgss_div_rich_snippet_itemtype = $cgss_div->getAttribute( 'itemtype' );
   if ( substr( $cgss_span_rich_snippet_itemtype, 0, strlen( 'http://schema.org/' ) ) == 'http://schema.org/' ) {
    $cgss_rich_snippet_pointer = 1;
    $cgss_type_rich_snippet = substr( $cgss_div_rich_snippet_itemtype, strlen( 'http://schema.org/' ) );
    $cgss_rich_snippet_result = __( 'Microdata rich snippet is present at this web page.', 'cgss' ) . '<br />' . __( 'Type of rich snippet is', 'cgss' ) . '&nbsp;' . $cgss_type_rich_snippet;
    $cgss_rich_snippet_action = __( 'OK', 'cgss' );
    break;
   }
  }
 }
 if ( $cgss_type_rich_snippet == null ) {
  $cgss_spans = $cgss_dom->getElementsByTagName( 'span' );
  foreach ( $cgss_spans as $cgss_span ) {
   $cgss_span_rich_snippet_itemtype = $cgss_span->getAttribute( 'itemtype' );
   if ( substr( $cgss_span_rich_snippet_itemtype, 0, strlen( 'http://schema.org/' ) ) == 'http://schema.org/' ) {
    $cgss_rich_snippet_pointer = 1;
    $cgss_type_rich_snippet = substr( $cgss_span_rich_snippet_itemtype, strlen( 'http://schema.org/' ) );
    $cgss_rich_snippet_result = __( 'Microdata rich snippet is present at this web page.', 'cgss' ) . '<br />' . __( 'Type of rich snippet is', 'cgss' ) . '&nbsp;' .        $cgss_type_rich_snippet;
    $cgss_rich_snippet_action = __( 'OK', 'cgss' );
    break;
   }
  }
 }
 if ( $cgss_type_rich_snippet == null ) {
  $cgss_rich_snippet_pointer = 0;
  $cgss_rich_snippet_result = __( 'There is no microdata rich snippet present in this web page.', 'cgss' );
  $cgss_rich_snippet_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Use any free SEO plugin to markup your web page with microdata rich snippet.', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 }

 //design data points
 $cgss_design_data_points = ( $cgss_http_reqests_pointer + $cgss_style_import_pointer + $cgss_style_attr_pointer + $cgss_browser_pointer + $cgss_visual_comp_pointer + $cgss_rich_snippet_pointer );
 
 //design data results array
 $cgss_design_results = array(
  array( __( 'HTTP Requests', 'cgss' ), __( 'Number of HTTP requests your web page makes to fetch content from server influences document load time, because more requests will call for more downloads and will take more time', 'cgss' ), $cgss_http_request_result, $cgss_http_request_action ),
  array( __( 'Stylesheet import url', 'cgss' ), __( '@import parameter inside stylesheet is bound to increase unnecessary document load. This should be avoided', 'cgss' ), $cgss_style_import_result, $cgss_style_import_action ),
  array( __( 'Style Attribute', 'cgss' ), __( 'Using this in any element of html of web page reduces quality by increasing browser rendering time', 'cgss' ), $cgss_style_attr_result, $cgss_style_attr_action ),
  array( __( 'Browser Compatibility', 'cgss' ), __( 'Google wants that your web page should look ok in different browsers (e.g. mozila firefox, chrome, internet explorer, safari, opera etc.), and the basic thing we can check is errors inside yor html', 'cgss' ), $cgss_browser_result, $cgss_browser_action ),
  array( __( 'Visual Complition', 'cgss' ), __( 'HTTP requests made in header compared to total HTTP requests influences visual complition, which is a important design standard parameter', 'cgss' ), $cgss_visual_comp_result, $cgss_visual_comp_action ),
  array( __( 'Rich Snippet', 'cgss' ), __( 'This type of HTML markup gives more information to search engine pages to render. Google encourages microdata type markup because this increases user experience in Search Engine Rank Page', 'cgss' ), $cgss_rich_snippet_result, $cgss_rich_snippet_action ),
 );


 /*
 *
 * Web Page Technical Analysis
 *
 */
 //url results
 if ( strpos( $cgss_url, '?' ) == TRUE and strpos( $cgss_url, '=' ) == TRUE  ) {
  $cgss_url_pointer = 0;
  $cgss_url_auto_part = explode( '?', $cgss_url );
  $cgss_url_result = '<p>' . __( 'Google may confuse this page as auto-generated.', 'cgss' ) . '</p><small>' . __( 'because of this part', 'cgss' ) . '&nbsp;:&nbsp;?' . $cgss_url_auto_part[1] . '</small>';
  $cgss_url_action = '<a href="' . home_url() . '/wp-admin/options-permalink.php" class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Change your url to different type of permalink', 'cgss' ) . '" target="_blank">' . __( 'Change it', 'cgss' ) . '</a>';
 } else {
  if ( strlen ( $cgss_url ) <= 255 ) {
   $cgss_url_pointer = 1;
   $cgss_url_result = __( 'This web page url maintains guidelines.', 'cgss' );
   $cgss_url_action = __( 'OK', 'cgss' );
  } else {
   $cgss_url_pointer = 0;
   $cgss_url_result = __( 'The web page url is too big. Google may consider it spam.', 'cgss' );
   $cgss_url_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Change your url size and type at page or post editor. Make sure you are not using any session tracking', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
  }
 }

 //If-Modified-Since results
 if ( array_key_exists( 'Last-Modified', $cgss_headers ) ) {
  $cgss_if_mod_since_pointer = 1;
  $if_mod_since_result = __( 'Last-Modified part in header is found. If-Modified-Since is On.', 'cgss' );
  $if_mod_since_action = __( 'OK', 'cgss' );
 } else {
  $cgss_if_mod_since_pointer = 0;
  $if_mod_since_result = __( 'Last-Modified part in header is not found. If-Modified-Since is Off', 'cgss' );
  $if_mod_since_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Ask your hosting provider to activate If-Modified-Since header', 'cgss' ) . '">' . __( 'Ask for it', 'cgss' ) . '</abbr>';
 }

 //caching results
 if ( array_key_exists( 'Cache-Control', $cgss_headers ) ) {
  $cgss_caching_pointer = 1;
  $cgss_cache_data = $cgss_headers['Cache-Control'];
  $cgss_caching_result = __( 'Cache is active. This web page has following cache parameters.', 'cgss' ) . '<br />' . $cgss_cache_data[0];
  $cgss_caching_action = __( 'OK', 'cgss' );
 } else {
  $cgss_caching_pointer = 0;
  $cgss_caching_result = __( 'Cache is inactive. This web page don\'t returns cache parameters.', 'cgss' );
  $cgss_caching_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Use cache method for better user experience. Use any free cache plugin available', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 }

 //Keep Alive results
 if ( $cgss_headers['Connection'] != 'Keep-Alive' ) {
  $cgss_keep_alive_pointer = 0;
  $keep_alive_result = __( 'Keep Alive Connection is Off', 'cgss' );
  $keep_alive_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Ask your hosting provider to activate Keep Alive Connection', 'cgss' ) . '">' . __( 'Ask for it', 'cgss' ) . '</abbr>';
 } else {
  $cgss_keep_alive_pointer = 1;
  $keep_alive_result = __( 'Keep Alive Connection On', 'cgss' );
  $keep_alive_action = __( 'OK', 'cgss' );
 }

 //gzip results
 $cgss_gzip_header_data = $_SERVER['HTTP_ACCEPT_ENCODING'];
 if ( substr( $cgss_gzip_header_data, 0, 4 ) == 'gzip' ) {
  $cgss_gzip_pointer = 1;
  $cgss_gzip_result = __( 'gzip compression in your web page headers is enabled.', 'cgss' );
  $cgss_gzip_action = __( 'OK', 'cgss' );
 } else {
  $cgss_gzip_pointer = 0;
  $cgss_gzip_result = __( 'No compression method is found in web page.', 'cgss' );
  $cgss_gzip_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Enable gzip compression for better results. Use free plugins.', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 }

 //cms results
 if ( get_bloginfo( 'version' ) != null ) {
  $cgss_cms_pointer = 1;
  $cgss_cms_result = __( 'You are using WordPress version', 'cgss' ) . '&nbsp;:&nbsp;' . get_bloginfo( 'version' );
  $cgss_cms_action = __( 'OK', 'cgss' );
 } else {
  $cgss_cms_pointer = 0;
  $cgss_cms_result = __( 'You are using WordPress, most probably it\'s a modified cms with wordpress core.', 'cgss' );
  $cgss_cms_action = '<abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Please use proper WordPress software', 'cgss' ) . '">' . __( 'Fix it', 'cgss' ) . '</abbr>';
 }

 //server result array
 $cgss_server_results = array(
  array( __( 'URL', 'cgss' ), __( 'If url has variable informations or is more than 255 bytes, search engines will consider it as spam.', 'cgss' ), $cgss_url_result, $cgss_url_action, $cgss_url_pointer ),
  array( __( 'If-Modified-Since', 'cgss' ), __( 'This is a server feature. This automatically Informs search engine robots, whenever any change takes place in web page content.', 'cgss' ), $if_mod_since_result, $if_mod_since_action, $cgss_if_mod_since_pointer ),
  array( __( 'Caching', 'cgss' ), __( 'Caching html, css, javascripts, images in users browsers can be very useful in reducing document load time. Search engine crawlers likes web pages with better document load time.', 'cgss' ), $cgss_caching_result, $cgss_caching_action, $cgss_caching_pointer ),
  array( __( 'Keep Alive', 'cgss' ), __( 'This is a server feature. This keeps the connection between server and browser active for a said amount of time. And saves time for excess communication. Hence it lowers document load time which is better.', 'cgss' ), $keep_alive_result, $keep_alive_action, $cgss_keep_alive_pointer ),
  array( __( 'gzip compression', 'cgss' ), __( 'This server feature delivers web page content to browser in gzip compressed format. Hence it lowers bandwidth and web page size.', 'cgss' ), $cgss_gzip_result, $cgss_gzip_action, $cgss_gzip_pointer ),
  array( __( 'CMS', 'cgss' ), __( 'Content Management System (cms) creates web page from scripts kept in server. So, Google crawlers may consider this contents to be auto generated. But, for WordPress users this is not a problem.', 'cgss' ), $cgss_cms_result, $cgss_cms_action ),
 );

 //counter server points
 $cgss_server_data_points = ( $cgss_url_pointer + $cgss_if_mod_since_pointer + $cgss_caching_pointer + $cgss_keep_alive_pointer + $cgss_gzip_pointer + $cgss_cms_pointer );
 
 //total counter of success and faliure
 $cgss_total_pointer = round( ( 0.25 * ( 0.75 * ( ( $cgss_page_data_points - $cgss_meta_keys_pointer ) / 5 ) + 0.25 * ( $cgss_page_social_points  / 7 ) ) + 0.25 * ( $cgss_content_data_points / 5 ) + 0.25 * ( $cgss_design_data_points / 6 ) + 0.25 * ( ( $cgss_server_data_points - $cgss_keep_alive_pointer ) / 5 ) ), 2 );
 //promo data showing
 $cgss_solve_data = '?theme=' . $cgss_theme_name . '&url=' . home_url();

 //scan time counter stop
 $cgss_scan_time = microtime();
 $cgss_scan_time = explode(' ', $cgss_scan_time);
 $cgss_scan_time = $cgss_scan_time[1] + $cgss_scan_time[0];
 $cgss_scan_finish = $cgss_scan_time;
 $total_scan_time = round(($cgss_scan_finish - $cgss_scan_start), 4);
 $cgss_scan_time_consumed = $total_scan_time;

$cgss_scaned_page_props = array(
 array( __( 'Web Page', 'cgss' ), $cgss_url ),
 array( __( 'Scanned for', 'cgss' ), __( 'Search Engine Compatibility, Google Webmaster Guidelines as standard', 'cgss' ) ),
 array( __( 'Theme Used', 'cgss' ), $cgss_theme_name ),
 array( __( 'Time Taken', 'cgss' ), $cgss_scan_time_consumed . '&nbsp;' . __( 'seconds for Scan', 'cgss' ) . '&nbsp;and&nbsp;' . $cgss_load_time_consumed . '&nbsp;' . __( 'seconds for loading components', 'cgss' ) ),
 );
?>
