<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeder ini disesuaikan dengan struktur tabel DB yang ada:
     * kolom: nama, nim, tanggung_jawab, foto
     */
    public function run(): void
    {
        $members = [
            [
                'nama'           => 'Renasya Cahya Handayani',
                'nim'            => '102022300290',
                'tanggung_jawab' => 'Koordinator, Konfigurasi ALB',
                'foto'           => null,
            ],
            [
                'nama'           => 'Miftha Huljannah Sarvita Yusuf',
                'nim'            => '102022300268',
                'tanggung_jawab' => 'Setup Load Balancer, Pengujian',
                'foto'           => null,
            ],
            [
                'nama'           => 'Mas Ayu Sakinah Rizki Fabila',
                'nim'            => '102022300172',
                'tanggung_jawab' => 'Struktur Database, Kesimpulan',
                'foto'           => null,
            ],
            [
                'nama'           => 'Bayudanta Yafi Setyawan',
                'nim'            => '102022300169',
                'tanggung_jawab' => 'Konfigurasi Web Server',
                'foto'           => null,
            ],
            [
                'nama'           => 'Aska Putra Supriyadi',
                'nim'            => '102022300197',
                'tanggung_jawab' => 'Pembuatan Instance, Analisis',
                'foto'           => null,
            ],
        ];

        foreach ($members as $member) {
            Member::updateOrCreate(['nim' => $member['nim']], $member);
        }
    }
}
