const routes = [{
        path: '/settings',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '/register',
            component: () =>
                import ('pages/RegisterPage.vue')
        }, {
            path: '/login',
            component: () =>
                import ('pages/LoginPage.vue')
        }, {
            path: '/admin',
            component: () =>
                import ('pages/AdminPage.vue')
        },
        { path: '/forgot-password', component: () => import('pages/ForgotPasswordPage.vue') },
        { path: '/verification', component: () => import('pages/VerificationPage.vue') }
      ]
    },
    // {
    //   path: '/',
    //   component: () => import('layouts/MainLayout.vue'),
    //   children: [
    //     { path: '', component: () => import('pages/IndexPage.vue') }
    //   ]
    // },




  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import("pages/PengaturanPeran.vue") }
    ]
  },
  {
    path: '/beranda-pembeli',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import("pages/page-pembeli/BerandaPembeli.vue") }
    ]
  },
  {
    path: '/register',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import("pages/RegisterPage.vue") }
    ]
  },
    {
        path: '/',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                import ("pages/PengaturanPeran.vue")
        }]
    },
    {
        path: '/beranda-pembeli',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                import ("pages/page-pembeli/HomePembeli.vue")
        }]
    },

  //penjual
  {
    path: '/beranda-penjual',
    component: () => import('layouts/MainLayout1.vue'),
    children: [
      { path: '', component: () => import("pages/page-penjual/BerandaPenjual.vue") }
    ]
  },
  {
    path: '/riwayat-penjual',
    component: () => import('layouts/MainLayout1.vue'),
    children: [
      { path: '', component: () => import("pages/page-penjual/RiwayatPenjual.vue") }
    ]
  },
  {
    path: '/rekap-penjual',
    component: () => import('layouts/MainLayout1.vue'),
    children: [
      { path: '', component: () => import("pages/page-penjual/RekapPenjual.vue") },
      { path: '/rekap-penjual/:id/detail', component: () => import('pages/page-penjual/DetailRekap.vue') },
    ]
  },
  {
    path: '/pesanan-penjual',
    component: () => import('layouts/MainLayout1.vue'),
    children: [
      { path: '', component: () => import("pages/page-penjual/pesanan/PesananPenjual.vue") }
    ]
  },
  {
    path: '/edit-pesanan',
    component: () => import('layouts/MainLayout1.vue'),
    children: [
      { path: '', component: () => import("pages/page-penjual/pesanan/EditPesanan.vue") }
    ]
  },
  {
    path: '/profile',
    component: () => import('layouts/MainLayout1.vue'),
    children: [
      { path: '', component: () => import("pages/page-penjual/ProfilePage.vue") }
    ]
  },


    // {
    //   path: '/pengaturan-peran',
    //   component: () => import('layouts/MainLayout.vue'),
    //   children:[
    //     {
    //       path: '',
    //       component: () =>
    //         import("pages/PengaturanPeran.vue"),
    //     }
    //   ],
    // },


    {
        path: '/:catchAll(.*)*',
        component: () =>
            import ('pages/ErrorNotFound.vue')
    }
]

export default routes
