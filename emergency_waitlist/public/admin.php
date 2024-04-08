<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='assets/style.css' />
    <script type="text/javascript" src="assets/emergencyWaitlist.js"></script>
    <script type="text/javascript" src="assets/jquery-3.7.1.min.js"></script>
    <title>Admin</title>
    <script>
        window.onload = function(){
            WaitlistApi.fetchWaitlistOrderedByTime(); //initial load
            WaitlistApi.fetchAllPatients();
            // setInterval(WaitlistApi.fetchWaitlistOrderedByTime, 1000); //keep refreshing
        }
    </script>
</head>
<body>
    <div class="title">Admin Dashboard</div>
    <div class="dashboard-container">
        <div class="tables-container">
            <button onclick="WaitlistApi.fetchWaitlistOrderedByTime();">Order by time</button>
            <button onclick="WaitlistApi.fetchWaitlistOrderedBySeverity();">Order by Severity</button>
            <div class="row">
                <div class="col">
                    <div class="patient-table" id="patients-waitlist"></div>
                </div>
                <div class="col">
                    <div class="patient-table" id="patients-all"></div>
                    
                </div>
            </div>
        </div>
        <!-- <div class="patient-table" id="patients-operating"></div> -->
    </div>
</body>
</html>