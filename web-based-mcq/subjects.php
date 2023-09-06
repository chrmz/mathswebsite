<?php
$pageName = "subjects"; //CREATES page name shown on tab
$requireAuthentication = true; //ALLOWS user and admin access rights
include_once './includes/head.php';
if (!isAdmin()) {
    header('location: not_allowed.php'); //ALLOWS ONLY admin to access page
    exit;
}
$module = null;

if (isset($_POST['delete-subject'])) {
    $subjectId = $_POST['subject-id'];
    deleteSubject($subjectId);
}

if (isset($_GET['moduleId'])) {
    $module = getModule($_GET['moduleId']);
} //SETS module id when selecting a module via url


?>
<section>
    <div class="container">
        <?php if (is_null($module)): ?>
            <h1> The module you're trying view it's subjects does not exist! </h1>
        <?php else: ?>
            <h1>
                <?= $module['name'] ?>
            </h1>

            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Lesson document</th>
                        <th>Delete </th>
                    </tr>
                </thead>

                <!--<CREATES TABLE FOR SUBJECTS WITH PDF FILE + DELETE FUNCTION>-->
                <tbody>
                    <?php foreach ($module['subjects'] as $key => $subject): ?>
                        <tr>
                            <td>
                                <?= $subject['name'] ?>
                            </td> <!--<Name of created subject>-->
                            <td> <a href="documents/<?= $subject['document'] ?>" target="_blank"><?= $subject['document'] ?></a>
                            </td> <!--<PDF of created subject>-->
                            <td><button onclick="removeSubject('<?= $subject['name'] ?>','<?= $subject['id'] ?>')"
                                    class="modal-toggle">Remove Subject</button></td> <!--<Remove Subject button>-->
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>


            <div>
                <div id="modal" class="modal-content">
                    <div class="modal-header">
                        <span class="modal-close">&times;</span>
                        <h2>Modal Header</h2>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span id="subject-name"></span>?</p>
                        <!--SPAN/CALLS name of subject after sentence-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-close">Cancel</button>
                        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?moduleId=' . $_GET['moduleId'] ?>">
                            <input id="subject-id" name="subject-id" type="hidden" value="">
                            <button type="submit" name="delete-subject">Remove Subject</button>
                        </form>
                    </div>
                </div>
            </div>

        <?php endif ?>
    </div>
    <section>
        <?php
        include_once './includes/footer.php'
            ?>