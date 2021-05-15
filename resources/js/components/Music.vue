<template>
    <div>
        <ul class="player">
            <li><svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><path d="M179.199,38.399c0,1.637-0.625,3.274-1.875,4.524l-85.076,85.075l85.076,85.075c2.5,2.5,2.5,6.55,0,9.05s-6.55,2.5-9.05,0  l-89.601-89.6c-2.5-2.5-2.5-6.551,0-9.051l89.601-89.6c2.5-2.5,6.55-2.5,9.05,0C178.574,35.124,179.199,36.762,179.199,38.399z"/></svg></li>
            <li v-on:click="playSong()"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g><path d="M144,124.9L353.8,256L144,387.1V124.9 M128,96v320l256-160L128,96L128,96z"/></g></svg></li>
            <li><svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><path d="M76.8,217.6c0-1.637,0.625-3.274,1.875-4.524L163.75,128L78.675,42.925c-2.5-2.5-2.5-6.55,0-9.05s6.55-2.5,9.05,0  l89.601,89.6c2.5,2.5,2.5,6.551,0,9.051l-89.601,89.6c-2.5,2.5-6.55,2.5-9.05,0C77.425,220.875,76.8,219.237,76.8,217.6z"/></svg></li>
            <input v-model="currentVolume" @input="setVolume()" type="range" min="0" max="100" step="1">
        </ul>
        <div class="song-main">
            <ul class="song-menu">
                <a @click="musicListOrAddSong()"><li :class="{activeMenu: ShowPopUp}">Music list</li></a>
                <a @click="musicListOrAddSong()"><li :class="{activeMenu: !ShowPopUp}">Add song</li></a>
            </ul>
            <div v-if="ShowPopUp == true">
                <form method="post" action="/addsong">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="input-form">
                        <input :class="{'error-input': errors.link}" type="text" placeholder="Ссылка на youtube/soundcloud" name="link">
                        <div class="error" v-if="errors.link">{{ errors.link[0] }}</div>
                    </div>
                    <div class="input-form">
                        <input :class="{'error-input': errors.name}" type="text" placeholder="Название трека" name="name">
                        <div class="error" v-if="errors.name">{{ errors.name[0] }}</div>
                    </div>
                    <div class="input-form">
                        <input type="submit" value="Add">
                    </div>
                </form>
            </div>
            <div v-else>
                <ul class="song-list">
                    <li class="song-item" v-for="song in Songs" @click="setSong(song.link)">{{ song.name }}</li>
                </ul>
                <div v-if="!lastpage" class="input-form">
                    <input @click="loadSongs" type="submit" value="More">
                </div>
            </div>
        </div>
        <div id="YT"></div>
        <iframe id="SC" allow="autoplay"
        src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/293">
        </iframe>
    </div>
</template>

<script>
export default {
    props: ['errors'],
    data() {
        return {
            YTPlayer: null,
            SCPlayer: null,
            YT: true,
            Paused: false,
            currentVolume: 50,
            Songs: [],
            lastpage: true,
            currentPage: 1,
            ShowPopUp: false,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    methods: {
        loadSongs() {
            axios.get('/api/songs?page=' + this.currentPage)
            .then((response) =>  {
                this.lastpage = response.data.current_page == response.data.last_page;
                this.currentPage += 1;
                this.Songs = this.Songs.concat(response.data.data);
            })
            .catch( function (error) {
                console.log(error);
            })
        },
        musicListOrAddSong() {
            this.ShowPopUp = !this.ShowPopUp;
        },
        createScripts() {
            const script2 = document.createElement('SCRIPT');
            script2.setAttribute('src', `https://www.youtube.com/iframe_api`);
            document.head.append(script2);
            window.onYouTubeIframeAPIReady = () => {
                this.YTPlayer = new YT.Player('YT', {
                    videoId: 'bHugxNlAbtM',
                    autoplay: false,
                });
            }

            const script1 = document.createElement('SCRIPT');
            script1.setAttribute('src', `https://w.soundcloud.com/player/api.js`);
            document.head.append(script1);
            script1.onload = () => {
                var iframeElement = document.querySelector('#SC');
                this.SCPlayer = SC.Widget(iframeElement);
                this.SCPlayer.bind(SC.Widget.Events.PLAY, () => this.setVolume());
            }
        },
        playSong() {
            if (this.Paused) {
                this.Paused = false;
                this.YT ? this.YTPlayer.playVideo() :  this.SCPlayer.play();
            } else {
                this.Paused = true;
                this.YT ? this.YTPlayer.pauseVideo() :  this.SCPlayer.pause();
            }
        },
        setSong(url) {
            this.SCPlayer.getVolume((volume) => { if (volume != this.currentVolume) this.setVolume(); });
            this.Paused = false;

            (url.indexOf('soundcloud') !== -1) ? this.YT = false : this.YT = true;
            if (this.YT) {
                this.YTPlayer.loadVideoById(url,0,'small');
                this.SCPlayer.pause();
            } else {
                this.SCPlayer.load(url, {auto_play: true});
                this.YTPlayer.stopVideo();
            }
        },
        setVolume() {
            this.YTPlayer.setVolume(this.currentVolume);
            this.SCPlayer.setVolume(this.currentVolume);
        }
    },
    mounted() {
        if (this.errors.link || this.errors.name) {
            this.ShowPopUp = true;
        }
        this.createScripts();
        this.loadSongs();
    },
}
</script>
