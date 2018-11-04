var myurl= "http://localhost:3000/table"
var myurl1= "http://localhost:3000/ind"

// to store previously searched data
//document.getElementById("stocksym1").value = localStorage.getItem("stocksym1");

//var symbol=String(document.getElementById("stocksym1").value);
//alert(symbol);

function saveInput() {
    var mysym= document.getElementById("stocksym1").value;
    if (mysym== "") {
        //alert("Please select a mysymfirst!");
        return false;
    }
    localStorage.setItem("stocksym1", mysym);
    //alert("Your mysymhas been saved!");
    location.reload();
    return false;
    //return true;
}




  
function reset_form()
		{
			window.location.href="hw8.html";
			//window.alert(document.getElementById("key").value);
			document.getElementById("stocksym1").value="";
		}

function test(){
	var mysym=String(document.getElementById("stocksym1").value);
	//alert("akjaaccasa");
	//alert(mysym);
	price(mysym);
	//Indicators(mysym);
	
}

function price(mysym){
	
	$.ajax({
	type:"GET",
    url : myurl, 
	 crossDomain:true,
	credentials: true,	 
	//contentType: "application/json",
	data : {sym: mysym},
    success: function (data) {
       //alert(data);
	   callback(data);
    },
	
	error:function(err){
					console.log(err)
				   }
});

var pricedata;
function callback(data) {
     console.log(data);  
	 //var ind= data["Meta Data"]["1. Information"];
	 
	 var jsstksym= data["Meta Data"]["2. Symbol"];
	 var jstime= data['Meta Data']['3. Last Refreshed'] ;
	 
	 
var temp1=data["Time Series (Daily)"];
var temp2=[]

for(key in temp1) {
  //console.log(key);
  temp2.push(key);
}
	 
	 var temp3=[];
	 for (x = 0; x < 120; x++) {
	temp3[x]=temp2[x];
				
	}
	 
	 temp3.reverse();
	 console.log(temp3);
	 
	 temp4=[];
	 
	 for (i in temp3)
	 {
		 temp4.push((temp3[i].substring(5,10)).replace("-","/"));
	 }
	 
	 
	 var price3=[];
	 
	 for (x = 0; x < 120; x++) {
	price3[x]=parseFloat(data['Time Series (Daily)'][temp2[x]]['4. close']);
				
	}	
	console.log(price3);
	
	
	var volume3=[];
	 
	 for (x = 0; x < 120; x++) {
	volume3[x]=(parseInt(data['Time Series (Daily)'][temp2[x]]['5. volume']))/1000000;
				
	}	
	console.log(volume3);
	price3.reverse();
	volume3.reverse();
	
	
	//p
	 //console.log(temp2);
	
	 //var temp= PKeys[0];
	 //console.log(PKeys);
	 //console.log(temp);
	 var jsprice= parseFloat(data["Time Series (Daily)"][temp2[0]]["4. close"]).toFixed(2);
	 //var jsprice=Math.floor10(jsprice1, -2);
	 //window.alert(ind);
	 console.log(jsprice);
	 
	 var jsprice2= parseFloat(data["Time Series (Daily)"][temp2[1]]["4. close"]);
	 
	 var jschange=(jsprice-jsprice2).toFixed(2);
	 var jsopen=parseFloat(data["Time Series (Daily)"][temp2[0]]["1. open"]).toFixed(2);
	 var jsclose=parseFloat(data["Time Series (Daily)"][temp2[1]]["4. close"]).toFixed(2);
	 var jsvolume=parseFloat(data["Time Series (Daily)"][temp2[0]]["5. volume"]);
	 var jshigh=parseFloat(data["Time Series (Daily)"][temp2[0]]["2. high"]).toFixed(2);
	 var jslow=parseFloat(data["Time Series (Daily)"][temp2[0]]["3. low"]).toFixed(2);
	 
	 var jsrange=jshigh.concat(" - ",jslow);
	 
	 
	 var jschngperc = (((jsprice-jsprice2)/jsprice2)*100).toFixed(2);
	 //var brac1="\(";
	 //var brac1="\)";
	 
	 var jschnwperc= jschange.concat("  ",jschngperc,"%","  ");
	 
	 
	 
	 
	 document.getElementById('tabstksym').innerHTML= jsstksym;
	 document.getElementById('tabprice').innerHTML= jsprice;
	 document.getElementById('tabchange').innerHTML= jschnwperc;
	 document.getElementById('tabtime').innerHTML= jstime;
	 document.getElementById('tabopen').innerHTML= jsopen;
	 document.getElementById('tabclose').innerHTML= jsclose;
	 document.getElementById('tabrange').innerHTML= jsrange;
	 document.getElementById('tabvol').innerHTML= jsvolume;
	 if (jschngperc >0)
	 {
	var tab_change = document.getElementById('tabchange')
	var addimg = document.createElement("IMG");
	var addimgtxt = document.createTextNode("  ");
	addimg.setAttribute("src", "http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png");				
	addimg.setAttribute("width", "15");
	addimg.setAttribute("height", "15");
	addimg.appendChild(addimgtxt);
	tab_change.appendChild(addimg);
	 }
	 else if (jschngperc <0)
	 {
		 var tab_change = document.getElementById('tabchange')
	var addimg = document.createElement("IMG");
	var addimgtxt = document.createTextNode("  ");
	addimg.setAttribute("src", "http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png");				
	addimg.setAttribute("width", "15");
	addimg.setAttribute("height", "15");
	addimg.appendChild(addimgtxt);
	tab_change.appendChild(addimg);
		 
	 }
	 
	 
	 
	 
	 //Price HighChart
	 var avlinkjs="<a style=\"color:#428bca\; font-style: normal\;\" target=\"_blank\" href=\"https://www.alphavantage.co/\" >";
	
	 Highcharts.chart('chart', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Stock price and Volume'
    },
    subtitle: {
        text: '<p style=\"color:#428bca \; font-style: normal\;\">Source:</p> '+ avlinkjs +
            'Alpha Vantage</a>'
    },
    xAxis: [{
        categories: temp4,
        crosshair: true,
		 min: 1,
		 minTickInterval: 7,
        tickWidth: 0,
		labels: {
            rotation :-45,
			style: {
                fontSize :'10px',
				fontStyle : 'normal'
            }
        }
		
		
    }],
    yAxis: [{ // Primary yAxis
		
		
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Stock Price',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		
		minTickInterval:5
    }, { // Secondary yAxis
        title: {
            text: 'Volume',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        labels: {
            format: '{value} M',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		minTickInterval:50,
        opposite: true
    }],
    tooltip: {
        shared: false
    },
     legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
		
    },
    series: [ {
        name: 'Price',
        type: 'area',
		color:'#fc7979',
		data: price3,
        tooltip: {
            valueSuffix: ''
        }
    },
	{
        name: 'Volume',
        type: 'column',
		color: '#FFFFFF',
        yAxis: 1,
        data: volume3,
        tooltip: {
            valueSuffix: ''
        }

    }
	]
});
	 
	 
	 
	 
}

}

function indicators(id){
	var symbol=String(document.getElementById("stocksym1").value);
	var avlinkjs="<a style=\"color:#428bca\; font-style: normal\;\" target=\"_blank\" href=\"https://www.alphavantage.co/\" >";
	  
	if(id=="SMA")
	{
	//alert("inside indi");
    //alert(symbol);
	$.ajax({
	type:"GET",
    url : myurl1, 
	 crossDomain:true,
	credentials: true,	 
	//contentType: "application/json",
	data : {id:id,sym:symbol},
    success: function (data) {
       //alert(data);
	   callback1(data);
    },
	
	error:function(err){
					console.log(err)
				   }
});
	
	
	
	

    function callback1(data) {
     console.log(data);  
	var jsonObj=data;
	 
	 console.log(jsonObj);
	 var ind= jsonObj["Meta Data"]["2: Indicator"];
		
		var SMAkey1=Object.keys(jsonObj["Technical Analysis: SMA"]);
		//Object.keys(SMAkvobj);
		var ran=jsonObj["Technical Analysis: SMA"];
		var SMAval1= [];
		var SMAkeynf= [];
		//var SMAkeynf1= [];
        for(i in SMAkey1)
		{
		SMAval1.push(parseFloat(ran[SMAkey1[i]]["SMA"]));
		SMAkeynf.push((SMAkey1[i].substring(5,10)).replace("-","/"));
		//if(
		//SMAkeynf1.push(SMAkeynf[i].getMonth()+"/"+SMAkeynf[i].getDate());
		}
		
		//console.log(SMAkeynf);
		//console.log(SMAkeynf1);
		
		var SMAkey2 = SMAkeynf.slice(0,121);
		var SMAval2 = SMAval1.slice(0,121);
		
		var SMAkey= [];
		var SMAval= [];
		SMAkey= SMAkey2.reverse();
		SMAval= SMAval2.reverse();
		
		 //new Date("2015-0");
		//window.alert(SMAval);
		//console.log(SMAkey);
		//console.log(SMAval);
		
		
		
		  Highcharts.chart('chart', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ ind +'</p>'
    },

    subtitle: {
        text: '<p style=\"color:#428bca \; font-style: normal\;\">Source:</p> '+ avlinkjs +
            'Alpha Vantage</a>'
    },

    yAxis: [{ // Primary yAxis
		
		
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: '<p style=\" font-style: normal\;\">SMA</p>',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		
		minTickInterval:0.01
    }],
	
	
	  xAxis: {
        categories: SMAkey,
		crosshair: true,
		 min: 1,
		 minTickInterval: 7,
        tickWidth: 0,
		labels: {
            rotation :-45,
			style: {
                fontSize :'10px',
				fontStyle : 'normal'
					}
				}
	  },
	  plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
			marker: {
                enabled: true
            }
        }
    },
	
    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    
    series: [{
        name: symbol,
        
		data: SMAval,
        tooltip: {
            valueSuffix: ''
        }
    }]

    
        

});
	
	 
	 
	 //var SMAkey1=Object.keys(jsonObj["Technical Analysis: SMA"]);
 }
	
	}	
	
	//EMA
	
	
	else if(id=="EMA")
	{
	//alert("inside indi");
    //alert(symbol);
	$.ajax({
	type:"GET",
    url : myurl1, 
	 crossDomain:true,
	credentials: true,	 
	//contentType: "application/json",
	data : {id:id,sym:symbol},
    success: function (data) {
       //alert(data);
	   callback1(data);
    },
	
	error:function(err){
					console.log(err)
				   }
});
	
	
	
	

    function callback1(data) {
     console.log(data);  
	var jsonObj=data;
	 
	 console.log(jsonObj);
	 var ind= jsonObj["Meta Data"]["2: Indicator"];
		var ind= jsonObj["Meta Data"]["2: Indicator"];
		
		var EMAkey1=Object.keys(jsonObj["Technical Analysis: EMA"]);
		//Object.keys(SMAkvobj);
		var ran=jsonObj["Technical Analysis: EMA"];
		var EMAval1= [];
		var EMAkeynf=[];
        for(i in EMAkey1)
		{
		EMAval1.push(parseFloat(ran[EMAkey1[i]]["EMA"]));
		EMAkeynf.push((EMAkey1[i].substring(5,10)).replace("-","/"));
		}
		
		var EMAkey2 = EMAkeynf.slice(0,121);
		var EMAval2 = EMAval1.slice(0,121);
		
		var EMAkey= [];
		var EMAval= [];
		EMAkey= EMAkey2.reverse();
		EMAval= EMAval2.reverse();
		
		
		//window.alert(EMAval);
		//console.log(EMAkey);
		//console.log(EMAval);
		
		
		
		  Highcharts.chart('chart', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:#428bca \; font-style: normal\;\">Source:</p> '+ avlinkjs +
            'Alpha Vantage</a>'
    },

    yAxis: [{ // Primary yAxis
		
		
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: '<p style=\" font-style: normal\;\">EMA</p>',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		
		minTickInterval:0.01
    }],
	plotOptions: {
        series: {
            marker: {
                enabled: true
            }
        }
    },
	
	
	  xAxis: {
        categories: EMAkey,
		crosshair: true,
		 min: 1,
		 minTickInterval: 7,
        tickWidth: 0,
		labels: {
            rotation :-45,
			style: {
                fontSize :'10px',
				fontStyle : 'normal'
				}
				}
	  },
	
    legend: {
       layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    
    series: [{
        name: symbol,
        
		data: EMAval,
        tooltip: {
            valueSuffix: ''
        }
    }]

    
        

});
	
	 
	 
	 //var SMAkey1=Object.keys(jsonObj["Technical Analysis: SMA"]);
 }
	
	}	
	
	
	else if(id=='STOCH')
	  {
		  $.ajax({
	type:"GET",
    url : myurl1, 
	 crossDomain:true,
	credentials: true,	 
	//contentType: "application/json",
	data : {id:id,sym:symbol},
    success: function (data) {
       //alert(data);
	   callback1(data);
    },
	
	error:function(err){
					console.log(err)
				   }
});
	
	
	
	

    function callback1(data) {
     console.log(data);  
	var jsonObj=data;
	 
	 console.log(jsonObj);

		
		var ind= jsonObj["Meta Data"]["2: Indicator"];
		
		var STOCHkey1=Object.keys(jsonObj["Technical Analysis: STOCH"]);
		//Object.keys(SMAkvobj);
		var ran=jsonObj["Technical Analysis: STOCH"];
		var STOCHval1= [];
		var STOCHval2= [];
		var STOCHkeynf=[];
        for(i in STOCHkey1)
		{
		STOCHval1.push(parseFloat(ran[STOCHkey1[i]]["SlowK"]));
		STOCHval2.push(parseFloat(ran[STOCHkey1[i]]["SlowD"]));
		STOCHkeynf.push((STOCHkey1[i].substring(5,10)).replace("-","/"));
		}
		
		var STOCHkey2  = STOCHkeynf.slice(0,121);
		var STOCHvalnew1 = STOCHval1.slice(0,121);
		var STOCHvalnew2 = STOCHval2.slice(0,121);
		
		var STOCHkey= [];
		var STOCHvalfn1= [];
		var STOCHvalfn2= [];
		
		STOCHkey= STOCHkey2.reverse();
		STOCHvalfn1= STOCHvalnew1.reverse();
		STOCHvalfn2= STOCHvalnew2.reverse();
		
		//window.alert(STOCHval);
		//console.log(STOCHkey);
		//console.log(STOCHvalfn1);
		//console.log(STOCHvalfn2);
		
		
		
		
		  Highcharts.chart('chart', {

    title: {
        text: '<p style=\" font-style: normal\;\"> Stochastic Oscillator (STOCH)</p>'
    },

    subtitle: {
        text: '<p style=\"color:#428bca \; font-style: normal\;\">Source:</p> '+ avlinkjs +
            'Alpha Vantage</a>'
    },

    yAxis: [{ // Primary yAxis
		
		
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: '<p style=\" font-style: normal\;\">STOCH</p>',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		
		minTickInterval:0.01
    }],
	
	
	  xAxis: {
        categories: STOCHkey,
		crosshair: true,
		 min: 1,
		 minTickInterval: 7,
        tickWidth: 0,
		labels: {
            rotation :-45,
			style: {
                fontSize :'10px',
				fontStyle : 'normal'
					}
				}
    },
	plotOptions: {
        series: {
            marker: {
                enabled: true
            }
        }
    },
	
    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    
    series: [{
        name: symbol+' SlowK',
        
		data: STOCHvalfn1,
        tooltip: {
            valueSuffix: ''
        }
    },
	{
        name: symbol+' SlowD',
        data: STOCHvalfn2
    }
	]
 

});
	  }
	  
}



	else if(id=='RSI')
	  {
		  $.ajax({
	type:"GET",
    url : myurl1, 
	 crossDomain:true,
	credentials: true,	 
	//contentType: "application/json",
	data : {id:id,sym:symbol},
    success: function (data) {
       //alert(data);
	   callback1(data);
    },
	
	error:function(err){
					console.log(err)
				   }
});
	
	
	
	

    function callback1(data) {
     console.log(data);  
	var jsonObj=data;
	 
	 console.log(jsonObj);

		
		var ind= jsonObj["Meta Data"]["2: Indicator"];
		
var RSIkey1=Object.keys(jsonObj["Technical Analysis: RSI"]);
		//Object.keys(SMAkvobj);
		var ran=jsonObj["Technical Analysis: RSI"];
		var RSIval1= [];
		var RSIkeynf=[];
		
        for(i in RSIkey1)
		{
		RSIval1.push(parseFloat(ran[RSIkey1[i]]["RSI"]));
		RSIkeynf.push((RSIkey1[i].substring(5,10)).replace("-","/"));
		}
		
		var RSIkey2 = RSIkeynf.slice(0,121);
		var RSIval2 = RSIval1.slice(0,121);
		
		var RSIkey= [];
		var RSIval= [];
		RSIkey= RSIkey2.reverse();
		RSIval= RSIval2.reverse();
		
		
		//window.alert(RSIval);
		//console.log(RSIkey);
		//console.log(RSIval);
		
		
		
		  Highcharts.chart('chart', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:#428bca \; font-style: normal\;\">Source:</p> '+ avlinkjs +
            'Alpha Vantage</a>'
    },

    yAxis: [{ // Primary yAxis
		
		
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: '<p style=\" font-style: normal\;\">RSI</p>',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		
		minTickInterval:0.01
    }],
	plotOptions: {
        series: {
            marker: {
                enabled: true
            }
        }
    },
	
	
	  xAxis: {
        categories: RSIkey,
		crosshair: true,
		 min: 1,
		 minTickInterval: 7,
        tickWidth: 0,
		labels: {
            rotation :-45,
			style: {
                fontSize :'10px',
				fontStyle : 'normal'
					}
				}
    },
	
    legend: {
       layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    
    series: [{
        name: symbol,
        
		data: RSIval,
        tooltip: {
            valueSuffix: ''
        }
    }]

    
        

});
	  }
	  
}


	else if(id=='ADX')
	  {
		  $.ajax({
	type:"GET",
    url : myurl1, 
	 crossDomain:true,
	credentials: true,	 
	//contentType: "application/json",
	data : {id:id,sym:symbol},
    success: function (data) {
       //alert(data);
	   callback1(data);
    },
	
	error:function(err){
					console.log(err)
				   }
});
	
	
	
	

    function callback1(data) {
     console.log(data);  
	var jsonObj=data;
	 
	 console.log(jsonObj);

		
		var ind= jsonObj["Meta Data"]["2: Indicator"];
		
        var ADXkey1=Object.keys(jsonObj["Technical Analysis: ADX"]);
		//Object.keys(SMAkvobj);
		var ran=jsonObj["Technical Analysis: ADX"];
		var ADXval1= [];
		var ADXkeynf=[];
        for(i in ADXkey1)
		{
		ADXval1.push(parseFloat(ran[ADXkey1[i]]["ADX"]));
		ADXkeynf.push((ADXkey1[i].substring(5,10)).replace("-","/"));
		}
		
		var ADXkey2 = ADXkeynf.slice(0,121);
		var ADXval2 = ADXval1.slice(0,121);
		
		var ADXkey= [];
		var ADXval= [];
		ADXkey= ADXkey2.reverse();
		ADXval= ADXval2.reverse();
		
		
		//window.alert(ADXval);
		//console.log(ADXkey);
		//console.log(ADXval);
		
		
		
		  Highcharts.chart('chart', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:#428bca \; font-style: normal\;\">Source:</p> '+ avlinkjs +
            'Alpha Vantage</a>'
    },

    yAxis: [{ // Primary yAxis
		
		
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: '<p style=\" font-style: normal\;\">ADX</p>',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		
		minTickInterval:0.01
    }],
	
	plotOptions: {
        series: {
            marker: {
                enabled: true
            }
        }
    },
	
	
	  xAxis: {
        categories: ADXkey,
		crosshair: true,
		 min: 1,
		 minTickInterval: 7,
        tickWidth: 0,
		labels: {
            rotation :-45,
			style: {
                fontSize :'10px',
				fontStyle : 'normal'
					}
				}
    },
	
    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    
    series: [{
        name: symbol,
        
		data: ADXval,
        tooltip: {
            valueSuffix: ''
        }
    }]

    
        

});
	  }
	  
}



	else if(id=='CCI')
	  {
		  $.ajax({
	type:"GET",
    url : myurl1, 
	 crossDomain:true,
	credentials: true,	 
	//contentType: "application/json",
	data : {id:id,sym:symbol},
    success: function (data) {
       //alert(data);
	   callback1(data);
    },
	
	error:function(err){
					console.log(err)
				   }
});
	
	
	
	

    function callback1(data) {
     console.log(data);  
	var jsonObj=data;
	 
	 console.log(jsonObj);

		
		var ind= jsonObj["Meta Data"]["2: Indicator"];
		
        
		var CCIkey1=Object.keys(jsonObj["Technical Analysis: CCI"]);
		//Object.keys(SMAkvobj);
		var ran=jsonObj["Technical Analysis: CCI"];
		var CCIval1= [];
		var CCIkeynf=[];
        for(i in CCIkey1)
		{
		CCIval1.push(parseFloat(ran[CCIkey1[i]]["CCI"]));
		CCIkeynf.push((CCIkey1[i].substring(5,10)).replace("-","/"));
		}
		
		var CCIkey2 = CCIkeynf.slice(0,121);
		var CCIval2 = CCIval1.slice(0,121);
		
		var CCIkey= [];
		var CCIval= [];
		CCIkey= CCIkey2.reverse();
		CCIval= CCIval2.reverse();
		
		
		//window.alert(CCIval);
		//console.log(CCIkey);
		//console.log(CCIval);
		
		
		
		  Highcharts.chart('chart', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:#428bca \; font-style: normal\;\">Source:</p> '+ avlinkjs +
            'Alpha Vantage</a>'
    },

    yAxis: [{ // Primary yAxis
		
		
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: '<p style=\" font-style: normal\;\">CCI</p>',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		
		minTickInterval:0.01
    }],
	
	plotOptions: {
        series: {
            marker: {
                enabled: true
            }
        }
    },
	
	
	  xAxis: {
        categories: CCIkey,
		crosshair: true,
		 min: 1,
		 minTickInterval: 7,
        tickWidth: 0,
		labels: {
            rotation :-45,
			style: {
                fontSize :'10px',
				fontStyle : 'normal'
					}
				}
    },
	
    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    
    series: [{
        name: symbol,
        data: CCIval,
        tooltip: {
            valueSuffix: ''
        }
    }]

    
        

});
	  }
	  
}


else if(id=='BBANDS')
	  {
		  $.ajax({
	type:"GET",
    url : myurl1, 
	 crossDomain:true,
	credentials: true,	 
	//contentType: "application/json",
	data : {id:id,sym:symbol},
    success: function (data) {
       //alert(data);
	   callback1(data);
    },
	
	error:function(err){
					console.log(err)
				   }
});
	
	
	
	

    function callback1(data) {
     console.log(data);  
	var jsonObj=data;
	 
	 console.log(jsonObj);

		
		var ind= jsonObj["Meta Data"]["2: Indicator"];
		
        
var BBANDSkey1=Object.keys(jsonObj["Technical Analysis: BBANDS"]);
		//Object.keys(SMAkvobj);
		
		var ran=jsonObj["Technical Analysis: BBANDS"];
		var BBANDSval1= [];
		var BBANDSval2= [];
		var BBANDSval3= [];
		var BBANDSkeynf=[];
		
        for(i in BBANDSkey1)
		{
		BBANDSval1.push(parseFloat(ran[BBANDSkey1[i]]["Real Lower Band"]));
		BBANDSval2.push(parseFloat(ran[BBANDSkey1[i]]["Real Upper Band"]));
		BBANDSval3.push(parseFloat(ran[BBANDSkey1[i]]["Real Middle Band"]));
		BBANDSkeynf.push((BBANDSkey1[i].substring(5,10)).replace("-","/"));
		}
		
		var BBANDSkey2  = BBANDSkeynf.slice(0,121);
		var BBANDSvalnew1 = BBANDSval1.slice(0,121);
		var BBANDSvalnew2 = BBANDSval2.slice(0,121);
		var BBANDSvalnew3 = BBANDSval3.slice(0,121);
		
		var BBANDSkey= [];
		var BBANDSvalfn1= [];
		var BBANDSvalfn2= [];
		var BBANDSvalfn3= [];
		
		BBANDSkey= BBANDSkey2.reverse();
		BBANDSvalfn1= BBANDSvalnew1.reverse();
		BBANDSvalfn2= BBANDSvalnew2.reverse();
		BBANDSvalfn3= BBANDSvalnew3.reverse();
		
		
		//nkey= BBANDSkey2.reverse();
		//window.alert(BBANDSval);
		//console.log(BBANDSkey);
		//console.log(BBANDSvalfn1);
		//console.log(BBANDSvalfn2);
		//console.log(BBANDSvalfn3);
		
		
		
		  Highcharts.chart('chart', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:#428bca \; font-style: normal\;\">Source:</p> '+ avlinkjs +
            'Alpha Vantage</a>'
    },

    yAxis: [{ // Primary yAxis
		
		
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: '<p style=\" font-style: normal\;\">BBANDS</p>',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		
		minTickInterval:0.01
    }],
	
	
	  xAxis: {
        categories: BBANDSkey,
		crosshair: true,
		 min: 1,
		 minTickInterval: 7,
        tickWidth: 0,
		labels: {
            rotation :-45,
			style: {
                fontSize :'10px',
				fontStyle : 'normal'
					}
				}
    },
	plotOptions: {
        series: {
            marker: {
                enabled: true
            }
        }
    },
	
    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    
    series: [{
        name: symbol+' Real Middle Band',
        
		data: BBANDSvalfn3,
        tooltip: {
            valueSuffix: ''
        }
    },
	{
        name: symbol+' Real Upper Band',
        data: BBANDSvalfn2
    }, 
	{
        name: symbol+' Real Lower Band',
        data: BBANDSvalfn1
    }
	]

    
        

});
	  }
	  
}



else if(id=='MACD')
	  {
		  $.ajax({
	type:"GET",
    url : myurl1, 
	 crossDomain:true,
	credentials: true,	 
	//contentType: "application/json",
	data : {id:id,sym:symbol},
    success: function (data) {
       //alert(data);
	   callback1(data);
    },
	
	error:function(err){
					console.log(err)
				   }
});
	
	
	
	

    function callback1(data) {
     console.log(data);  
	var jsonObj=data;
	 
	 console.log(jsonObj);

		
		var ind= jsonObj["Meta Data"]["2: Indicator"];
		
   	var MACDkey1=Object.keys(jsonObj["Technical Analysis: MACD"]);
		//Object.keys(SMAkvobj);
		var ran=jsonObj["Technical Analysis: MACD"];
		var MACDval1= [];
		var MACDval2= [];
		var MACDval3= [];
		var MACDkeynf=[];
        for(i in MACDkey1)
		{
		MACDval1.push(parseFloat(ran[MACDkey1[i]]["MACD"]));
		MACDval2.push(parseFloat(ran[MACDkey1[i]]["MACD_Hist"]));
		MACDval3.push(parseFloat(ran[MACDkey1[i]]["MACD_Signal"]));
		MACDkeynf.push((MACDkey1[i].substring(5,10)).replace("-","/"));
		}
		
		var MACDkey2  = MACDkeynf.slice(0,121);
		var MACDvalnew1 = MACDval1.slice(0,121);
		var MACDvalnew2 = MACDval2.slice(0,121);
		var MACDvalnew3 = MACDval3.slice(0,121);
		
		var MACDkey= [];
		var MACDvalfn1= [];
		var MACDvalfn2= [];
		var MACDvalfn3= [];
		
		MACDkey= MACDkey2.reverse();
		MACDvalfn1= MACDvalnew1.reverse();
		MACDvalfn2= MACDvalnew2.reverse();
		MACDvalfn3= MACDvalnew3.reverse();
		
		//window.alert(MACDval);
		console.log(MACDkey);
		//console.log(MACDvalfn1);
		//console.log(MACDvalfn2);
		//console.log(MACDvalfn3);
		
		
		
		  Highcharts.chart('chart', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:#428bca \; font-style: normal\;\">Source:</p> '+ avlinkjs +
            'Alpha Vantage</a>'
    },

    yAxis: [{ // Primary yAxis
		
		
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: '<p style=\" font-style: normal\;\">MACD</p>',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		
		
    }],
	plotOptions: {
        series: {
            marker: {
                enabled: true
            }
        }
    },
	
	
	  xAxis: {
        categories: MACDkey2,
		crosshair: true,
		 
		minTickInterval: 7,
        tickWidth: 0,
		labels: {
            rotation :-45,
			style: {
                fontSize :'10px',
				fontStyle : 'normal'
					}
				}
    },
	
    legend: {
       layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    
    series: [{
        name: symbol+' MACD',
        data: MACDvalnew1,
        tooltip: {
            valueSuffix: ''
        }
    },
	{
        name: symbol+' MACD_Hist',
        data: MACDvalnew2
    }, 
	{
        name: symbol+' MACD_Signal',
        data: MACDvalnew3
    }
	]

    
        

});
	  }
	  
}

// ind fun end 
}