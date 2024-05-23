import axios from "axios";

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
        }]
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
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                import ("pages/PengaturanPeran.vue")
        }]
    },

    // pembeli
    {
        path: '/beranda-pembeli',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                //viewtoko - done
                import ("pages/page-pembeli/BerandaPembeli.vue")
        }]
    },

    {
      path: '/halaman-toko',
      component: () =>
        import ('layouts/MainLayout.vue'),
      children: [{
          path: '',
          component: () =>
            import ("pages/page-pembeli/HalamanToko.vue")
        }
      ]
    },
    {
      path: '/detail-pesanan/:id',
      component: () =>
        import ("pages/page-pembeli/DetailPesanan.vue")
    },

    // {
    //     path: '/detail-pesanan',
    //     component: () =>
    //         import ('layouts/MainLayout.vue'),
    //     children: [{
    //         path: '',
    //         component: () =>
    //             //viewonemenu -> cek deh la lu harus passing data id trus ntr diabakal lempar data balik
    //             import ("pages/page-pembeli/DetailPesanan.vue")
    //     }]
    // },
    {
        path: '/ringkasan-pesanan',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                //ini pake js
                import ("pages/page-pembeli/RingkasanPesanan.vue")
        }]
    },
    {
        path: '/halaman-pembayaran',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                //showqris - done
                import ("pages/page-pembeli/HalamanPembayaran.vue")
        }]
    },
    {
        path: '/status-pesanan',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                //ini pake js sama kaya view keranjang
                import ("pages/page-pembeli/StatusPesanan.vue")
        }]
    },

    //penjual
    {
        path: '/beranda-penjual',
        component: () =>
            import ('layouts/MainLayout1.vue'),
        children: [{
            path: '',
            component: () =>
                //viewmenuperpenjual - api not ready
                import ("pages/page-penjual/BerandaPenjual.vue")
        }]
    },
    {
        path: '/riwayat-penjual',
        component: () =>
            import ('layouts/MainLayout1.vue'),
        children: [{
            path: '',
            component: () =>
                //viewtransaksi - done
                import ("pages/page-penjual/RiwayatPenjual.vue")
        }]
    },
    {
        path: '/rekap-penjual',
        component: () =>
            import ('layouts/MainLayout1.vue'),
        children: [{
            path: '',
            component: () =>
                //viewrekap - done
                import ("pages/page-penjual/RekapPenjual.vue")
        }]
    },
    {
        path: '/pesanan-penjual',
        component: () =>
            import ('layouts/MainLayout1.vue'),
        children: [{
            path: '',
            component: () =>
                //viewtransaksi - done
                import ("pages/page-penjual/pesanan/PesananPenjual.vue")
        }]
    },
    {
        path: '/edit-pesanan',
        component: () =>
            import ('layouts/MainLayout1.vue'),
        children: [{
            path: '',
            component: () =>
                //updatemenu -done
                import ("pages/page-penjual/pesanan/EditPesanan.vue")
        }]
    },
    {
        path: '/profile',
        component: () =>
            import ('layouts/MainLayout1.vue'),
        children: [{
            path: '',
            component: () =>
                //viewprofile - done
                import ("pages/page-penjual/ProfilePenjual.vue")
        }]
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
