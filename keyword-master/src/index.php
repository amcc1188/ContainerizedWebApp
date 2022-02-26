<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
require('functions.inc.php');

$output = array(
	"error" => false,
    "string" => "",
	"answer" => 0
);

//paragraph and word sent in URL
$paragraph = $_REQUEST['paragraph'];
$word = $_REQUEST['word'];

//error hadnling:

//invalid characters
$invalid = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
$invalid2 = '~[0-9]~';

//check for invalid characters
if(preg_match($invalid, $word)==1){
	$output['error'] = true;
	$output['answer']= "invalid characters entered";
	$output['string']= "null";
}

//check if number entered instead of word
elseif(preg_match($invalid2, $word)==1){
	$output['error'] = true;
	$output['answer']= "numbers entered";
	$output['string']= "null";
} 
//no word or paragraph entered   
elseif($word == '' && $paragraph == ''){
	$output['error']=true;
	$output['string']=$paragraph."+".$word."=".$answer;
	$output['answer']="paragraph & word missing";
}

//no paragraph entered
elseif($paragraph == ''){
	$output['error']=true;
	$output['string']=$paragraph."+".$word."=".$answer;
	$output['answer']="paragraph missing";
}

//no word entered
elseif($word == ''){
	$output['error']=true;
	$output['string']=$paragraph."+".$word."=".$answer;
	$output['answer']="word missing";
}

//multiple words entered
elseif(str_word_count($word)>1){
	$output['error']=true;
	$output['string']=$paragraph."+".$word."=".$answer;
	$output['answer']="multiple words entered";
}

//no errors
else{
	//invoke KeyWordCount function
	$answer=KeyWordCount($paragraph,$word);
	$output['string']=$paragraph."+".$word."=".$answer;
	$output['answer']=$answer;
}
	echo json_encode($output);

exit();
