<?php
include_once('./config/config.php');
?>

<?php 
/*
* Get Total Number of Questions
*/
$query = "SELECT * FROM questions";
//Get results
$result = $conn->query($query) or die("Error connecting to database: " . mysqli_connect_error());
$total = $result->num_rows;
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <title>PHP Quiz</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" />
       <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
                background-color: white;
                line-height: 1.7rem;
            } 

            li{
                list-style: none;
            }

            a{
                text-decoration: none;
            }

            .container{
                width: 60%;
                margin:0 auto;
                overflow: auto;
            }

            header{
                border-bottom: 3px #f4f4f4 solid;
            }

            footer{
                border-top: 3px #f4f4f4 solid;
                text-align: center;
                padding-top:5px ;
            }

            main{
                padding-bottom: 20px;
            }

            a.start{
                display: inline-block;
                color: #666;
                background: #f4f4f4;
                border: 1px dotted #ccc;
                padding: 6px 13px;
            }

            
        </style>

    </head>

    <body>
        <header>
            <div class="container">
                <h1>PHP Quizzer</h1>
        </header>
        <main>
            <div class="container">
                <h2>Test Your Knowledge</h2>
                <p>This is a multiple choice quiz to test your Knowledge</p>
                <ul>
                    <li><strong>Number Of Questions: </strong><?php echo $total; ?></li>
                    <li><strong>Type: </strong>Multiple Choice</li>
                    <li><strong>Estimated Time: </strong><?php echo $total * .5; ?> Minutes</li>
                </ul>
                <a href="phpquestion.php?n=1" class="start">Start Quiz</a>
            </div>
        </main>
        <footer>
            <div class="container">
                Copyright &copy 2023
        </footer>
    </body>
</html>