<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='assets/style.css' />
    <script type="text/javascript" src="assets/emergencyWaitlist.js"></script>
    <script type="text/javascript" src="assets/jquery-3.7.1.min.js"></script>
    <title>Patient</title>
    <script>
        window.onload = function(){
            WaitlistApi.fetchWaitTime(); //initial load
            // setInterval(WaitlistApi.fetchWaitlistOrderedByTime, 1000); //keep refreshing
        }
    </script>
</head>
<body>
    <div class="patient-header">
        <span class="text">Hello</span>
        <span class="text" id="patient-name" name="patient-name"></span>
        <span class="text" id="patient-code" name="patient-code"></span>
    </div>
    <label id="label-time" for="time">Approximate wait time:</label>
    <div class="time-container">
        <span class="text" id="time" name="time"></span>
    </div>
</body>
</html>