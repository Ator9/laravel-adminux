<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dd">Panel</a>
        <div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto mr-auto">
                <li class="nav-item{% if nav == 'home'%} active{% endif %}">
                    <a class="nav-link" href="">{{ __('adminux.home') }}</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('adminux.products') }}</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item active" href="">Cat</a>
                        <a class="dropdown-item active" href="">Cat</a>
                    </div>
                </li>
                <li class="nav-item{% if nav == 'report'%} active{% endif %}">
                    <a class="nav-link" href="">{{ __('adminux.account') }}</a>
                </li>
            </ul>
            <div class="row">
                <span class="text-warning mx-3">{{ auth('adminuxpanel')->user()->email }}</span>
                <a class="text-secondary" href="{{ asset($prefix.'/logout') }}"><span data-feather="log-out"></span></a>
            </div>
        </div>
    </div>
</nav><br><br><br>
