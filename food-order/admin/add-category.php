<?php include('partials/menu.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>Add Category</h1>
</br></br>
    <?php
      if(isset($_SESSION['add']))
      {
        echo $_SESSION['add'];//displaying session message
        unset($_SESSION['add']);//removing session message
      }
      if(isset($_SESSION['upload']))
      {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
      }
    ?>

    </br></br>

    <!-- add category form starts here-->
    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-30">
        <tr>
          <td> Title</td>
          <td> 
            <input type="text" name="title" placeholder="category title">
          </td>
        </tr>

        <tr>
          <td>Select image</td>
          <td>
            <input type="file" name="image">
          </td>
        </tr>

        <tr>
          <td>featured</td>
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
            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
          </td>
        </tr>
       
      </table>
    </form>
    <!-- add category form ends here-->
    <?php
      //check whether the submit button is clicked or not
      if(isset($_POST['submit']))
      {
        //echo "button clicked";
        //1.get the value from category form
        $title=$_POST['title'];

        //for radio input type we need to check whether the button is selected or not
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
        //check whether the image is selected or not and set value for image name accordingly
        //print_r($_FILES['image']);
        // die();//break the code here
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
            $ext =end(explode('.',$image_name));
            //rename the image
            $image_name="food_category_".rand(000,999).'.'.$ext;

            $source_path=$_FILES['image']['tmp_name'];
            $destination_path="../images/category/".$image_name;

            //finally upload the image
            $upload=move_uploaded_file($source_path,$destination_path);

            //check whether the image is uploaded or not
            //if image is not uploaded them we will stop the process and redirect with error message
            if($upload==false)
            {
              //set message
              $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
              //redirect to add category page 
              header('location:'.SITEURL.'admin/add-category.php');
              //stop the process
              die();
            }
          }
        }
        else
        {
          //dont upload the image and set the image name value as blank
          $image_name="";
        }
        //2.create sql query to insert category into database
        $sql="INSERT INTO tbl_category SET
        title='$title',
        image_name='$image_name',
        featured='$featured',
        active='$active'
        ";
        //3.execute the query and save in adtabase
        $res=mysqli_query($conn,$sql);

        //4.check whether the query is executed or not and data added or not
        if($res==true)
        {
          //query executed
          $_SESSION['add']="<div class='success'>Category added successfully</div>";
          //redirect to manage category page
          header('location:'.SITEURL.'admin/manage-category.php');
   
        }
        else{
          //failed to add category
          $_SESSION['add']="<div class='error'>Failed to add Category </div>";
          //redirect to manage category page
          header('location:'.SITEURL.'admin/add-category.php');
   
        }

      }
    ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>