<div class="card-block">
    <a class="d-flex flex-row align-items-center justify-content-center" target="_blank" href="{{ $route }}">
        <div class="col-auto p-0">
            <img class="img-fluid" src="{{ getUserProfilePicture($user->id) }}" alt="dashboard-user">
        </div>
        <div class="col">
            <h5>{{ $user->name }}</h5>
            <span><i class="fas fa-map-marker-alt f-18 m-r-5"></i>{{ $user->email }}</span>
        </div>
    </a>
</div>
