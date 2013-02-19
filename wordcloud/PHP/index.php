<?php
//
// 
// @author Harish Prasanna http://www.facebook.com/harishperfect
//
$path="test.txt";
$fdata=file_get_contents($path);
$noisepath="noise.txt";
$nodata=file_get_contents($noisepath);
$ndata=strtolower($nodata);
$lines = count(file($path)) - 1;


function filter_stopwords($words, $stopwords) {

    foreach ($words as $pos => $word) {
        if (!in_array(strtolower($word), $stopwords, TRUE)) {
            $filtered_words[$pos] = $word;
        }
    }

	$uwords=$filtered_words;
    return $filtered_words;

}


function word_freq($words) {

    $frequency_list = array();

    foreach ($words as $pos => $word) {

        $word = strtolower($word);
        if (array_key_exists($word, $frequency_list)) {
            ++$frequency_list[$word];
        }
        else {
            $frequency_list[$word] = 1;
        }

    }

    return $frequency_list;

}

function word_cloud($words, $div_size = 400) {

    $tags = 0;
    $cloud = "<div style=\"width: {$div_size}px\">";
    
    $fmax = 96; 
    $fmin = 8; 
    $tmin = min($words); 
    $tmax = max($words); 

    foreach ($words as $word => $frequency) {
    
        if ($frequency > $tmin) {
            $font_size = floor(  ( $fmax * ($frequency - $tmin) ) / ( $tmax - $tmin )  );
      
            $r = $g = 0; $b = floor( 255 * ($frequency / $tmax) );
            $color = '#' . sprintf('%02s', dechex($r)) . sprintf('%02s', dechex($g)) . sprintf('%02s', dechex($b));
        }
        else {
            $font_size = 0;
        }
        
        if ($font_size >= $fmin) {
            $cloud .= "<span style=\"font-size: {$font_size}px;title:{$frequency}; color: $color;\"><a href=\"http://127.0.0.1:8887/prog/lines.php?name={$word}\" title=\"{$frequency}\">$word</a></span> ";
            $tags++;
        }
        
    }
    
    $cloud .= "</div>";
    
    return array($cloud, $tags);
    
}


if (strtoupper($fdata != '')) 
    {

    $text = $fdata; 
    $stopwords=str_word_count($ndata,1);
    $words = str_word_count($text, 1); 
    $word_count = count($words);
    $unique_words = count( array_unique($words) ); 
	$uwords=array_unique($words);
    $words_filtered = filter_stopwords($words, $stopwords); 
    $word_frequency = word_freq($words_filtered); 
    $word_c = word_cloud($word_frequency);
    $word_cloud = $word_c[0]; 
    $tags = $word_c[1]; 
	

}


?>

<html>
<head>
    <title> Word Cloud by N.D.P.Harish Prasanna </title>
</head>

<body>
    <p><b>Total No of Lines:</b> <?php echo $lines; ?></p>
    <p><b>Total No of Words:</b> <?php echo $word_count; ?></p>
    <p><b>The unique words are:</b> <?php foreach($uwords as $value) {
  print $value;
  print " ";
} ?></p>
    <p><b>Number of words tagged:</b> <?php echo $tags; ?></p>
     <p><b>Word Cloud::</b> <?php echo $word_cloud; ?> </p>
    

</body>
</html>
