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

            label{
                display: inline-block;
                width: 180px;
            }

            input[type='text']{
                width: 97%;
                padding: 4px;
                border-radius: 5px;
                border: 1px #ccc solid;
            }

            input[type='number']{
                width: 50%;
                padding: 4px;
                border-radius: 5px;
                border: 1px #ccc solid;
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

            @media only screen and (max-width:960px){
                .container{
                    width: 80%;
                }
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
                <h2>Add A Question</h2>
                <form method="post" action="add.php">
                    <p>
                         <label>Question Number</label>
                        <input type="number" name="question_number" />
                    </p>
                    <p>
                        <label>Question Text</label>
                         <input type="text" name="question_text" />
                    </p>
                    <p>
                        <label>Choice #1</label>
                         <input type="text" name="choice1" />
                    </p>
                    <p>
                        <label>Choice #2</label>
                         <input type="text" name="choice2" />
                    </p>
                    <p>
                        <label>Choice #3</label>
                         <input type="text" name="choice3" />
                    </p>
                    <p>
                        <label>Choice #4</label>
                         <input type="text" name="choice4" />
                    </p>
                    <p>
                        <label>Correct Choice Number</label>
                         <input type="number" name="current_choice" />
                    </p>
                    <p>
                         <input type="submit" name="submit" value="Submit" />
                    </p>
                </form>
            </div>
        </main>
        <footer>
            <div class="container">
                Copyright &copy 2023
        </footer>
    </body>
</html>