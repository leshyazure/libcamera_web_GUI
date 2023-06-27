<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Libcamera PHP web controller">
    <meta name="author" content="DP">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="../../../../favicon.ico">
    <title>PHP camera GUI</title>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script>

        function resetCounter() {
            const cntr = document.getElementById("counter");
            cntr.value = 0;
        }

        function incrementCounter() {
            let i = document.getElementById("counter").value;
            i++;
            document.getElementById("counter").value = i;
        }

        //
        // const stop = document.getElementById("stop");

        // snap.addEventListener("click", ()=>{executeCommand('ctrl', 'snap')});
        // next.addEventListener("click", ()=>{executeCommand('next')});
        // prev.addEventListener("click", ()=>{executeCommand('prev')});
        // stop.addEventListener("click", ()=>{executeCommand('stop')});

        async function executeCommand(action, param) {
            //const snap = document.getElementById("snap");
            let data;
            let pattern = document.getElementById("pattern").value;
            let counter = document.getElementById("counter").value;
            let tuning_file = document.getElementById("tuning-file").value;
            let resolution = document.getElementById("resolution").value;
            let shutter = document.getElementById("shutter").value;
            let gain = document.getElementById("gain").value;
            let awb = document.getElementById("awb").value;
            let awbr = document.getElementById("awb_r").value;
            let awbb = document.getElementById("awb_b").value;
            let exposure = document.getElementById("exposure").value;
            let brightness = document.getElementById("brightness").value;
            let contrast = document.getElementById("contrast").value;
            let raw = document.getElementById("raw").checked;
            let snap_spinner = document.getElementById("snap_spinner");
            let usb_spinner = document.getElementById("usb_spinner");

            if (action == 'ctrl') {
                try {
                    snap_spinner.classList.remove("d-none");
                    const res = await fetch(`exec.php?action=${action}&param=${param}&pattern=${pattern}&raw=${raw}&counter=${counter}&tuning-file=${tuning_file}&res=${resolution}&shutter=${shutter}&gain=${gain}&awb=${awb}&awbr=${awbr}&awbb=${awbb}&exposure=${exposure}&brightness=${brightness}&contrast=${contrast}`);
                    // console.log(res.json());
                    data = await res.json();
                    // let data = resp;
                    console.log(data);
                    // console.log(resp.filename);
                    // document.getElementById("dbg").innerHTML = resp.count;

                } catch (error) {
                    console.error(new Error(error));
                }
                document.getElementById("preview").src = "img/" + data.filename;
                snap_spinner.classList.add("d-none");
                incrementCounter();
            } else if (action == 'usb') {
                try {
                    usb_spinner.classList.remove("d-none");
                    const res = await fetch(`exec.php?action=${action}`);
                    data = await res.json()
                   // if (data.)
                    console.log(data);
                } catch
                    (error) {
                    console.error(new Error(error));
                }
                usb_spinner.classList.add("d-none");

            }
        }
    </script>

</head>
<body>
<div class="container-fluid p-1 text-left" style="width: 98%;">
    <div class="container-fluid mt-1">
        <div class="row">
            <div class="col-xs-7 col-lg-7 float-left" onclick="executeCommand('ctrl', 'snap')">
                <img src="default.png" class="img-fluid" id="preview"/>
            </div>

            <div class="col-xs-5 col-lg-5 float-right">
                <div class="col-xs-12">

                    <div class="text-center my-2 pb-3">
                        <h3>PHP camera GUI</h3>
                    </div>
                </div>
                <form>
                    <div class="my-2 form-group row form-inline">
                        <label for="pattern" class="col-xs-2 col-form-label">Filename</label>
                        <div class="col-xs-5">
                            <select class="form-control" id="pattern">
                                <option value="1">dd-mm_hh-mm_NNN</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <input type="number" class="col-xs-2 form-control" id="counter" value="0">
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="col-xs-1 btn btn-success form-control" id="reset"
                                    onclick="resetCounter()">Reset
                            </button>
                        </div>
                    </div>
                    <div class="my-2 form-group row">
                        <label for="resolution" class="col-xs-2 col-form-label">Resolution</label>
                        <div class="col-xs-10">
                            <select class="form-control" id="resolution">
                                <option value="3280x2464">3280 x 2464</option>
                                <option value="1920×1080">1920 × 1080</option>
                                <option value="1640×1232">1640 × 1232</option>
                                <option value="640x480">640 x 480</option>
                            </select>
                        </div>
                    </div>
                    <div class="my-2 form-group row">
                        <label for="shutter" class="col-xs-2 col-form-label">Shutter (μs)</label>
                        <div class="col-xs-10">
                            <input type="number" class="col-xs-2 form-control" id="shutter" value="0">
                        </div>
                    </div>
                    <div class="my-2 form-group row">
                        <label for="gain" class="col-xs-2 col-form-label">Gain</label>
                        <div class="col-xs-10">
                            <input type="number" class="col-xs-2 form-control" id="gain" value="0">
                        </div>
                    </div>
                    <div class="my-2 form-group row">
                        <label for="exposure" class="col-xs-2 col-form-label">Exposure</label>
                        <div class="col-xs-10">
                            <input type="number" class="col-xs-2 form-control" id="exposure" value="0">
                        </div>
                    </div>
                    <div class="my-2 form-group row">
                        <label for="awb" class="col-xs-2 col-form-label">AWB mode</label>
                        <div class="col-xs-10">
                            <select class="form-control" id="awb">
                                <option value="none">none</option>
                                <option value="auto">auto</option>
                                <option value="incandescent">incandescent</option>
                                <option value="tungsten">tungsten</option>
                                <option value="fluorescent">fluorescent</option>
                                <option value="indoor">indoor</option>
                                <option value="daylight">daylight</option>
                                <option value="cloudy">cloudy</option>
                            </select>
                        </div>
                    </div>
                    <div class="my-2 form-group row">
                        <label for="awb_gain" class="col-xs-2 col-form-label">AWB gain</label>
                        <div class="col-xs-1 checkbox-inline">
                            <label for="awb_r" class="col-xs-2 col-form-label">Red:</label>
                        </div>
                        <div class="col-xs-3 checkbox-inline">
                            <input type="number" class="col-xs-2 form-control" id="awb_r" value="0">
                        </div>
                        <div class="col-xs-1 checkbox-inline">
                            <label for="awb_b" class="col-xs-2 col-form-label">Blue:</label>
                        </div>
                        <div class="col-xs-3 checkbox-inline">
                            <input type="number" class="col-xs-2 form-control" id="awb_b" value="0">
                        </div>
                    </div>
                    <div class="my-2 form-group row">
                        <label for="brightness" class="col-xs-2 col-form-label">Brightness</label>
                        <div class="col-xs-10">
                            <input type="number" class="col-xs-2 form-control" id="brightness" value="0.0">
                        </div>
                    </div>
                    <div class="my-2 form-group row">
                        <label for="contrast" class="col-xs-2 col-form-label">Contrast</label>
                        <div class="col-xs-10">
                            <input type="number" class="col-xs-2 form-control" id="contrast" value="1.0">
                        </div>
                    </div>

                    <div class="my-2 form-group row">
                        <label for="tuning-file" class="col-xs-2 col-form-label">Tuning file</label>
                        <div class="col-xs-10">
                            <select class="form-control" id="tuning-file">
                                <option value="none">-- none --</option>
                                <option value="imx219">imx219</option>
                                <option value="imx219">imx219_noir</option>
                                <option value="imx290">imx290</option>
                                <option value="imx296">imx296</option>
                                <option value="imx296_mono">imx296_mono</option>
                                <option value="imx378">imx378</option>
                                <option value="imx477">imx477</option>
                                <option value="imx477_noir">imx477_noir</option>
                                <option value="imx477_scientific">imx477_scientific</option>
                                <option value="imx519">imx519</option>
                                <option value="imx708">imx708</option>
                                <option value="imx708_noir">imx708_noir</option>
                                <option value="imx708_wide">imx708_wide</option>
                                <option value="imx708_wide_noir">imx708_wide_noir</option>
                                <option value="ov5647">ov5647</option>
                                <option value="ov5647_noir">ov5647_noir</option>
                                <option value="ov9281_mono">ov9281_mono</option>
                                <option value="se327m12">se327m12</option>
                                <option value="uncalibrated">uncalibrated</option>

                            </select>
                        </div>
                    </div>
                    <div class="my-2 form-group row">

                        <label for="raw" class="col-xs-2 col-form-label">Save as RAW</label>
                        <div class="col-xs-10 my-2">
                            <input class="form-check-input" type="checkbox" id="raw" value="enable_raw">
                        </div>

                    </div>

                    <div class="my-4 col-xs-8">
                        <button type="button" class="mx-3 btn btn-success" id="snap" onclick="executeCommand('ctrl', 'snap')">
                            <span class="d-none mx-2 spinner-border spinner-border-sm" id="snap_spinner" role="status"
                                  aria-hidden="true"></span>
                            <span class="sr-only">Snap</span>
                        </button>
                        <button type="button" class="mx-3 btn btn-success" id="usb"
                                onclick="executeCommand('usb', 'usb')">
                            <span class="d-none mx-2 spinner-border spinner-border-sm" id="usb_spinner" role="status"
                                  aria-hidden="true"></span>
                            <span class="sr-only">Copy to USB</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <div class="container-fluid text-center pt-5">
        <p id="dbg"></p>
        <hr class="hr"/>
        <p class="text-muted">© SIM 2023</p>

    </div>
</div>

</body>
</html>
<?php
