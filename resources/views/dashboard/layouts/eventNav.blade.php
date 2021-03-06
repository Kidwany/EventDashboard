<div class="container-fluid">
    <!-- Tabs With Icon Title -->
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                        <li class="nav-item"><a class="nav-link {{Request::is('event/*') ? 'active' : ''}}"         href="{{adminUrl('event/' . $event->id)}}"> <i class="zmdi zmdi-inbox"></i> الفعالية </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('applicants/*') ? 'active' : ''}}"    href="{{adminUrl('applicants/' . $event->id)}}"><i class="zmdi zmdi-group-work"></i> الطلبات </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('zones/*') ? 'active' : ''}}"         href="{{adminUrl('zones/' . $event->id)}}"><i class="zmdi zmdi-map"></i> المناطق </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('groups/*') ? 'active' : ''}}"        href="{{adminUrl('groups/' . $event->id)}}"><i class="zmdi zmdi-badge-check"></i> المجموعات </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('floors/*') ? 'active' : ''}}"        href="{{adminUrl('floors/' . $event->id)}}"><i class="zmdi zmdi-accounts"></i> الأدوار </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('gates/*') ? 'active' : ''}}"         href="{{adminUrl('gates/' . $event->id)}}"><i class="zmdi zmdi-store"></i> البوابات </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('organizers/*') ? 'active' : ''}}"    href="{{adminUrl('organizers/' . $event->id)}}"><i class="zmdi zmdi-fire"></i> المنظمين </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('tasks/*') ? 'active' : ''}}"         href="{{adminUrl('tasks/' . $event->id)}}"><i class="zmdi zmdi-view-list-alt"></i> المهام </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('tracking/*') ? 'active' : ''}}"      href="{{adminUrl('tracking/' . $event->id)}}"><i class="zmdi zmdi-map"></i> خريطه الفعاليه </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('tools/*') ? 'active' : ''}}"         href="{{adminUrl('tools/' . $event->id)}}"><i class="zmdi zmdi-speaker"></i> المعدات </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('finance/*') ? 'active' : ''}}"       href="{{adminUrl('finance/' . $event->id)}}"><i class="zmdi zmdi-money"></i> البيانات المالية </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('company/*') || Request::is('company-user/*') ? 'active' : ''}}"       href="{{adminUrl('company/' . $event->id)}}"><i class="zmdi zmdi-hotel"></i> الشركات</a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('break/*') || Request::is('break/*') ? 'active' : ''}}"       href="{{adminUrl('break/' . $event->id)}}"><i class="zmdi zmdi-local-cafe"></i> الإستراحة</a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('guardian-ship/*') ? 'active' : ''}}"                 href="{{adminUrl('guardian-ship/' . $event->id)}}"><i class="zmdi zmdi-plus-box"></i> العهدة</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
