    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="{{asset('storage')}}/{{Auth::user()->image}}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</div>
                    <div class="email">{{Auth::user()->email}}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">


                            <li><a href="{{Auth::user()->role->id==1 ? route('admin.settings'): route('author.settings')}}"><i class="material-icons">settings</i>settings</a></li>
                            <li>

                           <a class="dropdown-item" href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                  <i class="material-icons">input</i>Sign Out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>


                        </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">

                {{--//admin dashboard--}}
                    <li class="header">MAIN NAVIGATION</li>
                    @if(Request::is('admin*'))
                        <li class="{{Request::is('admin/dashboard')? 'active':''}}">
                            <a href="{{route('admin.dashboard')}}">
                                <i class="material-icons">home</i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="{{Request::is('admin/tag*')? 'active':''}}">
                            <a href="{{route('admin.tag.index')}}">
                                <i class="material-icons">label</i>
                                <span>Tag</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/category*') ? 'active' : '' }}">
                            <a href="{{ route('admin.category.index') }}">
                                <i class="material-icons">apps</i>
                                <span>Category</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/post*') ? 'active' : '' }}">
                            <a href="{{ route('admin.post.index') }}">
                                <i class="material-icons">library_books</i>
                                <span>Posts</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/pending/post') ? 'active' : '' }}">
                            <a href="{{ route('admin.post.pending') }}">
                                <i class="material-icons">library_books</i>
                                <span>Pending Posts</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/favorite') ? 'active' : '' }}">
                            <a href="{{ route('admin.favorite.index') }}">
                                <i class="material-icons">favorite</i>
                                <span>Favorite Posts</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/subscriber') ? 'active' : '' }}">
                            <a href="{{ route('admin.author.index') }}">
                                <i class="material-icons">account_circle</i>
                                <span>Author</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/subscriber') ? 'active' : '' }}">
                            <a href="{{ route('admin.subscriber.index') }}">
                                <i class="material-icons">subscriptions</i>
                                <span>Subscribers</span>
                            </a>
                        </li>

                        //System
                        <li class="header">System</li>

                        <li class="{{ Request::is('admin/settings') ? 'active' : '' }}">
                            <a href="{{ route('admin.settings') }}">
                                <i class="material-icons">settings</i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="material-icons">input</i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endif

                 {{--//author dashboard--}}
                    @if(Request::is('author*'))
                        <li class="{{Request::is('author/dashboard')? 'active':''}}">
                            <a href="{{route('admin.dashboard')}}">
                                <i class="material-icons">home</i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('author/post*') ? 'active' : '' }}">
                            <a href="{{ route('author.post.index') }}">
                                <i class="material-icons">library_books</i>
                                <span>Posts</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('author/favorite') ? 'active' : '' }}">
                            <a href="{{ route('author.favorite.index') }}">
                                <i class="material-icons">favorite</i>
                                <span>Favorite Posts</span>
                            </a>
                        </li>

                        <li class="header">System</li>

                        <li class="{{ Request::is('author/settings') ? 'active' : '' }}">
                            <a href="{{ route('author.settings') }}">
                                <i class="material-icons">settings</i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="material-icons">input</i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('home') }}">
                            <i class="material-icons">home</i>
                            <span>View Website</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2019<a href="javascript:void(0);"> Develop by Habibur Rahman</a>.
                </div>
            </div>
            <!-- #Footer -->
        </aside>

    </section>