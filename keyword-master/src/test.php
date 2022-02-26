<?php
echo "Test Script Starting\n";

$json = "http://frontend.40036410.qpc.hal.davecutting.uk/url.json";
$str = file_get_contents($json);
$data = json_decode($str, true);
$finalURL = '';
foreach($data['backendServices']['keywordcount'] as $url){

// Use get_headers() function
$headers = @get_headers($url);
 
// Use condition to check the existence of URL
if($headers && strpos( $headers[0], '200')) {
    $finalURL = $url;
   echo "Test Result: HTTP 200 OK - request has succeeded for $finalURL \n";
    break;
}
else {
     echo "Test Result: request has failed for $url \n";  
}
}

$keywordURL = "$finalURL";

//test condition: key word appears twice
$paragraph='This is test using test paragraph';

$paragraph = urlencode($paragraph);

$word='test';

$expect=2;

$endpoint = "$keywordURL/?paragraph=$paragraph&word=$word";

$data = file_get_contents($endpoint);

$response = json_decode($data, true);
    
    $answer = $response['answer'];

echo "Test Result: ".$paragraph."+".$word."=".$answer." (expected: ".$expect.")\n";

//test condition: error handling - no word or paragraph entered

$paragraph2='';

$word2='';

$expect2= "paragraph & word missing";

$endpoint2 = "$keywordURL/?paragraph=$paragraph2&word=$word2";

$data2 = file_get_contents($endpoint2);

$response2 = json_decode($data2, true);

    $answer2 = $response2['answer'];

echo "Test Result: ".$paragraph2."+".$word2."=".$answer2." (expected: ".$expect2.")\n";

//test condition: error handling - no word entered

$paragraph3='test paragraph';

$paragraph3 = urlencode($paragraph3);

$word3='';

$expect3= "word missing";

$endpoint3 = "$keywordURL/?paragraph=$paragraph3&word=$word3";

$data3 = file_get_contents($endpoint3);

$response3 = json_decode($data3, true);

    $answer3 = $response3['answer'];

echo "Test Result: ".$paragraph3."+".$word3."=".$answer3." (expected: ".$expect3.")\n";

//test condition: error handling - no paragraph entered
$paragraph4='';

$word4='test';

$expect4= "paragraph missing";

$endpoint4 = "$keywordURL/?paragraph=$paragraph4&word=$word4";

$data4 = file_get_contents($endpoint4);

$response4 = json_decode($data4, true);

    $answer4 = $response4['answer'];

echo "Test Result: ".$paragraph4."+".$word4."=".$answer4." (expected: ".$expect4.")\n";

//test condition: error handling - multiple words
$words='two words';
$words = urlencode($words);

$expect5= "multiple words entered";

$endpoint5 = "$keywordURL/?paragraph=$paragraph&word=$words";

$data5 = file_get_contents($endpoint5);

$response5 = json_decode($data5, true);

    $answer5 = $response5['answer'];

echo "Test Result: ".$paragraph."+".$words."=".$answer5." (expected: ".$expect5.")\n";

// test condition - error handling: numbers entered
$expect7 = 'numbers entered';
$paragraph7 = 'hi';
$words7 = '123';
$endpoint7 = "$keywordURL?paragraph=$paragraph7&word=$words7";
$data7 = file_get_contents($endpoint7);
$response7 = json_decode($data7, true);
$answer7 = $response7['answer'];
echo "Test Result: ".$paragraph7."+".$words7."=".$answer7." (expected: ".$expect7.")\n";

// test condition - error handling: numbers entered
$expect8 = 'invalid characters entered';
$paragraph8 = 'hi';
$words8 = '@!%';
$endpoint8 = "$keywordURL?paragraph=$paragraph8&word=$words8";
$data8 = file_get_contents($endpoint8);
$response8 = json_decode($data8, true);
$answer8 = $response8['answer'];
echo "Test Result: ".$paragraph8."+".$words8."=".$answer8." (expected: ".$expect8.")\n";

//only when all answers = expected the test is passed
if (isset($finalURL) && $answer==$expect && $answer2 == $expect2 && $answer3 == $expect3 && $answer4 == $expect4 && $answer5 == $expect5 && $answer7 == $expect7 && $answer8 == $expect8)
{
    echo "Test Passed\n";
    exit(0); // exit code 0 - success
}
else
{
    echo "Test Failed\n";
    exit(1); // exit code not zero - error
}

