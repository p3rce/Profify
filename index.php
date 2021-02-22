<?php

include('inc/header.php');

session_start();

if(isset($_SESSION['username']) || $_SESSION['sessionID']){

   header("location: home");

} else{

    

}




?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-language" content="en" />
    <meta name="author" content="https://www.profify.ca" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta name="description" content="Profify lets you organize all your social media sites into one so people can connect with you easier!" />
    <meta name="keywords" content="profify, profify.ca, Profify, link sharing, one link organizer, link organizer" />
    <meta property="og:description" />
    
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Profify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <!-- <link type="image/ico" rel="shortcut icon" href="favicon.ico" />
    <link type="image/png" rel="shortcut icon" href="assets/img/sunshinelogo.png" />
    <link rel="apple-touch-icon" href="assets/img/sunshinelogo.png" /> -->

    <link rel="icon" type="image/x-icon" href="{{ ('favicon.ico') }}" />


    <style type="text/css">
    #animate{
  margin: 0 auto;
  width: 20px;
  overflow: visible;
  position: relative;
}

#all{
  overflow: hidden;
  height: 100vh;
  width: 100%;
  position: fixed;
}


    </style>
</head>



<body style="background-color: #fffc00;" id="all">
    <!-- Start: Navigation with Button -->
    <div id="animate">
  </div>
    
    <!-- End: Navigation with Button -->
    <div style="/*padding-bottom: 0px;*/">
        <!-- Start: Main info -->
        <div class="text-center">
            <h1 style="font-size: 70px;color: #000000;"><strong>Profify</strong></h1><span style="font-size: 20px;">
            <strong>One Profile. For All Your Profiles.</strong><br>
            
            <p style="font-size:12px;"> Link your Insta, Snap, VSCO, <br> YouTube, SoundCloud, etc all to one place.</p>
           
            
            </span>
            <!-- Start: Login & Sign Up btns -->
            <div class="btn-group-vertical btn-group-lg" role="group" style="/*display: inherit;*/display: grid;margin-top: 20px;margin:auto;">
            <a class="btn" href="signup" style="margin-left: 10px;margin-right: 10px;border-radius: 2%;margin-top: 5px;margin-bottom: 10px;background-color: #ffffff;color: rgb(0,0,0);width: 350px;margin-bottom:20px;margin-top:10px;box-shadow: 1px 6px 2px 1px;"><strong>Create a Page</strong></a>
            <a class="btn" href="login" style="margin-left: 10px;margin-right: 10px;border-radius: 2%;padding-left: 30px;padding-right: 29px;margin-top: 5px;margin-bottom: 10px;background-color: #ffffff;color: rgb(0,0,0);width: 350px;box-shadow: 1px 6px 2px 1px;"><strong>Log In</strong></a>
            
            </div>
            
            <!-- End: Login & Sign Up btns -->
        </div>
        <!-- End: Main info -->
    </div>
    <!-- Start: simple footer -->
    <div class="footer-2" style="position: fixed;left: 0;bottom: 0;width: 100%;background-color: black;color: white;text-align: center;">
        <div class="container">
            <div class="row">
                <div class="col-8 col-sm-6 col-md-6">
                    <p class="text-left" style="margin-top:5%;margin-bottom:3%;"><strong>© <?php echo date("Y");?> Profify. All Rights Reserved</strong></p>
                </div>
                <div class="col-12 col-sm-6 col-md-6" style="margin-top: 30px;">
                    <div style="margin-bottom: 0px;height: 24px;"><a href="about" style="color: white;text-decoration: none;margin-left: 10px;margin-right: 10px;">about us</a><a href="legal" style="color: white;text-decoration: none;margin-left: 10px;margin-right: 10px;">legal</a>
                    <a href="contact" style="color: white;text-decoration: none;margin-left: 10px;margin-right: 10px;">contact us</a>
                        
                    </div>
                    <p class="text-right" style="margin-top: 4%;margin-bottom: 10%%;font-size: 1em;"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End: simple footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">

var container = document.getElementById('animate');
var emoji = ['🌽', '🍇', '🍌', '🍒', '🍕', '🍷', '🍭', '💖', '💩', '🐷', '🐸', '🐳', '🎃', '🎾', '🌈', '🍦', '💁', '🔥', '😁', '😱', '🌴', '👏', '💃'];
var circles = [];

for (var i = 0; i < 15; i++) {
  addCircle(i * 150, [10 + 0, 300], emoji[Math.floor(Math.random() * emoji.length)]);
  addCircle(i * 150, [10 + 0, -300], emoji[Math.floor(Math.random() * emoji.length)]);
  addCircle(i * 150, [10 - 200, -300], emoji[Math.floor(Math.random() * emoji.length)]);
  addCircle(i * 150, [10 + 200, 300], emoji[Math.floor(Math.random() * emoji.length)]);
  addCircle(i * 150, [10 - 400, -300], emoji[Math.floor(Math.random() * emoji.length)]);
  addCircle(i * 150, [10 + 400, 300], emoji[Math.floor(Math.random() * emoji.length)]);
  addCircle(i * 150, [10 - 600, -300], emoji[Math.floor(Math.random() * emoji.length)]);
  addCircle(i * 150, [10 + 600, 300], emoji[Math.floor(Math.random() * emoji.length)]);
}



function addCircle(delay, range, color) {
  setTimeout(function() {
    var c = new Circle(range[0] + Math.random() * range[1], 80 + Math.random() * 4, color, {
      x: -0.15 + Math.random() * 0.3,
      y: 1 + Math.random() * 1
    }, range);
    circles.push(c);
  }, delay);
}

function Circle(x, y, c, v, range) {
  var _this = this;
  this.x = x;
  this.y = y;
  this.color = c;
  this.v = v;
  this.range = range;
  this.element = document.createElement('span');
  /*this.element.style.display = 'block';*/
  this.element.style.opacity = 0;
  this.element.style.position = 'absolute';
  this.element.style.fontSize = '26px';
  this.element.style.color = 'hsl('+(Math.random()*360|0)+',80%,50%)';
  this.element.innerHTML = c;
  container.appendChild(this.element);

  this.update = function() {
    if (_this.y > 800) {
      _this.y = 80 + Math.random() * 4;
      _this.x = _this.range[0] + Math.random() * _this.range[1];
    }
    _this.y += _this.v.y;
    _this.x += _this.v.x;
    this.element.style.opacity = 1;
    this.element.style.transform = 'translate3d(' + _this.x + 'px, ' + _this.y + 'px, 0px)';
    this.element.style.webkitTransform = 'translate3d(' + _this.x + 'px, ' + _this.y + 'px, 0px)';
    this.element.style.mozTransform = 'translate3d(' + _this.x + 'px, ' + _this.y + 'px, 0px)';
  };
}

function animate() {
  for (var i in circles) {
    circles[i].update();
  }
  requestAnimationFrame(animate);
}

// animate();


    </script>
</body>

</html>