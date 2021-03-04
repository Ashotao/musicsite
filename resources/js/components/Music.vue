<template>
    <div>
        <ul class="player">
            <li><svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><path d="M179.199,38.399c0,1.637-0.625,3.274-1.875,4.524l-85.076,85.075l85.076,85.075c2.5,2.5,2.5,6.55,0,9.05s-6.55,2.5-9.05,0  l-89.601-89.6c-2.5-2.5-2.5-6.551,0-9.051l89.601-89.6c2.5-2.5,6.55-2.5,9.05,0C178.574,35.124,179.199,36.762,179.199,38.399z"/></svg></li>
            <li><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g><path d="M144,124.9L353.8,256L144,387.1V124.9 M128,96v320l256-160L128,96L128,96z"/></g></svg></li>
            <li><svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><path d="M76.8,217.6c0-1.637,0.625-3.274,1.875-4.524L163.75,128L78.675,42.925c-2.5-2.5-2.5-6.55,0-9.05s6.55-2.5,9.05,0  l89.601,89.6c2.5,2.5,2.5,6.551,0,9.051l-89.601,89.6c-2.5,2.5-6.55,2.5-9.05,0C77.425,220.875,76.8,219.237,76.8,217.6z"/></svg></li>
            <input type="range" min="0" max="100" step="1" value="50">
        </ul>
        <div class="song-main">
            <ul class="song-menu">
                <a v-on:click="showMusicList()"><li :class="{activeMenu: ShowPopUp}">Music list</li></a>
                <a v-on:click="showAddSong()"><li :class="{activeMenu: !ShowPopUp}">Add song</li></a>
            </ul>
            <div v-if="ShowPopUp == true">
                <form method="post" action="/addsong">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="input-form">
                        <input type="text" placeholder="Ссылка на youtube/soundcloud" name="link">
                    </div>
                    <div class="input-form">
                        <input type="text" placeholder="Название трека" name="name">
                    </div>
                    <div class="input-form">
                        <input type="submit" value="Add">
                    </div>
                </form>
            </div>
            <ul v-else class="song-list">
                <li class="song-item" v-for="song in Songs" v-on:click="playSong(song.link)">{{ song.name }}</li>
            </ul>
        </div>

        <iframe muted="muted" id="sc_widget" width="100%" style="display:none"></iframe>
        <div muted="muted" id="yt_widget" width="100%" style="display:none"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            SCplayer: null,
            YTplayer: null,
            YT: false,
            Songs: [],
            ShowPopUp: false,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
        showAddSong() {
            this.ShowPopUp = true;
        },
        showMusicList() {
            this.ShowPopUp = false;
        }
    },
    mounted() {
        this.createScripts();
        this.loadSongs();
        setTimeout(this.startScript, 500);
    }
}
</script>
