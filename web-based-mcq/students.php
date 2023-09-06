<?php 
$pageName = "students";
$requireAuthentication = true;
include_once './includes/head.php';
if(!isAdmin()) {
    header('location: not_allowed.php');
    exit;
}
$students =  getAllStudents();
?>

<section>
    <div class="container">
    <table class="styled-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Profile</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($students as $key => $student) : ?>
        <tr>
            <td><?=$student['first_name'].' '.$student['last_name']?></td>
            <td><?=$student['email']?></td>
            <td> <a href="student_profile.php?student_id=<?=$student['id']?>">see profile</a></td>
        </tr>
        <?php endforeach ?>
      
        
    </tbody>
</table>
    </div>


</section>
<?php 
    include_once './includes/footer.php'
?>