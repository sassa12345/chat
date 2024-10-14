<?php
header('Content-Type: application/json'); // JSONレスポンス用のヘッダー
$filename = 'groups/' . $_GET['groupName'] . '.txt';

if (file_exists($filename)) {
    $messages = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // メッセージを逆順に取得して表示
    $formattedMessages = implode('<br>', array_map('htmlspecialchars', array_reverse($messages)));

    echo json_encode(['newMessages' => $formattedMessages]);
} else {
    echo json_encode(['newMessages' => '']);
}
?>
