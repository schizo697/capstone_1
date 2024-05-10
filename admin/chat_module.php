<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('includes/chat_module.php');
?>
<head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" >
<!-- Font awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" >
<style>
        .contacts_body {
            overflow-y: auto;
            max-height: calc(100vh - 330px); 
        }
    </style>
</head>

<body>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Chat Module</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">    
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
<!-- Modal Search -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height: 300px; overflow-y: auto;">
                <div class="input-group">
                    <input type="search" id="searchInput" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <button type="button" class="btn btn-outline-primary" data-mdb-ripple-init>search</button>
                </div>
                <?php 
                $namesql = "SELECT info_id, user_info.firstname, user_info.lastname FROM user_info";
                $nameresult = mysqli_query($conn, $namesql);

                if($nameresult && mysqli_num_rows($nameresult) > 0) {
                    while($row = mysqli_fetch_assoc($nameresult)) {
						$info_id = $row['info_id'];
                        $firstname = $row['firstname'];
                        $lastname = $row['lastname'];
                        $name = $firstname . ' ' . $lastname;
                        ?>
                        <div class="container nameContainer">
                            <div class="mt-3">
                                <a href="chat_module.php?recipient_id=<?php echo $info_id ?>" style="text-decoration: none;">
                                    <p><?php echo $name ?></p>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- start -->
        <div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">

					<div class="card-header">
						<div class="input-group">
							<input type="text" placeholder="Search..." name="" class="form-control search" id="contactSearch">
							<div class="input-group-prepend">
								<span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
							</div>
						</div>
					</div>
					<div class="card-body contacts_body">
						<ui class="contacts" id="contactList">
                        <?php
						if(isset($_SESSION['user_id'])){
							$user_id = $_SESSION['user_id'];

							$sql = "SELECT user_info.info_id, user_info.firstname, user_info.lastname, user_account.isOnline, MAX(chats.time) AS last_chat_time, chats.reciever_id AS user_id
							FROM user_account
							JOIN user_info ON user_account.info_id = user_info.info_id
							JOIN chats ON user_info.info_id = chats.reciever_id
							WHERE chats.user_id = '$user_id'
							GROUP BY user_info.info_id, user_info.firstname, user_info.lastname, user_account.isOnline, chats.reciever_id
							ORDER BY last_chat_time DESC";
							$result = mysqli_query($conn, $sql);
	
							if($result && mysqli_num_rows($result) > 0){
								while($row = mysqli_fetch_assoc($result)){
									$info_id = $row['info_id'];
									$firstname = $row['firstname'];
									$lastname = $row['lastname'];
									$name = $firstname . ' ' . $lastname;
									$isOnline = $row['isOnline'];
									
									?>
									<li class="active">
									<a href="chat_module.php?recipient_id=<?php echo $info_id ?>" style="text-decoration: none;">
										<div class="d-flex bd-highlight">
											<?php
											if($isOnline == 1) {
												?>
												<div class="img_cont">
													<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
													<span class="online_icon"></span>
												</div>
												<div class="user_info">
													<span><?php echo $name; ?></span>
													<p>Online</p>
												</div>												
												<?php
											} else {
												?>
												<div class="img_cont">
													<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
													<span class="offline_icon"></span>
												</div>
												<div class="user_info">
													<span><?php echo $name; ?></span>
													<p>Offline</p>
												</div>
												<?php
											}
											?>
										</div>
									</a>                             
									</li>
									<?php
								}
							}
						}
                        ?>
						</ui>
					</div>
					<div class="card-footer">
					<button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
						New Chat
					</button>
					</div>
				</div>
            </div>
				<div class="col-md-8 col-xl-6 chat">
					<div class="card">
						<div class="card-header msg_head">
						<?php
						if(isset($_GET['recipient_id'])){
							$recipient_id = $_GET['recipient_id'];
							$sql = "SELECT user_info.info_id, user_info.firstname, user_info.lastname, user_account.isOnline
							FROM user_account
							JOIN user_info ON user_account.info_id = user_info.info_id
							WHERE user_account.info_id = $recipient_id LIMIT 1";
							$result = mysqli_query($conn, $sql);
	
							if($result && mysqli_num_rows($result) > 0){
								$row = mysqli_fetch_assoc($result);
								$user_id = $row['info_id'];
								$firstname = $row['firstname'];
								$lastname = $row['lastname'];
								$name = $firstname . ' ' . $lastname;
								$isOnline = $row['isOnline'];
						}
						?>
						<div class="d-flex bd-highlight">
							<?php 
							if($isOnline == 1) {
								?> 
								<div class="img_cont">
									<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
									<span class="online_icon"></span>
								</div>
								<div class="user_info">
									<span><?php echo $name; ?></span>
									<p>Online</p>
								</div>
								<?php
							} else {
								?> 
								<div class="img_cont">
									<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
									<span class="offline_icon"></span>
								</div>
								<div class="user_info">
									<span><?php echo $name; ?></span>
									<p>Offline</p>
								</div>
								<?php
							}
							?>
						</div>
						<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
						<div class="action_menu">
							<ul>
								<li><i class="fas fa-user-circle"></i> View profile</li>
							</ul>
						</div>
						<?php
						}
						?>
						</div>
						<div class="card-body msg_card_body" style="max-height: 386px;" id="scrollableDiv">
						<?php
							if(isset($_SESSION['user_id'])){
								$sender_id = $_SESSION['user_id'];

								if(isset($_GET['recipient_id'])){
									$receiver_id = $_GET['recipient_id'];

									$messageDisplay = "SELECT user_id, reciever_id, message, time FROM chats WHERE (user_id = '$sender_id' AND reciever_id = '$receiver_id') OR (user_id = '$receiver_id' AND reciever_id = '$sender_id') ORDER BY time ASC";
									$messageResult = mysqli_query($conn, $messageDisplay);

									if($messageResult && mysqli_num_rows($messageResult) > 0){
										while ($row = mysqli_fetch_assoc($messageResult)){
											$sent_id = $row['user_id'];
											$received_id = $row['reciever_id'];
											$message_content = $row['message'];
											$time = $row['time'];

											$message_time = strtotime($time);
											$current_time = time();

											if(date('Y-m-d', $message_time) == date('Y-m-d', $current_time)) {
												$formatted_time = "Today " . date('H:i', $message_time);
											} else {
												$formatted_time = date('Y-m-d H:i', $message_time);
											}

											if($sent_id == $sender_id && $received_id == $receiver_id){
												?>
												<div class="d-flex justify-content-end mb-4">
													<?php if (is_file($message_content)) { ?>
														<div class="msg_cotainer_send">
															<a href="<?php echo $message_content; ?>"><img src="<?php echo $message_content; ?>" class="img-fluid" style="height: 300px;"></a>
															<span class="msg_time_send"><?php echo $formatted_time; ?></span>
														</div>
													<?php } else { ?>
														<div class="msg_cotainer_send">
															<?php echo $message_content; ?>
															<span class="msg_time_send"><?php echo $formatted_time; ?></span>
														</div>
													<?php } ?>
													<div class="img_cont_msg">
														<img src="https://avatars.hsoubcdn.com/ed57f9e6329993084a436b89498b6088?s=256" class="rounded-circle user_img_msg">
													</div>
												</div>
												<?php
											} elseif ($sent_id == $receiver_id && $received_id == $sender_id){
												?>
												<div class="d-flex justify-content-start mb-4">
													<div class="img_cont_msg">
														<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg">
													</div>
													<?php if (is_file($message_content)) { ?>
														<div class="msg_cotainer">
															<a href="<?php echo $message_content; ?>"><img src="<?php echo $message_content; ?>" class="img-fluid" style="height: 300px;"></a>
															<span class="msg_time"><?php echo $formatted_time; ?></span>
														</div>
													<?php } else { ?>
														<div class="msg_cotainer">
															<?php echo $message_content; ?>
															<span class="msg_time"><?php echo $formatted_time; ?></span>
														</div>
													<?php } ?>
												</div>
												<?php
											}
										}
									}  else {
										?>
										<div class="card-body msg_card_body">
											<div class="d-flex justify-content-center mb-4" style="height: 286px;">
												<div class="msg_cotainer_send">
													No Conversation
												</div>
											</div>
										</div>
										<?php
									}
								}
							}
							?>
						</div>
						<div class="card-footer">
							<?php
							if(isset($_SESSION['user_id'])){
								$sender_id = $_SESSION['user_id'];
								
								if(isset($_GET['recipient_id'])){
									$reciever_id = $_GET['recipient_id'];

									if(isset($_POST['btnSend'])){
										date_default_timezone_set('Asia/Singapore');
										$localDatetime = date('Y-m-d H:i:s');

										if(!empty($_FILES['upload']['name'])){ // Check if file is uploaded
											$target_dir = "uploads/";
											$target_file = $target_dir . basename($_FILES["upload"]["name"]);
											$uploadOk = 1;
											$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

											// Check if file is a real file or fake
											if(isset($_POST["submit"])) {
												$check = getimagesize($_FILES["upload"]["tmp_name"]);
												if($check !== false) {
													echo "File is an image - " . $check["mime"] . ".";
													$uploadOk = 1;
												} else {
													echo "File is not an image.";
													$uploadOk = 0;
												}
											}

											// Check file size
											if ($_FILES["upload"]["size"] > 500000) {
												echo "Sorry, your file is too large.";
												$uploadOk = 0;
											}

											// Allow certain file formats
											if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
											&& $imageFileType != "gif" ) {
												$url = "chat_module.php?recipient_id=$recipient_id&error=true"; // Changed ? to &
												echo '<script>window.location.href="' . $url . '" </script>'; // Added missing closing bracket
												$uploadOk = 0;
											}
										

											// Check if $uploadOk is set to 0 by an error
											if ($uploadOk == 0) {
												echo "Sorry, your file was not uploaded.";
											// if everything is ok, try to upload file
											} else {
												if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
													echo "The file ". htmlspecialchars( basename( $_FILES["upload"]["name"])). " has been uploaded.";
													$message = $target_file;
													$messageSql = "INSERT INTO chats (user_id, reciever_id, message, time) VALUES ('$sender_id', '$reciever_id', '$message', '$localDatetime')";
													$messageSend = mysqli_query($conn, $messageSql);
													if($messageSend){
														$url = "chat_module.php?recipient_id=$reciever_id";
														echo '<script>window.location.href="' . $url . '"</script>';
														exit();
													} 
												} else {
													echo "Sorry, there was an error uploading your file.";
												}
											}
										} elseif(!empty($_POST['txtChat'])){ // Check if text message is sent
											$message = mysqli_real_escape_string($conn, $_POST['txtChat']);
											$messageSql = "INSERT INTO chats (user_id, reciever_id, message, time) VALUES ('$sender_id', '$reciever_id', '$message', '$localDatetime')";
											$messageSend = mysqli_query($conn, $messageSql);
											if($messageSend){
												$url = "chat_module.php?recipient_id=$reciever_id";
												echo '<script>window.location.href="' . $url . '"</script>';
												exit();
											} 
										} else {
											$url = "chat_module.php?recipient_id=$reciever_id";
											echo '<script>window.location.href="' . $url . '"</script>';
											exit();
										}
									}
								}
							}
							?>
							<form action="" method="POST" enctype="multipart/form-data">
								<div class="input-group">
									<div class="input-group-append">
										<input type="file" name="upload" id="fileInput" style="display: none;" onchange="displaySelectedFile()">
										<span class="input-group-text attach_btn" onclick="document.getElementById('fileInput').click();">
											<i class="fas fa-paperclip"></i>
										</span>
									</div>
									<input type="text" name="txtChat" id="txtChat" class="form-control type_msg" placeholder="Type your message..." onkeydown="handleKeyDown(event)"></input>
									<div class="input-group-append">
										<button type="submit" name="btnSend" class="input-group-text send_btn" onclick="sendMessage()"><i class="fas fa-location-arrow"></i></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
</body>

<!-- alert -->
<script>
    function showAlert(type, message) {
        Swal.fire({
            icon: type,
            text: message,
        });
    }

    function checkURLParams() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error') && urlParams.get('error') === 'true') {
            showAlert('warning', 'Error occurred while uploading image');
        }
    }

    window.onload = checkURLParams;
</script>

<script>
function handleKeyDown(event) {
    if (event.keyCode === 13) { // 13 is the keycode for 'Enter' key
        sendMessage();
    }
}

function sendMessage() {
    // Your sending logic here
    console.log(document.getElementById('txtChat').value); // Example: Logging the value of the input field
}
</script>

<script>
    function displaySelectedFile() {
        const fileInput = document.getElementById('fileInput');
        const txtChat = document.getElementById('txtChat');
        
        if (fileInput.files.length > 0) {
            txtChat.value = fileInput.files[0].name;
        }
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const nameContainers = document.querySelectorAll('.nameContainer');
            nameContainers.forEach(container => {
                const name = container.querySelector('p').innerText.toLowerCase();
                if (name.includes(searchText)) {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            });
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('contactSearch');
    const contactList = document.getElementById('contactList');

    searchInput.addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const contacts = contactList.getElementsByTagName('li');

        for (let i = 0; i < contacts.length; i++) {
            const contact = contacts[i];
            const name = contact.querySelector('.user_info span').textContent.toLowerCase();
            
            if (name.includes(searchQuery)) {
                contact.style.display = 'block';
            } else {
                contact.style.display = 'none';
            }
        }
    });
});
</script>
<script>
  var scrollableDiv = document.getElementById('scrollableDiv');
  scrollableDiv.scrollTop = scrollableDiv.scrollHeight;
</script>
<script>
    $(document).ready(function(){
        $('#action_menu_btn').click(function(){
            $('.action_menu').toggle();
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<?php
include('includes/footer.php');
?>
