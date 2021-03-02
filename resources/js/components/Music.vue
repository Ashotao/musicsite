<template>
    <div>
        <p>Music list</p>
        <Popup v-if="ShowPopUp == true" @closePopUp="addSong()"/>
        <button v-on:click="addSong()">Добавить песню</button>
        <div>
            <a href="#" v-on:click="YTplayer.playVideo()">Play</a>
        </div>
        <div>
            <a href="#" v-on:click="YTplayer.pauseVideo()">Pause</a>
        </div>
        <div>
            <ul>
                <li v-for="song in Songs" href="#" v-on:click="playSong(song.link)">{{ song.name }}</li>
            </ul>
        </div>
        <iframe muted="muted" id="sc_widget" width="100%" style="display:none"></iframe>
        <div muted="muted" id="yt_widget" width="100%" style="display:none"></div>
    </div>
</template>

<script>
import Popup from "./Popup";

export default {
    components: {Popup},
    data() {
        return {
            SCplayer: null,
            YTplayer: null,
            YT: false,
            Songs: [],
            ShowPopUp: false
        }
    },
    methods: {
        timeoutF() {
            if (this.YT == true) {
                this.YTplayer.playVideo();
            } else {
                this.SCplayer.play();
            };

            this.SCplayer.setVolume(40);
            this.YTplayer.setVolume(40);
        },
        createScripts() {
            const script = document.createElement('SCRIPT');
            script.setAttribute('src', `https://w.soundcloud.com/player/api.js`);
            document.body.appendChild(script);

            const script2 = document.createElement('SCRIPT');
            script2.setAttribute('src', `https://www.youtube.com/iframe_api`);
            document.body.appendChild(script2);
        },
        startScript() {
            const iframe = document.querySelector('#sc_widget');
            iframe.src = 'https://w.soundcloud.com/player/?url=http://api.soundcloud.com/tracks/43315398';
            this.SCplayer = SC.Widget(iframe);

            this.YTplayer = new YT.Player('yt_widget', {
                width: 0,
                height: 0,
                videoId: 'TxyDtZGRo6g',
            });
        },
        loadSongs() {
            axios.get('/api/songs')
            .then((response) =>  {
                this.Songs = response.data.songs;
            })
            .catch( function (error) {
                console.log(error);
            })
        },
        playSong($link) {
            if ($link.indexOf('http') !== -1) {
                this.YT = false;
            } else {
                this.YT = true;
            };

            if (this.YT == true) {
                this.YTplayer.loadVideoById($link);
                this.SCplayer.pause();
            } else {
                this.SCplayer.load($link);
                this.YTplayer.pauseVideo();
            };

            setTimeout(this.timeoutF, 1500);
        },
        addSong() {
           if (this.ShowPopUp == true)
               this.ShowPopUp = false;
           else
               this.ShowPopUp = true
        }
    },
    mounted() {
        this.createScripts();
        this.loadSongs();
        setTimeout(this.startScript, 500);
    }
}
</script>
