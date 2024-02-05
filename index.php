<?php

// Set the upload directory path
$uploadDir = 'uploads/';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
    $files = $_FILES['files'];

    // Iterate through each uploaded file
    for ($i = 0; $i < count($files['name']); $i++) {
        $fileName = $files['name'][$i];
        $fileTmp = $files['tmp_name'][$i];

        // Check for errors during file upload
        if ($files['error'][$i] === UPLOAD_ERR_OK) {
            // Move the uploaded file to the upload directory
            if (move_uploaded_file($fileTmp, $uploadDir . $fileName)) {
                echo "File '{$fileName}' uploaded successfully. Shareable link: <a href=\"{$uploadDir}{$fileName}\">{$fileName}</a><br>";
            } else {
                echo "File '{$fileName}' upload failed.<br>";
            }
        } else {
            echo "Error during file upload: {$files['error'][$i]}.<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Sharing Mini Project</title>
        <style>
        .drop-area {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
        }

        .drop-area.highlight {
            border-color: #0087F7;
        }
    </style>
</head>
<body>
<h1>File Sharing Mini Project</h1>

<div class="drop-area" id="dropArea">
    <div>Drag and drop files here or click to select files</div>
</div>
<br>

<div id="fileList"></div>

<script>
    var dropArea = document.getElementById('dropArea');
    var fileList = document.getElementById('fileList');

    dropArea.addEventListener('dragenter', handleDragEnter, false);
    dropArea.addEventListener('dragover', handleDragOver, false);
    dropArea.addEventListener('dragleave', handleDragLeave, false);
    dropArea.addEventListener('drop', handleDrop, false);

    function handleDragEnter(e) {
        e.preventDefault();
        dropArea.classList.add('highlight');
    }

    function handleDragOver(e) {
        e.preventDefault();
    }

    function handleDragLeave(e) {
        e.preventDefault();
        dropArea.classList.remove('highlight');
    }

    function handleDrop(e) {
        e.preventDefault();
        dropArea.classList.remove('highlight');

        var files = e.dataTransfer.files;
        var fileCount = files.length;

        for (var i = 0; i < fileCount; i++) {
            var file = files[i];
            var fileName = file.name;
            var fileSize = file.size;
            var fileItem = document.createElement('div');

            fileItem.innerHTML = fileName + ' (' + formatFileSize(fileSize) + ')';
            fileList.appendChild(fileItem);
        }
    }

    function formatFileSize(size) {
        var units = ['B', 'KB', 'MB', 'GB', 'TB'];
        var i = 0;

        while (size >= 1024 && i < units.length - 1) {
            size /= 1024;
            i++;
        }

        return size.toFixed(2) + ' ' + units[i];
    }
</script>

<form method="POST" enctype="multipart/form-data">
    <input type="submit" value="Upload">
</form>
</body>
</html>
