<?php
include("config/cohort_interns_connet.php");

if (isset($_POST["delete"])) {
    $id_to_delete = mysqli_real_escape_string($connect, $_POST["id_to_delete"]);

    $sqlQueries = "DELETE FROM cohort_delicacy WHERE id = $id_to_delete";

    if (mysqli_query($connect, $sqlQueries)) {
        header('Location: index.php');
    } else {
        echo 'Query Error: ' . mysqli_error($connect);
    }
}

//check get request id param
if (isset($_GET['id'])) {
    //escape sql characters
    $id = mysqli_real_escape_string($connect, $_GET['id']);

    //make sql
    $sqlQueries = "SELECT * FROM cohort_delicacy WHERE id = $id";

    //get the query result
    $sqlResult = mysqli_query($connect, $sqlQueries);

    //fetch the result in array format
    $cohortDelicacies = mysqli_fetch_assoc(result: $sqlResult);

    //free the memory
    mysqli_free_result($sqlResult);


    //close the connection
    mysqli_close($connect);
}
?>


<!DOCTYPE html>
<html>


<?php include("templates/header.php"); ?>

<div class="cointainer text-center my-5">
    <?php
    if (isset($cohortDelicacies)) {
        if ($cohortDelicacies) {
            // if delecacies exists
    ?>
            <h4><?php echo $cohortDelicacies['title']; ?></h4>
            <div class="row mb-4">
                <h5 class="text-secondary">
                    Created by <span class="fw-bold"><?php echo $cohortDelicacies['email']; ?></span>
                </h5>
            </div>

            <p>
                Created at <span class="fw-bold"> <?php echo date($cohortDelicacies['created_at']); ?>
                </span>
            </p>

            <div class="row mb-4">
                <div class="col">
                    <h5 class="text-secondary">
                        Ingredients
                    </h5>
                </div>
            </div>

            <p><?php echo $cohortDelicacies['ingredients'] ?>; </p>


            <!-- Deletion -->
            <form action="details.php" method="POST" onsubmit="return confirmDelete()">
                <input type="hidden" name="id_to_delete" value="<?php echo $cohortDelicacies['id']; ?>" />
                <input type="submit" name="delete" value="Delete" class="btn btn-danger" />
                <input type="hidden" name="id_to_edit" value="<?php echo $cohortDelicacies['id']; ?>" />
                <!-- <button type="edit" name="edit" value="edit" class="btn btn-success">
                    <a href="edit.php">EDIT</a></button> -->
            </form>
            <a href="edit.php?id=<?php echo $cohortDelicacies['id']; ?>" method="POST" name="id_to_update" class="edit_btn btn btn-primary" value="">Edit</a>
        <?php

        } else {
            //if delicacies does not exist
        ?>
            <div class="alert alert-warning" role="alert">
                <i class="bi 🔺m-2"></i>
                No such Delicacy exists
            </div>
        <?php
        }
    } else {
        //if no id is provided

        ?>
        <div class="alert alert-warning" role="alert">
            <i class="bi 🔺m-2"></i>
            No Delicacy ID provided
        </div>
    <?php
    }
    ?>
</div>

<!--Add a JS confirm dialog  -->
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this delicacy? This action cannot be undone!.")
    }
</script>


<?php include("templates/footer.php"); ?>

</html>