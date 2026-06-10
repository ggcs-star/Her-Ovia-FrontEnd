<?php
$apiUrl = 'https://admin.maherajewels.com/api/app-settings';
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

if ($data['success']) {
    $appName = $data['data']['app_name'];
    $appLogo = $data['data']['app_logo'];
    
    echo "📦 Fetching: $appName\n";
    
    $envFile = '.env';
    if (file_exists($envFile)) {
        $env = file_get_contents($envFile);
        $env = preg_replace('/APP_NAME="[^"]+"/', 'APP_NAME="' . $appName . '"', $env);
        file_put_contents($envFile, $env);
        echo "✅ .env updated\n";
    }
    
    $manifest = file_get_contents('nativephp/android/app/src/main/AndroidManifest.xml');
    $manifest = preg_replace('/android:label\s*=\s*"[^"]+"/', 'android:label="' . $appName . '"', $manifest);
    file_put_contents('nativephp/android/app/src/main/AndroidManifest.xml', $manifest);
    echo "✅ Manifest updated\n";
    
    $stringsFile = 'nativephp/android/app/src/main/res/values/strings.xml';
    if (file_exists($stringsFile)) {
        $strings = file_get_contents($stringsFile);
        $strings = preg_replace('/<string name="app_name">[^<]+<\/string>/', '<string name="app_name">' . $appName . '</string>', $strings);
        file_put_contents($stringsFile, $strings);
        echo "✅ Strings.xml updated\n";
    }
    
    $iconData = file_get_contents($appLogo);
    if ($iconData) {
        $folders = ['hdpi', 'mdpi', 'xhdpi', 'xxhdpi', 'xxxhdpi'];
        foreach ($folders as $folder) {
            $path = "nativephp/android/app/src/main/res/mipmap-$folder/ic_launcher.png";
            file_put_contents($path, $iconData);
            file_put_contents(str_replace('ic_launcher.png', 'ic_launcher_round.png', $path), $iconData);
            echo "✅ $folder\n";
        }
        echo "✅ Icon saved\n";
    }
    $iconData = file_get_contents($appLogo);

if ($iconData) {

    $folders = ['hdpi', 'mdpi', 'xhdpi', 'xxhdpi', 'xxxhdpi'];

    foreach ($folders as $folder) {

        $path = "nativephp/android/app/src/main/res/mipmap-$folder/ic_launcher.png";

        file_put_contents($path, $iconData);

        file_put_contents(
            str_replace('ic_launcher.png', 'ic_launcher_round.png', $path),
            $iconData
        );

        echo "✅ $folder\n";
    }

    echo "✅ Icon saved\n";

    // Play Store icon

    $playstoreDir = 'nativephp/android/app/src/main/playstore';

    if (!is_dir($playstoreDir)) {
        mkdir($playstoreDir, 0777, true);
    }

    file_put_contents(
        $playstoreDir . '/ic_launcher_playstore.png',
        $iconData
    );

    echo "✅ Play Store icon saved\n";
}
} else {
    echo "❌ API failed\n";
}