<?php
include("config/cohort_interns_connet.php");

if (isset($_POST["update"])) {
    
    $id =  $_POST['id'];
    $title =  $_POST['title'];
    $ingredients =  $_POST['ingredients'];
    $email = $_POST['email'];

    // Update query
    $sqlQueries = "UPDATE cohort_delicacy 
                   SET title = '$title', ingredients = '$ingredients', email = '$email'
                   WHERE id = $id";

    if (mysqli_query($connect, $sqlQueries)) {
        header('Location: index.php');
    
    } else {
        echo 'Query Error: ' . mysqli_error($connect);
    }

    // Close connection
    mysqli_close($connect);
}

if (isset($_GET['id'])) {
    // Escape SQL characters
    $id = mysqli_real_escape_string($connect, $_GET['id']);

    // Fetch record by ID
    $sqlQueries = "SELECT * FROM cohort_delicacy WHERE id = $id";

    $result = mysqli_query($connect, $sqlQueries);
    if ($result) {
        $delicacies = mysqli_fetch_assoc($result);
        if ($delicacies) {
            $email = $delicacies['email'];
            $title = $delicacies['title'];
            $ingredients = $delicacies['ingredients'];
        } else {
          echo 'Query Error: ' . mysqli_error($connect);
        }
    } else {
        echo 'Query Error: ' . mysqli_error($connect);
    }

    // Close connection
    mysqli_close($connect);
}

?>

<!DOCTYPE html>
<html>
<?php include("templates/header.php"); ?>

<section class="container py-5">
    <h4 class="text-secondary text-center mb-4">
        Edit Cohort Delicacy
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <!-- Hidden ID Field -->
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                value="<?php echo htmlspecialchars($email); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Delicacy Title</label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                class="form-control"
                                value="<?php echo htmlspecialchars($title); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="ingredients" class="form-label">Delicacy Ingredients</label>
                            <input
                                type="text"
                                id="ingredients"
                                name="ingredients"
                                class="form-control"
                                value="<?php echo htmlspecialchars($ingredients); ?>">
                        </div>

                        <div class="text-center">
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("templates/footer.php"); ?>
</html>
