<?php
include_once('./config/config.php');
?>
<?php
    //Set question number
    $number = (int) $_GET['n'];

    /*
    * Get total questions
    */
    $query = "SELECT * FROM questions";
    //Get result
    $result = $conn->query($query) or die("Error connecting to database: " . mysqli_connect_error());
    $total = $result->num_rows;

    /*
    *Get Question
    */ 
    $query = "SELECT * FROM `questions`
                WHERE question_number = $number";
    //Get result
    $result = $conn->query($query) or die("Error connecting to database: " . mysqli_connect_error());

    $question = $result->fetch_assoc();

    /*
    *Get Choices
    */ 
    $query = "SELECT * FROM `choices`
                WHERE question_number = $number";
    //Get result
    $choices = $conn->query($query) or die("Error connecting to database: " . mysqli_connect_error());

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

            .current{
                padding: 10px;
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
                <div class="current">Question <?php echo $question['question_number']; ?> of <?php echo $total; ?></div>
                <p class="question">
                    <?php echo $question['text']; ?>
                </p>
                <form method="post" action="process.php">
                    <ul class="choices">
                        <?php while ($row = $choices->fetch_assoc()): ?>
                            <li><input name="choice" type="radio" value="<?php echo $row['id']; ?>" /><?php echo $row['text']; ?></li>
                        <?php endwhile; ?>
                    </ul>
                    <input type="submit" value="Submit" />
                    <input type="hidden" name="number" value="<?php echo $number; ?>" />
                </form>
            </div>
        </main>
        <footer>
            <div class="container">
                Copyright &copy 2023
        </footer>
    </body>
</html>