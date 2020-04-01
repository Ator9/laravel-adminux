<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dd">Panel</a>
        <div>
            <a href="" class="mr-1"><button type="button" class="navbar-toggler btn btn-warning p-2">44444</button></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item{% if nav == 'home'%} active{% endif %}">
                    <a class="nav-link" href="">Home</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item active" href="">Cat</a>
                        <a class="dropdown-item active" href="">Cat</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Minerals</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown03">
                        <a class="dropdown-item" href="4">ddddd</a>
                        <a class="dropdown-item" href="4">ddddd</a>
                    </div>
                </li>
                <li class="nav-item{% if nav == 'report'%} active{% endif %}">
                    <a class="nav-link" href="">adaddasd</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="get" action="">
                <input class="form-control form-control-sm mr-sm-2" name="search" type="text" placeholder="..." value="Search" aria-label="Search" required>
                <button class="btn btn-warning btn-sm my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav><br><br><br>
