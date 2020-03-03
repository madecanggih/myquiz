// Set the date we're counting down to
var hours = 0;
hours = hours * 1000 * 60 * 60;

var minutes = 0;
minutes = minutes * 1000 * 60;

var seconds = 10;
seconds = seconds * 1000;

setTimeout(function(){ alert("Waktu Habis"); }, hours+minutes+seconds);

// setTimeout(function() { $("form").submit(); }, 60000);

var countDownDate = new Date().getTime()+hours+minutes+seconds;

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays_remaining date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days_remaining, hours_remaining, minutes_remaining and seconds_remaining
    // var days_remaining = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours_remaining = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes_remaining = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds_remaining = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="timer"
    // document.getElementById("timer").innerHTML = days_remaining + " Hari " + hours_remaining + " Jam "
    // + minutes_remaining + " Menit " + seconds_remaining + " Detik ";
    
    document.getElementById("timer").innerHTML = hours_remaining + " Jam "
    + minutes_remaining + " Menit " + seconds_remaining + " Detik ";

    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("timeleft").innerHTML = "<i class='fa fa-clock-o'></i> Waktu Habis";
    }
}, 1000);
