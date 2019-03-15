<?php
print "Usage: php s3rk.php company s3.txt \r\n";
$company = $argv[1];
$brute   = file($argv[2]);
$dot     = ".";
function curlthat($url)
{
    $ch      = curl_init();
    $timeout = 15;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    @$take = curl_getinfo($ch);
    curl_close($ch);
    return $data;
}
foreach ($brute as $sub) {
    curlthat("http://$sub$dot$company.s3.amazonaws.com");
    if ($take['HTTP_CODE'] == 200) {
        echo "Found S3: http://$sub$dot$company.s3.amazonaws.com \r\n";
        $ok = fopen("s3.txt", "a+");
        fwrite("http://$sub$dot$company.s3.amazonaws.com", $ok);
        fclose($ok);
    } else {
        echo "S3 Not Found: http://$sub$dot$company.s3.amazonaws.com \r\n";
    }
}
?>
