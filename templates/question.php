<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="your name">
        <meta name="description" content="include some description about your page">  
        <title>Wordle Game</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    </head>
    <body>
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <h1>CS4640 Wordle Game</h1>
                <h3>Hello <?=$_SESSION["name"]?>! Email:<?=$_SESSION["email"]?> Guesses:<?=count($_SESSION["guess"])?> </h3>
            </div>
            <div class="row">
                <div class="col-xs-8 mx-auto">
                <form action="?command=question" method="post">
                    <div class="h-100 p-5 bg-light border rounded-3">
                        <?php
                            if(isset($_SESSION["guess"])) {
                                for ($i = 0; $i < count($_SESSION["guess"]); $i++) {
                                    echo "word: ";
                                    echo $_SESSION["guess"][$i];

                                    echo ", word length: ";
                                    echo strlen($_SESSION["guess"][$i]); 
                                    
                                    echo ", characters in word but wrong spot: ";
                                    echo $_SESSION["letters_in_word"][$i]; 

                                    echo ", characters in word with right spot: ";
                                    echo $_SESSION["correct_letter"][$i];
                                    
                                    echo ", word length: ";
                                    echo $_SESSION["guess_length"][$i];
                                    

                                    echo "<br>";
                                }
                            }
                        ?>
                    </div>
                    <div class="h-10 p-5 mb-3">
                        <input type="text" class="form-control" id="answer" name="answer" placeholder="Type your answer here">
                    </div>
                    <div class="text-center">                
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="?command=gameover" class="btn btn-danger">Game Over</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>