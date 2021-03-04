<template>
    <div>
        <nav class="top-menu">
            <ul class="menu-main">
                <li :class="{'activeTop': $route.path == '/'}" class="left-item icon-home"> <router-link class="menu-icon" :to="{ name: 'home' }"><svg viewBox="-1 -1 18 18" xmlns="http://www.w3.org/2000/svg"><path d="M15.45,7L14,5.551V2c0-0.55-0.45-1-1-1h-1c-0.55,0-1,0.45-1,1v0.553L9,0.555C8.727,0.297,8.477,0,8,0S7.273,0.297,7,0.555  L0.55,7C0.238,7.325,0,7.562,0,8c0,0.563,0.432,1,1,1h1v6c0,0.55,0.45,1,1,1h3v-5c0-0.55,0.45-1,1-1h2c0.55,0,1,0.45,1,1v5h3  c0.55,0,1-0.45,1-1V9h1c0.568,0,1-0.437,1-1C16,7.562,15.762,7.325,15.45,7z"/></svg></router-link> </li>
                <li :class="{'activeTop': $route.path == '/music'}" class="left-item icon-music" v-if="user"> <router-link class="menu-icon" :to="{ name: 'music' }"><svg viewBox="-1 -2 23 24" xmlns="http://www.w3.org/2000/svg"><path d="M20 2.5V0L6 2v12.17A3 3 0 0 0 5 14H3a3 3 0 0 0 0 6h2a3 3 0 0 0 3-3V5.71L18 4.3v7.88a3 3 0 0 0-1-.17h-2a3 3 0 0 0 0 6h2a3 3 0 0 0 3-3V2.5z"/></svg></router-link> </li>
                <li class="right-item icon-logout" v-if="user"> <a href="/auth/logout" class="menu-icon"><svg viewBox="-3 -4 104 104" xmlns="http://www.w3.org/2000/svg"><g><path d="M43.7578,61.7578a5.9994,5.9994,0,1,0,8.4844,8.4844l18-18a5.9979,5.9979,0,0,0,0-8.4844l-18-18a5.9994,5.9994,0,0,0-8.4844,8.4844L51.5156,42H6A6,6,0,0,0,6,54H51.5156Z"/><path d="M90,0H30a5.9966,5.9966,0,0,0-6,6V18a6,6,0,0,0,12,0V12H84V84H36V78a6,6,0,0,0-12,0V90a5.9966,5.9966,0,0,0,6,6H90a5.9966,5.9966,0,0,0,6-6V6A5.9966,5.9966,0,0,0,90,0Z"/></g></svg></a> </li>
                <li :class="{'activeTop': $route.path == '/auth/login'}" class="right-item icon-login" v-if="!user"> <router-link class="menu-icon" :to="{ name: 'login' }"><svg viewBox="-1 -1 18 18" xmlns="http://www.w3.org/2000/svg"><path d="M12,9H8H4c-2.209,0-4,1.791-4,4v3h16v-3C16,10.791,14.209,9,12,9z"/><path d="M12,5V4c0-2.209-1.791-4-4-4S4,1.791,4,4v1c0,2.209,1.791,4,4,4S12,7.209,12,5z"/></svg></router-link> </li>
                <li :class="{'activeTop': $route.path == '/auth/register'}" class="right-item icon-register" v-if="!user"> <router-link class="menu-icon" :to="{ name: 'register' }"><svg viewBox="1 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9,2C5.1,2,2,5.1,2,9c0,3.9,3.1,7,7,7c3.9,0,7-3.1,7-7C16,5.1,12.9,2,9,2z M7.5,10C6.1,10,5,8.9,5,7.5C5,6.1,6.1,5,7.5,5  C8.9,5,10,6.1,10,7.5C10,8.9,8.9,10,7.5,10z"/><path d="M15,11l-4,4l2,2v0h2v2l0,0h2v2l0.7,0.7c0.2,0.2,0.4,0.3,0.7,0.3H21c0.6,0,1-0.4,1-1v-2.6c0-0.3-0.1-0.5-0.3-0.7L15,11z"/></svg></router-link> </li>
            </ul>
            <a class="navbar-logo" href=""><img src="https://html5book.ru/wp-content/uploads/2017/04/lily-logo.png"></a>
        </nav>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
export default {
    props: ['user']
}
</script>
