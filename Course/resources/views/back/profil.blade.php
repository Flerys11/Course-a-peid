<li class="nav-item navbar-dropdown dropdown-user dropdown">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            <img src="../assets/img/avatars/p.jpg" alt class="w-px-40 h-auto rounded-circle" />
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="#">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                            <img src="../assets/img/avatars/p.jpg" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        @auth

                            <span class="fw-semibold d-block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                            <small class="text-muted">{{ \Illuminate\Support\Facades\Auth::user()->role }}</small>
                        @endauth
                    </div>
                </div>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a class="dropdown-item" href="#">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">My Profile</span>
            </a>
        </li>

        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
            </a>
            <form id="logout-form" action="{{ route('auth.logout') }}" method="post" style="display: none;">
                @method("delete")
                @csrf
                <button class="btn btn-primary">Se Déconnecter</button>
            </form>
        </li>

    </ul>
</li>
