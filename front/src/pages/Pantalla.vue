<template>
        <div >
            <div class="text-align:center" style="border: 1px solid black;background: #263238;height: 70vh;width: 100%">
                <center>
                    <video controls src="video/spot1.mp4"  style="height: 70vh" autoplay muted playsinline id="videoElementId" ended="">
                        Your browser does not support HTML video.
                    </video>
    <!--                <button @click="aumentar" style="background: red">lorem*10</button>-->
            </center>
            </div>
            <div style="height: 30vh;border: 1px solid #c68400;background: #ffe54c" >
                <div class="grid" id="fichas" >
                                        <div  class="col1" style="display: flex;align-items: center;text-align: center" v-for="(item, i) in lista" :key="i">
                                            <p style="  font-size:3em;font-weight:bold;text-align: center;width: 100%" >
                                                {{ item }}
                                            </p>
                                        </div>
                </div>
            </div>
        </div>
    </template>

    <script>
    import { io } from 'socket.io-client'
    const socket = io(import.meta.env.VITE_API_SOCKET)

// Import other required libraries
    // Creates a client
    export default {
        name: 'pantallaPage',
        data() {
            return {
                video: 1,
                lista: ['','','','','','','',''],
                //socket : io('http://192.168.154.208:3000'),
                //socket : io('http://localhost:3000'),
                optionsVoice: [],
            }
        },
    mounted() {
      if (this.$store.boolSocket !== true) {
        
        socket.on('connect', () => {
          console.log('conectado')
        })
        socket.on('disconnect', () => {
          console.log('desconectado')
        })
        socket.on('atender', (data) => {
          console.log(data)
          if(this.lista.includes(data))
            this.lista.splice(this.lista.indexOf(data),1)
          this.lista.unshift(data)
            this.speak(data)
        })
        this.$store.boolSocket = true
      }

      /*
          if (data.detailArray === undefined) {
            this.$q.notify({
              message: 'Pedido nuevo',
              color: 'teal',
              icon: 'info',
              position: 'top-right'
            })
            this.consultarOrder()
          } else {
            this.printOrderAummentado(data.order, data.detailArray)
            this.$q.notify({
              message: 'Pedido Aumentado',
              color: 'red',
              icon: 'info',
              position: 'top-right'
            })
        this.consultarOrder()*/
            var cont=0;
            var newVideo = document.getElementById('videoElementId');
            newVideo.addEventListener('ended', function() {
                cont++;
                // console.log(newVideo);
                newVideo.src = 'video/spot'+cont+'.mp4';
                if (cont==11)
                    cont=0;
                newVideo.load();
            }, false);
            newVideo.play();

            // var socket = io();

            // var socket = io();

            // console.log('this is current player instance object', this.player)
            // this.aumentar('aa');
            // this.array.pop();
            // this.array.unshift('aa');
            //var list= ['','','','','','','',''];
            // this.socket.on('atender', function(msg){
            //     array.pop();
            //     array.unshift(msg);
            //      console.log(msg);
            //     $('#fichas').html('');
            //     for (let i=0;i<8;i++){
            //         $('#fichas').append('<div  class="col" style="display: flex;align-items: center;text-align: center">' +
            //             '                    <p style="  font-size:3em;font-weight:bold;text-align: center;width: 100%" >' +
            //             array[i] +
            //             '                    </p>' +
            //             '                </div>');
            //     }
            // });
        },
        created(){
       // this.setVoices()
            
        },
        computed: {

        },
        methods: {
            setVoices () {
                let id = setInterval(() => {
                if (this.optionsVoice.length === 0) {
                    this.voicesList()
                    console.log(this.optionsVoice)
                } else {
                    clearInterval(id)
                  }
                }, 50)
                console.log(id)
                },
                voicesList () {
                let teste = window.speechSynthesis
                this.optionsVoice = teste.getVoices().map(voice => ({
                    label: voice.name, value: voice.lang
                }))
            },
            async speak(cadena) {
                const synth = window.speechSynthesis;
                const voices = synth.getVoices();

                    //console.log(voices)
                    var msg = new SpeechSynthesisUtterance('Ticket '+cadena);
                    msg.rate = 0.5;
                    msg.pitch = 2;
                    msg.volume = 1;
                    msg.lang = 'es-ES'
                    //window.speechSynthesis.speak(msg);
                    msg.voice = voices[0];
                    synth.speak(msg);
            },
            aumentar(){
                // var
                socket.emit('chat message', 'aaa');
            },
            // listen event
            onPlayerPlay(player) {
                console.log('player play!', player)
            },

            playerReadied(player) {
                console.log('the player is readied', player)
                // you can use it to do something...
                // player.[methods]
            },
            onPlayerEnded(player){
                this.video++;
                console.log('acabo', player)
                this.playerOptions.sources=[{
                    type: 'video/mp4',
                    src: 'video/spot'+this.video+'.mp4'
                }];
                this.onPlayerPlay(player);
                if (this.video==11) this.video=0            }
        }
    }
    </script>
    <style>
    .grid {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 100%;
        padding: 5px;
        gap: 1px;
    }
    .col1 {
        float: left;
        width: 25%;
        height: 50%;
        background: #ffb300;
        border: 2px solid white;
        border-radius: 1em;
    }
    </style>
