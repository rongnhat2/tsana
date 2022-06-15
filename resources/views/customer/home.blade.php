@extends('customer.layout') 
@section('title', "Index")
 
@section('content')
	<section class="content-wrapper is-scrolling">
		<header>
			<div class="page-title">
				Home
			</div>
			<div class="customer-action">
				<div class="customer-create">
					<i class="fas fa-plus"></i>
				</div>
				<div class="customer-auth">
					L
				</div>
			</div>	
		</header>
		<main class="I-main">
			<div class="main-wrapper">
				<div class="main-heading">
					
				</div>
				<div class="main-body">
					<div class="tab-block w-50">
						<div class="tab-wrapper">
							<div class="tab-header">
								<div class="tab-name">
									My Priorities
								</div>
								<div class="tab-control-wrapper">
									<div class="tab-control-item is-active">
										Upcoming
									</div>
									<div class="tab-control-item">
										Overdue
									</div>
									<div class="tab-control-item">
										Completed
									</div>
								</div>
							</div>
							<div class="tab-body">
								<div class="task-create">
									<div class="create-icon"><i class="fas fa-plus"></i></div>
									<input type="text" class="create-content" placeholder="Click here to add a task...">
								</div>
								<div class="task-list-item is-scrolling">
									<div class="task-item">
										<div class="task-done"><i class="fas fa-check-circle"></i></div>
										<div class="task-name">123</div>
									</div>
									<div class="task-item">
										<div class="task-done"><i class="fas fa-check-circle"></i></div>
										<div class="task-name">123</div>
									</div>
									<div class="task-item">
										<div class="task-done"><i class="fas fa-check-circle"></i></div>
										<div class="task-name">123</div>
									</div>
									<div class="task-item">
										<div class="task-done"><i class="fas fa-check-circle"></i></div>
										<div class="task-name">123</div>
									</div>
									<div class="task-item">
										<div class="task-done"><i class="fas fa-check-circle"></i></div>
										<div class="task-name">123</div>
									</div>
									<div class="task-item">
										<div class="task-done"><i class="fas fa-check-circle"></i></div>
										<div class="task-name">123</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-block w-50">
						<div class="tab-wrapper">
							<div class="tab-header">
								<div class="tab-name">
									Project
								</div> 
							</div>
						</div>
					</div>
					<div class="tab-block w-100">
						<div class="tab-wrapper">
							<div class="tab-header">
								<div class="tab-name">
									Collaborator
								</div> 
							</div>
							<div class="tab-body">
								<div class="collab-list is-scrolling "> 
									<div class="collab-item-block">
										<div class="collab-item">
											
										</div>
									</div>
									<div class="collab-item-block">
										<div class="collab-item">
											
										</div>
									</div>
									<div class="collab-item-block">
										<div class="collab-item">
											
										</div>
									</div>
									<div class="collab-item-block">
										<div class="collab-item">
											
										</div>
									</div>
									<div class="collab-item-block">
										<div class="collab-item">
											
										</div>
									</div>
									<div class="collab-item-block">
										<div class="collab-item">
											
										</div>
									</div>
									<div class="collab-item-block">
										<div class="collab-item">
											
										</div>
									</div>
									<div class="collab-item-block">
										<div class="collab-item">
											
										</div>
									</div>
									<div class="collab-item-block">
										<div class="collab-item create-block" modal-control="Collab">
											<i class="fas fa-plus-circle"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>  
	</section>

    <div class="I-modal modal-collab" modal-block="Collab">
        <div class="modal-wrapper">
            <div class="modal-dialog">
            	<div class="dialog-header">
            		<div class="modal-title">
            			Invite people to Team
            		</div>
            		<div class="modal-dismiss" modal-close="Collab">
            			<i class="fas fa-times"></i>
            		</div>
            	</div>
                <div class="dialog-content">
					<div class="notification-wrapper">
						<div class="notification-group">
							<div class="notification-item error">nothing</div>
							<div class="notification-item success">nothing</div>
						</div>	
					</div>	
					<div class="form-wrapper">
						<label for="">Email</label>
						<input type="text" placeholder="Email">
					</div>
					<div class="form-wrapper button-action">
						<a href="#" class="button submit">Invite</a> 
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection()
 
@section('js')
<script type="text/javascript" src="{{ asset('customer/assets/js/page/auth.js') }}"></script>
@endsection()