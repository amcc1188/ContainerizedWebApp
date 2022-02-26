<!DOCTYPE html>
<html>
<head>

<title>WebWordCount</title>

<style type="text/css">
body  {
    font-size: 150%;
    font-family: monospace;
}

#logo
{
    font-family: Calibri, sans-serif;
    font-weight: lighter;
    color: #505050;
    margin: 0.5em;
}

#wordcount
{
    text-align: center;
    margin-top: 1em;
}

#paragraph {
    font-size: 90%;
    padding: 0.2em;
    margin: 0.2em;
    font-family: monospace;
    letter-spacing: 0.1em;
    border: 1px solid black;

}

#word {
    font-size: 90%;
    border: 1px solid black;
    padding: 0.2em;
    margin: 0.2em;
    font-family: monospace;
    letter-spacing: 0.1em;
    width: 400px;

}

.display {
    font-size: 90%;
    color: white;
    background-color: black;
    padding: 0.2em;
    margin: 0.2em;
    font-family: monospace;
    letter-spacing: 0.1em;
    width: 400px;

}

.wwcbutton {
    background-color: green;
    color: white;
    padding: 0px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin: 4px 2px;
    cursor: pointer;
    height: 40px;
    width: 400px;
}

.wwcbutton-inactive {
    background-color: gray;
    color: white;
    padding: 0px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin: 4px 2px;
    cursor: pointer;
    height: 40px;
    width: 400px;
}

.wwcbutton-clear {
    background-color: red;
    color: white;
    padding: 0px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin: 4px 2px;
    cursor: pointer;
    height: 40px;
    width: 400px;
}

</style>

</head>
<body>
<?php

$jsonurls = file_get_contents('url.json');
$urlsarray = json_decode($jsonurls, true);
$finalURL = '';
foreach($urlsarray['backendServices']['proxies'] as $url){

	// Use get_headers() function
	$headers = @get_headers($url);


	// Use condition to check the existence of URL
	if($headers && strpos( $headers[0], '200')) {
		$finalURL = $url;	
		break;
	}
	else {
	//	echo $status = $url." : URL Doesn't Exist<br>";
	}
}

?>

<div id="wordcount">
    <div id="logo">
        Web Word Count App
    </div>
    <div>
        <textarea id="paragraph" rows="5" cols="35" placeholder="Enter the paragraph here..." value = ''></textarea>
    </div>
    <div>
        <input type="text" id="word" placeholder="Enter the keyword here..." value="">
    </div>
    <div>
        <input type="text" class="display" id="display-1" readonly=1 placeholder="Total word count = 0 " value=""><br>
        <input type="text" class="display" id="display-2" readonly=1 placeholder="Keyword does not exist!" value=""><br>
        <input type="text" class="display" id="display-3" readonly=1 placeholder="Total keyword appearances = 0" value="">
    </div>
    <div>
        <button class="wwcbutton" onclick="WordCount();">Total words?</button>
    </div>
    <div>
        <button class="wwcbutton" onclick="Check();">Check keyword appearance</button>
    </div>
    <div>
        <button class="wwcbutton" onclick="KeywordAppearance();">Total keyword appearances?</button>
    </div>
    <div>
        <button class="wwcbutton-clear" onclick="Clear();">Clear</button>
    </div>

</div>
</body>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript">

	let result = 0;
	let paragraph = '';
	let word = '';


	let proxy = "<?php echo $finalURL; ?>";

	console.log("proxy URL : "+ proxy);
	function Display()
	{
		if (result == 1){
			//service return '1' if keyword exists
			result = 'Keyword exists!';
			}

		if (result == 0){
			//service return '0' if key word doesnt exist
			result = 'Keyword does not exist!';
		}
			//service return error message if word or paragraph hasnt been entered
			document.getElementById('display-2').value = result;


	}

	function DisplayCount(){

		//if paragraph missing service return error message, otherwise word count performed

		if(result == "paragraph missing"){

			document.getElementById('display-1').value = result;

		} else {

			document.getElementById('display-1').value = 'Total word count = '+ result;

		}


	}

	function DisplayKeyWordCount(){

			//if service return an integer value - no errors
			if( result == parseInt(result, 10)){

				document.getElementById('display-3').value = 'Total key word count = ' + result;

			}else{
				//service return error message of no word, no paragraph or multiple words entered
				document.getElementById('display-3').value = result;
			}




	}

	function Clear()
	{
		document.getElementById('paragraph').value = '';
		document.getElementById('word').value = '';
		document.getElementById('display-1').value = '';
		document.getElementById('display-2').value = '';
		document.getElementById('display-3').value = '';

	}

	function Check()
	{
		//retrieve paragraph & word values
		paragraph = document.getElementById('paragraph').value
		word = document.getElementById('word').value
		var invalid = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
		var hasnumber = /\d/;

	
  	 if (paragraph == '' && word == ''){

		  document.getElementById('display-2').value = 'Error! paragraph and word missing';
		   return;
	   }

	  else if (paragraph == ''){
			document.getElementById('display-2').value = 'Error! paragraph missing';
		   return;
	   }

	   else if (word == ''){
			document.getElementById('display-2').value = 'Error! word missing';
		   return;
	   } 

		else if (invalid.test(word)){		  
		document.getElementById('display-2').value = 'Error! invalid characters';
		return;
		}
		
		else if (hasnumber.test(word)){
		document.getElementById('display-2').value = 'Error! numbers entered';
		return;	
		}

		else if (word.split(" ").length > 1){
		document.getElementById('display-2').value = 'Error! multiple words entered';
 		return;
		}	
			

	   else  {

			let xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var j = JSON.parse(this.response);
					result = j.answer;
					//invoke function
					Display();
				}
			};

			// request to word check service - passing paragraph and word values in URL
			xhttp.open("GET",proxy+"?request=wordcheck&paragraph="+paragraph+"&word="+word);
			xhttp.send();

			return;
	 }
	}


	function WordCount(){

	//retrive paragraph value

	paragraph = document.getElementById('paragraph').value

	//invalid values	
	var invalid = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
	var hasnumber = /\d/;

	if (paragraph == ''){
	   document.getElementById('display-1').value = 'Error! paragraph missing';
	   return;

	} 

	else{ 

		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var j = JSON.parse(this.response);
				result = j.answer;
				//invoke function
				DisplayCount();
			}
		};

		// request to word count service - passing paragraph value in URL
		xhttp.open("GET",proxy+"?request=wordcount&paragraph="+paragraph);
		xhttp.send();

		return;

	}
	}

	function KeywordAppearance(){

		//retrieve paragraph & word values
		paragraph = document.getElementById('paragraph').value
		word = document.getElementById('word').value

		//check invalid values
		var invalid = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
		var hasnumber = /\d/;

	    if (paragraph == '' && word == '') {
		   document.getElementById('display-3').value = 'Error! paragraph & keyword missing';
	      return;
	  }

	  else if (paragraph == ''){
	      document.getElementById('display-3').value = 'Error! paragraph missing';
	       return;
	   }

		else if (word == ''){
	       document.getElementById('display-3').value = 'Error! word missing';
	      return;
	   }	  

		else if (invalid.test(word)){		  
		document.getElementById('display-3').value = 'Error! invalid characters';
		return;
		}		

		else if (hasnumber.test(word)){
		document.getElementById('display-3').value = 'Error! numbers entered';
		return;	
		}

		else if (word.split(" ").length > 1){
		document.getElementById('display-3').value = 'Error! multiple words entered';
 		return;
		}	

	    else
	   {
			let xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var j = JSON.parse(this.response);
					result = j.answer;
					//invoke function
					DisplayKeyWordCount();
				}
			};

			let url1 = proxy+"?request=keywordcount&paragraph="+paragraph+"&word="+word;
			console.log('url1 : '+url1);
			//request to keyword service - passing paragraph and word values in URL
			xhttp.open("GET",url1);
			xhttp.send();

			return;

}
}

</script>

</html>
