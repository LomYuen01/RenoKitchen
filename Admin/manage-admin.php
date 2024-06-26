<?php include('Partials/menu.php'); ?>

    <section class="home">
        <div class="title">
            <div class="text">Manage Admin Details</div>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="table">
            <!-- =================================================== Header Section =================================================== -->
            <section class="table-header">
                <div class="dropdown-toggle-column">
                    <div class="icon-border">
                        <i class='bx bx-cog select-icon'></i>
                        <span class="tooltip">Toggle Column</span>
                    </div>
                    
                    <ul class="menu-column" style="width: 200px; font-size: 12px;">
                        <li>
                            <label><input type="checkbox" class="checkbox-column" data-column="1" checked/>&nbsp; No. &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="2" checked/>&nbsp; Full Name &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="3" checked/>&nbsp; Username &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="4" checked/>&nbsp; Ph No. &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="5" checked/>&nbsp; Email &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="6" checked/>&nbsp; Position &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="7" checked/>&nbsp; Status &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="8" checked/>&nbsp; Actions &nbsp; </label> <br>
                        </li>
                    </ul>
                </div>

                <div class="input-group" style="margin-left: 45px;">
                    <input type="search" placeholder="Search Data...">
                    <i class='bx bx-search'></i>
                </div>

                <span></span>
                <span></span>

                <div class="add-food">
                    <?php if ($position == 'Superadmin') { ?>
                        <label for="dropdown-nav-bar" class="add-btn">
                            <i class='bx bx-plus icon'></i>
                            <?php echo "<a href=\"".SITEURL."admin/add-admin.php\"><span class=\"icon-text\">Add Admin</span></a>" ?>
                        </label>
                    <?php } else {echo "<span></span>"; } ?>
                </div>
            </section>
            <!-- =================================================== Header Section =================================================== -->

            <!-- ==================================================== Body Section ==================================================== -->
            <section class="table-body"style="height: 100%; box-shadow: -5px 0px 15px 2px rgba(0, 0, 0, 0.1);">
                <table>
                    <thead>
                        <tr>
                            <th><span class="text">No. <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></span></th>
                            <th> Full Name <span class="icon-arrow"></span></th>
                            <th> Username <span class="icon-arrow"></span></th>
                            <th> Ph No. <span class="icon-arrow"></span></th>
                            <th> Email <span class="icon-arrow"></span></th>
                            <th> Position <span class="icon-arrow"></th>
                            <th> Status <span class="icon-arrow"></th>
                            <?php if ($position == 'Superadmin') { ?>
                                <th style="padding-right: 4rem;"> Actions <span class="icon-arrow"></span></th>
                            <?php } echo "<th></th>"; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // Query to Get All Admin
                            $sql = "SELECT * FROM tbl_admin";

                            // Execute the Query
                            $res = mysqli_query($conn, $sql);

                            // Check whether the query is executed or not
                            if($res==TRUE)
                            {
                                // Count rows to check if we have data in database or not
                                $count = mysqli_num_rows($res);

                                $SN = 1;

                                // Check the num of rows
                                if($count > 0)
                                {
                                    // We have data in database
                                    while($rows = mysqli_fetch_assoc($res))
                                    {
                                        // Using while loop to get all the data from the database & will run as long as there is data in database
                                        $id = $rows['id'];
                                        $full_name = $rows['full_name'];
                                        $username = $rows['username'];
                                        $ph_no = $rows['ph_no'];
                                        $email = $rows['email'];
                                        $position = $rows['position'];
                                        $status = $rows['status'];
                                        $address_id = $rows['address_id'];

                                        // Display the values in the table
                                        ?>
                                        <tr>
                                            <td><?php echo str_pad($SN++, 2, '0', STR_PAD_LEFT); ?></td>
                                            <td> <?php echo $full_name; ?> </td>
                                            <td> <?php echo $username; ?> </td>
                                            <td> <?php echo $ph_no; ?> </td>
                                            <td> <?php echo $email; ?> </td>
                                            <td> <?php echo $position; ?> </td>
                                            <td><div class="<?php echo strtolower($status); ?>_status"><?php echo $status; ?></div></td>
                                            <td class="buttons"  style="padding-right: 3rem;"> 
                                                <?php if (isset($_SESSION['admin']['position']) && $_SESSION['admin']['position'] == 'Superadmin') { ?>
                                                    <a href="<?php echo SITEURL; ?>admin/view-admin.php?id=<?php echo $id; ?>&address_id=<?php echo $address_id; ?>" style="width: 40px; font-size: 14px;" class="btn-primary" title="View details"><i class='bx bx-search-alt'></i></a>
                                                    <a href="<?php echo SITEURL; ?>Admin/update-admin.php?id=<?php echo $id; ?>&address_id=<?php echo $address_id; ?>" style="width: 40px; font-size: 14px;" class="btn-secondary" title="Update details"><i class='bx bxs-edit'></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                }
                                else
                                {
                                    // We do not have data
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </section>
            <!-- ==================================================== Body Section ==================================================== -->
        </div>
    </section>
    <script>
        document.querySelectorAll(".dropdown-toggle-column").forEach(dropdown => {
            const select = dropdown.querySelector(".select-icon");
            const menu = dropdown.querySelector(".menu-column");

            select.addEventListener("click", () => {
                menu.classList.toggle("menu-open-column");

                // Add or remove the 'flex' display property
                if (menu.style.display !== 'flex') {
                    menu.style.display = 'flex';
                    // Scroll to the bottom of the dropdown
                    menu.lastElementChild.scrollIntoView(true);
                } else {
                    menu.style.display = '';
                }
            });
        });

        // Function to update column visibility
        function updateColumnVisibility(column, checked) {
            document.querySelectorAll('tr > :nth-child(' + column + ')').forEach(function(cell) {
                if (checked) {
                    cell.classList.remove('hidden-column');
                } else {
                    cell.classList.add('hidden-column');
                }
            });
        }

        // Code for hiding and showing columns
        document.querySelectorAll('.checkbox-column').forEach(function(checkbox) {
            var column = checkbox.dataset.column;

            // Add the 'hidden-column' class to the cells in this column
            document.querySelectorAll('tr > :nth-child(' + column + ')').forEach(function(cell) {
                cell.classList.add('hidden-column');
            });

            // Get the page name
            var pageName = window.location.pathname.split("/").pop();

            // Load the saved state from localStorage
            var savedState = localStorage.getItem(pageName + '-checkbox-column-' + column);
            if (savedState !== null) {
                checkbox.checked = savedState === 'true';
            }

            // Update column visibility based on checkbox state
            updateColumnVisibility(column, checkbox.checked);

            checkbox.addEventListener('change', function() {
                var checked = this.checked;

                // Save the state to localStorage
                localStorage.setItem(pageName + '-checkbox-column-' + column, checked);

                // Update column visibility based on checkbox state
                updateColumnVisibility(column, checked);
            });
        });

        // Show the content once the state has been loaded
        document.body.style.display = '';
    </script>
<?php include('Partials/footer.php'); ?>