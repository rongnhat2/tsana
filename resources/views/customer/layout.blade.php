@extends('customer.template')
 
@section('body')

	<aside>
		<div class="top-wrapper">
			<div class="top-logo">
				Tsana
			</div>
		</div>
		<div class="nav-wrapper">
			<div class="nav-item is-active">
				<i class="fas fa-home"></i> Home
			</div>
			<div class="nav-item">
				<i class="fas fa-tasks"></i> My Task
			</div>
			<div class="nav-item">
				<i class="fas fa-users"></i> Team
			</div> 
		</div>
		<div class="product-wrapper">
			<div class="product-main-wrapper">
				<div class="product-title">
					Project
				</div> 
				<div class="product-create" modal-full-control="Project">
					<i class="fas fa-plus"></i>
				</div>
			</div>
			<div class="collab-main-wrapper">
				<div class="collab-list">
					
				</div>
				<div class="collab-create" modal-control="Collab">
					<i class="fas fa-plus m-r-5"></i>Invite 
				</div>
			</div>
			<div class="project-main-wrapper">
				<div class="project-list">
					<div class="project-item project-public">
						<div class="project-icon"></div>
						<div class="project-name">
							Test
						</div> 
						<div class="project-action"> 
						</div>
					</div> 
					<div class="project-item project-private">
						<div class="project-icon"></div>
						<div class="project-name">
							Test Private
						</div>
						<div class="project-action">
							<i class="fas fa-lock"></i>
						</div>
					</div> 
				</div>
			</div>
		</div>		
	</aside>
	@yield('content')
	@yield('modal')
@endsection()