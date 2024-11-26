<?php
include("config/cohort_interns_connet.php");
// write queries for all delicacies
$sqlQueries = 'SELECT title, ingredients, id FROM cohort_delicacy ORDER BY created_at';

// get the result set
$sqlResult = mysqli_query($connect, $sqlQueries);

// fetch the resulting rows as an array
$delicacies = mysqli_fetch_all($sqlResult, MYSQLI_ASSOC);

// free the result from memory
mysqli_free_result($sqlResult);

// close connection
mysqli_close($connect);
?>

 

<!DOCTYPE html>
<html lang="en">
<?php
include("templates/header.php");
?>

<h4 class="text-center text-secondary mb-4">Delicacies</h4>

<div class="container my-5">
    <div class="row g-4">
        <?php
        foreach($delicacies as $delicacy):
        ?>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 mb-4">
                    <img src="./assets/foodimage.jpg" alt="logo" class="deliccacy">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <?php echo htmlspecialchars($delicacy['title']) ?>
                        </h6>
                        <ul class="list-unstyled text-secondary">
                            <?php foreach(explode(',' ,$delicacy ['ingredients']) as $ingredient): ?>
                                    <li> <?php echo htmlspecialchars($ingredient) ?> </li>
                                    <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <a href="details.php?id=<?php echo $delicacy['id'] ?>" class="btn-primary text-decoration-none">
                            more info...
                        </a>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>
    </div>
</div>


<?php
include("templates/footer.php");
?>

</html>