<?php include('partials/menu.php'); ?>
<div class="main-content">
  <div class="wrapper">
    <h1>Add Food</h1>
    </br></br>

  <?php
    if(isset($_SESSION['upload']))
    {
      echo $_SESSION['upload'];
      unset($_SESSION['upload']);
    }
    if(isset($_SESSION['add']))
      {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
      }
  ?>
  

  <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-30">
        <tr>
          <td> Title</td>
          <td> 
            <input type="text" name="title" placeholder="Food title">
          </td>
        </tr>

        <tr>
          <td>Description:</td>
          <td>
            <textarea name="description" cols="30" rows="5" placeholder="Description of the food">

            </textarea>
          </td>
        </tr>

        <tr>
          <td>Price:</td>
          <td>
            <input type="number" name="price" >
          </td>
        </tr>

        <tr>
          <td>Select Image:</td>
          <td>
            <input type="file" name="image">
          </td>
        </tr>

        <tr>
          <td>Category</td>
          <td> 
            <select name="category">
              <?php
                //create php code to display categories from database
                //1.create sql to get all active categories from database
                $sql="SELECT * FROM tbl_category WHERE active='yes'";

                $res=mysqli_query($conn,$sql);

                $count=mysqli_num_rows($res);

                if($count>0)
                {
                  while($row=mysqli_fetch_assoc($res))
                  {
                    $id=$row['id'];
                    $title=$row['title'];
                    ?>
                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                    <?php
                  }
                }
                else{
                  ?>
                  <option value="0">No category found</option>
                  <?php
                }
                //2.display on dropdown
              ?>              
            </select>
          </td>
        </tr>
      
        <tr>
          <td>Featured</td>
          <td>
            <input type="radio" name="featured" value="yes">Yes
            <input type="radio" name="featured" value="no">No
          </td>
        </tr>

        <tr>
          <td>Active</td>
          <td>
            <input type="radio" name="active" value="yes">Yes
            <input type="radio" name="active" value="no">No
          </td>
      </tr>

        <tr>
           <td colspan="2">
            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
          </td>
        </tr>

      </table>
    </form>

    <?php
      if(isset($_POST['submit']))
      {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        if(isset($_POST['featured']))
        {
          //get the value from form
          $featured=$_POST['featured'];
        }
        else 
        {
          //set the default value
          $featured="no";
        }
        if(isset($_POST['active']))
        {
          //get the value from form
          $active = $_POST['active'];
        }
        else 
        {
          //set the default value
          $active="no";
        }
        //2.upload the image if selcted
        //check whether the select image is clicked or not
        if(isset($_FILES['image']['name']))
        {
          //upload the image
          //to upload the image we need image name and source path and destination path
          $image_name=$_FILES['image']['name'];

          //upload image only if image is selected
          if($image_name!="")
          { 
            //auto rename image
            //get the extension of our image
            $ext = end(explode('.',$image_name));
            //rename the image
            $image_name="food-name-".rand(0000,9999).".".$ext;

            $source_path = $_FILES['image']['tmp_name'];
            $destination_path="../images/food/".$image_name;

            //finally upload the image
            $upload=move_uploaded_file($source_path, $destination_path);

            //check whether the image is uploaded or not
            //if image is not uploaded them we will stop the process and redirect with error message
            if($upload==false)
            {
              //set message
              $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
              //redirect to add food page 
              header('location:'.SITEURL.'admin/add-food.php');
              //stop the process
              die();
            }
          }
        }
        else
        {
          //dont upload the image and set the image name value as blank
          $image_name = "";
        }
        //3.insert innto database
        //for numerical value no need to single quotes
        $sql2 = " INSERT INTO tbl_food SET
          title = '$title',
          description = '$description',
          prize = $price,
          img_name = '$image_name',
          category_id =$category,
          featured = '$featured',
          active = '$active'
        ";

        $res2 = mysqli_query($conn,$sql2);

        if($res2==true)
        {
          //query executed
          $_SESSION['add']="<div class='success'>Food added successfully</div>";
          //redirect to manage category page
          header('location:'.SITEURL.'admin/manage-food.php');   
        }
        else
        {
          //failed to add category
          $_SESSION['add']="<div class='error'>Failed to add food </div>";
          //redirect to manage category page
          header('location:'.SITEURL.'admin/add-food.php');   
        }
    }    
    ?>

  </div>
</div>


<?php include('partials/footer.php'); ?>