<?php include('partials/menu.php'); ?>

<div class="main-content">
  <div class="wrapper">
  <h1>Manage Category</h1>
  </br></br></br>
  <?php
      if(isset($_SESSION['add']))
      {
        echo $_SESSION['add'];//displaying session message
        unset($_SESSION['add']);//removing session message
      }
      if(isset($_SESSION['remove']))
      {
        echo $_SESSION['remove'];
        unset($_SESSION['remove']);
      }
      if(isset($_SESSION['delete']))
      {
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
      }
      if(isset($_SESSION['no-category-found']))
      {
        echo $_SESSION['no-category-found'];
        unset($_SESSION['no-category-found']);
      }
      if(isset($_SESSION['update']))
      {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
      }
      if(isset($_SESSION['upload']))
      {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
      }
      if(isset($_SESSION['failed-remove']))
      {
        echo $_SESSION['failed-remove'];
        unset($_SESSION['failed-remove']);
      }
    ?>

    </br></br>
        <!--button to add admin-->
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add category</a>
        
</br></br></br>
        <table class="tbl-full">

          <tr>
            <th>S.N.</th>
            <th>Title</th>
            <th>Image</th>
            <th>Featured</th>
            <th>Active</td>
            <th>Actions</td>
          </tr>

          <?php
          //query to get all category
          $sql="SELECT * FROM tbl_category";
          //execute the query
          $res=mysqli_query($conn,$sql);

          $count=mysqli_num_rows($res);

          //create serial number variable and assign value 1
          $sn=1;

          //check whether we have data in database
          if($count>0)
          {
            //we have data in database
            //get the data and display
            while($row=mysqli_fetch_assoc($res))
            {
              $id=$row['id'];
              $title=$row['title'];
              $image_name=$row['image_name'];
              $featured=$row['featured'];
              $active=$row['active'];
              ?>
            
            <tr>
              <td><?php echo $sn++; ?></td>
              <td><?php echo $title; ?></td>

              <td>
                <?php 
                  //check whether the image name is available or not
                  if($image_name!="")
                  {
                    //display the image
                    ?>
                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px">
                    <?php
                  }
                  else{
                    //display the message
                    echo "<div class='error'>Image not added</div>";
                  }
                ?>
              </td>

              <td><?php echo $featured; ?></td>
              <td><?php echo $active; ?></td>
              <td>
              <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">update Category</a>
              <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">delete Category</a>
              </td>
            </tr>
              <?php

            }

          }
          else{
            //we dont have data in database
            //we'll display the message inside table
            ?>

            <tr>
              <td colspan="6"><div class="error">No category added</div></td>

            </tr>


            <?php
          }


          ?>

          

          
        </table>
</div>
</div>
<?php include('partials/footer.php'); ?>