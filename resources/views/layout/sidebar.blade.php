<div class="sidebar" data-color="azure" data-image="{{ asset('admin/img/full-screen-image-3.jpg') }}">
    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    <div class="logo">
        Web truyện
    </div>

    <div class="sidebar-wrapper">

        <div class="user">
            <div class="info">
                @auth
                <div class="photo">
                    <img src="{{ auth()->user()->avatar ?? asset('img/no_face.png') }}" />
                </div>

                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
						<span>
							{{ auth()->user()->name }}
	                        <b class="caret"></b>
						</span>
                    <span style="margin-top: 4px">
                        {{ auth()->user()->level->name }}
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
                <a data-toggle="collapse" href="#userHandle">
                    <i class="pe-7s-users"></i>
                    <p>Xử lý người dùng
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="userHandle">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('admin.levels.index') }}">
                                <span class="sidebar-mini">Cb</span>
                                <span class="sidebar-normal">Cấp bậc</span>
                            </a>
                        </li>
                        <li>
                            <a href="../forms/regular.html">
                                <span class="sidebar-mini">Nd</span>
                                <span class="sidebar-normal">Người dùng</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#storiesHandle">
                    <i class="pe-7s-note2"></i>
                    <p>Xử lý truyện
                       <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="storiesHandle">
                    <ul class="nav">
                        <li>
                            <a href="../forms/regular.html">
                                <span class="sidebar-mini">TL</span>
                                <span class="sidebar-normal">Thể loại</span>
                            </a>
                        </li>
                        <li>
                            <a href="../forms/extended.html">
                                <span class="sidebar-mini">Tr</span>
                                <span class="sidebar-normal">Truyện</span>
                            </a>
                        </li>
                        <li>
                            <a href="../forms/validation.html">
                                <span class="sidebar-mini">Ch</span>
                                <span class="sidebar-normal">Chương truyện</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
