const WaitlistApi = {
    validateAdmin: function (data) {
        $.ajax({
          type: "POST",
          url: "api.php?path=/validate/admin",
          data: data,
          success: function (response) {
            window.location.href = response;            
          },
          error: function(jqXHR, status, error){
            alert("Inavlid Login.");
          }
        });
    },
    validatePatient: function (data) {
        $.ajax({
          type: "POST",
          url: "api.php?path=/validate/patient",
          data: data,
          success: function (response) {
                let data = JSON.parse(response);
                window.location.href = data.page;   
          },
          error: function(jqXHR, status, error){
            alert("Inavlid Login.");
          }
        });
    },
    insertNewPatient: function(data){
        $.ajax({
            type: "POST",
            url: "api.php?path=/insert/patient",
            data: data,
            success: function (response) {
                //patient inserted   
                window.location.href = response;        
            },
            error: function(jqXHR, status, error){
                //patient already exist
                //sent to patient page
                alert("Could not add to wait list.");
            }
          });
    },
    fetchWaitlistOrderedByTime: function(){
        $.ajax({
            type: "POST",
            url: "api.php?path=/fetch/waitlist/ordered/time",
            success: function (response) {
                renderTable(response, "patients-waitlist");
            },
            error: function(jqXHR, status, error){
                
            }
          });
    },
    fetchWaitlistOrderedBySeverity: function(){
        $.ajax({
            type: "POST",
            url: "api.php?path=/fetch/waitlist/ordered/severity",
            success: function (response) {
                renderTable(response, "patients-waitlist");
            },
            error: function(jqXHR, status, error){
                
            }
          });
    },
    fetchAllPatients: function(){
        $.ajax({
            type: "POST",
            url: "api.php?path=/fetch/all/patients",
            success: function (response) {
                renderTable(response, "patients-all");
            },
            error: function(jqXHR, status, error){
                
            }
          });
    },
    fetchWaitTime: function(){
        $.ajax({
            type: "POST",
            url: "api.php?path=/fetch/wait/time",
            success: function (response) {
                renderPatient(response);
            },
            error: function(jqXHR, status, error){
                console.log("error");
            }
          });
    },
}

let currentPatient = {
    name: "",
    code: "",
    time: ""
}

function submitAdmin(){
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let data = {
        username: username,
        password: password
    }
    WaitlistApi.validateAdmin(JSON.stringify(data));
}

function submitPatient(){
    let name = document.getElementById("name").value;
    let code = document.getElementById("code").value;
    let data = {
        name: name,
        code: code
    }
    WaitlistApi.validatePatient(JSON.stringify(data));
}

function waitPatient(){

    let name = document.getElementById("name").value;
    let injury = document.getElementById("injurySeverity").value;
    let data = {
        name: name,
        injury_severity: injury,
    }
    WaitlistApi.insertNewPatient(JSON.stringify(data));
}


function renderTable(jsonData, tableName){
    let tableContainer = document.getElementById(tableName);
    tableContainer.innerHTML = '';
    let table = document.createElement("table");
    let cols = Object.keys(jsonData[0]);
    let thead = document.createElement("thead");
    let tr = document.createElement("tr");

    cols.forEach((item) => {
        let th = document.createElement("th");
        if(item == "start_of_wait"){
            item = "Time waiting"
        }
        th.innerText = item;
        tr.appendChild(th);
    });
    thead.appendChild(tr);
    table.appendChild(tr);

    jsonData.forEach((item) =>{
        let tr = document.createElement("tr");

        let vals = Object.values(item);

        vals.forEach((elem) => {
            let td = document.createElement("td")
            td.innerText = elem;
            tr.appendChild(td);
        });
        table.appendChild(tr);
    });
    tableContainer.appendChild(table);

}

function renderPatient(jsonData){
    let nameBox = document.getElementById("patient-name");
    let codeBox = document.getElementById("patient-code");
    let timeBox = document.getElementById("time");

    nameBox.innerText = jsonData.name;
    codeBox.innerText = jsonData.code;
    timeBox.innerText = jsonData.waitTime;
}

