<div class="sidebar" data-color="azure" data-image="../assets/img/full-screen-image-3.jpg">
    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    <div class="logo">
        XXX
    </div>

    <div class="sidebar-wrapper">

        <div class="user">
            <div class="info">
                @auth
                <div class="photo">
                    <img src="{{ auth()->user()->avatar }}" />
                </div>

                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
						<span>
							{{ auth()->user()->name }}
	                        <b class="caret"></b>
						</span>
                </a>

                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a href="#pablo">
                                <span class="sidebar-mini">MP</span>
                                <span class="sidebar-normal">My Profile</span>
                            </a>
                        </li>

                        <li>
                            <a href="#pablo">
                                <span class="sidebar-mini">EP</span>
                                <span class="sidebar-normal">Edit Profile</span>
                            </a>
                        </li>

                        <li>
                            <a href="#pablo">
                                <span class="sidebar-mini">S</span>
                                <span class="sidebar-normal">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </div>

        <ul class="nav">
            <li>
                <a href="{{ route('admin.users.index') }}">
                    <i class="pe-7s-graph"></i>
                    <p>Users</p>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}">
                    <i class="pe-7s-graph"></i>
                    <p>Categories</p>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.stories.index') }}">
                    <i class="pe-7s-graph"></i>
                    <p>Stories</p>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="pe-7s-graph"></i>
                    <p>Student</p>
                </a>
            </li>
        </ul>
    </div>
</div>
