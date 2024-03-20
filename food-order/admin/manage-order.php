<?php include('partials/menu.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>Manage Order</h1>
    </br></br></br>

    <?php
      if(isset($_SESSION['update']))
      {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
      }
    ?>
    </br></br>
        <table class="tbl-full">

          <tr>
            <th>S.N.</th>
            <th>Food</th>
            <th>prize</th>
            <th>Qty</th>
            <th>Total</th>
            <th>order date</th>
            <th>status</th>
            <th>customer name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>
          </tr>

          <?php
            //get all orders from database
            $sql="SELECT * FROM tbl_order ORDER BY id DESC";//displaying latest order at first
            //execute the query
            $res=mysqli_query($conn,$sql);
            $count =mysqli_num_rows($res);

            $sn=1;

            if($count>0)
            {
              while($row=mysqli_fetch_assoc($res))
              {
                $id=$row['id'];
                $food=$row['food'];
                $prize=$row['prize'];
                $quantity=$row['quantity'];
                $total=$row['total'];
                $order_date=$row['order_date'];
                $status=$row['status'];
                $customer_name=$row['customer_name'];
                $customer_contact=$row['customer_contact'];
                $customer_email=$row['customer_email'];
                $customer_address=$row['customer_address'];

                ?>

                  <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $food; ?></td>
                    <td><?php echo $prize; ?></td>
                    <td><?php echo $quantity; ?> </td>
                    <td> <?php echo $total; ?></td>
                    <td><?php echo $order_date; ?> </td>

                    <td> 
                      <?php 
                        if($status=="ordered")
                        {
                          echo "<label>$status</label>";
                        }
                        elseif($status=="on delivery")
                        {
                          echo "<label style='color:orange;'>$status</label>";
                        }
                        elseif($status=="delivered")
                        {
                          echo "<label style='color:green;'>$status</label>";
                        }
                        elseif($status=="cancelled")
                        {
                          echo "<label style='color:red;'>$status</label>";
                        }
                      ?>
                    </td>

                    <td><?php echo $customer_name; ?> </td>
                    <td><?php echo $customer_contact; ?> </td>
                    <td><?php echo $customer_email; ?> </td>
                    <td><?php echo $customer_address; ?> </td>
                    <td>
                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">update order</a>
              
                    </td>
                  </tr>

                <?php
              }
            }
            else{
              echo "<tr><td colspan='12' class='error'>Orders not available </td></tr>";
            }
          ?>

          
          
        </table>
  </div>
</div>

<?php include('partials/footer.php'); ?>