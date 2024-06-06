<?php 
    include('partials-front/menu.php'); 
    $user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : "";
?>
    <!-- Home -->
    <style>
        table, th, td {
            border: 1px solid grey;
            border-collapse: collapse;
            padding: auto;
        }

        .order_box{
            border: 1px solid black;
            position: relative;
            width: 80%;
            margin-top: -25px;
            padding-bottom: 15%;
            display: flex;
            gap: 20px;
        }

        .order_tab{
            display: contents;
        }


        .order_box > div >label{
            padding:0 20px;
            font-size: 1.6rem;
            text-transform: capitalize;
            color: rgb(134, 134, 134);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition:  color 0.3s;
        }

        .order_box> div > label::after{
            content: '';
            display: block;
            width: 60px;
            height: 8px;
            background-color: rgb(55, 55, 55);
            margin-top: 10px;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
            opacity: 0.2;
            transition: opacity 0.3s;
        }

        .order_content{
            width: 100%;
            height: 100%;
            border: 1px solid green; 
            position: absolute;
            top: 65px;
            background-color: rgb(255, 243, 209);
            opacity: 0;
            border: 10px solid rgb(55, 55, 55);
            box-sizing: border-box;
            
            justify-content: center;
            align-items: center;
            font-size: 4rem;
            transition: opacity 0.3s;
        }

        .order_input{
            display: none;
        }

        .order_input:checked + label + .order_content{
            opacity: 1;
        }

        .order_input:checked + label{
            color: rgb(55, 55, 55);
        }

        .order_input:checked + label::after{
            opacity: 1;
        }

        .detail{
            font-size: 1.1rem;
            padding: 10px;
        }

    </style>

    <section class="home">
        <!--====== Forms ======-->
        <div class="form-container">
            <i class="fa-solid fa-xmark form-close"></i>

            <!-- Login Form -->
            <div class="form login-form">
                <form action="<?php echo SITEURL; ?>login.php" method="POST">
                    <h2>Login</h2>

                    <div class="input-box">
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <i class="fa-solid fa-envelope email"></i>
                    </div>

                    <div class="input-box">
                        <input type="password" name="password" placeholder="Enter your password" required>
                        <i class="fa-solid fa-lock password"></i>
                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                    </div>

                    <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">

                    <div class="option-field">
                        <span class="checkbox">
                            <input type="checkbox" id="check">
                            <label for="check" style="margin-bottom: 0;">Remember me</label>
                        </span>
                        <a href="#" class="forgot-password">Forgot password?</a>
                    </div>

                    <button type="submit" name="submit" class="btn">Login Now</button>

                    <div class="login-singup">
                        Don't have an account? <a href="<?php echo SITEURL; ?>signup.php">Sign up</a>
                    </div>
                </form>
            </div>
        </div>
        <!--====== Forms ======-->

        <!--===== Content =====-->
        <div style="width: 90%; margin: auto; margin-top: 5%; margin-left:2%; display:inline-flex; ">
            <div class="order_box" style="border: 1px solid black; font-size: 1rem; width: 80%; height: 75vh; margin-left: 2%; background-color: #d9d9d9;" >
                <div class="order_tab">
                    <input type="radio" name="order" id="order_current" class="order_input" checked>
                    <label for="order_current">Order</label>
                    <div class="order_content"  style="padding-bottom: 10%; padding-top:10%;">
                        <div style="margin:auto; width:80%;">
                            <table class="order">
                                <tr>
                                    <th class="order-title">Order ID</th>
                                    <th class="order-title">Name</th>
                                    <th class="order-title">Address</th>
                                    <th class="order-title">Order Time</th>
                                    
                                    <th class="order-title">Order Status</th>
                                </tr>
                                <?php

                                $sql = "SELECT tbl_order.id as tbl_order_id, tbl_order.order_time, tbl_order.delivery_time, tbl_order.order_status, 
                                    tbl_order_address.id as tbl_order_address_id, tbl_order_address.firstname, tbl_order_address.address, tbl_order_address.city, tbl_order_address.state, 
                                    tbl_order_address.zip 
                                    FROM tbl_order 
                                    INNER JOIN tbl_order_address ON tbl_order.address_id = tbl_order_address.id 
                                    WHERE tbl_order.customer_id = '$user_id' AND tbl_order.order_status != 'Delivered'
                                    ORDER BY tbl_order.order_time DESC"; 

                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $tbl_order_id = $row['tbl_order_id'];
                                        $name = $row['firstname'];
                                        $address = $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ', ' . $row['zip'];
                                        $order_time = $row['order_time'];
                                        $order_status = empty($row['order_status']) ? 'Prepare' : $row['order_status'];
                                        $delivery_time = empty($row['delivery_time']) ? 'No delivery yet' : $row['delivery_time'];

                                        echo '<tr class="detail">';
                                        echo '<td class="detail">' . $tbl_order_id . '</td>';
                                        echo '<td class="detail">' . $name . '</td>';
                                        echo '<td class="detail">' . $address . '</td>'; 
                                        echo '<td class="detail">' . $order_time . '</td>';
                                        echo '<td class="detail">' . $order_status . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="order_tab">
                    <input type="radio" name="order" id="order_history" class="order_input">
                    <label for="order_history">Order History</label>
                    <div class="order_content" style="padding-bottom: 10%; padding-top:10%;">
                        <div style="margin:auto; width:80%;">
                            <table class="order">
                                <tr>
                                    <th class="order-title">Order ID</th>
                                    <th class="order-title">Name</th>
                                    <th class="order-title">Address</th>
                                    <th class="order-title">Order Time</th>
                                    <th class="order-title">Delivery Time</th>
                                    <th class="order-title">Order Status</th>
                                    <th class="order-title">Action</th>
                                </tr>
                                <?php
                                $user_id = 1; 

                                
                                $sql = "SELECT tbl_order.id as tbl_order_id, tbl_order.order_time, tbl_order.delivery_time, tbl_order.order_status, 
                                    tbl_order_address.id as tbl_order_address_id, tbl_order_address.firstname, tbl_order_address.address, tbl_order_address.city, tbl_order_address.state, 
                                    tbl_order_address.zip 
                                    FROM tbl_order 
                                    INNER JOIN tbl_order_address ON tbl_order.address_id = tbl_order_address.id 
                                    WHERE tbl_order.customer_id = '$user_id' AND tbl_order.order_status = 'Delivered'
                                    ORDER BY tbl_order.order_time DESC"; 
                                

                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $tbl_order_id = $row['tbl_order_id'];
                                        $name = $row['firstname'];
                                        $address = $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ', ' . $row['zip'];
                                        $order_time = $row['order_time'];
                                        $order_status = empty($row['order_status']) ? 'Prepare' : $row['order_status'];
                                        $delivery_time = empty($row['delivery_time']) ? 'No delivery yet' : $row['delivery_time'];

                                        echo '<tr>';
                                        echo '<td>' . $tbl_order_id . '</td>';
                                        echo '<td>' . $name . '</td>';
                                        echo '<td>' . $address . '</td>'; 
                                        echo '<td>' . $order_time . '</td>';
                                        echo '<td>' . $delivery_time . '</td>';
                                        echo '<td>' . $order_status . '</td>';
                                        echo '<td><a href="profile_invoice.php?order_id=' . $tbl_order_id . '"><button>Invoice</button></a></td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php include('partials-front/footer.php'); ?>
