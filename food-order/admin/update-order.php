<?php include('partials/menu.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>Update Order</h1>
    </br></br></br>

    <?php
      if(isset($_GET['id']))
      {
        $id=$_GET['id'];

        $sql="SELECT * FROM tbl_order WHERE id=$id";

        $res=mysqli_query($conn,$sql);

        $count=mysqli_num_rows($res);

        if($count==1)
        {
          $row=mysqli_fetch_assoc($res);

          $food=$row['food'];
          $prize=$row['prize'];
          $quantity=$row['quantity'];
          $status=$row['status'];
          $customer_name=$row['customer_name'];
          $customer_contact=$row['customer_contact'];
          $customer_email=$row['customer_email'];
          $customer_address=$row['customer_address'];
        }
        else{
          header('location:'.SITEURL.'admin/manage-order.php');
        }
      }
      else{
        header('location:'.SITEURL.'admin/manage-order.php');
      }
    ?>
    <form action="" method="POST">
      <table class="tbl-30">
        <tr>
          <td>Food name</td>
          <td><b><?php echo $food; ?><b></td>
        </tr>

        <tr>
          <td>Price</td>
          <td><b><?php echo $prize; ?><b></td>
        </tr>

        <tr>
          <td>Qty</td>
          <td>
            <input type="number" name="quantity" value="<?php echo $quantity; ?>">
          </td>
        </tr>

        <tr>
          <td>Status</td>
          <td>
            <select name="status">
                <option <?php if($status=="ordered"){echo "selected";} ?>value="ordered">Ordered</option>
                <option <?php if($status=="on delivery"){echo "selected";} ?>value="on delivery">on delivery</option>
                <option <?php if($status=="delivered"){echo "selected";} ?> value="delivered">delivered</option>
                <option <?php if($status=="cancelled"){echo "selected";} ?> value="cancelled">cancelled</option>
              </select>
            </td>
        </tr>

        <tr>
          <td>Customer name:</td>
          <td>
            <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
          </td>
        </tr>

        <tr>
          <td>Customer contact:</td>
          <td>
            <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
          </td>
        </tr>

        <tr>
          <td>Customer email:</td>
          <td>
            <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
          </td>
        </tr>

        <tr>
          <td>Customer address:</td>
          <td>
            <textarea  name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="prize" value="<?php echo $prize; ?>">
            <input type="submit" name="submit" value="update order" class="btn-secondary">
          </td>
        </tr>
      </table>

    </form>

    <?php
      if(isset($_POST['submit']))
      {
        $id=$_POST['id'];
        $prize=$_POST['prize'];
        $quantity=$_POST['quantity'];
        $total=$prize*$quantity;
        $status=$_POST['status'];
        $customer_name=$_POST['customer_name'];
        $customer_contact=$_POST['customer_email'];
        $customer_email=$_POST['customer_email'];
        $customer_address=$_POST['customer_address'];

        $sql2="UPDATE tbl_order SET
          quantity=$quantity,
          total=$total,
          status='$status',
          customer_name='$customer_name',
          customer_contact='$customer_contact',
          customer_email='$customer_email',
          customer_address='$customer_address'
          WHERE id=$id
        
        ";

        $res2=mysqli_query($conn, $sql2);

        if($res2==true)
        {
          $_SESSION['update']="<div class='success'>Order updated successfully</div>";
          header('location:'.SITEURL.'admin/manage-order.php');
        }
        else
        {
          $_SESSION['update']="<div class='error'>Failed to update order</div>";
          header('location:'.SITEURL.'admin/manage-order.php');
        
        }
      }
    ?>
    
  </div>
</div>

<?php include('partials/footer.php'); ?>