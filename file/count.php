<?php

$filename = "count.txt";
$content = file_get_contents($filename);

if($content === false){ die("讀取失敗"); }

if($content == ""){
  echo "BB";
  $DataArray = [];
} else {
  $DataArray = json_decode($content, true);
}

$DataArray_keys = array_keys($DataArray);

if(!in_array($_GET['url_1'], $DataArray_keys)){
  $DataArray[$_GET['url_1']]['count'] = 1;
} else {
  $DataArray[$_GET['url_1']]['count']++;
}

$editContent = json_encode($DataArray);

$writeResult = file_put_contents($filename, $editContent);

if($writeResult === false){ die("寫入失敗"); }

// --- .txt 儲存數據 Ok. ---
// exit;

$count_number = $DataArray[$_GET['url_1']]['count'];

$count_number = str_pad($count_number, 4, "0", STR_PAD_LEFT);

header("Content-Type: image/svg+xml");

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: 0");
header("Pragma: no-cache");

// 參數設定
$digitWidth = 40;   // 每個數字區塊的寬度
$digitHeight = 60;  // 每個數字區塊的高度
$gap = 5;           // 數字間距
$digits = $count_number;
$fontSize = 36;
$svgWidth = (strlen($digits) * ($digitWidth + $gap)) - $gap;
$svgHeight = $digitHeight;

// 輸出 SVG 開始標籤
echo '<svg width="' . $svgWidth . '" height="' . $svgHeight . '" xmlns="http://www.w3.org/2000/svg">' . "\n";

// 逐個繪製數字與背景
for ($i = 0; $i < strlen($digits); $i++) {
    $x = $i * ($digitWidth + $gap);
    $y = 0;
    $char = $digits[$i];

    // 背景方塊
    echo '<rect x="' . $x . '" y="' . $y . '" width="' . $digitWidth . '" height="' . $digitHeight . '" fill="black" rx="5" ry="5" />' . "\n";

    // 數字文字
    echo '<text x="' . ($x + $digitWidth / 2) . '" y="' . ($y + $digitHeight * 0.7) . '" ';
    echo 'font-size="' . $fontSize . '" fill="lime" font-family="monospace" text-anchor="middle">';
    echo $char . '</text>' . "\n";
}

// 關閉 SVG
echo '</svg>';



?>
