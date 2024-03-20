<?php include('partials/menu.php'); ?>
<div class="main-content">
  <div class="wrapper">
    <h1> Update Food<h1>
    </br></br>

   
    <?php  //getting data from the form
      //check whether the id is set or not
      if(isset($_GET['id']))
      {
        $id=$_GET['id'];
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        $res2=mysqli_query($conn,$sql2);

        $count=mysqli_num_rows($res2);
        if($count==1)
        {
          $row2=mysqli_fetch_assoc($res2);

          $title=$row2['title'];
          $description=$row2['description'];
          $prize=$row2['prize'];
          $current_image=$row2['img_name'];
          $current_category=$row2['category_id'];
          $featured=$row2['featured'];
          $active=$row2['active'];
        }
        else
        {
          //redirect to manage category page
          //
          header('location:'.SITEURL.'admin/manage-food.php');
        }
      }
      else
      {
        header('location:'.SITEURL.'admin/manage-category.php');
      }
    ?>
    

    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-30">
        <tr>
          <td>Title:</td>
          <td>
            <input type="text" name="title" value="<?php echo $title; ?>">
          </td>
        </tr>

        <tr>
          <td>Description</td>
          <td>
            <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
          </td>
        </tr>

        <tr>
          <td>Prize</td>
          <td>
            <input type="number" name="prize" value="<?php echo $prize; ?>">
          </td>
        </tr>

        <tr>
          <td>Current image:</td>
          <td>
            <?php
              if($current_image!="")
              {
                ?>
                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                <?php
              }
              else{
                echo "<div class='error'>Image not added</div>";
              }
            ?>
          </td>
        </tr>

        <tr>
          <td>New image</td>
          <td>
            <input type="file" name="image">
          </td>
        </tr>

        <tr>
          <td>Category</td>
          <td>
            <select name="category">
              <?php
                $sql="SELECT * FROM tbl_category WHERE active='yes'";
                $res=mysqli_query($conn,$sql);
                $count=mysqli_num_rows($res);
                if($count>0)
                {
                  while($row=mysqli_fetch_assoc($res))
                  {
                    $category_title = $row['title'];
                    $category_id=$row['id'];

                    //echo "<option value='$category_id'>$category_title</option>";
                    ?>
                    <option value="<?php echo $category_id; ?> "><?php echo $category_title; ?></option>
                    <?php
                  }
                }
                else
                {
                  echo "<option value='0'>Category not available</option>";
                }
              ?>
              
               </select>
          </td>
        </tr>

        <tr>
          <td>Featured:</td>
          <td>
            <input <?php if($featured=="yes"){echo "checked";} ?> type="radio" name="featured" value="yes">Yes
            <input <?php if($featured=="no"){echo "checked";} ?> type="radio" name="featured" value="no">No
          </td>
        </tr>

        <tr>
          <td>Active</td>
          <td>
            <input <?php if($active=="yes"){echo "checked";} ?> type="radio" name="active" value="yes">Yes
            <input <?php if($active=="no"){echo "checked";} ?> type="radio" name="active" value="no">No
          </td>
        </tr>

        <tr>
           <td colspan="2">
            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Update Category" class="btn-secondary">
          </td>
        </tr>
        
      </table>
    </form>

    <?php //updating the form

        if(isset($_POST['submit']))
        {
          //echo"clicked";
          //1.get all the values from form
          $id=$_POST['id'];
          $title=$_POST['title'];
          $description=$_POST['description'];
          $prize=$_POST['prize'];
          $current_image=$_POST['current_image'];
          $category=$_POST['category'];
          $featured=$_POST['featured'];
          $active=$_POST['active'];

          //2.updating new image if selected
          //check whether image is selcted or not
          if(isset($_FILES['image']['name']))
          {
            $image_name=$_FILES['image']['name'];

            if($image_name!="")
            {
              //image available
              //A.upload the image

              //auto rename image
              //get the extension of our image
              $ext =end(explode('.',$image_name));
              //rename the image
              $image_name="food-name-".rand(0000,9999).'.'.$ext;

              $source_path=$_FILES['image']['tmp_name'];
              $destination_path="../images/food/".$image_name;

              //finally upload the image
              $upload=move_uploaded_file($source_path,$destination_path);

              //check whether the image is uploaded or not
              //if image is not uploaded them we will stop the process and redirect with error message
              if($upload==false)
              {
                //set message
                $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
                //redirect to manage food page 
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop the process
                die();
              }
              //B.remove the current image if available
              if($current_image!="")
              {
                $remove_path = "../images/food/".$current_image;

                $remove=unlink($remove_path);
                //check whether the image is removed or not
                //if failed to remove then display message and stop the process
                if($remove==false)
                {
                  $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image </div> ";
                  header('location:'.SITEURL.'admin/manage-food.php');
                  die();
                }
              }
            }
            else
            {
              $image_name=$current_image;
            }
          }         
          else
          {
            $image_name=$current_image;
          }
                       

          //3.update the database
          $sql3 = "UPDATE tbl_food SET

          title='$title',
          description='$description',
          prize=$prize,
          img_name='$image_name',
          category_id='$category',
          featured='$featured',
          active='$active'
          WHERE id=$id
          ";                 

          $res3=mysqli_query($conn,$sql3);
          //4.redirect to manage category with message
          if($res3==true)
          {
            $_SESSION['update']="<div class='success'>Food updated successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
          }
          else
          {
            $_SESSION['update']="<div class='error'>Failed to update Food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
          }
      }
    ?>
  </div>
</div>

<?php include('partials/footer.php'); ?>