<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ファイル名とパスの設定
$groupName = $_POST['groupName'] ?? 'default'; // デフォルトグループ名
$filename = 'groups/' . $groupName . '.txt';

// 名前とメッセージの取得
$name = $_POST['name'] ?? '';
$message = $_POST['message'] ?? '';

// IPアドレスとタイムスタンプを追加
$ipAddress = $_SERVER['REMOTE_ADDR'];
$timeStamp = date('Y-m-d H:i:s');

// メッセージが空でない場合のみ保存
if (!empty($name) && !empty($message)) {
    // 新しいメッセージのフォーマット
    $formattedMessage = "[$timeStamp] [$ipAddress] $name: $message";

    // 現在のファイル内容を取得し、各行ごとに配列として読み込み
    $currentMessages = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    
    // 15文を超えていた場合、最も古いメッセージを削除
    if (count($currentMessages) >= 15) {
        array_pop($currentMessages); // 最も古いメッセージを削除
    }

    // 新しいメッセージを先頭に追加
    array_unshift($currentMessages, $formattedMessage);

    // 配列を改行で区切ってファイルに保存
    if (file_put_contents($filename, implode("\n", $currentMessages) . "\n") === false) {
        echo "メッセージの保存に失敗しました。";
    }
}
?>
