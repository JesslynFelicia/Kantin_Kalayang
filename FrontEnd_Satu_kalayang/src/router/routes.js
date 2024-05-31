const routes = [{
        path: '/',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
                path: '',
                component: () =>
                    import ("pages/PengaturanPeran.vue")
            },
            {
                path: '/register',
                component: () =>
                    import ('pages/RegisterPage.vue')
            },
            {
                path: '/login',
                component: () =>
                    import ('pages/LoginPage.vue')
            },
            {
                path: '/admin',
                component: () =>
                    import ('pages/AdminPage.vue')
            },
            {
                path: '/forgot-password',
                component: () =>
                    import ('pages/ForgotPasswordPage.vue')
            },
            {
                path: '/verification',
                component: () =>
                    import ('pages/VerificationPage.vue')
            }
        ]
    },

    // const routes = [{
    //         path: '/settings',
    //         component: () =>
    //             import ('layouts/MainLayout.vue'),
    //         children: [{
    //             path: '/register',
    //             component: () =>
    //                 import ('pages/RegisterPage.vue')
    //         }, {
    //             path: '/login',
    //             component: () =>
    //                 import ('pages/LoginPage.vue')
    //         }, {
    //             path: '/admin',
    //             component: () =>
    //                 import ('pages/AdminPage.vue')
    //         }]
    //     },
    // {
    //   path: '/',
    //   component: () => import('layouts/MainLayout.vue'),
    //   children: [
    //     { path: '', component: () => import('pages/IndexPage.vue') }
    //   ]
    // },

    {
        path: '/beranda-pembeli',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
                path: '',
                component: () =>
                    import ("pages/page-pembeli/BerandaPembeli.vue")
            },
            {
                path: '/ringkasan-pesanan',
                component: () =>
                    import ("pages/page-pembeli/RingkasanPesanan.vue")
            },
            {
                path: '/pembayaran',
                component: () =>
                    import ("pages/page-pembeli/Pembayaran.vue")
            },
            {
                path: '/status-pesanan',
                component: () =>
                    import ("pages/page-pembeli/StatusPesanan.vue")
            },
        ]
    },
    {
        path: '/halaman-toko',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                import ("pages/page-pembeli/HalamanToko.vue")
        }]
    },
    {
        path: '/detail-pesanan/:id',
        component: () =>
            import ("pages/page-pembeli/DetailPesanan.vue")
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

    //penjual
    {
        path: '/beranda-penjual',
        component: () =>
            import ('layouts/MainLayout1.vue'),
        children: [{
            path: '',
            component: () =>
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
                    import ("pages/page-penjual/RekapPenjual.vue")
            },
            {
                path: '/rekap-penjual/:id/detail',
                component: () =>
                    import ('pages/page-penjual/DetailRekap.vue')
            },
        ]
    },
    {
        path: '/pesanan-penjual',
        component: () =>
            import ('layouts/MainLayout1.vue'),
        children: [{
            path: '',
            component: () =>
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
                import ("pages/page-penjual/pesanan/EditPesanan.vue")
        }]
    },
    {
        path: '/profile',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                import ("pages/page-penjual/ProfilePage.vue")
        }]
    },
    {
        path: '/beranda-admin',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                import ("pages/BerandaAdmin.vue")
        }]
    },
    {
        path: '/daftar-akun',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                import ("pages/DaftarAkun.vue")
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
        path: '/halaman-toko/:id',
        component: () =>
            import ('layouts/MainLayout.vue'),
        children: [{
            path: '',
            component: () =>
                import ("pages/page-pembeli/HalamanToko.vue")
        }]
    },

    {
        path: '/detail-pesanan/:menud',
        component: () =>
            import ("pages/page-pembeli/DetailPesanan.vue")
    },
    // {
    //   path: '/halaman-toko/:id',
    //   component: () =>
    //     import ("pages/page-pembeli/HalamanToko.vue")
    // },

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
    // {
    //     path: '/profile-penjual',
    //     component: () =>
    //         import ('layouts/MainLayout1.vue'),
    //     children: [{
    //         path: '',
    //         component: () =>
    //             //viewprofile - done
    //             import ("pages/page-penjual/ProfilePenjual.vue")
    //     }]
    // },


    {
        path: '/:catchAll(.*)*',
        component: () =>
            import ('pages/ErrorNotFound.vue')
    }
]

export default routes