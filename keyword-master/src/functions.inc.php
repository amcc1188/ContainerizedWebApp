<?php

function KeyWordCount($paragraph, $word)

{   
    //convert to all upper-case as search is case insensitive     
    $paragraph = strtoupper($paragraph);
    $word = strtoupper($word);

   if (strpos($paragraph, $word) !== false){

        //if key word exists - return count
        return substr_count($paragraph, $word); 
    }  

    else
        //key word doesnt exist
        return 0;  
}

