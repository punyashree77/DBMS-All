<?php include('partials/menu.php'); ?>

  <div class="main-content">
    <div class="wrapper"> 
      <h1>Change Password</h1>
      <br><br>

        <?php
        if(isset($_GET['id']))
        {
          $id=$_GET['id'];
        }
        ?>

      <form action="" method="POST">

        <table class="tbl-30">
          <tr>
            <td> Current password:</td>
            <td>
              <input type="password" name="current_password" placeholder="Current password">
            </td>
          </tr>

          <tr>
            <td> New Password:</td>
            <td>
              <input type="password" name="new_password" placeholder="New password">
            </td>
          </tr>

          <tr>
            <td>Conform Password</td>
            <td>
              <input type="password" name="conform_password" placeholder="conform password">
            </td>
          </tr>

          <tr>
            <td colspan="2">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <input type="submit" name="submit" value="change password" class="btn-secondary" >
            </td>
          </tr>
        </table>
      </form>

  </div>
</div>


<?php
  //check whether the submit button is clicked or not
  if(isset($_POST['submit']))
  {
    //echo "clicked";

    //1.get the data from form
    $id=$_POST['id'];
    $current_password=md5($_POST['current_password']);
    $new_password=md5($_POST['new_password']);
    $conform_password=md5($_POST['conform_password']);
    //2.check the user with current id and current password exists or not
    $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password' ";

    //execute the query
    $res=mysqli_query($conn,$sql);

    if($res==true)
    {
      //check whether data is available or not
      $count=mysqli_num_rows($res);

      if($count==1)//only this is nedded when we dont need old password
      {
        //user exists and password can be changed
        // echo"user found";
        //check whether the new password and conform password match
        if($new_password==$conform_password)
        {
        //update the password
        //echo"pwd match";
        $sql2="UPDATE tbl_admin SET
        password='$new_password'
        WHERE id=$id
        ";

        //execute the query
        $res2=mysqli_query($conn,$sql2);

        //check whether the query executed or not
        if($res2==true)
        {
          //display success message
          $_SESSION['change-pwd']="<div class='success'>password changed successfully</div>";
          //redirect the user
          header('location:'.SITEURL.'admin/manage-admin.php');
     
        }
        else{
          //display error message
          $_SESSION['change-pwd']="<div class='error'>failed to change password </div>";
          //redirect the user
          header('location:'.SITEURL.'admin/manage-admin.php');
     
        }
       }
       else
       {
        //redirect to manage admin page
        $_SESSION['pwd-not-match']="<div class='error'>Password did not match</div>";
        //redirect the user
        header('location:'.SITEURL.'admin/manage-admin.php');
   
       }
      }
      else{
        //user does not exist set message and redirect
        $_SESSION['user-not-found']="<div class='error'>user not found</div>";
        //redirect the user
        header('location:'.SITEURL.'admin/manage-admin.php');
      }
    }
    //3.check whether the new password and confirm password match or not 

    //4.change password if all above is true
  }
?>
<?php include('partials/footer.php'); ?>