<div class="md:hidden">
    <div @click="sidemenu = false"
         class="fixed inset-0 z-30 bg-gray-600 opacity-0 pointer-events-none transition-opacity ease-linear duration-300"
         :class="{'opacity-75 pointer-events-auto': sidemenu, 'opacity-0 pointer-events-none': !sidemenu}">
    </div>

    <!-- Small Screen Menu -->
    @include('site.layouts.user_panel.includes.small_sidebar')
    <!-- @end Small Screen Menu -->
</div>


<!-- Menu Above Medium Screen -->
    @include('site.layouts.user_panel.includes.medium_sidebar')
<!-- @end Menu Above Medium Screen -->
