<?php include 'inc/navbar.php'; ?>
<?php
    $sql = "SELECT * FROM employee";
    $result = mysqli_query($conn, $sql);
    $employee = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $id = '';
    if(isset($_POST['submit_for_delete'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (!empty($id)) {
            $sql = "DELETE FROM employee WHERE id='$id'";
            if (mysqli_query($conn, $sql)) {
                header('Location: view.php');
            } else {
                echo 'Could not be deleted';
            }
        }
    } elseif(isset($_POST['submit_for_update'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (!empty($id)) {
            session_start();
            $_SESSION['employee_id'] = $id;
            header('Location: update.php');
        }
    }
?>



<div class="container m-4 my-5">
    <h1 class="my-3">View and Delete Employees</h1>
    <?php if(empty($employee)) : ?>
        <p>No record yet</p>
    <?php else : ?>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Title</th>
                <th scope="col">Salary</th>
                <th scope="col">Destroy</th>
                <th scope="col">Update</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($employee as $item) : ?>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <tr>
                            <th scope="row"><?php echo $item['id']; ?></th>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['email']; ?></td>
                            <td><?php echo $item['title']; ?></td>
                            <td><?php echo $item['salary']; ?></td>
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <td> <input class="btn btn-outline-danger btn-sm" type="submit" value="delete" name="submit_for_delete"> </td>
                            <td> <input class="btn btn-outline-primary btn-sm" type="submit" value="update" name="submit_for_update"> </td>
                        </tr>
                    </form>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>



<?php
    include 'inc/footer.php';
?>
