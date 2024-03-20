<?php
  include('../config/constants.php');

  //check whether the id and image name is set or not
  if(isset($_GET['id']) AND isset($_GET['image_name']))
  {
    //get the value and delete
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];

    //remove the physical image file if available
    if($image_name!="")
    {
      //image is availab;e.so delete it
      $path="../images/food/".$image_name;
      $remove=unlink($path);

      //if failed to remove image 
      if($remove==false)
      {
        $_SESSION['remove']="<div class='error'>Failed to remove food image</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
        die();
      }
    }
    //delete data from database
    $sql="DELETE FROM tbl_food WHERE id=$id";
    $res=mysqli_query($conn,$sql);

    //check whether data is deleted from database or not
    if($res==true)
    {
     $_SESSION['delete']="<div class='success'> Food Deleted Successfully</div>";
      header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
      $_SESSION['delete']="<div class='error'>Failed to delete Food.Try again later</div>";
      header('location:'.SITEURL.'admin/manage-food.php');
    }
  }
  else{
    //redirect to manage category page
    header('location:'.SITEURL.'admin/manage-food.php');
  }

?>