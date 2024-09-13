<template>
  <div class="q-pa-xs">
    <q-layout  class="shadow-2 rounded-borders">



      <q-page-container>
        <q-page class="q-pa-md">
           <div class="row">
            <div class="col-6"><q-btn @click="repetir()" color="yellow-7" size="xl" icon="restart_alt">Repetir</q-btn></div>
            <div class="col-6"><q-btn @click="atender()" color="green-7" size="xl" icon="navigate_next">Atender</q-btn></div>
           </div>
          <q-table
            title="Lista de fichas Atendidas"
            :rows="tickets"
            :columns="columna"
            row-key="name"
          >
          <template v-slot:body-cell-op="props">
                <q-td key="op" :props="props">
                <q-btn color="blue-5" icon="published_with_changes" size="sm" @click="dialogCambio=true;boleto=props.row" ><q-tooltip>Tranferir Cajero</q-tooltip></q-btn>
                </q-td>
            </template>
          </q-table>

          <q-dialog v-model="dialogCambio" persistent>
            <q-card style="width: 700px; max-width: 80vw;">
              <q-card-section class="row items-center">
                <q-avatar icon="people_alt" color="primary" text-color="white" />
                <span class="q-ml-sm">Reasignar Ticket a otro cajero</span>
              </q-card-section>
              <q-card-section>
                <div class="row">
                  <div class="col-10"><q-select dense v-model="usuario" :options="usuarios" label="CAJEROS" option-label="caja" /></div>
                  <div class="col-2"><q-btn color="indigo" size="sm" icon="send"  @click="cambioCajero" /></div>
                </div>                
              </q-card-section>
              <q-card-actions align="right">
                <q-btn flat label="CANCELAR" color="primary" v-close-popup />
              </q-card-actions>
            </q-card>
          </q-dialog>
        </q-page>
     </q-page-container>
    </q-layout>
    </div>

</template>

<script>
import {globalStore} from '../stores/globalStore'
import { io } from 'socket.io-client'
import moment from 'moment'
const socket = io(import.meta.env.VITE_API_SOCKET)

export default {
    name: 'VentanillaPage',
    data: () => ({
        columna: [
          {label:'OP',field:'op',name:'op'},
          {label:'CAJA',field:'empleado',name:'empleado'},
          {label:'NUMERO',field:'numero',name:'numero'},
          {label:'ESTADO',field:'estado',name:'estado'},
          {label:'FECHA',field: row=>moment(row.updated_at).format('DD/MM/YYYY h:mm:ss'),name:'FECHA'},
        ],
        dialog: true,
        dialogCambio:false,
        drawer: null,
        units:[],
        usuarios:[],
        usuario:{},
        user:{},
        nombrecaja:'',
        boleto:{},
        tickets:[],
        // socket : io('http://192.168.154.130:3000'),
        //socket : io('http://localhost:3000'),
        store:globalStore()

    }),
    created(){
      this.datosatender()
      this.getUser()

    },
    mounted() {

      if (this.$store.boolSocket !== true) {
      
        socket.on('connect', () => {
          console.log('conectado')
        })
        socket.on('disconnect', () => {
          console.log('desconectado')
        })
        // socket.on('atender', (data) => {
        //   console.log(data)
        // })
        this.$store.boolSocket = true
        this.datosatender()
      }
        if (!this.store.isLoggedIn) {
            this.$router.push('/login')
        }
        // console.log('Component mounted.')
    },

    methods:{
      cambioCajero(){
        if(this.usuario.id == undefined)
          return false
        console.log(this.usuario)
        console.log(this.boleto)
        this.$api.post('transferir',{ticket_id:this.boleto.id,user_id:this.usuario.id}).then(()=>{
          this.dialogCambio=false
          this.datosatender()
          this.$q.notify({
            icon: 'check',
          message: 'Correcto Cambio Caja',
          color: 'green'
        })
        })
      },
      getUser(){
        this.$api.post('listCaja').then(res=>{
          console.log(res.data)
          this.usuarios=res.data
          this.usuario=this.usuarios[0]
        })

      },
        datosatender(){
          this.$api.post('datosatender').then(res=>{
            //console.log(res.data)
            //return false
              this.tickets=res.data;
          })
        },

        atender(){
            this.$api.post('/atender',{nombrecaja:this.store.user.caja}).then(res=>{
                    // this.tickets=res.data
                    console.log('atender',res.data)
                    if(!res.data) {alert('Todos los clientes fueron atendidos')
                      return false
                    }
                  //socket.emit('atender', res.data.numero+'->'+res.data.empleado);
                    this.datosatender()
                    this.$api.post('/ultificha')
                        .then(res=>{
                            console.log(res);
                            socket.emit('atender', res.data.numero+' -> '+res.data.empleado);
                            //socket.emit('atender', res.data.numero+'->'+res.data.empleado);
                            //socket.on('disconnect', () => {
                           ///     console.log('desconectado')
                           // })
                        });

                }).catch(()=>{
                    alert('Todos los clientes fueron atendidos')

                });
        },
        repetir(){
          this.$api.post('/ultificha',{nombrecaja:this.store.user.caja})
                        .then(res=>{
                            console.log(res);
                            socket.emit('atender', res.data.numero+' -> '+res.data.empleado);
                        });
        }
    },

}
</script>
