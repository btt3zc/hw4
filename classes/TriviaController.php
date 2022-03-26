<?php
class TriviaController {

    private $command;

    public function __construct($command) {
        $this->command = $command;
    }

    public function run() {
        switch($this->command) {
            case "question":
                $this->question();
                break;
            case "logout":
                $this->destroyCookies();
            case "login":
            default:
                $this->login();
                break;
        }
    }

    // Clear all the cookies that we've set
    private function destroyCookies() {          
        session_destroy(); 
    }
    

    // Display the login page (and handle login logic)
    public function login() {
        if (isset($_POST["email"]) && !empty($_POST["email"])) { /// validate the email coming in
            $_SESSION["email"] = $_POST["email"]; 
            $_SESSION["name"] = $_POST["name"]; 
            header("Location: ?command=question");
            return;
        }

        include "templates/login.php";
    }

    // Load a question from the API
    private function loadQuestion() {
        
        $file = file("https://www.cs.virginia.edu/~jh2jf/courses/cs4640/spring2022/wordlist.txt",true);
        $wCount = count($file);
        // Return the question
        
        if (isset($_SESSION["target_word"]) == False) {
            $word =  trim($file[rand(0, $wCount - 1)]); 
            $_SESSION["target_word"] = $word;

            //$question = $_SESSION["target_word"];
        }
        return $_SESSION["target_word"];

    }
    //works
    private function addGuess() {
        if(!isset($_SESSION["guess"])) {
            $_SESSION["guess"] = array(); 
        }
    

        array_push($_SESSION["guess"],$_POST["answer"]);
        //print_r($_SESSION["guess"]); 
    }


    private function addLength() {
        if(!isset($_SESSION["guess_length"])) {
            $_SESSION["guess_length"] = array(); 
        
    }

}




    private function CheckWord($q,$a,$incrementi,$incrementj) {
        strcasecmp($q[$incrementj],$a[$incrementi]); 
            if (strcasecmp($q[$incrementj],$a[$incrementi]) == 0) {
                return 1; // in the word, somewhere
            } else {
                return 2; // not in word
            }
                        
    }


    // Display the question template (and handle question logic)
    public function question() {
        // set user information for the page from the cookie
        $user = [
            "name" => $_SESSION["name"],
            "email" => $_SESSION["email"],
        ];

        // load the word
        //if (isset($question) == False) {
        //    $this->loadQuestion();
        //    $question = $_SESSION["target_word"];
       // }
        $question = $this->loadQuestion();
        echo $question; 
        if (isset($_POST["answer"])) {
            $this->addGuess(); 
            $this->addLength(); 

            if(strlen($question) == strlen($_POST["answer"]) ) {

                print_r ($_SESSION["guess_length"]);
                array_push($_SESSION["guess_length"], "correct word length");
                
                for($i = 0; $i < strlen($_POST["answer"]);  $i++) { 
                    // case for same letters
                    //strpos($_POST["answer"][$i], $question[$i])
                    if(  strcasecmp($question[$i],$_POST["answer"][$i]  == 0 )) {
                        echo "in word"; 
                    }
                    //case for in word 
                    else {

                        $in_word = 0;
                        for($j = 0; $j < strlen($question);  $j++) {
                            if ($this->CheckWord($question,$_POST["answer"], $i,$j) == 1) {
                                $in_word = 1; 
                            } 
                        }
                        //echo $in_word; 
                    
                        //echo  $_POST["answer"][$i]; 
                        
                    }
                }
            } else {
                $length_1 = strlen($question); 
                $length_2 = strlen($_POST["answer"]); 
                if($length_1 >  $length_2 ) {
                    array_push($_SESSION["guess_length"], "too short");
                    $shortest = $length_2; 
                } else {
                    $shortest = $length_1; 
                    array_push($_SESSION["guess_length"], "too long");
                }
                print_r ($_SESSION["guess_length"]); 
                for($i = 0; $i < $shortest;  $i++) { 
                    // case for same letters
                    //strpos($_POST["answer"][$i], $question[$i])
                    if(  strcasecmp($question[$i],$_POST["answer"][$i]  == 0 )) {
                        echo "in word"; 
                    }
                    //case for in word 
                    else {

                        $in_word = 0;
                        for($j = 0; $j < strlen($question);  $j++) {
                            if ($this->CheckWord($question,$_POST["answer"], $i,$j) == 1) {
                                $in_word = 1; 
                            } 
                        }
                        //echo $in_word; 
                    
                        //echo  $_POST["answer"][$i]; 
                        
                    }
                }
            }
        }






        $message = "";

        // if the user submitted an answer, check it

        include("templates/question.php");
    }
}