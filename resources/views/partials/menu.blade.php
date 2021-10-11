<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('music_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/music-items*") ? "menu-open" : "" }} {{ request()->is("admin/playlists*") ? "menu-open" : "" }} {{ request()->is("admin/music-topics*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-music">

                            </i>
                            <p>
                                {{ trans('cruds.music.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('music_item_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.music-items.index") }}" class="nav-link {{ request()->is("admin/music-items") || request()->is("admin/music-items/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-play-circle">

                                        </i>
                                        <p>
                                            {{ trans('cruds.musicItem.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('playlist_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.playlists.index") }}" class="nav-link {{ request()->is("admin/playlists") || request()->is("admin/playlists/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-headphones">

                                        </i>
                                        <p>
                                            {{ trans('cruds.playlist.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('music_topic_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.music-topics.index") }}" class="nav-link {{ request()->is("admin/music-topics") || request()->is("admin/music-topics/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-atlas">

                                        </i>
                                        <p>
                                            {{ trans('cruds.musicTopic.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('curhat_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/curhatans*") ? "menu-open" : "" }} {{ request()->is("admin/comments*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon far fa-envelope-open">

                            </i>
                            <p>
                                {{ trans('cruds.curhat.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('curhatan_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.curhatans.index") }}" class="nav-link {{ request()->is("admin/curhatans") || request()->is("admin/curhatans/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-envelope-square">

                                        </i>
                                        <p>
                                            {{ trans('cruds.curhatan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('comment_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.comments.index") }}" class="nav-link {{ request()->is("admin/comments") || request()->is("admin/comments/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-comment">

                                        </i>
                                        <p>
                                            {{ trans('cruds.comment.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('journey_group_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/journeys*") ? "menu-open" : "" }} {{ request()->is("admin/journals*") ? "menu-open" : "" }} {{ request()->is("admin/mood-trackers*") ? "menu-open" : "" }} {{ request()->is("admin/mood-tracker-reasons*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-align-justify">

                            </i>
                            <p>
                                {{ trans('cruds.journeyGroup.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('journey_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.journeys.index") }}" class="nav-link {{ request()->is("admin/journeys") || request()->is("admin/journeys/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-asterisk">

                                        </i>
                                        <p>
                                            {{ trans('cruds.journey.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('journal_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.journals.index") }}" class="nav-link {{ request()->is("admin/journals") || request()->is("admin/journals/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-book-open">

                                        </i>
                                        <p>
                                            {{ trans('cruds.journal.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('mood_tracker_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.mood-trackers.index") }}" class="nav-link {{ request()->is("admin/mood-trackers") || request()->is("admin/mood-trackers/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-swimmer">

                                        </i>
                                        <p>
                                            {{ trans('cruds.moodTracker.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('mood_tracker_reason_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.mood-tracker-reasons.index") }}" class="nav-link {{ request()->is("admin/mood-tracker-reasons") || request()->is("admin/mood-tracker-reasons/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-exchange-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.moodTrackerReason.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>