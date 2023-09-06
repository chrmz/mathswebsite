DROP schema `web_based_mcq`;
create schema `web_based_mcq`;

use `web_based_mcq`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('Student','Admin') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


/**
create initial user (username= user, password=1234 )
**/
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `role`, `password`) 
VALUES ('1', "Prince", 'Eke', 'admin@admin.com', 'Admin', '$2y$10$clx7Rwrbj0EYVwz5fx8Twux03ITpGxXZe3Nvb3qPYzafd8ryiQ4ym');


CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `popular` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  `document` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- INSERT THE MODLES
INSERT INTO `modules` (`id`, `name`, `logo`, `popular` ) VALUES ('1', "Algebra", 'algebra.png', 1);
INSERT INTO `modules` (`id`, `name`, `logo`, `popular` ) VALUES ('2', "Fractions", 'fractions.png', 1);
INSERT INTO `modules` (`id`, `name`, `logo`, `popular` ) VALUES ('3', "Number Systems", 'numbers.png', 1);
INSERT INTO `modules` (`id`, `name`, `logo`, `popular` ) VALUES ('4', "Probability", 'Probability.png', 1);
INSERT INTO `modules` (`id`, `name`, `logo`, `popular` ) VALUES ('5', "Trigonemtry", 'trigonometry.png', 1);
INSERT INTO `modules` (`id`, `name`, `logo`, `popular` ) VALUES ('6', "Geometry", 'geometry.webp', 1);

-- INSERT THE subjects
INSERT INTO `subject` (`id`, `name`, `module_id` ) VALUES ('1', "Quadratics", 1);

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL UNIQUE,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


INSERT INTO `quizzes` (`id`, `name`, `image`) VALUES ('1', "Beginner", 'easy.webp' );
INSERT INTO `quizzes` (`id`, `name`, `image`) VALUES ('2', "Normal", 'normal.jpg');
INSERT INTO `quizzes` (`id`, `name`, `image`) VALUES ('3', "Hard", 'hard.jpg');
INSERT INTO `quizzes` (`id`, `name`, `image`) VALUES ('4', "Extreme", 'extreme.webp');
INSERT INTO `quizzes` (`id`, `name`, `image`) VALUES ('5', "Legendary", 'legendary.jpg');

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `difficulty` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` TEXT NOT NULL,
  `quiz_time` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`quiz_id`) REFERENCES quiz(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `quiz_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer` TEXT NOT NULL,
  `correct` tinyint(4) DEFAULT 1,
  `quiz_question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`quiz_question_id`) REFERENCES quiz_questions(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `user_quiz_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT 1,
  `question_offset` int(11) NOT NULL,
  `question_id` int(11),
  `answers` varchar(255),
  `time_left` int(11),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `student_quiz_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `quiz_id`int(11) DEFAULT 1,
  `question_id` int(11),
  `answers_selected` varchar(255),
  `correct` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `quiz_result_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT 1,
  `feedback` TEXT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


DROP VIEW IF EXISTS students_result_view;


CREATE VIEW students_result_view 
AS
Select 
    qz.name as difficulty,
    q.name as quiz_name,
    qz.id as quiz_id,
   	res.student,
    res.user_id,
    res.grade_percentage,
    IFNULL(fb.number_of_feedbacks , 0 ) AS number_of_feedbacks,
     CASE 
        	WHEN res.grade_percentage >= 90 THEN 'A'
            WHEN res.grade_percentage < 90 AND res.grade_percentage >= 75 THEN 'B'
            WHEN res.grade_percentage < 75 AND res.grade_percentage >= 50 THEN 'C'
            WHEN res.grade_percentage < 50 AND res.grade_percentage>= 30 THEN 'D'
            WHEN res.grade_percentage< 30 AND res.grade_percentage >= 15 THEN 'E'
        ELSE 'F'
      END AS grade,
     CASE 
        	WHEN res.grade_percentage >= 50  THEN 'Passed'
          ELSE 'Failed'
      END AS result
FROM quizzes qz
JOIN quiz q on qz.name = q.difficulty
JOIN (
  SELECT
       (((q.total_question-q.wrong_aswers) / q.total_question) * 100 ) AS grade_percentage,
      	q.total_question,
        q.wrong_aswers,
        q.quiz_id, 
        q.user_id,
       q.student 
FROM (
  SELECT 
	DISTINCT
        the_count.total_question,
        the_res.quiz_id, 
        the_res.user_id,
        IFNULL(the_wrongs.wrong_answers, 0) as wrong_aswers,
 	    concat(u.first_name, ' ', u.last_name) as student 
  FROM `student_quiz_results`  the_res 
  JOIN users u on u.id = the_res.user_id
  JOIN (
      SELECT 
        COUNT(*) AS total_question,
          quiz_id, 
          user_id 
      FROM student_quiz_results
        GROUP BY quiz_id, user_id
    ) the_count on the_count.quiz_id = the_res.quiz_id and the_count.user_id = the_res.user_id
  LEFT JOIN
    ( SELECT 
        * 
      FROM (
        SELECT 
                CASE WHEN correct = false  THEN COUNT(1) ELSE 0  END wrong_answers,
              quiz_id, 
              user_id 
          FROM student_quiz_results 
            GROUP BY correct, quiz_id, user_id 
            )qqq 
        where wrong_answers > 0 
    ) the_wrongs  on the_wrongs.quiz_id = the_res.quiz_id and the_wrongs.user_id = the_res.user_id ) 
  q ) res on res.quiz_id = q.id
LEFT JOIN (
  select 
    count(1) as number_of_feedbacks,
    user_id,
    quiz_id
  FROM quiz_result_feedback
  GROUP BY 2, 3
) fb  on fb.quiz_id = q.id and fb.user_id = res.user_id
