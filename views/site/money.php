<?php

$data = '<h1>Курс валют</h1>';
$data .= '<p><table>';

foreach ($money as $item) {
    $data .= '<tr>';
    $data .= '<td>';
    $data .= $item['money_CharCode'];
    $data .= '</td>';
    $data .= '<td>';
    $data .= $item['count'];
    $data .= '</td>';
    $data .= '<td>';
    $data .= $item['money_Name'];
    $data .= '</td>';
    $data .= '</tr>';
}

$data .= '</table></p>';
$html = $data;

file_put_contents(\Yii::getAlias('@webroot') . '/stat/site-money.html', $html);
echo $html;