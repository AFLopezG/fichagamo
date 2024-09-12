import { RouteRecordRaw } from 'vue-router'
import MainLayout from 'layouts/MainLayout.vue'
import IndexPage from 'pages/IndexPage.vue'
import Login from 'pages/Login.vue'
import Cliente from 'pages/Cliente.vue'
import Pantalla from 'pages/Pantalla.vue'
import Ventanilla from 'pages/Ventanilla.vue'
import Usuarios from 'pages/Usuarios.vue'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', component: IndexPage , meta:{ requiresAuth: true } },
      { path: '/usuarios', component: Usuarios, meta: { requiresAuth: true } },
      { path: '/ventanilla', component: Ventanilla, meta: { requiresAuth: true } },
    ],
  },
  {
    path: '/login',
    component: Login
  },
  {
    path: '/cliente',
    component: Cliente
  },
  {
    path: '/pantalla',
    component: Pantalla
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
