<?php 

$start = (int) time();
while (true) {
	if ((int) time() > $start) {
		$start = (int) time();
		break;
	}
}
$end = ((int) time()) + 1;
$i = 0;
$url = 'http://t.l:81/index.php?r=site%2Fmoney';

$content=0;

while (time() < $end) {
	$content_ = file_get_contents($url);
        if ($content_ !== false) 
	$content++;
	$i++;
}

echo $content;
echo '======';
echo $i;
echo PHP_EOL;
