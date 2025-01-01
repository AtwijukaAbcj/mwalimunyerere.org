<?php 
include_once('header.php');
include_once('root/config.php');
$users = dbSQL("SELECT * FROM users");

?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="<?=HOME_URL;?>">Home</a></li>
              <li class="breadcrumb-item active">List of Users </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">    
      <?php if(!empty($_SESSION['msg'])) echo log_message(); ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> <b>  <i class="fa fa-list"> </i> List of Users </b> </h3>
              </div>
              <div class="card-body table-responsive">
             <?php if(sizeof($users) > 0) { ?>
                <table id="examples" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Phone Number </th>
                            <th> Country </th>
                            <th> Role </th>
                            <th> Action </th>
                      </tr>
                  </thead>
                  <tbody>
                     <?php foreach($users as $row): ?>
                        <tr>
                              <td> <?=$row->firstName;?> </td>
                              <td> <?=$row->email;?> </td>
                              <td> <?=$row->contact;?> </td>
                              <td> <?=$row->country;?> </td>
                              <td> <?=$row->role;?> </td>
                              <td> 
                                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal<?=$row->userID;?>">Update</button>
                                  <a href="root/proc.inc.php?udelete=<?=$row->userID;?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                              </td>
                        </tr>
                      <?php endforeach; ?>
                  </tbody>
                </table>
                <?php } else { ?>
                    <b style="color:red"> No users registered so far </b>
                <?php } ?>
              </div>
             </div>
           </div>
        </div>
      </div>
   </section>
</div>

<!-- Modals for each user -->
<?php foreach($users as $row): ?>
<div class="modal fade" id="updateModal<?=$row->userID;?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$row->userID;?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel<?=$row->userID;?>">Update User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="update_user.php" method="POST">
          <input type="hidden" name="userID" value="<?=$row->userID;?>">
          <div class="form-group">
            <label for="firstName<?=$row->userID;?>">First Name</label>
            <input type="text" class="form-control" id="firstName<?=$row->userID;?>" name="firstName" value="<?=$row->firstName;?>" required>
          </div>
          <div class="form-group">
            <label for="email<?=$row->userID;?>">Email</label>
            <input type="email" class="form-control" id="email<?=$row->userID;?>" name="email" value="<?=$row->email;?>" required>
          </div>
          <div class="form-group">
            <label for="contact<?=$row->userID;?>">Phone Number</label>
            <input type="text" class="form-control" id="contact<?=$row->userID;?>" name="contact" value="<?=$row->contact;?>" required>
          </div>
          <div class="form-group">
            <label for="country<?=$row->userID;?>">Country</label>
            <input type="text" class="form-control" id="country<?=$row->userID;?>" name="country" value="<?=$row->country;?>" required>
          </div>
          <div class="form-group">
            <label for="role<?=$row->userID;?>">Role</label>
            <select name="role" class="form-control" id="role<?=$row->userID;?>" required>
              <?php foreach($uc_list as $role): ?>
                <option value="<?=$role;?>" <?=($row->role == $role) ? 'selected' : '';?>><?=$role;?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<?php include('footer.php');?>
