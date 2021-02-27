<template>
    <div>
        <p>Music</p>
        <div>
            <button v-on:click=""><</button>
            <button v-on:click="">Play</button>
            <button v-on:click="">></button>
            <input type="range" min="0" max="100" step="1" value="50">
        </div>
        <div>
            <ul>
                <li v-for="song in Songs" v-on:click="playSong(song.link)">{{ song.name }}</li>
            </ul>
        </div>
        <audio controls :src="currentSong" ref="audio"></audio>
    </div>
</template>

<script>
export default {
    data() {
        return {
            Songs: [],
            currentSong: null,
        }
    },
    methods: {
        loadSongs() {
            axios.get('/api/songs')
                .then((response) =>  {
                    this.Songs = response.data;
                })
                .catch( function (error) {
                    console.log(error);
                })
        },
        playSong($url) {
            axios.get('/api/getsongurl/bHugxNlAbtM')
            .then((response) => {
                this.currentSong = response.data;
            })
            .catch(function (error) {
                console.log(error);
            })
        }
    },
    mounted() {
        this.loadSongs();
    }
}
</script>
