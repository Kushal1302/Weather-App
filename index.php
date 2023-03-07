<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" class="css">
    <title>Weather - App</title>
</head>
<body style="background: linear-gradient(blue,10%, pink); height: 140vh; width:100%;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
        <div class="container-fluid">
          <a class="navbar-brand" href="#" id="logo">Weather App</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="">Logout</a>
              </li>
             
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" id="inputSearch" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit"  id="inputButton">Search</button>
              </form>
          </div>
        </div>
     
    </nav>
    <div class="container content mt-5">
        <div class="row">
            <div class="col-md-6 offset-3">
                <form action="" >
                    <label for="city " class="fw-bold fs-3">Enter City :</label>
                    <input type="text" class="form-control bg-transparent text-center mt-3" name="city" id="city">
                    <button id="submit" class="btn btn-success mt-4" type="submit">Search</button>
                   
                </form>
             
            </div>
           
        </div>
        <div class="row" id="weather">
        

        </div>
    </div>
<div class="footer container">
    <h2 class="text-center fw-bold ">Feedback Form</h2>
    <div class="row">
        <div class="col-md-6 offset-3">
            <form action="weatherApp.php" method="post">
                <label for="name" class="fw-bold">Enter Your Name</label>
                <input type="text" class="form-control" id="name" name="name">
                <label for="name" class="fw-bold">Enter Phone Number</label>
                <input type="number" class="form-control" id="number" name = "number">
                <label class="fw-bold">Message</label>
                <textarea class="form-control" id="textarea" cols="30" rows="6" name = "message"></textarea>
                <button type="submit" class="btn btn-success mt-3">Submit</button>
                <button type="reset" class="btn btn-danger mt-3">Reset</button>
            </form>
        </div>
    </div>
</div>

<?php
    $server = "localhost";
    $dbname = "weatherfeedback";
    $pass = "";
    $serverName = "root";
    $conn = mysqli_connect($server , $serverName , $pass , $dbname);
   
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name = $_POST['name'];
        $number = $_POST['number'];
        // echo $name;
        $message = $_POST['message'];
        
        $sql = "Insert into `weatherfeedback` (`name` , `number` , `message`) values ('$name' , '$number' , '$message')";
        $result = mysqli_query($conn , $sql);
    }



?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        const city = document.querySelector('#city') 
        const  Search = document.querySelector('#inputSearch');
        const apiKey = `3ebedc18270a5a055880cb64d33311aa`;
        const weather = document.getElementById('weather');
        const getWeather = async(city)=> {
            weather.innerHTML = `<h2> Loading </h2>`
            const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`
            const response = await fetch(url)
            const data = await response.json()
            console.log(data)
            return showWeather(data)
        }
        const getWeather2 = async(Search)=> {
            weather.innerHTML = `<h2> Loading </h2>`
            const url = `https://api.openweathermap.org/data/2.5/weather?q=${Search}&appid=${apiKey}&units=metric`
            const response = await fetch(url)
            const data = await response.json()
            console.log(data)
            return showWeather(data)
        }
    let showWeather = (data) =>{
            console.log(data)
            if(data.cod === "404"){
                weather.innerHTML = `
           
            <div>
                <h2 style="color:blue;">City Not Found</h2>
                
            </div>
            `
            }
            if(data.weather[0].main === "Clouds"){
                document.body.style.background = "linear-gradient(pink,20%, #afb6b9)"

            }else if(data.weather[0].main === "Clear"){
                document.body.style.transition = "backgroundColor 5s";
                document.body.style.background = "linear-gradient(pink,20%, #F7CD5D)"

            }else if(data.weather[0].main === "Haze"){
                document.body.style.background = " linear-gradient(pink , 20% , #9099a1)"
            }
            weather.innerHTML = `
            <div>

                <img src="https://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png" alt="">
                <span>${data.weather[0].main} <span style="font-size:50px;">${data.main.temp}°</span></span>
            
            </div>
            <div>
               
                <h2> Pressure = ${data.main.pressure} </h2>
                <h2> Wind Speed = ${data.wind.speed} </h2>  
            </div>
            `
            
            
        }
        document.getElementById("submit").addEventListener("click" ,function(event) {
           getWeather(city.value)
            event.preventDefault()
        })
       document.getElementById('inputButton').addEventListener("click",function(event){
        getWeather2(Search.value)
            event.preventDefault()
       })
  
      
      
    </script>
</body>
</html>
    
