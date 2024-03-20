<?php include('partials-front/menu.php'); ?>
<?php
    //check whether food id is set or not
    if(isset($_GET['food_id']))
    {
        $food_id=$_GET['food_id'];

        $sql=" SELECT * FROM tbl_food WHERE id=$food_id";

        $res = mysqli_query($conn, $sql);
        $count =mysqli_num_rows($res);

        if($count==1)
        {
            $row= mysqli_fetch_assoc($res);
            $title=$row['title'];
            $prize=$row['prize'];
            $image_name=$row['img_name'];

        }
        else
        {
            header('location:'.SITEURL);
        }
    }
    
?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php
                            //check whether the image is available or not
                            if($image_name=="")
                            {
                                echo "<div class='error'>Image not available</div>";
                            }
                            else{
                                ?>
                                    <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price"><?php echo $prize; ?></p>
                        <input type="hidden" name="prize" value="<?php echo $prize; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="quantity" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Yashapradha" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9380xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@yashu.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                //check whether submit button is clicked or not
                if(isset($_POST['submit']))
                {
                    //get all details from form
                    $food=$_POST['food'];
                    $prize=$_POST['prize'];
                    $quantity=$_POST['quantity'];

                    $total=$prize * $quantity;

                    $order_date=date("Y-m-d h:i:Sa");//order date

                    $status="ordered";

                    $customer_name=$_POST['full-name'];
                    $customer_contact=$_POST['contact'];
                    $customer_email=$_POST['email'];
                    $customer_address=$_POST['address'];

                    //save the order in database
                    $sql2="INSERT INTO tbl_order SET
                    food='$food',
                    prize=$prize,
                    quantity=$quantity,
                    total=$total,
                    order_date='$order_date',
                    status='$status',
                    customer_name='$customer_name',
                    customer_contact='$customer_contact',
                    customer_email='$customer_email',
                    customer_address='$customer_address'

                    ";
                    //execute the query
                    $res2= mysqli_query($conn, $sql2);

                    if($res2==true)
                    {
                        $_SESSION['order']="<div class='success text-center'>Food ordered successfully </div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        $_SESSION['order']="<div class='error text-center'>Failed to order food </div>";
                        header('location:'.SITEURL);
                    }
                }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>