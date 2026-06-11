<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Andi Pratama',
                'nim' => '1202210001',
                'role' => 'Project Manager & Cloud Architect',
                'email' => 'andi.pratama@student.univ.ac.id',
                'phone' => '+6281234567890',
                'photo' => 'images/members/andi.png',
                'github' => 'https://github.com/andipratama',
                'linkedin' => 'https://linkedin.com/in/andipratama',
                'bio' => 'Andi leads the project and designs the overall systems architecture. He is in charge of deploying this Laravel app to AWS Elastic Beanstalk and setting up the RDS MySQL database.',
            ],
            [
                'name' => 'Budi Santoso',
                'nim' => '1202210002',
                'role' => 'Lead Frontend Developer',
                'email' => 'budi.santoso@student.univ.ac.id',
                'phone' => '+6281234567891',
                'photo' => 'images/members/budi.png',
                'github' => 'https://github.com/budisantoso',
                'linkedin' => 'https://linkedin.com/in/budisantoso',
                'bio' => 'Budi is a creative frontend developer who loves crafting seamless interactive experiences using modern HTML, CSS, and Javascript. He is the master behind the beautiful glassmorphic UI.',
            ],
            [
                'name' => 'Citra Lestari',
                'nim' => '1202210003',
                'role' => 'UI/UX Designer & Content Strategist',
                'email' => 'citra.lestari@student.univ.ac.id',
                'phone' => '+6281234567892',
                'photo' => 'images/members/citra.png',
                'github' => 'https://github.com/citralestari',
                'linkedin' => 'https://linkedin.com/in/citralestari',
                'bio' => 'Citra focuses on user-centric design principles. She conducts user testing, establishes the color palette, and ensures the website feels high-end, modern, and easy to navigate.',
            ],
            [
                'name' => 'Dewi Anggraini',
                'nim' => '1202210004',
                'role' => 'DevOps Engineer & QA specialist',
                'email' => 'dewi.anggraini@student.univ.ac.id',
                'phone' => '+6281234567893',
                'photo' => 'images/members/dewi.png',
                'github' => 'https://github.com/dewianggraini',
                'linkedin' => 'https://linkedin.com/in/dewianggraini',
                'bio' => 'Dewi handles backend integrations, testing automation, and database migrations. She is also responsible for configuring the security groups and database backups on AWS RDS.',
            ],
        ];

        foreach ($members as $member) {
            Member::updateOrCreate(['nim' => $member['nim']], $member);
        }
    }
}
