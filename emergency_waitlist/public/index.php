<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='assets/style.css' />
    <script type="text/javascript" src="assets/emergencyWaitlist.js"></script>
    <script type="text/javascript" src="assets/jquery-3.7.1.min.js"></script>
    <title>Main</title>
</head>
<body>
    <div class="page-container">
        <div class="form-container" id="patient-form">
            <form >
                <div>Patient Login</div>
                <input type="text" name="name" id="name" placeholder="Name" required >
                <span class="focus-bg"></span>
                <input type="text" name="code" id="code" placeholder="3 Letter Code" required maxlength="3">
                <input class="input-button" type="button" value="Login" id="submitPatientButton" onclick="submitPatient();"> 
                <div id="sperator">Or</div>
                <label for="injurySeverity">Enter severity of injury (1-5):</label>
                <input type="text" name="injurySeverity" id="injurySeverity" placeholder="Injury">
                <input class="input-button" type="button" value="Enter waitlist" id="waitPatientButton" onclick="waitPatient();"> 
    
            </form>
        </div>
        <div class="form-container" id="admin-form">
            <form >
                <div>Admin Login</div>
                <input type="text" name="username" id="username" placeholder="Username" required >
                <input type="text" name="password" id="password" placeholder="Password" required >
                <input class="input-button" type="button" value="Login" id="submitAdminButton" onclick="submitAdmin();"> 
            </form>
        </div>
    </div>

</body>
</html>