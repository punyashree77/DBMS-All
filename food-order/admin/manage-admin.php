<?php include('partials/menu.php'); ?>

  <!--main section starts-->
  <div class="main-content">
    <div class="wrapper"> 
      <h1>Manage Admin</h1>
      </br>
      <?php
        if(isset($_SESSION['add']))
        {
          echo $_SESSION['add'];//displaying session message
          unset($_SESSION['add']);//removing session message
        }
        if(isset($_SESSION['delete']))
        {
          echo $_SESSION['delete'];//displaying session message
          unset($_SESSION['delete']);//removing session message
        }
        if(isset($_SESSION['update']))
        {
          echo $_SESSION['update'];
          unset($_SESSION['update']);
        }
        if(isset($_SESSION['user-not-found']))
        {
          echo $_SESSION['user-not-found'];
          unset($_SESSION['user-not-found']);
        }
        if(isset($_SESSION['pwd-not-match']))
        {
          echo $_SESSION['pwd-not-match'];
          unset($_SESSION['pwd-not-match']);
        }
        if(isset($_SESSION['change-pwd']))
        {
          echo $_SESSION['change-pwd'];
          unset($_SESSION['change-pwd']);
        }
      ?>
      </br></br></br>
      <!--button to add admin-->
      <a href="add-admin.php" class="btn-primary">Add admin</a>      
      </br></br></br>
      <table class="tbl-full">
        <tr>
          <th>S.N.</th>
          <th>Full Name</th>
          <th>username</th>
          <th>actions</th>
        </tr>
        <?php
        //query to get all admin
          $sql="SELECT * FROM tbl_admin";
          //execute the query
          $res=mysqli_query($conn,$sql);
          //check whether the query is executed or not
            if($res==TRUE)
            {
              //count rows to check whether we have data in database
              $count=mysqli_num_rows($res);//function to get all rows in database
              $sn=1;//create a variable and assign the value    
              //check the num of rows
              if($count>0)
              {
                //we have data in database
                while($rows=mysqli_fetch_assoc($res))
                {
                  //using while loop to get all the data from database
                  $id=$rows['id'];
                  $full_name=$rows['full_name'];
                  $username=$rows['username'];
                  //display the values in our table
                  ?>
                  <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $full_name; ?></td>
                    <td><?php echo $username; ?></td>
                    <td>
                    <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change password</a>
                    <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">update admin</a>
                    <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">delete admin</a>
                    </td>
                  </tr>
                  <?php
                }
              }
              else{
                //we do not have data in database
              }
            }
        ?>
      </table>
    </div>  
  </div>
  <!--main section ends-->

<?php include('partials/footer.php'); ?>