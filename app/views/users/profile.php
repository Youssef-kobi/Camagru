<?php require_once APPROOT . '/views/inc/header.php';?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Edit Your Profile</h2>
            <p>Please fill the form to edit</p>
            <p>Empty forms wont be edited </p>
            <form action="<?php echo URLROOT;?>/users/profile" method="post">
                <div class="form-group">
                    <label for="username">Username:<sup>*</sup><i>  <?php echo $_SESSION['user_username'];?></i> </label>
                    <? echo $_SESSION['user_username']; ?> 
                    <input type="text" name="username" autocomplete="off"  class="form-control form-control-lg <?php echo (!empty($data
                    ['username_err'])) ? 'is-invalid' : '' ;?> " value="" >
                    <span class="invalid-feedback"><?php echo $data['username_err']?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup><i>  <?php echo $_SESSION['user_email'];?></i> </label>
                    <input type="text" name="email" autocomplete="off"  class="form-control form-control-lg <?php echo (!empty($data
                    ['email_err'])) ? 'is-invalid' : '' ;?> " value="" >
                    <span class="invalid-feedback"><?php echo $data['email_err']?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" name="password" autocomplete="off"  class="form-control form-control-lg <?php echo (!empty($data
                    ['password_err'])) ? 'is-invalid' : '' ;?> " value="" >
                    <span class="invalid-feedback"><?php echo $data['password_err']?></span>
                </div>
                <div class="form-group"> 
                    <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                    <input type="password" name="confirm_password" autocomplete="off"  class="form-control form-control-lg <?php echo (!empty($data
                    ['confirm_password_err'])) ? 'is-invalid' : '' ;?> " value="" >
                    <span class="invalid-feedback"><?php echo $data['confirm_password_err']?></span>
                </div>
                <p>Please enter your current Password To Edit:</p>
                <div class="form-group"> 
                    <label for="current_password">Current Password: <sup>*</sup></label>
                    <input type="password" name="current_password" autocomplete="off"  class="form-control form-control-lg <?php echo (!empty($data
                    ['current_password_err'])) ? 'is-invalid' : '' ;?> " value="" >
                    <span class="invalid-feedback"><?php echo $data['current_password_err']?></span>
                </div>
                <div class="form-group"> 
                    <label for="notification"> Notifications : </label>
                    <?php if($this->userModel->isNotify($_SESSION['user_username'])): ?>
                    <input type="checkbox" name="notification" checked >
                    <?php else: ?>
                        <input type="checkbox" name="notification" >
                    <?php endif ?>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value ="Edit" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once APPROOT . '/views/inc/footer.php';?>