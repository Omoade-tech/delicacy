<?php
include('config/cohort_interns_connet.php');

$email = $title = $ingredients = '';

$errors = ['email' => '', 'title' => '', 'ingredients' => '',];

if (isset($_POST['submit'])) {
    // check the email

    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required';
    } else {
        $email = $_POST['email'];

        if (!filter_var($email, filter: FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email must be valid email address";
        }
    }

    // check the title
    if (empty($_POST['title'])) {
        $errors['title'] = 'Title must be letters and spaces';
    } else {
        $title = $_POST['title'];

        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
            $errors['title'] = 'title must be a comma separated list!';
        }
    }


    // check the ingredients
    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] = 'At least one ingredients is required';
    } else {
        $ingredients = $_POST['ingredients'];

        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
            $errors['ingredients'] = 'ingredients must be a comma separated list!';
        }
    }

    if (array_filter($errors)) {
        // echo errors in the form
    } else {
        // escape sql charts
        $email = mysqli_real_escape_string($connect, $_POST['email']);
        $title = mysqli_real_escape_string($connect, $_POST['title']);
        $ingredients = mysqli_real_escape_string($connect, $_POST['ingredients']);

        // create sql queries

        $sqlQueries = "INSERT INTO cohort_delicacy(title, email, ingredients) VALUES ('$title', '$email', '$ingredients')";

        // save to database and check

        if (mysqli_query($connect, $sqlQueries)) {
            // success

            header("location: index.php");
        } else {
            echo 'Query Error: ' . mysqli_error($connect);
        }
    }
}
?>



<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<section class="container py-5">
    <h4 class="text-seondary text-center mb-4">
        Add Cohort Delicacies in the form below
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                value="<?php echo htmlspecialchars($email) ?>">
                            
                                <div class="text-danger">
                                <?php echo $errors['email'] ?>
                            </div>


                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">
                                Delicacy Title
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                class="form-control"
                                value="<?php echo htmlspecialchars($title) ?>">

                            <div class="text-danger">
                                <?php echo $errors['title'] ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="ingredients" class="form-label">
                                Delicacy ingredients
                            </label>

                            <input
                                type="text"
                                id="ingredients"
                                name="ingredients"
                                class="form-control"
                                value="<?php echo htmlspecialchars($ingredients) ?>">

                            <div class="text-danger">
                                <?php echo $errors['ingredients'] ?>
                            </div>
                        </div>

                        <div class="text-center">
                            <button name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>











<?php include('templates/footer.php'); ?>

</html>