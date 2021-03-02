<template>
    <div>
        <div>
            <button v-on:click="$emit('closePopUp')">X</button>
        </div>

        <div>
            Добавить песню:
            <form method="post" action="/addsong">
                <input type="hidden" name="_token" :value="csrf">
                <label for="link">Ссылка</label>
                <input type="text" placeholder="Ссылка на youtube/soundcloud" id="link" name="link">
                <label for="name">Название трека</label>
                <input type="text" placeholder="Название трека" id="name" name="name">
                <button type="submit">Добавить</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },

}
</script>
