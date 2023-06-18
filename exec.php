<?php

$action = $_GET["action"];
$param = $_GET["param"];
$tuning_file = $_GET["tuning-file"];
$pattern = $_GET["pattern"];
$raw = $_GET["raw"];
$counter = $_GET["counter"];
$resolution = $_GET["res"];
$shutter = $_GET["shutter"];
$gain = $_GET["gain"];
$awb = $_GET["awb"];
$awbr = $_GET["awbr"];
$awbb = $_GET["awbb"];
$ev = $_GET["exposure"];
$brightness = $_GET["brightness"];
$contrast = $_GET["contrast"];

$output=null;
$tun_file = null;
$filename = null;
$raw_p = null;
$width = 0;
$height = 0;
$awb_param = null;
$ext = ".jpg";
$nousb = false;

if (isset($resolution)) {
    $sign   = 'x';
    $length = strlen($resolution);
    $pos = strpos($resolution, $sign);
    $width = substr($resolution, 0, -($pos+1));
    $height = substr($resolution, ($pos+1));
}
if (isset($action)) {
    if ($action == "ctrl") {
        if (isset($raw)) {
            if ($raw) {
               $raw_p = " --raw";
            }
        }
        if ($pattern == 1) {
            //dd-mm_hh-mm_NNN
            if ($counter < 10) {
                $counter = "00" . $counter;
            } else if ($counter < 100) {
                $counter = "0" . $counter;
            }
            $filename = date("d-m") . "_" . date("H-i") . "_" . $counter . $ext;
        }
//    $command = shell_exec("echo {$action} >/tmp/vlc_command");
//    $command = exec("pwd", $output);

        if ($tuning_file != 'none') {
            $tun_file = " --tuning-file /usr/share/libcamera/ipa/raspberrypi/" . $tuning_file . ".json";
        }

        if ($awb == 'none') {
            $awb_param = "--awbgains {$awbr},{$awbb}";
        } else {
            $awb_param = "--awb {$awb}";
        }

        $cmd = "sudo libcamera-still{$tun_file} --width {$width} --height {$height}{$raw_p} --shutter {$shutter} --gain {$gain} {$awb_param} --ev {$ev} --brightness {$brightness} --contrast {$contrast} --immediate -o /var/www/html/img/{$filename}";
        $command = exec($cmd, $output);

        echo json_encode(array("action" => $action, "command" => $cmd, "output" => $output, "filename" => $filename));
    }
    else if ($action == "usb") {
        $detect = exec("find /dev -name sd* | head -n 1",$output);
        if ($detect != null) {
            $check = exec('test -d "/mnt/usb" && echo true || echo false',$output);
            if ($check == "false") {
                exec("sudo mkdir /mnt/usb",$output);
            }
                exec("sudo mount {$detect} /mnt/usb",$output);
                exec("sudo cp /var/www/html/img/* /mnt/usb",$output);
                exec("sudo umount /mnt/usb",$output);

        } else {
            $nousb = true;
            $output = "USB not detected";
        }
        echo json_encode(array("action" => $action, "command" => $detect, "output" => $output));
    }
}


