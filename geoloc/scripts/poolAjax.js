function sendRequest(u) {
    var obj = $.ajax({url: u, async: false});
    return $.parseJSON(obj.responseText);
}

$(function () {
    $('#loginButton').click(function () {
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;

        var theUrl = "http://52.89.116.249/~anna.addei/CarPool/geoloc/pool_ajax.php?cmd=1&username="+username+"&password="+password;
        var obj = sendRequest(theUrl);

        if (obj.result === 1) {
            alert("Login successful");
            window.open("http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#homepage");

        } else {
            alert("failed to login");
            window.open("http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#login");

        }
    });
});

$(function () {
    $('#signUpButton').click(function () {
        var firstname = document.getElementById('signUpFirstname').value;
        var lastname = document.getElementById('signUpLastname').value;
        var username = document.getElementById('signUpUsername').value;
        var phoneNumber = document.getElementById('signUpPhoneNumber').value;
        var password = document.getElementById('signUpPassword').value;

        var theUrl = "http://52.89.116.249/~anna.addei/CarPool/geoloc/pool_ajax.php?cmd=2&firstname=" +firstname+ "&lastname=" +lastname+
                        "&username="+username+ "&phoneNumber=" + phoneNumber+ "&password="+password;
        var obj = sendRequest(theUrl);

        if (obj.result == 1) {
            alert("Sign up successful");
            window.open("http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#login");

        } else {
            alert("failed to sign up");
            window.open("http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#signUp");

        }
    });
});

$(function () {
    $('#createPoolButton').click(function () {
        var spotsAvailable = document.getElementById('spotsAvailable').value;
        var fare = document.getElementById('fare').value;
        var date = document.getElementById('date').value;
        var destination = document.getElementById('destination').value;

        var theUrl = "http://52.89.116.249/~anna.addei/CarPool/geoloc/pool_ajax.php?cmd=3&spotsAvailable=" +spotsAvailable+ "&fare=" +fare+
            "&date="+date+ "&destination=" + destination;
        var obj = sendRequest(theUrl);

        if (obj.result == 1) {

            alert("Create pool successful");
            window.open("http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#homepage");

        } else {
            alert("failed to create pool");

            
            window.open("http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#createPool");

        }
    });
});

    $(function () {
    $('#joinPoolButton').click(function () {

        var theUrl = "http://52.89.116.249/~anna.addei/CarPool/geoloc/pool_ajax.php?cmd=4";
        var obj = sendRequest(theUrl);

        if (obj.result == 1) {

            var length = obj.pool.length;

            for(var i =0; i<length;i++){
               // var result ="<tr><td>"+obj.pool[i].spotsAvailable+"</td><td>"+obj.pool[i].fare+"</td><td>"+obj.pool[i].date+
               //      "</td><td>"+obj.pool[i].destination+"</td><td>"+obj.pool[i].owner+"</td></tr>";

            var result = "<div data-role='content' style='text-shadow: none'><div class='row'><div class='col s12 m7'>" +
                "<div class='card'><div class='card-image'><span class='card-title'> Destination: "+obj.pool[i].destination+
                "</span></div><div class='card-content'><span name='pid' hidden>"+obj.pool[i].pid+"</span><p>Destination: "+obj.pool[i].destination+
                "</p><p>Spots Available: "+obj.pool[i].spotsAvailable+"</p><p>Fare: "+ obj.pool[i].fare+"</p><p>Date: "+

                obj.pool[i].date+"</p><p>Owner: "+obj.pool[i].owner+"</p><p><a href='http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#mapPage'>View Location</a><button class='joinButton' onclick='joinButton("+obj.pool[i].pid+")'>Join</button></p></div></div>" + "</div></div></div>";

                $("#hello").append(result);
            }
            // result +="</table>";
            // document.getElementById('hello').innerHTML = result;
            location.href = "http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#joinPool";


        } else {
            alert("failed to sign up");
            // window.open("index.html#homepage");
        }
    });
});

function joinButton($pid) {
    var pid = $pid;
    var payment = "";
    var name=prompt("Would you like to pay by Cash or Mobile Money?","Mobile Money");
    if (name.toUpperCase()== "CASH"){
        payment = "cash";
    }
    else{
        payment = "mobile";
    }
    var theUrl = "http://52.89.116.249/~anna.addei/CarPool/geoloc/pool_ajax.php?cmd=5&pid=" + $pid +"&pay=" +payment;
    var obj = sendRequest(theUrl);

    if (obj.result == 1) {
        alert("join successful");
        window.open("http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#homepage");

    }else {
            alert("failed to join");
            //window.open("index.html#createPool");

        }
    }

$(function () {
    $('#poolsCreatedButton').click(function () {

        var theUrl = "http://52.89.116.249/~anna.addei/CarPool/geoloc/pool_ajax.php?cmd=6";
        var obj = sendRequest(theUrl);

        if (obj.result == 1) {

            var length = obj.pool.length;

            for(var i =0; i<length;i++){
                // var result ="<tr><td>"+obj.pool[i].spotsAvailable+"</td><td>"+obj.pool[i].fare+"</td><td>"+obj.pool[i].date+
                //      "</td><td>"+obj.pool[i].destination+"</td><td>"+obj.pool[i].owner+"</td></tr>";

                var result = "<div data-role='content' style='text-shadow: none'><div class='row'><div class='col s12 m7'>" +
                    "<div class='card'><div class='card-image'><span class='card-title'> Destination: "+obj.pool[i].destination+
                    "</span></div><div class='card-content'><span name='pid' hidden>"+obj.pool[i].pid+"</span><p>Destination: "+obj.pool[i].destination+
                    "</p><p>Spots Available: "+obj.pool[i].spotsAvailable+"</p><p>Fare: "+ obj.pool[i].fare+"</p><p>Date: "+
                    obj.pool[i].date+"</p><p><b>Cash plan : </b>"+obj.pool[i].passengers+"</p><p><b>Mobile Money plan : </b>"+obj.pool[i].mobilePassengers+"</p></div></div>" + "</div></div></div>";
                $("#myPoolList").append(result);
            }
            // result +="</table>";
            // document.getElementById('hello').innerHTML = result;
            location.href = "http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#myPool";


        } else {
            alert("failed to sign up");
            // window.open("index.html#homepage");
        }
    });
});








//var html = "<table border='1|1'>";
//for (var i = 0; i < length; i++) {

  //  html+="<tr>";
  // html+="<td>"+rows[i].spotsAvailable+"</td>";
  //  html+="<td>"+rows[i].fare+"</td>";
  //  html+="<td>"+rows[i].date+"</td>";
  //  html+="<td>"+rows[i].destination+"</td>";
  //  html+="<td>"+rows[i].owner+"</td>";

   // html+="</tr>";

//}
//html+="</table>";
//document.getElementById("box").innerHTML = html;

