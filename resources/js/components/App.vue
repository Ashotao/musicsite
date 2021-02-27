<template>
    <div>
            <h1>Pamoika App</h1>
        {{ user }}
        <p>
            <router-link :to="{ name: 'home' }">Home |</router-link>
            <router-link v-if="user" :to="{ name: 'music' }">Music |</router-link>
            <a v-if="user" href="/auth/logout">Logout |</a>
            <router-link v-if="!user" :to="{ name: 'login' }">Login |</router-link>
            <router-link v-if="!user" :to="{ name: 'register' }">Register |</router-link>
        </p>

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
