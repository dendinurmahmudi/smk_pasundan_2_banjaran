@extends('master')
@section('judul','Pesan')
@section('class','ti-email fa-fw')
@section('label','Pesan')
@extends('Admin/sidebar')
@section('konten')
<div class="chat-main-box">
	<!-- .chat-left-panel -->
	<div class="chat-left-aside">
		<div class="open-panel"><i class="ti-angle-right"></i></div>
		<div class="chat-left-inner">
			<div class="form-material">
				<input class="form-control p-20" type="text" placeholder="Search Contact">
			</div>
			<ul class="chatonline style-none ">
				<div class="customvtab">
					<ul class="nav tabs-vertical" id="slimtest3">
						<li class="tab active">
							<a data-toggle="tab" href="#vhome3" aria-expanded="true"><img src="{{ asset('assets/templates/plugins/images/users/varun.jpg') }}" alt="user-img" class="img-circle"><span>Tanos</span></a>
						</li>
						<li class="tab">
							<a data-toggle="tab" href="#vprofile3" aria-expanded="false"> <span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Profile</span> </a>
						</li>
						<li class="tab">
							<a aria-expanded="false" data-toggle="tab" href="#vmessages3"> <span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Messages</span> </a>
						</li>
						<li class="tab active">
							<a data-toggle="tab" href="#vhome3" aria-expanded="true"> <span class="visible-xs"><i class="ti-home"></i></span> <span class="hidden-xs">Home</span> </a>
						</li>
						<li class="tab">
							<a data-toggle="tab" href="#vprofile3" aria-expanded="false"> <span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Profile</span> </a>
						</li>
						<li class="tab">
							<a aria-expanded="false" data-toggle="tab" href="#vmessages3"> <span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Messages</span> </a>
						</li>
						<li class="tab active">
							<a data-toggle="tab" href="#vhome3" aria-expanded="true"> <span class="visible-xs"><i class="ti-home"></i></span> <span class="hidden-xs">Home</span> </a>
						</li>
						<li class="tab">
							<a data-toggle="tab" href="#vprofile3" aria-expanded="false"> <span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Profile</span> </a>
						</li>
						<li class="tab">
							<a aria-expanded="false" data-toggle="tab" href="#vmessages3"> <span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Messages</span> </a>
						</li>
					</ul>
				</div>
				<li class="p-20"></li>
			</ul>
		</div>
	</div>
	<!-- .chat-left-panel -->
	<!-- .chat-right-panel -->
	<div class="tab-content">
		<div id="vhome3" class="tab-pane active">
			<div class="chat-right-aside">
					<div class="chat-box" id="slimtest1">
						<ul class="chat-list slimscroll p-t-30">
							<li>
								<div class="chat-image"> <img alt="male" src="{{ asset('assets/templates/plugins/images/users/ritesh.jpg') }}"> </div>
								<div class="chat-body">
									<div class="chat-text">
										<h4>Ritesh</h4>
										<p> Hi, Genelia how are you and my son? </p> <b>10.00 am</b> </div>
									</div>
								</li>
								<li class="odd">
									<div class="chat-image"> <img alt="Female" src="{{ asset('assets/templates/plugins/images/users/genu.jpg') }}"> </div>
									<div class="chat-body">
										<div class="chat-text">
											<h4>Genelia</h4>
											<p> Hi, How are you Ritesh!!! We both are fine sweetu. </p> <b>10.03 am</b> </div>
										</div>
									</li>
									<li>
										<div class="chat-image"> <img alt="male" src="{{ asset('assets/templates/plugins/images/users/ritesh.jpg') }}"> </div>
										<div class="chat-body">
											<div class="chat-text">
												<h4>Ritesh</h4>
												<p> Oh great!!! just enjoy you all day and keep rocking</p> <b>10.05 am</b> </div>
											</div>
										</li>
										<li class="odd">
											<div class="chat-image"> <img alt="Female" src="{{ asset('assets/templates/plugins/images/users/genu.jpg') }}"> </div>
											<div class="chat-body">
												<div class="chat-text">
													<h4>Genelia</h4>
													<p> Your movei was superb and your acting is mindblowing </p> <b>10.07 am</b> </div>
												</div>
											</li>
											<li>
												<div class="chat-image"> <img alt="male" src="{{ asset('assets/templates/plugins/images/users/ritesh.jpg') }}"> </div>
												<div class="chat-body">
													<div class="chat-text">
														<h4>Ritesh</h4>
														<p> Oh great!!! just enjoy you all day and keep rocking</p> <b>10.05 am</b> </div>
													</div>
												</li>
												<li class="odd">
													<div class="chat-image"> <img alt="Female" src="{{ asset('assets/templates/plugins/images/users/genu.jpg') }}"> </div>
													<div class="chat-body">
														<div class="chat-text">
															<h4>Genelia</h4>
															<p> Your movei was superb and your acting is mindblowing </p> <b>10.07 am</b> </div>
														</div>
													</li>
												</ul>
											</div>
											<div class="row send-chat-box">
												<div class="col-sm-12">
													<textarea class="form-control" placeholder="Type your message"></textarea>
													<div class="custom-send">
														<button class="btn btn-danger btn-rounded" type="button" >Send</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!--  -->

									<div id="vprofile3" class="tab-pane">
										<div class="chat-right-aside">
											<div class="chat-box" id="slimtest2">
												<div class="chat-main-header">
													<div class="p-20 b-b">
														<h3 class="box-title">Chat Message</h3> </div>
													</div>
													<div class="chat-box">
														<ul class="chat-list slimscroll p-t-30">
															<li>


																jajaj
															</div>
														</div>
														<div class="row send-chat-box">
															<div class="col-sm-12">
																<textarea class="form-control" placeholder="Type your message"></textarea>
																<div class="custom-send">
																	<button class="btn btn-danger btn-rounded" type="button" >Send</button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- .chat-right-panel -->
											</div>
											<script type="text/javascript">

												$('#slimtest1').slimScroll({
													height: '350px'
												});
												$('#slimtest2').slimScroll({
													height: '350px'
												});
												$('#slimtest3').slimScroll({
													height: '350px'
												});
											</script>
											@endsection