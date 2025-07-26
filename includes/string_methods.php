 <?php
    //====================================================
    // Extra concept::::recursive Function
    // function factorial($n){
    //     if($n==0 || $n ==1){
    //         return 1;
    //     }
    //     else{
    //         return $n * factorial($n - 1);
    //     }
    // }
    // echo "factorial is" . factorial(3);


    //=================================================//

    // str_replace string Method 
    // $text = "I am a PHP Developer  NewSoftwares.net For Last 1 Year";
    // $search = ['I', "1", "am", 'the'];
    // $replace = ['We', "One", 'are', 'Junior'];
    // $count = 0;


    // $finaltext = str_replace($search, $replace, $text, $count);
    // echo $finaltext . "<br>";
    // echo "The Replacement made: " . $count;
    //trim string methods
    // $name = "!!!!!!!!!!hanan@@@@@@@";
    // echo trim($name,'!,@');

    //implode String Method 
    //===============================//
    //syntax--------
    // string implode(separator,array)
    //================================//

    //seperator Belongs to The specific type Which you wanna join Your String.... and Array belongs to the parameter Which You Wanna Join

    //example........With seperator Used......
    // $arr = ["I Love PHP","Love Mangoes",1,"Love Grapes"];
    // echo implode(",",$arr);
    // //example......With No seperator Used...........
    // $arr2 = ['I','Love','Mangoes'];
    // echo implode('.....',$arr2);

    //substr String Method............

    // substr(string_name, start_position, string_length_to_cut)
    // $str = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero nemo hic accusamus inventore, est ex impedit deleniti cumque facere aliquid sed esse adipisci';
    // echo substr($str,0,10);


    //strpos string  method 

    //syntax: Original string, SearchStr, and start_position....

    // function search($string, $search)
    // {
    //     $position = strpos($string, $search);

    //     if (is_numeric($position)) {
    //         return "Found At Position &nbsp;" . $position;
    //     } else {
    //         return "Not Found";
    //     }
    // }

    // $string = 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis dolore commodi possimus dolorem molestias, aspernatur itaque autem, voluptate non quod facilis excepturi eligendi dolor, delectus rem porro eius et sapiente';
    // $search = "Lorem";
    // echo search($string, $search);

   //  $name = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, delectus maxime. Placeat nesciunt, quam et consequuntur eum accusamus! Harum, dolor adipisci assumenda dicta distinctio id maiores doloribus repudiandae vel sapiente!";
   //  $newname = strtoupper($name);
   //  echo $newname;


   //htmlspechar() string method
// $input = 'Welcome <b>Admin</b>!';
// echo htmlspecialchars($input);

// $input = 'Nice website! <img src="fake.jpg" onerror="alert(\'XSS\')">';
// echo htmlspecialchars($input);

// $name = '<img src="x" onerror="alert(\'You are hacked!\')">';
// $new = htmlspecialchars($name);
// echo $new;

//str_tags 
$text = '<script>alert("Hack")</script><b>Hello</b>';
echo "Original: $text<br>";
echo "strip_tags: " . strip_tags($text, '<b>') . "<br>";
echo "htmlspecialchars: " . htmlspecialchars($text);




