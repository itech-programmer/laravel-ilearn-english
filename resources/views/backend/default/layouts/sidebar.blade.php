<div id="sidebar-menu" class="sidebar-menu">
    <ul>
        <li class="menu-title">
            <span>{{ auth()->user()->roles->implode('name') }}</span>
        </li>
        <!--begin::Item-->
        <li class="{{ (request()->routeIs('backend.index')) ? 'active' : '' }}">
            <a href="{{ route('backend.index') }}">
                <i class="fad fa-chart-network"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="{{ (request()->routeIs('users.index')) ? 'active' : '' }}">
            <a href="{{ route('users.index') }}">
                <i class="fad fa-users"></i>
                <span>Users</span>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="{{ (request()->routeIs('courses.index')) ? 'active' : '' }}">
            <a href="{{ route('courses.index') }}">
                <i class="fad fa-books"></i>
                <span>Courses</span>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <!--begin::Item-->
        <li class="{{ (request()->routeIs('chapters.index')) ? 'active' : '' }}">
            <a href="{{ route('chapters.index') }}">
                <i class="fa-solid fa-chalkboard"></i>
                <span>Chapters</span>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="{{ (request()->routeIs('lessons.index')) ? 'active' : '' }}">
            <a href="{{ route('lessons.index') }}">
                <i class="fad fa-chalkboard-user"></i>
                <span>Lessons</span>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="{{ (request()->routeIs('exercises.index')) ? 'active' : '' }}">
            <a href="{{ route('exercises.index') }}">
                <i class="fad fa-tasks"></i>
                <span>Exercises</span>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="{{ (request()->routeIs('questions.index')) ? 'active' : '' }}">
            <a href="{{ route('questions.index') }}">
                <i class="fad fa-question"></i>
                <span>Questions</span>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="{{ (request()->routeIs('dictionaries.index')) ? 'active' : '' }}">
            <a href="{{ route('dictionaries.index') }}">
                <i class="fa-duotone fa-globe"></i>
                <span>Dictionary</span>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
{{--        <li class="{{ (request()->routeIs('games.index')) ? 'active' : '' }}">--}}
{{--            <a href="{{ route('games.index') }}">--}}
{{--                <i class="fa-duotone fa-gamepad-modern"></i>--}}
{{--                <span>Dictionary</span>--}}
{{--            </a>--}}
{{--        </li>--}}
        <!--end::Item-->
    </ul>
</div>
