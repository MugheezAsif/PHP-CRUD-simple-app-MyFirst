<?php include 'inc/navbar.php'; ?>

<?php 
    session_start();
    $id = $_SESSION['employee_id'];
    $sql = "SELECT * FROM employee WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $employee = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $name = $email = $title = $salary = '';
    $nameErr = $emailErr = $titleErr = $salaryErr = '';

    if (isset($_POST['submit'])) {
        // Validating inputs
        if(empty($_POST['name'])) {
            $nameErr = 'Provide a name';
        } else {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        if(empty($_POST['email'])) {
            $emailErr = 'Provide an Email';
        } else {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        }
        if(empty($_POST['title'])) {
            $titleErr = 'Provide a Title';
        } else {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        if(empty($_POST['salary'])) {
            $salaryErr = 'Provide a Salary';
        } else {
            $salary = filter_input(INPUT_POST, 'salary', FILTER_SANITIZE_NUMBER_INT);
        }
        // Entring record in database
        if (empty($nameErr) && empty($emailErr) && empty($titleErr) && empty($salaryErr)) {
            $sql = "UPDATE employee SET name='$name', email='$email', title='$title', salary='$salary' WHERE id='$id'";
            if (mysqli_query($conn, $sql)) {
                header('Location: view.php');
                unset($_SESSION['employee_id']);
            }
        }
        
    }

?>

<div class="container m-4 my-5">
    <h1 class="my-4">Update Employee Record</h1>
    <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
        
        <div class="row mb-4">
            <div class="col">
            <div class="form-outline">
                <label class="form-label" for="form6Example1">Name</label>
                <input value="<?php echo $employee[0]['name'] ?>" type="text" name="name" id="form6Example1" class="form-control <?php echo $nameErr ? 'is-invalid' : null; ?>" maxlength="20" />
                <div class="invalid-feedback">
                    <?php echo $nameErr; ?>
                </div>
            </div>
            </div>
            <div class="col">
            <div class="form-outline">
                <label class="form-label" for="form6Example2">Email</label>
                <input value="<?php echo $employee[0]['email'] ?>" type="text" name="email" id="form6Example2" class="form-control <?php echo $emailErr ? 'is-invalid' : null; ?>" maxlength="25"/>
                <div class="invalid-feedback">
                    <?php echo $emailErr; ?>
                </div>
            </div>
            </div>
        </div>
        <div class="form-outline mb-4">
            <label class="form-label" for="form6Example3">Title</label>
            <input value="<?php echo $employee[0]['title'] ?>" type="text" name="title" id="form6Example3" class="form-control <?php echo $titleErr ? 'is-invalid' : null; ?>" maxlength="25"/>
            <div class="invalid-feedback">
                <?php echo $titleErr; ?>
            </div>
        </div>
        <div class="form-outline mb-4">
            <label class="form-label" for="form6Example4">Salary</label>
            <input value="<?php echo $employee[0]['salary'] ?>" type="text" name="salary" id="form6Example4" class="form-control <?php echo $salaryErr ? 'is-invalid' : null; ?>" />
            <div class="invalid-feedback">
                <?php echo $salaryErr; ?>
            </div>
        </div>

        <input type="submit" name="submit" value="Create" class="btn btn-dark w-100">
    </form>
</div>

<?php include 'inc/footer.php'; ?>
