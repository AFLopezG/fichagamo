<template>
    <div class="q-pa-md">
      <q-btn
        label="Nuevo usuario"
        color="positive"
        @click="regDialog"
        icon="add_circle"
        class="q-mb-xs"
      />
  
      <q-dialog v-model="alert" full-width>
        <q-card >
          <q-card-section class="bg-green-14 text-white">
            <div class="text-h7"><q-icon name="add_circle" /> REGISTRO DE NUEVO USUARIO</div>
          </q-card-section>
          <q-card-section class="q-pt-xs">
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
              <div class="row">
                <div class="col-md-6 col-xs-12">
                <q-input
                outlined
                    v-model="dato.cedula"
                    type="text"
                    label="Carnet "
                    hint="Ingresar CI"
                    lazy-rules
                    :rules="[(val) => val.length > 5 || 'Por favor ingresa datos']"
                  />
                  <q-input
                  outlined
                    v-model="dato.name"
                    type="text"
                    label="Nombre "
                    hint="Ingresar Nombre"
                    lazy-rules
                    :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"
                  />
                 <!-- <q-select hint="Cargo" v-model="cargo" :options="cargos" label="Cargo" outlined />-->
 
                  <q-input
                  outlined
                    v-model="dato.email"
                    type="email"
                    label="Email"
                    hint="Correo electronico"
                    lazy-rules
                    :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"
                  />
  
                  <q-input
                  outlined
                    v-model="dato.password"
                    label="Contraseña"
                    hint="Contraseña"
                    lazy-rules
                    :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"
                    :type="typePassword?'password':'text'"
                  >
                  <template v-slot:append>
                            <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
                          </template>
                        </q-input>
                  <q-input
                  outlined
                    v-model="dato.fechalimite"
                    type="date"
                    label="Fecha Limite"
                    lazy-rules
                    :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"
                  />
  
                </div>
                <div class="col-md-6 col-xs-12">
                  <div class="text-5">Permisos</div>
                  <q-checkbox style="width: 100%"  v-for="(permiso,index) in permisos" :key="index" :label="permiso.nombre" v-model="permiso.estado" />
                </div>
              </div>
  
              <div>
                <q-btn label="Crear" type="submit" color="positive" icon="add_circle" />
                <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>
  
      <q-table dense :filter="filter" title="REGISTRO DE USUARIOS" :rows="data" :columns="columns" row-key="name" :rows-per-page-options="[50,100]">
        <template v-slot:top-right>
          <q-input outlined dense debounce="300" v-model="filter" placeholder="Search">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>
        <template v-slot:body-cell-permisos="props">
            <q-td key="permisos" :props="props">
              <ul>
                <li v-for="(p,i) in props.row.permisos" :key="i">{{p.nombre}}</li>
              </ul>
            </q-td>
            </template>
            <template v-slot:body-cell-cajas="props">
            <q-td key="cajas" :props="props">
              <ul>
                <li v-for="(p,i) in props.row.units" :key="i">{{p.nombre}}</li>
              </ul>
            </q-td>
            </template>
            <template v-slot:body-cell-estado="props">
            <q-td key="estado" :props="props">
              <q-badge :color="props.row.state=='ACTIVO'?'green':'red'"  :label="props.row.state" @click="cambioEstado(props.row)" />
            </q-td>
            </template>
            <template v-slot:body-cell-opcion="props">
  
            <q-td key="opcion" :props="props">
              <q-btn dense round flat  color="yellow" @click="editRow(props)" icon="edit"  />
              <q-btn dense round flat color="positive" @click="cambiopass(props)" icon="vpn_key" />
              <q-btn dense round flat color="green-10" @click="mispermisos(props)" icon="post_add" />
              <q-btn dense round flat color="deep-purple-9" @click="miscaja(props)" icon="summarize"/>
              
              <q-btn dense round flat color="red" @click="deleteRow(props)" icon="delete" ></q-btn>
            </q-td>
  
        </template>
      </q-table>
  
      <q-dialog v-model="dialog_mod">
        <q-card style="max-width: 80%; width: 50%">
          <q-card-section class="bg-warning text-white">
            <div class="text-h7"> <q-icon name="edit"/> MODIFICAR DATOS DE USUARIO</div>
          </q-card-section>
          <q-card-section class="q-pt-xs">
            <q-form @submit="onMod" class="q-gutter-md">
                <q-input
                outlined
              v-model="dato2.cedula"
              type="text"
              label="Carnet"
              hint="Ingresar CI"
              lazy-rules
              :rules="[(val) => val.length > 5 || 'Por favor ingresa datos']"
            />
              <q-input
              outlined
                v-model="dato2.name"
                type="text"
                label="Nombre "
                hint="Ingresar Nombre"
                lazy-rules
                :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"
              />

              <q-input
                filled
                v-model="dato2.email"
                type="email"
                label="Email"
                hint="Correo electronico"
                lazy-rules
                :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"
              />
              <q-input
              outlined
              v-model="dato2.fechalimite"
              type="date"
              label="Fecah Limite"
              lazy-rules
              :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"
            />
              <div>
                <q-btn label="Modificar" type="submit" color="positive" icon="add_circle" />
                <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>
  
      <q-dialog v-model="dialog_del">
        <q-card>
          <q-card-section class="row items-center">
            <q-avatar icon="clear" color="red" text-color="white" />
            <span class="q-ml-sm">Seguro de eliminar Registro.</span>
          </q-card-section>
  
          <q-card-actions align="right">
            <q-btn flat label="Eliminar" color="deep-orange" @click="onDel" />
            <q-btn flat label="Cancelar" color="primary" v-close-popup />
          </q-card-actions>
        </q-card>
      </q-dialog>
  
      <q-dialog v-model="modelpermiso">
        <q-card style="width: 700px;max-width: 80vw">
          <q-card-section class="bg-info">
            <div class="text-h7 text-white"><q-icon name="folder"/> PERMISOS DE ACCESO</div>
          </q-card-section>
          <q-card-section>
            <q-form @submit.prevent="updatepermisos">
              <!--          v-on:click.native="updatepermiso(permiso)"-->
              <q-checkbox style="width: 100%"  v-for="(permiso,index) in permisos2" :key="index" :label="permiso.nombre" v-model="permiso.estado" />
              <!--          <q-form>-->
              <!--&lt;!&ndash;            <q-checkbox v-model="permisos" />&ndash;&gt;-->
              <!--          </q-form>-->
              <q-btn  type="submit" color="info" icon="send" label="Actualizar"></q-btn>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>

      <q-dialog v-model="modelunit">
        <q-card style="width: 700px;max-width: 80vw">
          <q-card-section class="bg-info">
            <div class="text-h7 text-white"><q-icon name="folder"/> CAJAS ASIGNAR</div>
          </q-card-section>
          <q-card-section>
            <q-form @submit.prevent="updatecaja">
              <!--          v-on:click.native="updatepermiso(permiso)"-->
              <q-checkbox style="width: 100%"  v-for="(unit,index) in units" :key="index" :label="unit.nombre" v-model="unit.estado" />
              <!--          <q-form>-->
              <!--&lt;!&ndash;            <q-checkbox v-model="permisos" />&ndash;&gt;-->
              <!--          </q-form>-->
              <q-btn  type="submit" color="info" icon="send" label="Actualizar"></q-btn>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>

    </div>
  </template>
  
  <script>
  import { date } from 'quasar'
  import moment from 'moment'
  
  export default {
    name: 'UserPage',
    data () {
      return {
        alert: false,
        dialog_mod: false,
        dialog_del: false,
        typePassword: true,
        modelunit:false,
        fecha: date.formatDate(new Date(), 'YYYY-MM-DD'),
        filter: '',
        dato: { fechalimite: (moment(this.fecha).add(36, 'months').format('YYYY-MM-DD')) },
        model: '',
        dato2: {},
        options: [],
        props: [],
        unidades: [],
        permisos: [],
        permisos2: [],
        modelpermiso: false,
        units:[],
        uni: {},
        columns: [
          { name: 'cuenta', align: 'left', label: 'cuenta ', field: 'cuenta', sortable: true },
          { name: 'name', align: 'left', label: 'NOMBRE ', field: 'name', sortable: true },
          { name: 'email', align: 'left', label: 'E-MAIL', field: 'email', sortable: true },
          { name: 'estado', align: 'left', label: 'ESTADO', field: 'state', sortable: true },
          { name: 'permisos', align: 'left', label: 'PERMISOS', field: 'permisos', sortable: true },
          { name: 'cajas', align: 'left', label: 'cajas', field: 'cajas', sortable: true },
          { name: 'opcion', label: 'OPCIÓN', field: 'action', sortable: false }
        ],
        data: []
      }
    },
    created () {
      /* if (!this.$store.state.login.boolusuario){
         this.$router.replace({ path: '/' })
      } */
  
      this.misdatos()
      this.$api.get('permiso').then(res => {
        res.data.forEach(r => {
          this.permisos.push({ id: r.id, nombre: r.nombre, estado: false })
          this.permisos2.push({ id: r.id, nombre: r.nombre, estado: false })
        })
      })
      this.getUnit()
    },
    methods: {
        getUnit(){
            this.$api.get('unit').then((res) => {
                this.units=[]
                res.data.forEach(r => {
                this.units.push({id:r.id,nombre:r.nombre,estado:false})                    
                });
            })
        },
      cambioEstado(user1){
        this.$api.post('cambioEstado/' + user1.id).then(() => {
          this.misdatos()
        })
      },
      regDialog () {
        this.dato = {  }
        this.alert = true
      },
      updatepermisos () {
        this.$api.put('updatepermisos/' + this.dato2.id, { permisos: this.permisos2 }).then(() => {
          // console.log(res.data)
          this.modelpermiso = false
          this.misdatos()
        }).catch(err => {
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
        })
      },
      updatecaja () {
        this.$api.put('updatecajero/' + this.dato2.id, { units: this.units }).then(() => {
          // console.log(res.data)
          this.modelunit = false
          this.misdatos()
        }).catch(err => {
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
        })
      },
      mispermisos (i) {
        // console.log(i.row)
        this.modelpermiso = true
        this.dato2 = i.row
        let p
        this.permisos2.forEach(pe => {
          // console.log(pe);
          p = this.dato2.permisos.find(r => r.pivot.permiso_id === pe.id)
          // console.log(p)
          if (p !== undefined) { pe.estado = true } else { pe.estado = false }
          // console.log(p)
        })
      },
      miscaja(i){
        this.modelunit = true
        this.dato2 = i.row
        let p
        this.units.forEach(pe => {
          // console.log(pe);
          p = this.dato2.units.find(r => r.pivot.unit_id === pe.id)
          // console.log(p)
          if (p !== undefined) { pe.estado = true } else { pe.estado = false }
          // console.log(p)
        })
      },
      misdatos () {
        this.$q.loading.show()
        this.$api.get('user').then((res) => {
          console.log(res.data)
          this.data = res.data
          this.$q.loading.hide()
        })
      },
      editRow (item) {
        this.dato2 = item.row
        // console.log(this.dato2)
        this.dialog_mod = true
      },
      deleteRow (item) {
        this.dato2 = item.row
        this.dialog_del = true
      },
      onSubmit () {
        this.$q.loading.show()
        this.$api.post('user', {
          cedula: this.dato.cedula,
          name: this.dato.name,
          password: this.dato.password,
          email: this.dato.email,
          fechalimite: this.dato.fechalimite,
          permisos: this.permisos
        }).then(() => {
          // console.log(res.data)
          this.$q.notify({
            color: 'green-4',
            textColor: 'white',
            icon: 'cloud_done',
            message: 'Creado correctamente'
          })
          this.dato = { fechalimite: (moment(this.fecha).add(12, 'months').format('YYYY-MM-DD')) }
          this.alert = false
          this.misdatos()
        }).catch(err => {
          console.log(err.response.data)
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
          this.$q.loading.hide()
        })
      },
      onMod () {
        this.$q.loading.show()
        this.$api.put('user/' + this.dato2.id, {
          cedula: this.dato2.cedula,
          name: this.dato2.name,
          email: this.dato2.email,
          fechalimite: this.dato2.fechalimite
        }).then(() => {
          this.$q.notify({
            color: 'green-4',
            textColor: 'white',
            icon: 'cloud_done',
            message: 'Modificado correctamente'
          })
          this.dialog_mod = false
          this.misdatos()
        })
      },
      onDel () {
        this.$q.loading.show()
        this.$api.delete('user/' + this.dato2.id)
          .then(() => {
            this.$q.notify({
              color: 'green-4',
              textColor: 'white',
              icon: 'cloud_done',
              message: 'Eliminado correctamente'
            })
            this.dialog_del = false
            this.misdatos()
          }).catch(err => {
            this.$q.loading.hide()
            this.$q.notify({
              message: err.response.data.message,
              icon: 'error',
              color: 'red'
            })
          })
      },
      onReset () {
        this.dato.nombre = null
        this.dato.inicio = 0
        this.dato.fin = 0
      },
      cambiopass (i) {
        // console.log(i.row);
        this.$q.dialog({
          title: 'CAMBIAR PASSWORD',
          message: 'Ingresar nueva contraseña',
          prompt: {
            model: '',
            type: 'text' // optional
          },
          cancel: true,
          persistent: true
        }).onOk(data => {
          this.$q.loading.show()
          this.$api.put('updatePassword/' + i.row.id, { password: data }).then(() => {
            this.$q.loading.hide()
          })
        }) 
      }
    }
  }
  </script>