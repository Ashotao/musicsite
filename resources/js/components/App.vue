<template>
    <div>
            <h1>Pamoika App</h1>

        <p>
                <router-link :to="{ name: 'home' }">Home</router-link> |
                <router-link :to="{ name: 'auth' }">Auth</router-link> |
                <router-link :to="{ name: 'music' }">Music</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
export default {}
</script>
