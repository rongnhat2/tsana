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
					<div class="auth-action-wrapper">
						<div class="auth-action-item">Profile</div>
						<div class="auth-action-item action-logout" atr="Logout">Logout</div>
					</div>
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
									<input type="text" class="create-content create-content-task" placeholder="Click here to add a task...">
								</div>
								<div class="task-list-item is-scrolling">
									
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
							<div class="tab-body">
								<div class="project-list-group is-scrolling">
									<div class="project-item project-create" modal-full-control="Project">
										<div class="project-icon">
											<i class="fas fa-plus"></i>
										</div>
										<div class="project-description"> 
											<div class="project-task">Create Project</div>
										</div>
									</div>
									<div class="project-item">
										<div class="project-icon">
											
										</div>
										<div class="project-description">
											<div class="project-name">projetc name</div>
											<div class="project-task">2 task</div>
										</div>
									</div> 
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


    <div class="I-modal modal-collab" modal-block="Collab" id="invite-form">
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
					<div class="notification-wrapper"> </div>	
					<div class="form-wrapper">
						<label for="">Email</label>
						<input type="text" class="data-email" placeholder="Email">
					</div>
					<div class="form-wrapper button-action">
						<a href="#" class="button submit send-invite" atr="Push">Invite</a> 
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="I-modal modal-task" modal-block="Task" id="modal-task">
        <div class="modal-wrapper">
            <div class="modal-dialog">
            	<div class="dialog-header">
            		<div class="modal-title">
            			<div class="mark-done-wrapper">
            				<i class="fas fa-check"></i><span>Mark Complete</span>
            			</div>	
            		</div>
            		<div class="modal-dismiss" modal-close="Task">
            			<i class="fas fa-times"></i>
            		</div>
            	</div>
                <div class="dialog-content">
					<div class="notification-wrapper">

					</div>	 
					<div class="task-name">
						{{-- <div class="update-name"><i class="fas fa-check"></i></div> --}}
						<input type="text" class="data-name">
					</div>
					<div class="task-description-list is-scrolling">
						<div class="task-row">
							<div class="task-item">
								<div class="item-title">Assignee</div>
								<input type="hidden" class="data-assign">
								<div class="item-content no-assign">
									<div class="user-assign">
										<div class="user-avatar">
											<i class="fas fa-user"></i>
										</div>
										<div class="user-name">
											No assignee
										</div>
										<div class="user-list-team is-scrolling">
											 
										</div>
									</div>
									<div class="user-wrapper">
										<div class="user-avatar">
											
										</div>
										<div class="user-name">
											
										</div>
										<div class="user-action">
											<i class="fas fa-times"></i>
										</div>
									</div>
									<div class="user-section-wrapper">
										{{-- <select name="">
											<option value="">123</option> 
										</select> --}}
									</div>
								</div>
							</div>
						</div>
						<div class="task-row">
							<div class="task-item">
								<div class="item-title">Start Date</div>
								<div class="item-content"> 
									<input type="date" class="data-start">
								</div>
							</div>
							<div class="task-item">
								<div class="item-title">End Date</div>
								<div class="item-content"> 
									<input type="date" class="data-end">
								</div>
							</div>
						</div> 
						<div class="task-row">
							<div class="task-item">
								<div class="item-title">Project</div>
								<div class="item-content"> 
									<!-- <div class="project-assign">
										Assign Project
										<div class="project-list-wrapper">
											<div class="project-item">test</div>
											<div class="project-item">test</div>
										</div>
									</div> -->
									{{-- <div class="project-select-wrapper">
										<div class="project-name">
											test
										</div>
										<div class="project-section"> 
											<select name="">
												<option value="">123</option> 
											</select>
										</div>
										<div class="project-action">
											<i class="fas fa-times"></i>
										</div>
									</div> --}}
								</div>
							</div>
							<div class="task-item">
								<div class="item-title">Priority</div>
								<div class="item-content"> 
									<div class="priority-wrapper">
										<select name="" class="data-priority">
											<option value="0">----</option>
											<option value="1">Low</option>
											<option value="2">Medium</option>
											<option value="3">High</option> 
										</select>
									</div>		
								</div>
							</div> 
						</div> 
						<div class="task-row fulltask">
							<div class="task-item ">
								<div class="item-title">Description</div>
								<div class="item-content"> 
									<textarea name="" id="" placeholder="Add more detail" class="data-description"></textarea>
								</div>
							</div>
						</div>
						<div class="task-row fulltask">
							<div class="task-item ">
								<div class="item-title">Sub task</div>
								<div class="item-content"> 
									<div class="sub-task-list">
										<div class="item-list">
											
										</div>		
										<div class="sub-task-item">
											<div class="sub-task-done"></div> 
											<input type="text" class="input-create-subtask" placeholder="Create New Sub Task">
										</div>
									</div>	
									{{-- <div class="sub-task-create">
										<i class="fas fa-plus m-r-5"></i>Create Sub Task
									</div>	 --}}
								</div>
							</div>
						</div>
					</div>
                </div>
                <div class="dialog-footer">
                	<button type="button" class="btn-save">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="I-full-modal modal-project" modal-full-block="Project">
    	<div class="modal-wrapper">
            <div class="modal-dialog">
            	<div class="dialog-header">
            		<div class="modal-title">
            			Create Project
            		</div>
            		<div class="modal-dismiss" modal-full-close="Project">
            			<i class="fas fa-times"></i>
            		</div>
            	</div>
                <div class="dialog-content">
					<div class="modal-project-wrapper">
						<div class="notification-wrapper">

						</div>	
						<div class="form-wrapper">
						 	<div class="sprint-list">
						 		<div class="sprint-item">
						 			One Sprint
						 		</div>
						 		<div class="sprint-item">
						 			Multi Sprint
						 		</div>
						 	</div>
						 </div>
						<div class="form-wrapper">
							<label for="">Project name</label>
							<input type="text" placeholder="Project name">
						</div>
						<div class="form-wrapper">
							<label for="">Project privacy</label>
							<select name="" id="">
								<option value="0">Public</option>
								<option value="1">Private</option>
							</select>
						</div>
						<div class="form-wrapper button-action">
							<a href="#" class="button submit">Create</a> 
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection()
 
@section('js')
<script type="text/javascript" src="{{ asset('customer/assets/js/page/home.js') }}"></script>
@endsection()