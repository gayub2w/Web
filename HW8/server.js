var express = require('express');
var app = express();
var request = require("request");
var urlencode = require('urlencode');
var bodyParser = require('body-parser');
var fetch = require('node-fetch');
var Router = require('router');

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.use(function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    next();
});

//var url = "https://www.alphavantage.co/query?function=SMA&symbol=AAPL&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8";

var url="https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=AAPL&apikey=77RQS8FMJXG5LVF8&outputsize=full";


app.get('/table', function (req, res) {
   // Prepare output in JSON format
   res.setHeader('Content-Type', 'application/json');
   var stksym = req.param('sym');
   console.log(stksym);
   console.log("in node");
   
   
fetch("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol="+stksym+"&apikey=77RQS8FMJXG5LVF8&outputsize=full")
    .then(function(rest) {
        return rest.json();
    })
		
	.then(function(body) {
        res.send(body);
    });
	
	
	
	
})


app.get('/ind', function (req, res) {
   // Prepare output in JSON format
   res.setHeader('Content-Type', 'application/json');
   var stksym = req.param('sym');
   var ind = req.param('id');
   console.log(stksym);
   console.log("in node");
   
   
fetch("https://www.alphavantage.co/query?function="+ind+"&symbol="+stksym+"&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8")
    .then(function(rest) {
        return rest.json();
    })
		
	.then(function(body) {
        res.send(body);
    });
   
})

app.listen(3000,function(){
	console.log("listening");
})




