<?php

return [
    'invoices' => [
        'title' => 'Faktur',
        'group' => 'Pembayaran',
        'single' => 'Faktur',
        'widgets' => [
            'count' => 'Total Faktur',
            'paid' => 'Total Pembayaran',
            'due' => 'Total Belum Dibayar'
        ],
        'columns' => [
            'id' => 'ID Faktur',
            'name' => 'Nama Pelanggan',
            'phone' => 'Nomor Telepon',
            'address' => 'Alamat',
            'date' => 'Tanggal Faktur',
            'due_date' => 'Tanggal Jatuh Tempo',
            'type' => 'Jenis Faktur',
            'status' => 'Status',
            'currency_id' => 'Mata Uang',
            'items' => 'Item Faktur',
            'item' => 'Item',
            'item_name' => 'Nama Item',
            'description' => 'Deskripsi',
            'qty' => 'Kuantitas',
            'price' => 'Harga',
            'discount' => 'Diskon',
            'vat' => 'PPN',
            'total' => 'Total',
            'shipping' => 'Pengiriman',
            'notes' => 'Catatan',
            'account' => 'Akun',
            'by' => 'Oleh',
            'from' => 'Dari',
            'paid' => 'Dibayar',
            'updated_at' => 'Diperbarui Pada',
        ],
        'sections' => [
            'billed_from' => [
                'title' => 'Ditagih Dari',
                'columns' => [
                    'name' => 'Nama Perusahaan',
                    'address' => 'Alamat Perusahaan',
                    'phone' => 'Telepon Perusahaan',
                ],
            ],
            'customer_data' => [
                'title' => 'Data Pelanggan',
                'columns' => [
                    'name' => 'Nama',
                    'phone' => 'Telepon',
                    'address' => 'Alamat',
                ],
            ],
            'invoice_data' => [
                'title' => 'Data Faktur',
                'columns' => [
                    'date' => 'Tanggal Faktur',
                    'due_date' => 'Tanggal Jatuh Tempo',
                    'type' => 'Jenis Faktur',
                    'status' => 'Status',
                    'currency' => 'Mata Uang',
                ],
            ],
            'totals' => [
                'title' => 'Total'
            ],
        ],
        'filters' => [
            'status' => 'Status',
            'type' => 'Jenis Faktur',
            'due' => [
                'label' => 'Tanggal Jatuh Tempo',
                'columns' => [
                    'overdue' => 'Terlambat',
                    'today' => 'Hari Ini',
                ]
            ],
        ],
        'actions' => [
            'view_invoice' => 'Lihat Faktur',
            'edit_invoice' => 'Edit Faktur',
            'delete_invoice_forever' => 'Hapus Faktur Permanen',
            'print' => 'Cetak Faktur',
            'pay' => [
                'label' => 'Bayar Faktur',
                'notification' => [
                    'title' => 'Faktur Dibayar',
                    'body' => 'Pembayaran Faktur Berhasil'
                ]
            ],
            'status' => [
                'title' => 'Status',
                'label' => 'Ubah Status',
                'notification' => [
                    'title' => 'Status Berubah',
                    'body' => 'Status Faktur Berhasil Diperbarui'
                ]
            ],
        ],
        'logs' => [
            'title' => 'Log Faktur',
            'single' => 'Log Faktur',
            'columns' => [
                'log' => 'Log',
                'type' => 'Jenis',
                'created_at' => 'Dibuat Pada',
            ],
        ],
        'view' => [
            'bill_from' => 'Ditagih Dari',
            'bill_to' => 'Ditagih Kepada',
            'invoice' => 'Faktur',
            'issue_date' => 'Tanggal Terbit',
            'due_date' => 'Tanggal Jatuh Tempo',
            'status' => 'Status',
            'type' => 'Jenis',
            'item' => 'Item',
            'total' => 'Total',
            'price' => 'Harga',
            'vat' => 'PPN',
            'discount' => 'Diskon',
            'qty' => 'Kuantitas',
            'subtotal' => 'Subtotal',
            'tax' => 'Pajak',
            'paid' => 'Dibayar',
            'balance_due' => 'Sisa Pembayaran',
            'notes' => 'Catatan',
        ]
    ],
    'settings' => [
        'status' => [
            'title' => 'Pengaturan Status Order',
            'description' => 'Ubah warna dan teks status order Anda',
            'columns' => [
                'status' => 'Status',
                'color' => 'Warna',
                'value' => 'Nilai',
            ]
        ],
    ],
];

