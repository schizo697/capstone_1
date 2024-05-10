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
<!-- start -->
        <div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
					<div class="card-header">
						<div class="input-group">
							<input type="text" placeholder="Search..." name="" class="form-control search">
							<div class="input-group-prepend">
								<span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
							</div>
						</div>
					</div>
					<div class="card-body contacts_body">
						<ui class="contacts">
                        <?php
                        $sql = "SELECT info_id, firstname, lastname FROM user_info";
                        $result = mysqli_query($conn, $sql);

                        if($result && mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $user_id = $row['info_id'];
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                                $name = $firstname . ' ' . $lastname;
                                ?>
                                <li class="active">
								<a href="chat_module.php?recipient_id=<?php echo $user_id ?>" style="text-decoration: none;">
									<div class="d-flex bd-highlight">
										<div class="img_cont">
											<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
											<span class="online_icon"></span>
										</div>
										<div class="user_info">
											<span><?php echo $name; ?></span>
											<p>Online</p>
										</div>
									</div>
								</a>                             
                                </li>
                                <?php
                            }
                        }
                        ?>
						</ui>
					</div>
					<div class="card-footer"></div>
				</div>
            </div>
				<div class="col-md-8 col-xl-6 chat">
					<div class="card">
						<div class="card-header msg_head">
						<?php
						if(isset($_GET['recipient_id'])){
							$recipient_id = $_GET['recipient_id'];
							$sql = "SELECT info_id, firstname, lastname FROM user_info WHERE info_id = $recipient_id LIMIT 1";
							$result = mysqli_query($conn, $sql);
	
							if($result && mysqli_num_rows($result) > 0){
								$row = mysqli_fetch_assoc($result);
								$user_id = $row['info_id'];
								$firstname = $row['firstname'];
								$lastname = $row['lastname'];
								$name = $firstname . ' ' . $lastname;
						}
						?>
						<div class="d-flex bd-highlight">
							<div class="img_cont">
								<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
								<span class="online_icon"></span>
							</div>
							<div class="user_info">
								<span><?php echo $name; ?></span>
								<p>1767 Messages</p>
							</div>
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

										// Convert time to Unix timestamp
										$message_time = strtotime($time);
										$current_time = time();

										// Check if message was sent today
										if(date('Y-m-d', $message_time) == date('Y-m-d', $current_time)) {
											$formatted_time = "Today " . date('H:i', $message_time);
										} else {
											$formatted_time = date('Y-m-d H:i', $message_time);
										}

										if($sent_id == $sender_id && $received_id == $receiver_id){
											?>
											<div class="d-flex justify-content-end mb-4">
												<div class="msg_cotainer_send">
													<?php echo $message_content; ?>
													<span class="msg_time_send"><?php echo $formatted_time; ?></span>
												</div>
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
												<div class="msg_cotainer">
													<?php echo $message_content; ?>
													<span class="msg_time"><?php echo $formatted_time; ?></span>
												</div>
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
										if(!empty($_POST['txtChat'])){
											$message = $_POST['txtChat'];
											date_default_timezone_set('Asia/Singapore');
											$localDatetime = date('Y-m-d H:i:s');

											$message = mysqli_real_escape_string($conn, $message);

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
                            <form action=" " method="POST">
							<div class="input-group">
								<div class="input-group-append">
									<span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
								</div>
								<textarea name="txtChat" class="form-control type_msg" placeholder="Type your message..."></textarea>
								<div class="input-group-append">
									<button type="submit" name="btnSend" class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></button>
								</div>
							</div>
                        </form>
						</div>
					</div>
				</div>
			</div>
		</div>
</body>
<script>
  // Scroll to the bottom of the div
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<?php
include('includes/footer.php');
?>
