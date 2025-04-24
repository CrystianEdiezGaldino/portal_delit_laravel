<header class="main-header">
    <div class="d-flex align-items-center">
        <h1 class="page-title">{{ $title ?? 'Dashboard' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                @if(isset($breadcrumb))
                    @foreach($breadcrumb as $item)
                        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                            @if(!$loop->last)
                                <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                            @else
                                {{ $item['title'] }}
                            @endif
                        </li>
                    @endforeach
                @endif
            </ol>
        </nav>
    </div>
    <div class="header-actions">
        <div class="dropdown">
            <button class="btn btn-link dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i>
                {{ Auth::user()->nome }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('user.profile') }}">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Sair</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

<style>
    .user-info {
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
        margin: 10px 0;
    }
    .user-info p {
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    .user-info strong {
        color: #495057;
    }
</style>