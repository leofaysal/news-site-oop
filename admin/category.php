<?php include "header.php";


 ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">

            <table class="content-table">

                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>

                        <tr>
                            <td class='id'><?php echo $serial;?></td>
                            <td><?php echo $row['category_name'];?></td>
                            <td><?php echo $row['post'];?></td>
                            <td class='edit'><a href="update-category.php?id=<?php echo $row['category_id'];?>"><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a onClick="deleteConfirm(<?php echo $row['category_id']; ?>)"><i class='fa fa-trash-o'></i></a></td>


                        <!-- Javascript Fuction for deleting data -->
                        <script language="javascript">
                        function deleteConfirm(catid){
                          if(confirm("Are you sure you want to delete this?")){
                            window.location.href="delete-category.php?id="+catid;
                            return true;
                          }
                        }
                        </script>
                        </tr>

                    </tbody>
                </table>
              

            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
