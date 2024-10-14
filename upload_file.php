<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$groupName = $_POST['groupName'] ?? 'default';
$uploadDir = 'uploads/' . $groupName . '/'; // グループごとにフォルダを作成
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$response = ['status' => 'error', 'message' => 'ファイルのアップロードに失敗しました。'];

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = basename($_FILES['file']['name']);
    $destination = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $destination)) {
        $response['status'] = 'success';
        $response['message'] = 'ファイルが正常にアップロードされました。';
        $response['filePath'] = $destination;
        $response['fileName'] = $fileName;
    } else {
        $response['message'] = 'ファイルの保存に失敗しました。';
    }
}

echo json_encode($response);
?>
