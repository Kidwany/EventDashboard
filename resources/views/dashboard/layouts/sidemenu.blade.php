
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="https://www.dashboard.hemmtk.com/"><img src="{{asset('general/hemmtk.jpeg')}}" width="80" alt="Aero"><span class="m-l-10"> تطبيق همتك</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="{{adminUrl('profile')}}"><img src="{{asset('dashboard/assets/images/user.png')}}" alt="User"></a>
                    <div class="detail">
                        <h4> {{Auth::user()->name}} </h4>
                        <small>مدير التطبيق</small>
                    </div>
                </div>
            </li>
            <li class="active open"><a href="https://www.dashboard.hemmtk.com/"><i class="zmdi zmdi-home"></i><span>الصفحة الرئيسية</span></a></li>
            @if(auth()->user()->is_approved == 1)
                <li>
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-fire"></i><span>المواسم</span></a>
                    <ul class="ml-menu">
                        <li><a href="{{adminUrl('season')}}">شاهد جميع المواسم</a></li>
                        <li><a href="{{adminUrl('season/create')}}"> موسم جديد </a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>المستخدمين </span></a>
                    <ul class="ml-menu">
                        <li><a href="{{adminUrl('admin')}}">شاهد المستخدمين</a></li>
                        <li><a href="{{adminUrl('admin/create')}}">مستخدم جديد</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-tag"></i><span>الباقات </span></a>
                    <ul class="ml-menu">
                        <li><a href="{{adminUrl('package')}}">شاهد الباقات</a></li>
                        <li><a href="{{adminUrl('package/consumption')}}">تابع استهلاكك</a></li>
                    </ul>
                </li>
            @endif
            {{--<li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-car-wash"></i><span>المغاسل</span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('car-wash')}}">شاهد جميع المغاسل</a></li>
                    <li><a href="{{adminUrl('car-wash/create')}}"> مغسلة جديدة </a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-washing-machine"></i><span>التلميع</span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('car-polish')}}">شاهد جميع محلات التلميع</a></li>
                    <li><a href="{{adminUrl('car-polish/create')}}"> محل تلميع جديد </a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-wrench"></i><span>الخدمات</span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('services')}}">شاهد جميع الخدمات</a></li>
                    <li><a href="{{adminUrl('services?type=wash')}}"> خدمات الغسيل </a></li>
                    <li><a href="{{adminUrl('services?type=polish')}}"> خدمات التلميع </a></li>
                    <li><a href="{{adminUrl('services/create')}}"> خدمة جديدة </a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-car"></i><span>العلامات التجارية</span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('car-brand')}}">شاهد جميع العلامات التجارية</a></li>
                    <li><a href="{{adminUrl('car-brand/create')}}"> علامة تجارية جديدة </a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-truck"></i><span>أحجام السيارات</span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('car-size')}}">شاهد جميع الأحجام</a></li>
                    <li><a href="{{adminUrl('car-size/create')}}"> حجم جديد </a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-colorize"></i><span>ألوان السيارات</span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('car-color')}}">شاهد جميع الألوان</a></li>
                    <li><a href="{{adminUrl('car-color/create')}}"> لون جديد </a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shopping-cart-plus"></i><span>عمليات الحجز</span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('appointments')}}">جميع العمليات</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-notifications"></i><span>الإشعارات</span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('notification')}}">جميع الإشعارات</a></li>
                    <li><a href="{{adminUrl('notification/create')}}">اشعار جديد</a></li>
                </ul>
            </li>
            --}}{{--<li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-money-box"></i><span>التحويلات البنكية</span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('bank-transfer')}}">التحويلات النكية</a></li>
                </ul>
            </li>--}}{{--
            <li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-local-offer"></i><span>العروض </span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('offer')}}"> شاهد العروض السابقة </a></li>
                    <li><a href="{{adminUrl('offer/create')}}"> عرض جديد   </a></li>
                </ul>
            </li>
            --}}{{--<li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-money"></i><span>إعدادات الدفع </span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('payment-setting/1/edit')}}"> ضبط إعدادات الدفع </a></li>
                </ul>
            </li>--}}{{--
            <li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-money-box"></i><span>الرموز الترويجية </span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('promo-code/create')}}"> اضافة رمز ترويجي </a></li>
                    <li><a href="{{adminUrl('promo-code')}}"> شاهد الرموز السابقة </a></li>
                </ul>
            </li>
            --}}{{--<li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-comment-alert"></i><span>الشكاوى و المقترحات </span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('message')}}"> شاهد جميع الرسائل </a></li>
                </ul>
            </li>--}}{{--
            --}}{{--<li>
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-phone"></i><span>عدل بيانات الإتصال</span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('contact/edit')}}">عدل بيانات الإتصال </a></li>
                </ul>
            </li>--}}{{--
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-swap-alt"></i><span>إدارة التطبيق </span></a>
                <ul class="ml-menu">
                    <li><a href="{{adminUrl('admin')}}"> شاهد المديرين  </a></li>
                    <li><a href="{{adminUrl('admin/create')}}">اضف مدير للتطبيق</a></li>
                </ul>
            </li>--}}

            {{--<li><a href="{{adminUrl('logout')}}"><i class="zmdi zmdi-sign-in"></i><span>تسجيل الخروج  </span></a>
            </li>--}}
        </ul>
    </div>
</aside>


{{--<!-- Right Sidebar -->
<aside id="rightsidebar" class="right-sidebar">
    <ul class="nav nav-tabs sm">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#setting"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chat"><i class="zmdi zmdi-comments"></i></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="setting">
            <div class="slim_scroll">
                <div class="card">
                    <h6>Theme Option</h6>
                    <div class="light_dark">
                        <div class="radio">
                            <input type="radio" name="radio1" id="lighttheme" value="light" checked="">
                            <label for="lighttheme">Light Mode</label>
                        </div>
                        <div class="radio mb-0">
                            <input type="radio" name="radio1" id="darktheme" value="dark">
                            <label for="darktheme">Dark Mode</label>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h6>Color Skins</h6>
                    <ul class="choose-skin list-unstyled">
                        <li data-theme="purple"><div class="purple"></div></li>
                        <li data-theme="blue"><div class="blue"></div></li>
                        <li data-theme="cyan"><div class="cyan"></div></li>
                        <li data-theme="green"><div class="green"></div></li>
                        <li data-theme="orange"><div class="orange"></div></li>
                        <li data-theme="blush" class="active"><div class="blush"></div></li>
                    </ul>
                </div>
                <div class="card">
                    <h6>General Settings</h6>
                    <ul class="setting-list list-unstyled">
                        <li>
                            <div class="checkbox rtl_support">
                                <input id="checkbox1" type="checkbox" value="rtl_view">
                                <label for="checkbox1">RTL Version</label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox ms_bar">
                                <input id="checkbox2" type="checkbox" value="mini_active">
                                <label for="checkbox2">Mini Sidebar</label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <input id="checkbox3" type="checkbox" checked="">
                                <label for="checkbox3">Notifications</label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <input id="checkbox4" type="checkbox">
                                <label for="checkbox4">Auto Updates</label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <input id="checkbox5" type="checkbox" checked="">
                                <label for="checkbox5">Offline</label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <input id="checkbox6" type="checkbox" checked="">
                                <label for="checkbox6">Location Permission</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-pane right_chat" id="chat">
            <div class="slim_scroll">
                <div class="card">
                    <ul class="list-unstyled">
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="assets/images/xs/avatar4.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Sophia <small class="float-right">11:00AM</small></span>
                                        <span class="message">There are many variations of passages of Lorem Ipsum available</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="assets/images/xs/avatar5.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Grayson <small class="float-right">11:30AM</small></span>
                                        <span class="message">All the Lorem Ipsum generators on the</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="assets/images/xs/avatar2.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Isabella <small class="float-right">11:31AM</small></span>
                                        <span class="message">Contrary to popular belief, Lorem Ipsum</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="me">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="assets/images/xs/avatar1.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">John <small class="float-right">05:00PM</small></span>
                                        <span class="message">It is a long established fact that a reader</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="assets/images/xs/avatar3.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Alexander <small class="float-right">06:08PM</small></span>
                                        <span class="message">Richard McClintock, a Latin professor</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>
<!-- Main Content -->--}}
