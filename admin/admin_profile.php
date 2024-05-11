<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('includes/admin_profile.php');
?>
<script>https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css</script>
<script>https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js</script>
<script>https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js</script>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold">Edogaru</span><span class="text-black-50">edogaru@mail.com.my</span><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <?php 
                if(isset($_SESSION['user_id'])){
                    $user_id = $_SESSION['user_id'];

                    $profileSql = "SELECT firstname, lastname, gender, contact, address FROM user_info WHERE info_id = '$user_id'";
                    $profileResult = mysqli_query($conn, $profileSql);

                    if($profileResult && mysqli_num_rows($profileResult) > 0){
                        $profileRow = mysqli_fetch_assoc($profileResult);
                        ?>
                        <form>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">Firstname</label>
                                <input type="text" class="form-control" value="<?php echo $profileRow['firstname'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Lastname</label>
                                <input type="text" class="form-control" value="<?php echo $profileRow['lastname'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Gender</label>
                                <input type="text" class="form-control" value="<?php echo $profileRow['gender'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Contact</label>
                                <input type="text" class="form-control" value="<?php echo $profileRow['contact'] ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Address</label>
                                <input type="text" class="form-control" value="<?php echo $profileRow['address'] ?>">
                            </div>
                        </div>
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
                        </form>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php
include('includes/footer.php');
?>