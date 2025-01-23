<?php
// Path ke direktori /files
$uploadDir = __DIR__ . '/files';

// Daftar ekstensi berbahaya
$dangerousExtensions = [
    'cgi', 'pl', 'py', 'pyc', 'pyo', 'php3', 'php4', 'php6', 'pcgi', 'pcgi3', 'pcgi4', 'pcgi5', 'pcgi6', 'inc',
    'php', 'Php', 'pHp', 'phP', 'PHp', 'pHP', 'PhP', 'PHP', 'php5', 'Php5', 'pHp5', 'phP5', 'PHp5', 'pHP5', 'PhP5', 'PHP5',
    'phar', 'PHAR', 'Phar', 'PHar', 'PHAr', 'pHAR', 'phAR', 'phaR', 'php6', 'php7', 'php8', 'php9', 'phtml', 'Phtml',
    'pHtml', 'phTml', 'pHTml', 'phtMl', 'phtmL', 'PHTML', 'PHTml', 'PHTMl', 'PhtMl', 'PHTml', 'PHtML', 'pHTMl', 'PhTML',
    'pHTML', 'PhtmL', 'PHTmL', 'PhtMl', 'PhtmL', 'pHtMl', 'PhTmL', 'pHtmL', 'aspx', 'ASPX', 'asp', 'ASP',
    'php.jpg', 'php.jpeg', 'php.pjpeg', 'php.png', 'php.gif', 'php.test', 'php;.jpg', 'php.bak', 'php.pdf', 'php.xlsx',
    'php.zip', 'php56', 'php78', 'php96', 'php69', 'php67', 'php68', 'shtml', 'php.unknown', 'php.doc', 'php.docx',
    'php.xxxjpg', 'php.xxxjpeg', 'php.xxxgif', 'php.xxxpjpeg', 'php.xxxpng', 'php.xxxtxt', 'php.xxxtxt', 'php.xxxzip',
    'alfa', 'suspected', 'py', 'exe', 'htm', 'html', 'htaccess'
];

// Fungsi untuk mengubah isi file berbahaya menjadi teks
function secureUpload($uploadDir, $dangerousExtensions) {
    // Scan file di dalam direktori
    $files = scandir($uploadDir);

    foreach ($files as $file) {
        // Abaikan file . dan ..
        if ($file === '.' || $file === '..') {
            continue;
        }

        // Path lengkap file
        $filePath = $uploadDir . '/' . $file;

        // Cek apakah file memiliki ekstensi berbahaya
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if (in_array($extension, $dangerousExtensions)) {
            // Overwrite isi file dengan teks statis
            $newContent = "File ini telah diamankan oleh sistem.\n";
            file_put_contents($filePath, $newContent);

            echo "File $file dengan ekstensi $extension telah diamankan. Isi file telah diubah.\n";
        }
    }
}

// Monitoring folder
echo "Monitoring folder $uploadDir untuk file berbahaya...\n";
while (true) {
    secureUpload($uploadDir, $dangerousExtensions);

    // Tunggu selama 2 detik sebelum scan ulang
    sleep(2);
}
