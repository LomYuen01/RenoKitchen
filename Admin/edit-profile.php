<?php include('Partials/menu.php'); ?>
<script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
    <section class="home">
        <div class="title">
            <div class="text">Edit Profile</div>

            <?php
                if (isset($_GET['id'])) 
                {
                    $id = $_GET['id'];
                }

                if (isset($_GET['address_id'])) 
                {
                    $address_id = $_GET['address_id'];
                }

                if(isset($_GET['id'])) {
                    // Get the id of selected admin
                    $id = $_GET['id'];

                    // Create the Sql Query to Get the details
                    $sql = "SELECT a.*, ad.address, ad.postal_code, ad.city, ad.state, ad.country 
                            FROM tbl_admin a 
                            JOIN tbl_address ad ON a.address_id = ad.id 
                            WHERE a.id=$id";

                    // Execute the Query
                    $res = mysqli_query($conn, $sql);

                    if($res==TRUE) {
                        // Check whether the data is available or not
                        $count = mysqli_num_rows($res);

                        if($count==1) {
                            // Get the Details
                            $row = mysqli_fetch_assoc($res);

                            $full_name = $row['full_name'];
                            $username = $row['username'];
                            $password = $row['password'];
                            $current_image = $row['image_name'];
                            $IC = $row['IC'];
                            $ph_no = $row['ph_no'];
                            $email = $row['email'];
                            $position = $row['position'];
                            $status = $row['status'];

                            $address = $row['address'];
                            $postal_code = $row['postal_code'];
                            $city = $row['city'];
                            $state = $row['state'];
                            $country = $row['country'];
                        }
                        else
                        {
                            // Redirect to Manage Admin Page with Message
                            echo "<script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Admin Information Not Found.',
                                    icon: 'error'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '".SITEURL."admin/index.php';
                                    }
                                });
                            </script>";
                        }
                    }
                }
                else
                {
                    // Redirect to Manage Admin Page
                    header('location:'.SITEURL.'admin/index.php');
                }
            ?>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container" style="overflow: visible;">
            <!-- =================================================== Form Section =================================================== -->
                <form action="" method="POST" enctype="multipart/form-data" style="background: none; box-shadow: none;">
                    <section class="profile-container">
                        <div class="profile-img">
                            <?php
                                if($current_image != "")
                                {
                                    // Display the Image
                                    $borderColor = $status == 'active' ? '#ff4757' : '#2ed573';
                                    echo "<img src='".SITEURL."images/Profile/".$current_image."' id='profileImage' style='border-color: $borderColor; border-width: 2.5px; border-style: solid;'>";
                                }
                                else
                                {
                                    // Display the default image
                                    echo "<img src='../images/no_profile_pic.png' id='profileImage'>";
                                }
                            ?>
                            <div class="icon-border">
                                <i class='bx bx-camera icon' title="Choose an Image" id="image_icon"></i>
                                <input type="file" id="fileInput" name="image" style="display: none;">
                            </div>
                        </div>
                        <div class="user-details">
                            <span class="details"><?php echo $full_name; ?> [<?php echo $position; ?>]</span>
                            <span class="light-color"><?php echo $username ?></span>
                        </div>
                    </section>
                    
                    <section class="profile-form" data-title="Profile Details">
                        <div class="profile-details">
                            <!-- Personal Details -->
                            <span class="title-name">Personal Information</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Full Name</span>
                                    <input type="text" name="full_name" value="<?php echo $full_name; ?>" placeholder=" Full Name" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Username</span>
                                    <input type="text" name="username" value="<?php echo $username; ?>" placeholder=" Username" required>
                                </div>

                                <div class="input-box password">
                                    <span class="details">Password</span>
                                    <div class="password-container">
                                        <input type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder=" Password" required>
                                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                                    </div>
                                </div>

                                <div class="input-box">
                                    <span class="details">IC</span>
                                    <input type="text" name="IC" value="<?php echo $IC; ?>" placeholder=" IC" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input type="text" name="email" value="<?php echo $email; ?>" placeholder=" Email" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Ph No.</span>
                                    <input type="text" name="ph_no" value="<?php echo $ph_no; ?>" placeholder=" Phone Number" required>
                                </div>
                            </div>

                            <!-- Address -->
                            <span class="title-name">Address Details</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Address</span>
                                    <input type="text" name="address" value="<?php echo $address; ?>" placeholder=" Floor/Unit, Street" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Postal Code</span>
                                    <input type="text" name="postal_code" value="<?php echo $postal_code; ?>" placeholder=" Postal Code" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">City</span>
                                    <input type="text" name="city" value="<?php echo $city; ?>" placeholder=" City" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">State</span>
                                    <input type="text" name="state" value="<?php echo $state; ?>" placeholder=" State" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Country</span>
                                    <input type="text" name="country" value="<?php echo $country; ?>" placeholder=" Country" required>
                                </div>
                            </div>

                            <div class="button">
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                                <input type="hidden" name="address_id" value="<?php echo $address_id; ?>">
                                <input type="submit" name="submit" value="Update Profile" class="btn-secondary">
                            </div>
                        </div>
                    </section>
                </form>
            <!-- =================================================== Form Section =================================================== -->
        </div>
    </section>
    <script>
        const fileInput = document.getElementById('fileInput');
        const errorMessage = document.getElementById('errorMessage');
        const icon = document.getElementById('image_icon');

        icon.addEventListener('click', () => {
        fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            const image = new Image();

            image.onload = function() {
                if (this.width !== this.height) {
                    Swal.fire('Error!', 'Please upload an image with equal width and height.', 'error');
                } else {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('profileImage').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            };

            image.src = URL.createObjectURL(file);
        });
    </script>
    <script src="../Style/show-hide.js"></script>
<?php include('Partials/footer.php'); ?>

<?php
    if(isset($_POST['submit']))
    {
        // Get the data from Form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);  // Password Encryption with MD5
        $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
        $IC = mysqli_real_escape_string($conn, $_POST['IC']);
        $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // Get the address details from Form
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);

        // Get the IDs of the records to update
        $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
        $address_id = mysqli_real_escape_string($conn, $_POST['address_id']);

        // 2. Upload the Image if selected
        // Check whether the select image is clicked or not and upload the image only if the image is selected
        if(isset($_FILES['image']['name']))
        {
            // Get the details of the selected image
            $image_name = $_FILES['image']['name'];

            // Check whether the image is selected or not and upload image only if selected
            if($image_name != "")
            {
                // Image is selected
                // A. Rename the image

                // ---------- If image exist, it will add a suffix to the image name ---------- //
                        
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    $base_name = basename($image_name, ".".$ext);
                
                    // Start with no suffix
                    $suffix = '';
                    $index = 1;
                
                    // While a file with the current name exists, increment the suffix
                    while(file_exists("../images/Profile/" . $base_name . $suffix . '.' . $ext)) 
                    {
                        $suffix = '(' . $index++ . ')';
                    }
            
                    // Set the image name to the base name plus the suffix
                    $image_name = $base_name . $suffix . '.' . $ext;

                // ---------------------------------------------------------------------------- //

                $source_path = $_FILES['image']['tmp_name'];  

                $destination_path = "../images/Profile/".$image_name;

                // B. Upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                // Check whether the image is uploaded or not
                // If its not, we will stop the process and redirect with error message
                if($upload == FALSE)
                {
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to Upload Image.',
                            icon: 'error'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '".SITEURL."admin/index.php';
                            }
                        });
                    </script>";
                    die(); // Stop the Process
                }

                // Remove the current image if it exists
                if($current_image != "")
                {
                    $remove_path = "../images/Profile/".$current_image;
                    $remove = unlink($remove_path);

                    // Check whether the image is removed or not
                    // If failed to remove, display message and stop the process
                    if($remove==FALSE)
                    {
                        echo "<script>
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to remove current Image.',
                                icon: 'error'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '".SITEURL."admin/index.php';
                                }
                            });
                        </script>";
                        die(); // Stop the Process
                    }
                }
            }
            else
            {
                $image_name = $current_image;
            }
        }
        else
        {
            $current_image = $current_image;  // Default Value
        }

        // SQL Query to update the address details in tbl_address
        $sql_address = "UPDATE tbl_address SET
            address = '$address',
            postal_code = '$postal_code',
            city = '$city',
            state = '$state',
            country = '$country'
            WHERE id = $address_id
        ";

        // Executing Query and Updating Data in tbl_address
        $res_address = mysqli_query($conn, $sql_address) or die(mysqli_error());

        // Check whether the (Query is executed) data is updated or not
        if($res_address==TRUE)
        {
            // Data Updated
            // SQL Query to update the admin details in tbl_admin
            $sql_admin = "UPDATE tbl_admin SET
                full_name = '$full_name',
                username = '$username',
                password = '$password',
                IC = '$IC',
                ph_no = '$ph_no',
                email = '$email',
                address_id = '$address_id',
                image_name = '$image_name'
                WHERE id = $id
            ";

            // Executing Query and Updating Data in tbl_admin
            $res_admin = mysqli_query($conn, $sql_admin) or die(mysqli_error());

            // Check whether the (Query is executed) data is updated or not and display appropriate message
            if($res_admin==TRUE)
            {
                // Data Updated
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Admin Updated Successfully.',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."admin/index.php';
                        }
                    });
                </script>";
            }
            else
            {
                // Failed to Update Data
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to Update Admin. Try Again Later.',
                        icon: 'error'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '".SITEURL."admin/index.php';
                        }
                    });
                </script>";
            }
        }
        else
        {
            // Failed to Update Address
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to Update Address. Try Again Later.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".SITEURL."admin/index.php';
                    }
                });
            </script>";
        }
    }
?>