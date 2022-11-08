<header class="desktop">
    <section class="header__top">
        <div class="container">
            <ul class="header__top__nav">
                <li class="header__top__logo">
                    <a href="">
                        <img src="./img/logo.png" alt="">
                    </a>
                </li>
                <li class="header__top__dark_mode dark__btn">
                    <i class="fa-regular fa-lightbulb"></i>
                </li>
                <li class="header__top__dark_mode light__btn">
                    <i class="fa-sharp fa-solid fa-lightbulb"></i>
                </li>
                <li class="header__top__search">
                    <form action="" method="get">
                        <input type="search" placeholder="nhập truyện cần tìm">
                        <button>
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </li>
                <li class="header__top__info header__top__info--close">
                    <!-- <a class="btn btn-primary top__info__register">Đăng ký</a>
                    <a class="btn btn-primary mx-3 top__info__login">Đăng nhập</a> -->
                    <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle border info" data-toggle="dropdown">
                            <img src="./img/icon.png" class="avatar rounded-circle" alt="">
                            Nguyễn Thị Bảo Link
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Another link</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <section class="header__bottom" id="navDesktop">
        <div class="container">
            <ul class="header__bottom__nav">
                <li><a href="">Trang chủ</a></li>
                <li>
                    <a href="#">Thể loại <i class="fa-solid fa-caret-down"></i></a>
                    <nav class="header__bottom__subnav">
                        <li><a href=""> Ngôn Tình</a></li>
                        <li><a href=""> Xuyên Không</a></li>
                        <li><a href=""> Năn nỉ</a></li>
                        <li><a href=""> Sống lại</a></li>
                        <li><a href=""> Trọng sinh</a></li>
                    </nav>
                </li>
                <li><a href="#">Xếp hạng <i class="fa-solid fa-caret-down"></i></a></li>
                <li><a href="">Tìm truyện</a></li>
                <li><a href="">Lịch sử</a></li>
                <li><a href="">Theo dõi</a></li>
                <li><a href="">Tin tức</a></li>
            </ul>
        </div>
    </section>
</header>
<header class="mobile">
    <section class="header__top">
        <div class="container">
            <ul class="header__top__nav">
                <li class="header__top__logo">
                    <a href="">
                        <img src="./img/icon.png" alt="">
                    </a>
                </li>
                <li class="header__top__dark_mode dark__btn">
                    <i class="fa-regular fa-lightbulb"></i>
                </li>
                <li class="header__top__dark_mode light__btn">
                    <i class="fa-sharp fa-solid fa-lightbulb"></i>
                </li>
                <li class="header__top__info header__top__info--close">
                    <!-- <a class="btn btn-primary btn-sm top__info__register">Đăng ký</a>
                    <a class="btn btn-primary btn-sm mx-2 top__info__login">Đăng nhập</a> -->
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle border info" data-toggle="dropdown">
                            <img src="./img/icon.png" class="avatar rounded-circle" alt="">
                            Nguyễn Thị Bảo Link
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Link 3</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Another link</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <section class="header__middle">
        <div class="header__middle__search">
            <form action="" method="get">
                <input type="search" placeholder="nhập truyện cần tìm">
                <button>
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>
    </section>
    <section class="header__bottom" id="navMobile">
        <input type="checkbox" id="showMenuBarCheck">
        <div class="index">
            <a href="">Trang chủ</a>
            <label for="showMenuBarCheck" class="bars nav__btn">
                <i class="fa-solid fa-list"></i>
            </label>
            <label for="showMenuBarCheck" class="close nav__btn">
                <i class="fa-solid fa-rectangle-xmark"></i>
            </label>
        </div>
        <ul class="header__bottom__nav">
            <li>
                <a class="show__subnav__btn">Thể loại
                    <i class="fa-solid fa-caret-down"></i>
                    <i class="fa-solid fa-caret-up"></i>
                </a>
                <ul class="header__bottom__subnav">
                    <li><a href=""> Ngôn Tình</a></li>
                    <li><a href=""> Xuyên Không</a></li>
                    <li><a href=""> Năn nỉ</a></li>
                    <li><a href=""> Sống lại</a></li>
                    <li><a href=""> Trọng sinh</a></li>
                    <li><a href=""> Trọng sinh</a></li>
                    <li><a href=""> Trọng sinh</a></li>
                </ul>
            </li>
            <li><a class="show__subnav__btn">Xếp hạng
                    <i class="fa-solid fa-caret-down"></i>
                    <i class="fa-solid fa-caret-up"></i>
                </a>
            </li>
            <li><a href="">Tìm truyện</a></li>
            <li><a href="">Lịch sử</a></li>
            <li><a href="">Theo dõi</a></li>
            <li><a href="">Tin tức</a></li>
        </ul>
    </section>
</header>