<?php include('Partials/menu.php'); ?>

    <section class="home">
        <div class="title">
            <div class="text">Add Category</div>

            <?php
                if(isset($_SESSION['add']))  // Checking whether the session is set or not
                {
                    echo "<br />" . nl2br($_SESSION['add']);
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['upload']))  // Checking whether the session is set or not
                {
                    echo "<br />" . nl2br($_SESSION['upload']);
                    unset($_SESSION['upload']);
                }
            ?>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container">
            <!-- =================================================== Header Section =================================================== -->
            <section class="table-form">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="user-details">
                        <div class="half-width">
                            <div class="input-box">
                                <span class="details">Category Name</span>
                                <input type="text" name="title" placeholder="Category Name" required>
                            </div>

                            <div class="input-box"></div>

                            <div class="input-box">
                                <span class="details">Image</span>
                                <input type="file" id="image" name="image">
                            </div>
                        </div>
                    </div>

                    <div class="radio">
                        <div class="FoodSize">
                            <span class="text">Food Size</span>
                            <div class="down">
                                <input type="radio" name="FoodSize" value="Yes"> Yes 
                                <input type="radio" name="FoodSize" value="No"> No
                            </div>
                        </div>

                        <div class="featured">
                            <span class="text">Featured</span>
                            <div class="down">
                                <input type="radio" name="featured" value="Yes"> Yes 
                                <input type="radio" name="featured" value="No"> No
                            </div>
                        </div>

                        <div class="active">
                            <span class="text">Active</span>
                            <div class="down">
                                <input type="radio" name="active" value="Yes"> Yes 
                                <input type="radio" name="active" value="No"> No
                            </div>
                        </div>
                    </div>
                    
                    <div class="button">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </div>
                </form>

            </section>
            <!-- =================================================== Header Section =================================================== -->
        </div>
    </section>
<?php include('Partials/footer.php'); ?>

<?php
// Process the value from Form and save it in Database
// Check whether the submit button is clicked or not

if(isset($_POST['submit']))
{
    // echo "Clicked";
    // 1. Get the value from Category Form
    $title = $_POST['title'];
    
    // For radio input, we need to check whether the button is selected or not
    if(isset($_POST['FoodSize']))
    {
        // Get the value from Form
        $FoodSize = $_POST['FoodSize'];
    }
    else
    {
        // Set the Defult Value
        $FoodSize = "No";
    }

    if(isset($_POST['featured']))
    {
        // Get the value from Form
        $featured = $_POST['featured'];
    }
    else
    {
        // Set the Defult Value
        $featured = "No";
    }

    if(isset($_POST['active']))
    {
        // Get the value from Form
        $active = $_POST['active'];
    }
    else
    {
        // Set the Defult Value
        $active = "No";
    }

    // Check whether the image is selected or not and set the value for image name accrodingly
    if(isset($_FILES['image']['name']))
    {
        // To upload image we need image name, source path and destination path
        $image_name = $_FILES['image']['name'];

        // Upload the image only if image is selected
        if($image_name != "")
        {
            // ---------- If image exist, it will add a suffix to the image name ---------- //
            
                $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                $base_name = basename($image_name, ".".$ext);
            
                // Start with no suffix
                $suffix = '';
                $index = 1;
            
                // While a file with the current name exists, increment the suffix
                while(file_exists("../images/category/" . $base_name . $suffix . '.' . $ext)) 
                {
                    $suffix = '(' . $index++ . ')';
                }
        
                // Set the image name to the base name plus the suffix
                $image_name = $base_name . $suffix . '.' . $ext;

            // ---------------------------------------------------------------------------- //

            $source_path = $_FILES['image']['tmp_name'];  

            $destination_path = "../images/category/".$image_name;

            // Finally upload the image
            $upload = move_uploaded_file($source_path, $destination_path);

            // Check whether the image is uploaded or not
            // If its not, we will stop the process and redirect with error message
            if($upload == FALSE)
            {
                $_SESSION['upload'] = "<div class='error'> Failed to Upload Image. </div>";
                header('location:'.SITEURL.'admin/add-category.php');
                die(); // Stop the Process
            }
        }

    }
    else
    {
        // Don't Upload the image and set the image name value as blank
        $image_name = "";
    }

    // 2. Create SQL Query to Insert Category into Database
    $sql = "INSERT INTO tbl_category SET
        title = '$title',
        image_name = '$image_name',
        FoodSize = '$FoodSize',
        featured = '$featured',
        active = '$active'
    ";

    // 3. Execute the Query and Save in Database
    $res = mysqli_query($conn, $sql);

    // 4. Check whether the query is executed or not and data is added or not
    if($res == TRUE)
    {
        // Query Executed and Category Added
        $_SESSION['add'] = "<div class='success'> Category Added Successfully. </div>";

        // Redirect to Manage Category Page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        // Failed to Add Category
        $_SESSION['add'] = "<div class='error'> Failed to Add Category. </div>";

        // Redirect to Add Category Page
        header('location:'.SITEURL.'admin/add-category.php');
    }
}

?>