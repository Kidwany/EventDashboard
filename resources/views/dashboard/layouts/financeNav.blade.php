<div class="container-fluid">
    <!-- Tabs With Icon Title -->
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs p-0 mb-3">
                        <li class="nav-item"><a class="nav-link {{Request::is('finance/*') ? 'active' : ''}}"  href="{{adminUrl('finance/' . $event->id)}}">الإحصائيات</a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('expected_expenses/*') ? 'active' : ''}}" href="{{adminUrl('expected_expenses/' . $event->id)}}">التكاليف </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('tickets/*') ? 'active' : ''}}" href="{{adminUrl('tickets/' . $event->id)}}">التذاكر </a></li>
                        <li class="nav-item"><a class="nav-link {{Request::is('sponsors/*') ? 'active' : ''}}" href="{{adminUrl('sponsors/' . $event->id)}}">الرعاة </a></li>
                        <li class="nav-item"><a class="nav-link" href="#messages">المساحات</a></li>
                        <li class="nav-item"><a class="nav-link " href="#settings">اخرى</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
