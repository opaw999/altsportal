		<!-- begin #content -->
		<div id="content" class="content content-full-width inbox">
			<!-- begin vertical-box -->
			<div class="vertical-box with-grid">
				<!-- begin vertical-box-column -->
				<div class="vertical-box-column width-200 bg-silver hidden-xs">
					<!-- begin vertical-box -->
					<div class="vertical-box">
						<!-- begin wrapper -->
						<div class="wrapper bg-silver text-center">
							<a href="javascript:;" class="btn btn-success p-l-40 p-r-40 btn-sm">
								Compose
							</a>
						</div>
						<!-- end wrapper -->
						<!-- begin vertical-box-row -->
						<div class="vertical-box-row">
							<!-- begin vertical-box-cell -->
							<div class="vertical-box-cell">
								<!-- begin vertical-box-inner-cell -->
								<div class="vertical-box-inner-cell">
									<!-- begin scrollbar -->
									<div data-scrollbar="true" data-height="100%">
										<!-- begin wrapper -->
										<div class="wrapper p-0">
											<div class="nav-title"><b>FOLDERS</b></div>
											<ul class="nav nav-inbox">
												<li class="active"><a href="<?php echo base_url(); ?>"><i class="fa fa-inbox fa-fw m-r-5"></i> Inbox <span class="badge pull-right count_unread_msg"><?php echo $this->email_model->count_unread_msg(); ?></span></a></li>
												<li><a href="javascript:;"><i class="fa fa-envelope fa-fw m-r-5"></i> Sent</a></li>
												<!-- <li><a href="javascript:;"><i class="fa fa-pencil-alt fa-fw m-r-5"></i> Drafts</a></li> -->
												<li><a href="javascript:;"><i class="fa fa-trash fa-fw m-r-5"></i> Bin</a></li>
											</ul>
										</div>
										<!-- end wrapper -->
									</div>
									<!-- end scrollbar -->
								</div>
								<!-- end vertical-box-inner-cell -->
							</div>
							<!-- end vertical-box-cell -->
						</div>
						<!-- end vertical-box-row -->
					</div>
					<!-- end vertical-box -->
				</div>
				<!-- end vertical-box-column -->
				<!-- begin vertical-box-column -->
				<input type="hidden" name="msgId" value="">
				<input type="hidden" name="prev_page" value="0">
				<input type="hidden" name="nxt_page" value="10">
				<input type="hidden" name="previous_page" value="">
				<input type="hidden" name="next_page" value="">
				<input type="hidden" class="row_position" value="">
				<input type="hidden" name="total_msg" value="<?php echo $this->email_model->count_total_msg(); ?>">
				<div class="vertical-box-column bg-white">
					<!-- begin vertical-box -->
					<div class="vertical-box view_message">
						<!-- begin wrapper -->
						<div class="wrapper bg-silver-lighter">
							<!-- begin btn-toolbar -->
							<div class="btn-toolbar">
								<div class="btn-group m-r-5">
									<a href="javascript:;" class="p-t-5 pull-left m-r-3 m-t-2" data-click="email-select-all">
										<i class="far fa-square fa-fw text-muted f-s-16 l-minus-2"></i>
									</a>
								</div>
								<!-- begin btn-group -->
								<div class="btn-group dropdown m-r-5">
									<button class="btn btn-white btn-sm" data-toggle="dropdown">
										View All <span class="caret m-l-3"></span>
									</button>
									<ul class="dropdown-menu text-left text-sm">
										<li class="active"><a href="javascript:;"><i class="fa fa-circle f-s-10 fa-fw m-r-5"></i> All</a></li>
										<li><a href="javascript:;"><i class="fa fa-circle f-s-10 fa-fw m-r-5"></i> Unread</a></li>
									</ul>
								</div>
								<!-- end btn-group -->
								<!-- begin btn-group -->
								<div class="btn-group m-r-5">
									<button class="btn btn-sm btn-white refresh"><i class="fa fa-redo f-s-14 t-plus-1"></i></button>
								</div>
								<!-- end btn-group -->
								<!-- begin btn-group -->
								<div class="btn-group">
									<button class="btn btn-sm btn-white hide delete_email" data-email-action="delete"><i class="fa t-plus-1 fa-trash f-s-14 m-r-3"></i> <span class="hidden-xs">Delete</span></button>
								</div>
								<!-- end btn-group -->
								<!-- begin btn-group -->
								<div class="btn-group ml-auto">
									<button class="btn btn-white btn-sm previous">
										<i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
									</button>
									<button class="btn btn-white btn-sm next">
										<i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
									</button>
								</div>
								<!-- end btn-group -->
							</div>
							<!-- end btn-toolbar -->
						</div>
						<!-- end wrapper -->
						<!-- begin vertical-box-row -->
						<div class="vertical-box-row">
							<!-- begin vertical-box-cell -->
							<div class="vertical-box-cell">
								<!-- begin vertical-box-inner-cell -->
								<div class="vertical-box-inner-cell">
									<!-- begin scrollbar -->
									<div data-scrollbar="true" data-height="100%">
										<!-- begin list-email -->
										<ul class="list-group list-group-lg no-radius list-email messages">
											
										</ul>
										<!-- end list-email -->
									</div>
									<!-- end scrollbar -->
								</div>
								<!-- end vertical-box-inner-cell -->
							</div>
							<!-- end vertical-box-cell -->
						</div>
						<!-- end vertical-box-row -->
						<!-- begin wrapper -->
						<div class="wrapper bg-silver-lighter clearfix">
							<div class="btn-group pull-right">
								<button class="btn btn-white btn-sm previous">
									<i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
								</button>
								<button class="btn btn-white btn-sm next">
									<i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
								</button>
							</div>
							<div class="m-t-5 text-inverse f-w-600 count_total_msg"><?php echo $this->email_model->count_total_msg(); ?> messages</div>
						</div>
						<!-- end wrapper -->
					</div>

					<div class="vertical-box view_message_detail">
						<!-- begin wrapper -->
						<div class="wrapper bg-silver-lighter clearfix">
							<div class="pull-left">
								<div class="btn-group m-r-5">
									<a href="javascript:;" class="btn btn-white btn-sm back_to_page"><i class="fa fa-reply f-s-14 m-r-3 m-r-xs-0 t-plus-1"></i> <span class="hidden-xs">Back</span></a>
								</div>
								<div class="btn-group m-r-5">
									<a href="javascript:;" class="btn btn-white btn-sm delete_spec_msg"><i class="fa fa-trash f-s-14 m-r-3 m-r-xs-0 t-plus-1"></i> <span class="hidden-xs">Delete</span></a>
								</div>
							</div>
							<div class="pull-right">
								<div class="btn-group">
									<a href="javascript:;" class="btn btn-white btn-sm previous_details"><i class="fa fa-arrow-up f-s-14 t-plus-1"></i></a>
									<a href="javascript:;" class="btn btn-white btn-sm next_details"><i class="fa fa-arrow-down f-s-14 t-plus-1"></i></a>
								</div>
							</div>
						</div>
						<!-- end wrapper -->
						<!-- begin vertical-box-row -->
						<div class="vertical-box-row">
							<!-- begin vertical-box-cell -->
							<div class="vertical-box-cell">
								<!-- begin vertical-box-inner-cell -->
								<div class="vertical-box-inner-cell">
									<!-- begin scrollbar -->
									<div data-scrollbar="true" data-height="100%">
										<!-- begin wrapper -->
										<div class="wrapper view_details">
											
										</div>
										<!-- end wrapper -->
									</div>
									<!-- end scrollbar -->
								</div>
								<!-- end vertical-box-inner-cell -->
							</div>
							<!-- end vertical-box-cell -->
						</div>
						<!-- end vertical-box-row -->
						<!-- begin wrapper -->
						<div class="wrapper bg-silver-lighter text-right clearfix">
							<div class="btn-group">
								<a href="javascript:;" class="btn btn-white btn-sm previous_details"><i class="fa fa-arrow-up"></i></a>
								<a href="javascript:;" class="btn btn-white btn-sm next_details"><i class="fa fa-arrow-down"></i></a>
							</div>
						</div>
						<!-- end wrapper -->
					</div>
					<!-- end vertical-box -->
				</div>
				<!-- end vertical-box-column -->
			</div>
			<!-- end vertical-box -->
		</div>
		<!-- end #content -->