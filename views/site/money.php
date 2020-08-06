<?php
$html = $data;

file_put_contents('/var/www/html/basic/web/stat/site-money.html', $html);
echo $html;