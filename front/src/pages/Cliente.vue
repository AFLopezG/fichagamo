<template>
  <div class="q-pa-xs">
    <q-layout  class="shadow-2 rounded-borders">
      <q-header elevated>
        <q-toolbar>
            <img src="img/gamo.png" width="100px">

          <q-toolbar-title>FICHA DE ATENCION</q-toolbar-title>

          <q-btn flat round dense icon="whatshot" />
        </q-toolbar>
      </q-header>

      <q-footer elevated>
        <q-toolbar>
          <q-toolbar-title>&copy; {{ new Date().getFullYear() }}</q-toolbar-title>
        </q-toolbar>
      </q-footer>

      <q-page-container>
        <q-page class="q-pa-md">
            <div class="row" align="center" justify="center" >
                <div v-for="(item, i) in units" :key="i" style="padding:10px;">
                    <q-card :style="'padding:10px; height:250px; width:350px; background-color: '+item.color"  @click="unit=item;dialogCliente=true">
                        <div class="my-card" flat bordered>
                            <q-card-section horizontal>
                                <q-card-section>
                                    <span style="font-size: 30px; font-weight: bold;">{{ item.nombre }}</span>
                                    <!--<br> <span style="font-size: 24px; font-weight: bold;">{{ item.nombre }}</span>-->
                                </q-card-section>

                                <q-img
                                class="col-5"
                                :src="'img/'+item.imagen"
                                style="height: 220px;width: 180px;"
                                />
                            </q-card-section>
                        </div>
                    </q-card>
                </div>
            </div>
            <q-dialog v-model="dialogCliente" persistent>
                <q-card style="width: 700px; max-width: 80vw;">

                    <q-card-section>
                        <div class="col-12 q-pa-sm" v-for="tip in tipos" :key="tip">
                            <q-btn size="40px" class="full-width" outline color="indigo-10" :label="tip.nombre" @click="ticket(tip)" full-width>
                                <q-icon :name="tip.icono" />
                                <q-icon :name="tip.icono2" v-if="!tip.icono2==''"/>
                            </q-btn>
                        </div>
                        
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn outline label="CANCELAR" color="primary" v-close-popup />
                    </q-card-actions>
                </q-card>
            </q-dialog>
        </q-page>
      </q-page-container>
      <div id="myelement" class="hidden"></div>
    </q-layout>
  </div>
</template>
<style scoped>
.imagen {
    width:100%;
}
</style>

<script>
import moment from 'moment'
import 'moment/locale/es'
import { Printd } from 'printd'

import { QSpinnerGears } from 'quasar'
    export default {
        name: 'ClientePage',
        data: () => ({
            dialogCliente:false,
            drawer: null,
            tipos:[],
            tipo:{},
            units:[],
            unit:{},
            divece:null,
            items: [
                {
                    color: '#1F7087',
                    src: 'https://cdn.vuetifyjs.com/images/cards/foster.jpg',
                    title: 'Supermodel',
                    artist: 'Foster the People',
                },
                {
                    color: '#952175',
                    src: 'https://cdn.vuetifyjs.com/images/cards/halcyon.png',
                    title: 'Halcyon Days',
                    artist: 'Ellie Goulding',
                },
            ],
        }),
        mounted() {
            // console.log('Component mounted.')
            this.getUnit()
            this.getTipo()

        },
        methods:{
            getTipo(){
                this.$api.get('/tipo').then(res=>{
                    console.log(res.data)
                    this.tipos=res.data
                })
            },
            getUnit(){
                this.$api.get('/unit').then(res=>{this.units=res.data})
            },
            ticket(item){
                // console.log('aaa');
                this.$api.post('/registrar',{unit_id:this.unit.id,tipo_id:item.id}).then(async res=>{
                    console.log(res.data);
                    this.dialogCliente=false
                    this.$q.notify({
                        spinner: QSpinnerGears,
                        message: 'Imprimiendo...',
                        position: 'top',
                        timeout: 2000
                        })
                    let cadena=''
                    cadena+=`<html><header>
                        <style>*{padding:0px;border:0px;margin:0px;}</style>
                        
                        </header>
                        <body><div style="text-align:center;padding-left: 5px;padding-right: 5px;">
                            <img width="70px" src="gamo.jpg" alt="">
                            <p>`+res.data.unit.nombre+`</p>
                            <h4>`+res.data.numero+`</h4>
                            <p>Tome asiento y espere su turno</p>
                            <p>`+moment().format('D/MM/YYYY, h:mm:ss a')+`</p>                            
                        </div></body></html>`
                        document.getElementById('myelement').innerHTML = cadena
                        //this.connectAndPrint()
                        const d = new Printd()
                        d.print( document.getElementById('myelement') )
                    // setTimeout(function(){

                    // },250);

                })
            },
            connectAndPrint() {
                navigator.usb.getDevices()
                .then(devices => {
                    if (devices.length > 0) {
                        device = devices[0];
                        return setup(device);
                    }
                })

    if (this.device == null) {
        navigator.usb.requestDevice({ filters: [{ vendorId: 1046 }] })
        .then(selectedDevice => {
            this.device = selectedDevice;
            console.log(this.device);
            return setup(this.device);
        })
        .then(() => this.print())
        .catch(error => { console.log(error); })
    }
    else
        print();
},
 print() {
    var string = document.getElementById('myelement').value + '\n';
    var encoder = new TextEncoder();
    var data = encoder.encode(string);
    device.transferOut(1, data)
    .catch(error => { console.log(error); })
},
 setup(device) {
    return device.open()
    .then(() => device.selectConfiguration(1))
    .then(() => device.claimInterface(0))
}
        },

        props: {
            source: String,
        },


    }
</script>
