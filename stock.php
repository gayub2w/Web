<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">	
<html>
<head>
 
 <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


  <title>Stock Search</title>
  <meta name="Generator" content="Cocoa HTML Writer">
  <meta name="CocoaVersion" content="1348.17">
  <style type="text/css">
  

.indlink{
	text-decoration:  none;
	color: blue;
	cursor:pointer;
}
  
  .bu{
    
    border: 1px solid black;
    border-collapse: collapse;
	background-color:white;
    border-color:#DCDCDC;
    padding: 1px 16px;
	text-align: center;
    text-decoration: none;
    display: inline-block;
	font-size:12px;
	border-radius:4px;
    cursor: pointer;
}
  
	div.stfrm{
		position:relative;
		top:-1%;
		width: 400px;
   	    border: 1px solid #DCDCDC;
    	height: 175px;
    	margin: 10px auto; 

    	
	  }
	  
	
	table,th,td {
	font-style: normal;
	font-family: Times New Roman;
    border: 1px solid black;
    border-collapse: collapse;
    border-color:#DCDCDC;
    
	}
	table {
		position:relative;
		left:9%;
		width:82%;
	}
	
	.col1 {
		text-align: left;
		width:30%;
		background-color:#F1F1F1;
		font-weight:bold;
		
	}
	
	.col2{
		text-align: center;
		width:70%;
	}
	
	.col3{
		text-align: left;
		height:25px;
		
	}
	.container {
		position: relative;
		
	border: 1px solid black;
	border-color:#DCDCDC;
    margin-top: 15px;
    margin-bottom: 20px;
    margin-right: 135px;
	margin-left: 135px;
	height: 600px;	
	display:none;
	}
	#Price{
		display:block;
	}
	.arrows 
	{
		margin-top: 0px;
		margin-bottom: 15px;
		margin-right: 135px;
		margin-left: 135px;
		height: 50px;	
		display:none;
		position: relative;
	}
	#downarrow{
	display:block;
	}
	#uparrow{
	display:none;
	}
	
	#nftext
	{
		text-align: center;
		font-style: normal; 
		color:#C0C0C0;
	}
	#newsfeed {
			margin-bottom: 15px;
			display:none;
				
	}
	
 </style>
  
  
  
  </head>
<body id="body_1">
	
	<form name= "theForm" id ="myForm" action="" method="POST">
      <div class="stfrm" id="parent" style="background-color:#F1F1F1;">
          <i><p style="text-align:center"><font size="5"><b>Stock Search</b></font></p></i>
          <hr>
          &nbsp;Enter Stock Ticker Symbol:*
          <input type="text" id="key" name="ssym" value="<?php echo
isset($_POST["ssym"]) ? $_POST["ssym"] : "" ?>" > 
          <br>
	
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <input type="submit" class="bu" name="submit" value="Search" >&nbsp;
         <input type="button" class="bu" id="reset" value="Clear" onclick="reset_form();">
	
		 <i><p><font size="3">&nbsp;*- Mandatory fields<p><i>
         
      </div>
	</form>
	
	
	
	<?php
	 //print_r($_POST);
	 //$stksym = $_POST["ssym"];
	 //echo "$stksym";
	 ?>
	 
	 <br/>
	 <?php
	 //echo "nu";
	 if(isset($_POST["submit"]))
	{
			
		if(!empty($_POST["ssym"]))
			
		{
			$stksym = $_POST["ssym"];
			//https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=MSFT&interval=1min&apikey=demo
			$stktab= file_get_contents("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".urlencode($_POST["ssym"])."&apikey=77RQS8FMJXG5LVF8&outputsize=full");
			
			//$errormsg="Error Message";
			
			$stkobj=json_decode($stktab,true);
			//console.log($stkobj);
			
			
			
			$elementCount  = count($stkobj);
			//print_r($elementCount);
			if($elementCount!==1)
			{
			$test=$stkobj['Meta Data']['1. Information'] ;
			//print_r($test);
			//echo "<br/>";
			ini_alter('date.timezone','America/Los_Angeles');
			
			$timesmp1=$stkobj['Meta Data']['3. Last Refreshed'] ;
			$timesmp = substr($timesmp1,0,10); 
			//<br/>
			$test2=key($stkobj['Time Series (Daily)']) ;
			//print_r($test2);
			//echo "<br/>";
			$keys = array_keys($stkobj['Time Series (Daily)']);
			//print_r($keys);
			$days=[];
			for ($x = 0; $x < 120; $x++) {
				$days[$x]= $keys[$x];
				
				$days[$x] = date('m/d', strtotime( $days[$x] ));
			}
			$days1=[];
			$days1=array_reverse($days);
			$startday=json_encode($days[0]);
			//print_r($startday);
			$days5=[];
			$days5=json_encode($days1);
			//print_r($days);
			$volume =[];
			for ($x = 0; $x < 120; $x++) {
				$volume[$x]= (int)substr($stkobj['Time Series (Daily)'][$keys[$x]]['5. volume'],0,2);
				//echo "The number is: $x <br>";
				}
			//$startvol=$volume[0];
			//print_r($startvol);
			$vol1=[];
			$vol1=array_reverse($volume);
			$volume3=json_encode($vol1);
			
			//print_r($volume3);
			
			$price =[];
			$pricenew =[];
			for ($x = 0; $x < 120; $x++) {
				$price[$x]=(float)$stkobj['Time Series (Daily)'][$keys[$x]]['4. close'];
				//echo "The number is: $x <br>";
				//$pricenew[$x] = date('d/m', strtotime( $price[$x] ));
				}	
				//print_r($pricenew);
			//$volume= $stkobj['Time Series (Daily)'][$keys[2]]['5. volume'];
			$price1=[];
			$price1=array_reverse($price);
			$minprice=min($price1);
			//print_r($minprice);
			$price3=json_encode($price1);
			
			
			
			//echo "Am here";
			
			
			
			//print_r($price);
			
            $test3 = $keys[1];
			//print_r($test3);
			//echo "<br/>";
			//echo "<br/>";
			$open1= $stkobj['Time Series (Daily)'][$test2]['1. open'];
			//print_r($open1);
			
			///echo "<br/>";
			$high1= $stkobj['Time Series (Daily)'][$test2]['2. high'];
			//print_r($high1);
			
			//echo "<br/>";
			$low1= $stkobj['Time Series (Daily)'][$test2]['3. low'];
			//print_r($low1);
			
			//echo "<br/>";			
			$close1= $stkobj['Time Series (Daily)'][$test2]['4. close'];
			//print_r($close1);
			$close2= $stkobj['Time Series (Daily)'][$test3]['4. close'];
			$change=round($close1-$close2,2);
			
			$changeperc=round((($close1-$close2)/$close2)*100,2);
			
			
			
			//echo "<br/>";
			$volume1= $stkobj['Time Series (Daily)'][$test2]['5. volume'];
			//print_r($volume1);
			//echo "<br/>";
			//echo "<br/>";
			
		
			/*		
			print "<center><table border=1>
				<tbody><tr><td>Link to Homework#1</td><td>Link to Homework#2</td>
				</tr><tr><td>Link to Homework#3</td><td>Link to Homework#4</a></td>
				</tr></tbody></table>";
			*/
			echo"<table>";			
			echo"<tr><td class='col1'>Stock Ticker Symbol</td><td class='col2'>$stksym</td></tr>";
			echo"<tr><td class='col1'>Close</td><td class='col2'>$close1</td></tr>";
			echo"<tr><td class='col1'>Open</td><td class='col2'>$open1</td></tr>";
			echo"<tr><td class='col1'>Previous Close</td><td class='col2'>$close2</td></tr>";
			if ($change >0)
			{
			
			echo"<tr><td class='col1'>Change</td><td class='col2'>$change<img src='http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png' alt=''  height=15 width=15></img></td></tr>";
			}
			else if($change<0)
			{
			echo"<tr><td class='col1'>Change</td><td class='col2'>$change<img src='http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png' alt='' height=15 width=15></img></td></tr>";	
			}
			else
			{
				echo"<tr><td class='col1'>Change</td><td class='col2'>$change</td></tr>";
			}
			
			
			
			//echo"<tr><td class='col1'>Change</td><td class='col2'>$change</td></tr>";
			if ($changeperc >0)
			{
			
			echo"<tr><td class='col1'>Change Percent</td><td class='col2'>$changeperc%<img src='http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png' alt=''  height=15 width=15></img></td></tr>";
			}
			else if($changeperc <0)
			{
			echo"<tr><td class='col1'>Change Percent</td><td class='col2'>$changeperc%<img src='http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png' alt='' height=15 width=15></img></td></tr>";	
			}
			else
			{
				echo"<tr><td class='col1'>Change Percent</td><td class='col2'>$changeperc%</td></tr>";
			}
			
			
			echo"<tr><td class='col1'>Day's Range</td><td class='col2'>$low1-$high1</td></tr>";
			echo"<tr><td class='col1'>Volume</td><td class='col2'>$volume1</td></tr>";
			echo"<tr><td class='col1'>Timestamp</td><td class='col2'>$timesmp</td></tr>";
			//Price,SMA, EMA, STOCH, RSI, ADX, CCI, BBANDS and MACD
			echo"<tr><td class='col1'>Indicators</td><td class='col2'>&nbsp;<a class='indlink' href='#' onclick='dispchart(this.innerHTML); drawchart(this.innerHTML);'>Price</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a class='indlink' href='#' onclick='dispchart(this.innerHTML); drawchart(this.innerHTML);'>SMA</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a class='indlink' href='#' onclick='dispchart(this.innerHTML); drawchart(this.innerHTML);'>EMA</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a class='indlink' href='#' onclick='dispchart(this.innerHTML); drawchart(this.innerHTML);'>STOCH</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a class='indlink' href='#' onclick='dispchart(this.innerHTML); drawchart(this.innerHTML);'>RSI</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a class='indlink' href='#' onclick='dispchart(this.innerHTML); drawchart(this.innerHTML);'>ADX</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a class='indlink' href='#' onclick='dispchart(this.innerHTML); drawchart(this.innerHTML);'>CCI</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a class='indlink' href='#' onclick='dispchart(this.innerHTML); drawchart(this.innerHTML);'>BBANDS</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a class='indlink' href='#' onclick='dispchart(this.innerHTML); drawchart(this.innerHTML);'>MACD</a>&nbsp;</td></tr>";
			//echo"<tr><td class='col1'>Indicators</td><td class='col2'> <a href='http://cs-server.usc.edu:31848/rough.php#container'>Price</a>    SMA    EMA    STOCH    RSI    ADX    CCI    BBANDS    MACD </td></tr>";
			echo"</table>";
			
			
			
			
			
			
			?>
			<div id="Price" class="container">
  			</div>
			<div id="SMA" class="container">
  			</div>
			<div id="EMA" class="container">
  			</div>
			<div id="STOCH" class="container">
  			</div>
			<div id="RSI" class="container">
  			</div>
			<div id="ADX" class="container">
  			</div>
			<div id="CCI" class="container">
  			</div>
			<div id="BBANDS" class="container">
  			</div>
			<div id="MACD" class="container">
  			</div>
			
			
			
	<?php
			
			
			$price_date = date('d/m/Y', strtotime( $timesmp ));
			//echo"$price_date";
			
			$link1=	"<a style=\"color:blue\; font-style: normal\;\" href=\"https://www.alphavantage.co/\"  target=\"_blank\"  >";
		
			echo "<script type='text/javascript'> 
			Highcharts.chart('Price', {
    chart: {
		zoomType: 'xy'
    },
    title: {
        text: '<p style=\"font-style: normal\;\">Stock Price ($price_date)</p>'
    },
    subtitle: {
        text: '<p style=\"color:blue \; font-style: normal\;\">Source:</p> $link1 ' +
            'Alpha Vantage</a>'
    },
    xAxis: [{
        categories: $days5,
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
		min:$minprice,
		
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: '<p style=\" font-style: normal\;\">Stock Price</p>',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
		
		minTickInterval:5
    }, { // Secondary yAxis
        title: {
            text: '<p style=\" font-style: normal\;\">Volume</p>',
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
        align: 'right',
        verticalAlign: 'middle',
        layout: 'vertical',
        x: 0,
        y: 10
		
    },
	  
	
    series: [ {
        name: '$stksym',
        type: 'area',
		color:'#fc7979',
		data: $price3,
        tooltip: {
            valueSuffix: ''
        }
    },
	{
        name: '$stksym Volume',
        type: 'column',
		color: '#FFFFFF',
        yAxis: 1,
        data: $volume3,
        tooltip: {
            valueSuffix: ''
        }

    }
	]
});
			</script>";
			$stksym = $_POST["ssym"];
			
			//I
		//https://www.alphavantage.co/query?function=SMA&symbol=MSFT&interval=daily&time_period=10&series_type=close&apikey=demo
		//$stkchart= file_get_contents("https://www.alphavantage.co/query?function=SMA&symbol=".urlencode($_POST["ssym"])."&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8");
		//$stkctobj=json_decode($stkchart,true);
		//print_r($stkctobj);
		
		//$series=$stkctobj['Technical Analysis: SMA'];
		//print_r($series);
		
		
		
		//Main '}' end of block where we have a proper input stock symbol
		
		//newsfeed
		
		$xmlobj = file_get_contents("https://seekingalpha.com/api/sa/combined/".urlencode($_POST["ssym"]).".xml");
		//https://seekingalpha.com/api/sa/combined/AAPL.xml
		$xml = simplexml_load_string($xmlobj);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		
		
		$items = $array["channel"]["item"];
		
		
		
		//pubDate
		//print_r($json);
		$newslink=[];
		$pubtime=[];
		$title=[];
		
		for($x=0; $x<count($items); $x++) 
		{
				//print_r($items[$x]["link"]);
				//echo "<br/>";
				//print_r($items[$x]["pubDate"]);
				$newslink[$x]=$items[$x]["link"];
				$title[$x]=$items[$x]["title"];
				//substr($timesmp1,0,10)
				$pubtime[$x]=substr($items[$x]["pubDate"],0,-5);
		}
		
		//print_r($newslink);
		//print_r($pubtime);
		$newslink1=[];
		$pubtime1=[];
		$title1=[];
		
		for($x=0; $x<count($newslink); $x++) 
		{
			if(strpos($newslink[$x], 'news')==false)
			{
				//print_r("Am here");
				//print_r($newslink[$x]);
				array_push($newslink1,$newslink[$x]);
				array_push($pubtime1,$pubtime[$x]);
				array_push($title1,$title[$x]);
				
			}
		}
		echo"<div id='downarrow' class='arrows' onclick='dispnewsfeed(this.id)'>";
		echo "<p id='nftext'>click to show stock news</p>";
		echo "<img src='http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png' style='position:absolute;left:50%;top:5% width:20px;height:20px;'>";
		echo"</div>";
		
		echo"<div id='uparrow' class='arrows' onclick='dispnewsfeed(this.id)'>";
		echo "<p id='nftext'>click to hide stock news</p>";
		echo "<img src='http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Up.png' style='position:absolute;left:50%;top:5% width:20px;height:20px;'>";
		echo"</div>";
		
		//print_r($newslink1);
		//print_r($pubtime1);
		    echo"<div id='newsfeed'>";
			echo"<table>";			
			echo"<tr><td class='col3'><a target='_blank' style='color: blue;' href=$newslink1[0]>$title1[0]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	Publicated Time:&nbsp;$pubtime1[0]</td></tr>";
			echo"<tr><td class='col3'><a target='_blank' style='color: blue;' href=$newslink1[1]>$title1[1]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	Publicated Time:&nbsp;$pubtime1[1]</td></tr>";
			echo"<tr><td class='col3'><a target='_blank' style='color: blue;' href=$newslink1[2]>$title1[2]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	Publicated Time:&nbsp;$pubtime1[2]</td></tr>";
			echo"<tr><td class='col3'><a target='_blank' style='color: blue;' href=$newslink1[3]>$title1[3]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	Publicated Time:&nbsp;$pubtime1[3]</td></tr>";
			echo"<tr><td class='col3'><a target='_blank' style='color: blue;' href=$newslink1[4]>$title1[4]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	Publicated Time:&nbsp;$pubtime1[4]</td></tr>";
			echo"</table>";
			echo"</div>";
		
		
		}
		
		else
		{
	 		echo"<table>";			
			echo"<tr><td class='col1'>Error</td><td class='col2'>Error: No record has been found,please enter a valid symbol</td></tr>";
			echo"</table>";
		}
	 
	}
	 
		 //If search is clicked without any input
		else
		{
	 		 echo '<script type="text/javascript">alert("Please enter a symbol");</script>';
		}
	}
	
	
	
	?>
	
<script type="text/javascript">
  
  
  
  
  function reset_form()
		{
			window.location.href="stock.php";
			//window.alert(document.getElementById("key").value);
			document.getElementById("key").value="";
		}
		
	
  
  function dispchart(id)
  {
	  
	  document.getElementById('EMA').style.display = 'none';
	  document.getElementById('SMA').style.display = 'none';
	  document.getElementById('STOCH').style.display = 'none';
	  document.getElementById('RSI').style.display = 'none';
	  document.getElementById('ADX').style.display = 'none';
	  document.getElementById('CCI').style.display = 'none';
	  document.getElementById('BBANDS').style.display = 'none';
	  document.getElementById('MACD').style.display = 'none';
	  document.getElementById('Price').style.display = 'none';
	  
	  document.getElementById(id).style.display = 'block';
  }
  
  function drawchart(id)
  {
	  var avlinkjs="<a style=\"color:blue\; font-style: normal\;\" target=\"_blank\" href=\"https://www.alphavantage.co/\" >";
	  var nkey=[];
	  if(id=='SMA')
	  {
		  var stksymbol=document.getElementById("key").value;
		  //window.alert(stksymbol);
		  
		var SMAchart= "https://www.alphavantage.co/query?function=SMA&symbol="+encodeURIComponent(stksymbol)+"&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8";
		
		var a;
		a=loadJSON(SMAchart);	//calls the loadXML function
    	
		function loadJSON(url) 
		{
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
		xmlhttp.open("GET",url,false);
		xmlhttp.overrideMimeType("application/json");
		xmlhttp.send();
			
		jsonObj= JSON.parse(xmlhttp.responseText);
		//console.log(jsonObj);
		return jsonObj; 
		}
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
		
		
		
		  Highcharts.chart('SMA', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ ind +'</p>'
    },

    subtitle: {
        text: '<p style=\"color:blue \; font-style: normal\;\">Source:</p> '+ avlinkjs +
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
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    
    series: [{
        name: stksymbol,
        
		data: SMAval,
        tooltip: {
            valueSuffix: ''
        }
    }]

    
        

});
	  }
	  
	    else if(id=='EMA')
	  {
		  var stksymbol=document.getElementById("key").value;
		  //window.alert(stksymbol);
		  
		var EMAchart= "https://www.alphavantage.co/query?function=EMA&symbol="+encodeURIComponent(stksymbol)+"&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8";
		
		var a;
		b=loadJSON(EMAchart);	//calls the loadXML function
    	
		function loadJSON(url) 
		{
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
		xmlhttp.open("GET",url,false);
		xmlhttp.overrideMimeType("application/json");
		xmlhttp.send();
			
		jsonObj= JSON.parse(xmlhttp.responseText);
		//console.log(jsonObj);
		return jsonObj; 
		}
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
		
		
		
		  Highcharts.chart('EMA', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:blue \; font-style: normal\;\">Source:</p> '+ avlinkjs +
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
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    
    series: [{
        name: stksymbol,
        
		data: EMAval,
        tooltip: {
            valueSuffix: ''
        }
    }]

    
        

});
	  }
	  
	  
	  else if(id=='STOCH')
	  {
		  var stksymbol=document.getElementById("key").value;
		  //window.alert(stksymbol);
		  
		var STOCHchart= "https://www.alphavantage.co/query?function=STOCH&symbol="+encodeURIComponent(stksymbol)+"&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8";
		
		var b;
		b=loadJSON(STOCHchart);	//calls the loadXML function
    	
		function loadJSON(url) 
		{
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
		xmlhttp.open("GET",url,false);
		xmlhttp.overrideMimeType("application/json");
		xmlhttp.send();
			
		jsonObj= JSON.parse(xmlhttp.responseText);
		//console.log(jsonObj);
		return jsonObj; 
		}
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
		
		
		
		
		  Highcharts.chart('STOCH', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:blue \; font-style: normal\;\">Source:</p> '+ avlinkjs +
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
	
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    
    series: [{
        name: stksymbol+' SlowK',
        
		data: STOCHvalfn1,
        tooltip: {
            valueSuffix: ''
        }
    },
	{
        name: stksymbol+' SlowD',
        data: STOCHvalfn2
    }
	]

    
        

});
	  }
	  
	  
	    
	    else if(id=='RSI')
	  {
		  var stksymbol=document.getElementById("key").value;
		  //window.alert(stksymbol);
		  
		var RSIchart= "https://www.alphavantage.co/query?function=RSI&symbol="+encodeURIComponent(stksymbol)+"&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8";
		
		var a;
		b=loadJSON(RSIchart);	//calls the loadXML function
    	
		function loadJSON(url) 
		{
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
		xmlhttp.open("GET",url,false);
		xmlhttp.overrideMimeType("application/json");
		xmlhttp.send();
			
		jsonObj= JSON.parse(xmlhttp.responseText);
		//console.log(jsonObj);
		return jsonObj; 
		}
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
		
		
		
		  Highcharts.chart('RSI', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:blue \; font-style: normal\;\">Source:</p> '+ avlinkjs +
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
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    
    series: [{
        name: stksymbol,
        
		data: RSIval,
        tooltip: {
            valueSuffix: ''
        }
    }]

    
        

});
	  }
	  
	  
	  
	  else if(id=='ADX')
	  {
		  var stksymbol=document.getElementById("key").value;
		  //window.alert(stksymbol);
		  
		var ADXchart= "https://www.alphavantage.co/query?function=ADX&symbol="+encodeURIComponent(stksymbol)+"&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8";
		
		var a;
		b=loadJSON(ADXchart);	//calls the loadXML function
    	
		function loadJSON(url) 
		{
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
		xmlhttp.open("GET",url,false);
		xmlhttp.overrideMimeType("application/json");
		xmlhttp.send();
			
		jsonObj= JSON.parse(xmlhttp.responseText);
		//console.log(jsonObj);
		return jsonObj; 
		}
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
		
		
		
		  Highcharts.chart('ADX', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:blue \; font-style: normal\;\">Source:</p> '+ avlinkjs +
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
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    
    series: [{
        name: stksymbol,
        
		data: ADXval,
        tooltip: {
            valueSuffix: ''
        }
    }]

    
        

});
	  }
	  
	  else if(id=='CCI')
	  {
		  var stksymbol=document.getElementById("key").value;
		  //window.alert(stksymbol);
		  
		var CCIchart= "https://www.alphavantage.co/query?function=CCI&symbol="+encodeURIComponent(stksymbol)+"&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8";
		
		var a;
		b=loadJSON(CCIchart);	//calls the loadXML function
    	
		function loadJSON(url) 
		{
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
		xmlhttp.open("GET",url,false);
		xmlhttp.overrideMimeType("application/json");
		xmlhttp.send();
			
		jsonObj= JSON.parse(xmlhttp.responseText);
		//console.log(jsonObj);
		return jsonObj; 
		}
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
		
		
		
		  Highcharts.chart('CCI', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:blue \; font-style: normal\;\">Source:</p> '+ avlinkjs +
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
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    
    series: [{
        name: stksymbol,
        data: CCIval,
        tooltip: {
            valueSuffix: ''
        }
    }]

    
        

});
	  }
	  
	  else if(id=='BBANDS')
	  {
		  var stksymbol=document.getElementById("key").value;
		  //window.alert(stksymbol);
		  
		var BBANDSchart= "https://www.alphavantage.co/query?function=BBANDS&symbol="+encodeURIComponent(stksymbol)+"&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8";
		
		var b;
		b=loadJSON(BBANDSchart);	//calls the loadXML function
    	
		function loadJSON(url) 
		{
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
		xmlhttp.open("GET",url,false);
		xmlhttp.overrideMimeType("application/json");
		xmlhttp.send();
			
		jsonObj= JSON.parse(xmlhttp.responseText);
		//console.log(jsonObj);
		return jsonObj; 
		}
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
		
		
		
		  Highcharts.chart('BBANDS', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:blue \; font-style: normal\;\">Source:</p> '+ avlinkjs +
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
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    
    series: [{
        name: stksymbol+' Real Middle Band',
        
		data: BBANDSvalfn3,
        tooltip: {
            valueSuffix: ''
        }
    },
	{
        name: stksymbol+' Real Upper Band',
        data: BBANDSvalfn2
    }, 
	{
        name: stksymbol+' Real Lower Band',
        data: BBANDSvalfn1
    }
	]

    
        

});
	  }
	  
	  
	  else if(id=='MACD')
	  {
		  var stksymbol=document.getElementById("key").value;
		  //window.alert(stksymbol);
		  
		var MACDchart= "https://www.alphavantage.co/query?function=MACD&symbol="+encodeURIComponent(stksymbol)+"&interval=daily&time_period=10&series_type=close&apikey=77RQS8FMJXG5LVF8";
		
		var b;
		b=loadJSON(MACDchart);	//calls the loadXML function
    	
		function loadJSON(url) 
		{
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		
		xmlhttp.open("GET",url,false);
		xmlhttp.overrideMimeType("application/json");
		xmlhttp.send();
			
		jsonObj= JSON.parse(xmlhttp.responseText);
		//console.log(jsonObj);
		return jsonObj; 
		}
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
		
		
		
		  Highcharts.chart('MACD', {

    title: {
        text: '<p style=\" font-style: normal\;\">'+ind+'</p>'
    },

    subtitle: {
        text: '<p style=\"color:blue \; font-style: normal\;\">Source:</p> '+ avlinkjs +
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
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    
    series: [{
        name: stksymbol+' MACD',
        data: MACDvalnew1,
        tooltip: {
            valueSuffix: ''
        }
    },
	{
        name: stksymbol+' MACD_Hist',
        data: MACDvalnew2
    }, 
	{
        name: stksymbol+' MACD_Signal',
        data: MACDvalnew3
    }
	]

    
        

});
	  }
	  
	  
	  
	  
  }
  
  
  function dispnewsfeed(id)
  
  {
	  console.log(id);
	  if(id=="downarrow"){
	  document.getElementById('newsfeed').style.display = 'block';
	  document.getElementById('uparrow').style.display = 'block';
	  document.getElementById('downarrow').style.display = 'none';
	  }
	  else{
		
	  document.getElementById('newsfeed').style.display = 'none';
	  document.getElementById('downarrow').style.display = 'block';
	  document.getElementById('uparrow').style.display = 'none';
	  }
	  
  }
  
  
 
  
  
  </script>	
</body>
</html>