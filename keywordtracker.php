<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p>&lt;?php</p>
<p> error_reporting(E_ALL &amp; ~E_NOTICE);</p>
<p> if ($_REQUEST['v']) {<br />
  echo '2';<br />
  exit;<br />
  }</p>
<p> function get_page($host, $url) {<br />
  global $i, $fail_count;<br />
  $handle = fsockopen($host, 80, $errno, $errstr, 30);<br />
  if (!$handle) {<br />
  if ($fail_count &lt; 5) {<br />
  $i--;<br />
  $fail_count++;<br />
  }<br />
  } else {<br />
  if ($_REQUEST['c']) $cookie = &quot;Cookie: $_REQUEST[c]\r\n&quot;;<br />
  fwrite ($handle, &quot;GET $url HTTP/1.0\r\nHost: $host\r\nConnection: Close\r\n$cookie\r\n&quot;);</p>
<p> while (!feof ($handle)) {<br />
  $string = fgetc ($handle);<br />
  if ($string == '&lt;' || $string == '{') break;<br />
  }<br />
  while (!feof($handle)) {<br />
  $string .= fread($handle, 40960);<br />
  }<br />
  fclose($handle);<br />
  return $string;<br />
  }<br />
  }</p>
<p> if ($_REQUEST['t']) {<br />
  $query_order = array(1);<br />
  } else {<br />
  $num = 10;<br />
  if ($_REQUEST['se'] == 'y') $num = 50;<br />
  if ($_REQUEST['se'] == 'g') $num = 8;<br />
  <br />
  for ($i = 1; $i &lt;= $_REQUEST['d']; $i += $num) {<br />
  $query_order[] = $i;<br />
  }<br />
  <br />
  if ($_REQUEST['l'] &gt; 0 &amp;&amp; $_REQUEST['l'] &lt; 1001) {<br />
  $x = $_REQUEST['l'] - 1;<br />
  $y = $x - ($x % $num) + 1;<br />
  $query_order[$y / $num] = 1;<br />
  $query_order[0] = $y;<br />
  $slice = array_slice($query_order, 1, max (0, ($y / $num) - 1));<br />
  rsort ($slice); <br />
  foreach ($slice as $array_key =&gt; $value) {<br />
  $query_order[$array_key + 1] = $value;<br />
  }<br />
  }<br />
  }</p>
<p> if ($_REQUEST['se'] == 'g') {<br />
  $error = '';<br />
  $fail_count = 0;<br />
  for ($i = 0; $i &lt; count($query_order); $i++) {<br />
  @set_time_limit(30);<br />
  $start = $query_order[$i];<br />
  <br />
  $data = get_page ('ajax.googleapis.com', '/ajax/services/search/web?v=1.0&amp;rsz=large&amp;start=' . ($start - 1) . '&amp;q=' . urlencode ($_REQUEST['q']));<br />
  $parser = json_decode($data, true);</p>
<p> if ($_REQUEST['u'] &amp;&amp; is_array($parser['responseData']['results'])) {<br />
  unset ($results_detail);<br />
  $position = $start;<br />
  foreach ($parser['responseData']['results'] as $result) {<br />
  if (substr_count (strtolower ($result['url']), $_REQUEST['u'])) $results[] = $position;<br />
  <br />
  if ($_REQUEST['s']) {<br />
  $results_detail[$position]['title'] = $result['title'];<br />
  $results_detail[$position]['url'] = $result['unescapedUrl'];<br />
  }<br />
  $position++;<br />
  }<br />
  }</p>
<p> $results_total = $parser['responseData']['cursor']['estimatedResultCount'];<br />
  if ($error &amp;&amp; $fail_count &lt; 5) {<br />
  unset ($error);<br />
  $i--;<br />
  $fail_count++;<br />
  }<br />
  if ($results) break;<br />
  }<br />
  <br />
  } elseif ($_REQUEST['se'] == 'y') {<br />
  $error = '';<br />
  $fail_count = 0;<br />
  for ($i = 0; $i &lt; count($query_order); $i++) {<br />
  @set_time_limit(30);<br />
  $start = $query_order[$i]; <br />
  <br />
  $data = get_page ('api.search.yahoo.com', '/WebSearchService/V1/webSearch?appid=keywordtracker&amp;query=' . urlencode ($_REQUEST['q']) . '&amp;start=' . $start . '&amp;results=50');<br />
  <br />
  $parser = xml_parser_create('UTF-8');<br />
  xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); <br />
  xml_parse_into_struct($parser, $data, $vals, $index); <br />
  xml_parser_free($parser);</p>
<p> if ($index['ERROR']) {<br />
  $error = $vals[$index['MESSAGE'][0]]['value'];<br />
  }<br />
  <br />
  if ($_REQUEST['u'] &amp;&amp; is_array($index['URL'])) {<br />
  unset ($results_detail);<br />
  $position = $start;<br />
  foreach ($index['URL'] as $url_key) {<br />
  if ($vals[$url_key]['level'] == 3) {<br />
  if (substr_count (strtolower ($vals[$url_key]['value']), $_REQUEST['u'])) $results[] = $position;<br />
  <br />
  if ($_REQUEST['s']) {<br />
  $results_detail[$position]['title'] = $vals[$url_key - 2]['value'];<br />
  $results_detail[$position]['summary'] = $vals[$url_key - 1]['value'];<br />
  $results_detail[$position]['url'] = $vals[$url_key]['value'];<br />
  }<br />
  $position++;<br />
  }<br />
  }<br />
  }<br />
  $results_total = $vals[$index['RESULTSET'][0]]['attributes']['TOTALRESULTSAVAILABLE'];<br />
  if ($error &amp;&amp; $fail_count &lt; 5) {<br />
  unset ($error);<br />
  $i--;<br />
  $fail_count++;<br />
  }<br />
  if ($results_detail) {<br />
  if ($_REQUEST['s']) {<br />
  <br />
  $position_key = max(0, min ($results[0] - 4, count ($results_detail) - 10));<br />
  $results_detail = array_slice ($results_detail, $position_key, 10);<br />
  foreach ($results_detail as $result) {<br />
  $position_key++;<br />
  $results_new[$position_key] = $result;<br />
  }<br />
  $results_detail = $results_new;<br />
  }<br />
  break;<br />
  } <br />
  }<br />
  <br />
  } elseif ($_REQUEST['se'] == 'b') {<br />
  $error = '';<br />
  $fail_count = 0;<br />
  for ($i = 0; $i &lt; count($query_order); $i++) {<br />
  @set_time_limit(30);<br />
  $start = $query_order[$i];<br />
  <br />
  $data = get_page ('www.bing.com', '/search?q=' . urlencode ($_REQUEST['q']) . '&amp;first=' . $start . '&amp;count=10&amp;format=rss');</p>
<p> $parser = xml_parser_create('UTF-8');<br />
  xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); <br />
  xml_parse_into_struct($parser, $data, $vals, $index); <br />
  xml_parser_free($parser);</p>
<p> unset ($results_detail);<br />
  $position = $start;<br />
  if (is_array ($index['LINK'])) {<br />
  foreach ($index['LINK'] as $url_key) {<br />
  if ($vals[$url_key]['level'] == 4 &amp;&amp; !strpos($vals[$url_key]['value'], 'www.bing.com:80/search')) {<br />
  if (substr_count (strtolower ($vals[$url_key]['value']), $_REQUEST['u'])) $results[] = $position;<br />
  <br />
  if ($_REQUEST['s']) {<br />
  $results_detail[$position]['title'] = $vals[$url_key - 1]['value'];<br />
  $results_detail[$position]['summary'] = $vals[$url_key + 1]['value'];<br />
  $results_detail[$position]['url'] = $vals[$url_key]['value'];<br />
  }<br />
  $position++;<br />
  }<br />
  }<br />
  }<br />
  if ($results) break;<br />
  if ($error &amp;&amp; $fail_count &lt; 5) {<br />
  unset ($error);<br />
  $i--;<br />
  $fail_count++;<br />
  }<br />
  }<br />
  }<br />
  <br />
  if (!$results) $results[] = 9999;<br />
  $output['results'] = implode ('|', $results);<br />
  <br />
  if ($error) $output['error'] = $error;<br />
  <br />
  if ($_REQUEST['t']) {<br />
  $output['total'] = $results_total;<br />
  echo serialize($output);<br />
  } elseif ($_REQUEST['s']) {<br />
  $output['total'] = $results_total;<br />
  $output['detail'] = $results_detail;<br />
  echo serialize ($output);<br />
  } else {<br />
  echo serialize ($output);<br />
  }<br />
  <br />
  ?&gt;</p>
</body>
</html>