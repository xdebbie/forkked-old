<?php
require_once './includes/config.php';
include_once './includes/dao.php';
$dao = new DAO();
$dao->setDb($db);

$rows = $dao->read_all_albums();
$data = "pubdate; score; artist; album; genre; label; year;
 url; \n";
foreach ($rows as $item) {
    $pubdate = strtotime($item->pubdate);
    $pubdate = date('Y-m-d', $pubdate);
    $data .= $pubdate . ';' . $item->score . ';"' . $item->artist . '";"' . $item->album . '";"' . $item->genre . '";"' . $item->label . '";' . trim(str_replace('• ', '', $item->year)) . ';"' . $item->url . '";' . "\n";
}

header('Content-type: application/octet-stream');
header('Pragma: no-cache');
header('Expires: 0');
print "$header\n$data";
