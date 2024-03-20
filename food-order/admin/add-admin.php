<?php include('partials/menu.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>Add Admin</h1>
</br></br>

<?php
if(isset($_SESSION['add']))//checking whether the session is set or not
{
  echo $_SESSION['add'];//display session message is set
  unset($_SESSION['add']);//remove session message
}
?>
    <form action="" method="post">
      <table class="tbl-30">
        <tr>
          <td>Full Name</td>
          <td>
            <input type="text" name="full_name" placeholder="enter your name"></td>
        </tr>

        <tr>
          <td>Username</td>
          <td>
            <input type="text" name="username" placeholder=" your username"></td>
        </tr>

        <tr>
          <td>Password</td>
          <td><input type="password" name="password" placeholder=" your password"></td>
        </tr>

        <tr>
          <td colspan="2">
            <input type="submit" name="submit" value="add admin" class="btn-secondary">
</td>
</tr>
      </table>
    </form>
  </div>
</div>
<?php include('partials/footer.php'); ?>
<?php
  //process the value form and save it in database
  //check whether the button is clicked or not
  if(isset($_POST['submit']))
  {
    //button clicked
    //echo"button clicked";

    //1.Get the data from form
    $full_name=$_POST['full_name'];
    $username=$_POST['username'];
    $password= md5($_POST['password']);//Password encription with md5

    //2.sql query to save the data into database
    $sql="INSERT INTO tbl_admin SET
    full_name='$full_name',
    username='$username',
    password='$password'
    ";

    //3.execute query and save data in database
   
    $res=mysqli_query($conn,$sql) or die(mysqli_error());

    //4.check whether the query is executed or not
    if($res==TRUE)
    {
      //echo"data inserted";
      //create a session variable to display a message
      $_SESSION['add'] = "<div class='success'>Admin added successfully</div>";
     //redirect page
      header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
      //echo"failed to insert data";
      //create a session variable to display a message
      $_SESSION['add']="<div class='error'>failed to add admin</div>";
     //redirect page
      header("location:".SITEURL.'admin/add-admin.php');
    
    }


  }
  
?>