<?php
$requireAuthentication = true;
$pageName = "add_module";
include_once './includes/head.php';

$subjectName = '';
$errors = array();
$module = null;
if (isset($_GET['moduleId'])) {
    $module = getModule($_GET['moduleId']);

    if (isset($_POST['submit']) && isset($_FILES['document']['name']) && (!is_null($module))) {
        $subjectName = $_POST['name'];
        $errors = saveSubject($subjectName, $_GET['moduleId'], $_FILES['document']);
        if (sizeof($errors) == 0) {
            header('location: subjects.php?moduleId=' . $_GET['moduleId']);
        }
    }
}


if (!isAdmin()) {
    header('location: not_allowed.php');
    exit;
}


?>

<section>
    <?php if (is_null($module)): ?>
        <h1> The module you're trying to add the subject does not exist! </h1>
    <?php else: ?>
        <form method="post" class="modal-content form"
            action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?moduleId=' . $_GET['moduleId'] ?>"
            enctype="multipart/form-data">


            <div class="container">
                <?php foreach ($errors as $key => $error): ?>
                    <p style="color : #ff000">
                        <?= $error ?>
                    </p>
                <?php endforeach ?>

                <div class="form-group">
                    <label for="email">Subject name:</label>
                    <input type="text" placeholder="Subject name" name="name" value="<?= $subjectName ?>" required />
                </div>

                <div class="form-group">
                    <div class="upload-header">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                            <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#000000"
                                    d="M7 10V9C7 6.23858 9.23858 4 12 4C14.7614 4 17 6.23858 17 9V10C19.2091 10 21 11.7909 21 14C21 15.4806 20.1956 16.8084 19 17.5M7 10C4.79086 10 3 11.7909 3 14C3 15.4806 3.8044 16.8084 5 17.5M7 10C7.43285 10 7.84965 10.0688 8.24006 10.1959M12 12V21M12 12L15 15M12 12L9 15">
                                </path>
                            </g>
                        </svg>
                        <p id="result">Drag & drop to upload file!</p>
                    </div>
                    <label class="upload-footer" for="upload">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="#000000">
                            <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                            <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M15.331 6H8.5v20h15V14.154h-8.169z"></path>
                                <path d="M18.153 6h-.009v5.342H23.5v-.002z"></path>
                            </g>
                        </svg>
                        <p>Or click here to upload file</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                            <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path stroke-width="2" stroke="#000000"
                                    d="M5.16565 10.1534C5.07629 8.99181 5.99473 8 7.15975 8H16.8402C18.0053 8 18.9237 8.9918 18.8344 10.1534L18.142 19.1534C18.0619 20.1954 17.193 21 16.1479 21H7.85206C6.80699 21 5.93811 20.1954 5.85795 19.1534L5.16565 10.1534Z">
                                </path>
                                <path stroke-linecap="round" stroke-width="2" stroke="#000000" d="M19.5 5H4.5"></path>
                                <path stroke-width="2" stroke="#000000"
                                    d="M10 3C10 2.44772 10.4477 2 11 2H13C13.5523 2 14 2.44772 14 3V5H10V3Z"></path>
                            </g>
                        </svg>
                    </label>

                    <input id="upload" type="file" name="document" accept="application/pdf" required />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-submit" name="submit">Upload</button>
                </div>

            </div>
        </form>
    <?php endif ?>
</section>

<?php
include_once './includes/footer.php'
    ?>