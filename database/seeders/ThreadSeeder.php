<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ThreadSeeder extends Seeder
{
    public function run()
    {
        // 1. Pastikan User Admin Ada
        $user = User::firstOrCreate(
            ['email' => 'admin@tachyon.sec'],
            [
                'name' => 'CyberOps Admin',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Artikel Panjang 1: Ransomware
        Thread::create([
            'user_id' => $user->id,
            'type' => 'article',
            'title' => 'Analisis Mendalam: Varian Baru Ransomware LockBit 3.0',
            'category_id' => 'Malware',
            'image' => null,
            'content' => "Tim riset keamanan siber kami baru saja menyelesaikan analisis forensik terhadap varian terbaru LockBit 3.0 yang menyerang beberapa institusi keuangan di Asia Tenggara minggu lalu.

Varian ini menunjukkan evolusi signifikan dibandingkan pendahulunya. Berikut adalah temuan utama kami:

1. Teknik Anti-Analisis
Malware ini kini memeriksa lingkungan sandbox sebelum dieksekusi. Jika ia mendeteksi adanya debugger atau virtual machine monitoring tools, ia akan mematikan dirinya sendiri atau mengeksekusi kode 'junk' yang tidak berbahaya untuk menipu analis.

2. Enkripsi Hybrid
LockBit 3.0 menggunakan kombinasi AES-256 untuk mengenkripsi file dan RSA-4096 untuk mengunci key AES tersebut. Ini membuat upaya dekripsi tanpa private key penyerang menjadi mustahil secara komputasi saat ini.

3. Penyebaran Lateral
Setelah menginfeksi satu endpoint, malware menggunakan kredensial yang dicuri dari memori (LSASS dump) untuk melompat ke server lain melalui protokol RDP dan SMB.

Rekomendasi Mitigasi:
- Segera perbarui signature EDR (Endpoint Detection and Response) Anda.
- Batasi penggunaan PowerShell pada user biasa.
- Lakukan backup offline secara berkala (prinsip 3-2-1).",
        ]);

        // 3. Artikel Panjang 2: Phishing
        Thread::create([
            'user_id' => $user->id,
            'type' => 'article',
            'title' => 'Waspada! Kampanye Phishing "Urgent Action" Menargetkan HRD',
            'category_id' => 'Social Eng',
            'image' => null,
            'content' => "Divisi Blue Team Tachyon mendeteksi lonjakan serangan email phishing yang sangat tertarget (spear-phishing) yang menyasar departemen HRD di berbagai perusahaan teknologi.

Modus Operandi:
Pelaku mengirimkan email lamaran kerja dengan subjek \"LAMARAN KERJA - SENIOR DEVELOPER - [NAMA PELAMAR]\". Email tersebut terlihat sangat meyakinkan dengan bahasa formal yang rapi.

Di dalam email, terdapat lampiran bernama \"CV_Portfolio_2024.pdf.exe\".
Karena Windows secara default menyembunyikan ekstensi file, korban hanya melihat \"CV_Portfolio_2024.pdf\". Icon file tersebut juga telah dimodifikasi menyerupai icon Adobe Acrobat Reader.

Dampak:
Jika file dieksekusi, ia akan menginstal backdoor 'AsyncRAT' yang memberikan penyerang akses penuh ke komputer korban, termasuk kemampuan untuk merekam layar, merekam ketikan keyboard (keylogger), dan mencuri password browser.

Tindakan Pencegahan:
1. Edukasi staf HRD untuk selalu memeriksa ekstensi file.
2. Atur Windows untuk 'Show file extensions'.
3. Blokir file executable (.exe, .scr, .bat, .vbs) pada gateway email perusahaan.",
        ]);

        // 4. Artikel Panjang 3: SSH Vulnerability
        Thread::create([
            'user_id' => $user->id,
            'type' => 'article',
            'title' => 'Zero-Day Kritis pada OpenSSH: Update Server Anda Sekarang!',
            'category_id' => 'Vulnerability',
            'image' => null,
            'content' => "Dunia server Linux sedang diguncang oleh penemuan kerentanan baru (CVE-2024-9999) pada pustaka OpenSSH versi 8.0 hingga 9.3. Kerentanan ini diklasifikasikan sebagai 'CRITICAL' dengan skor CVSS 9.8.

Apa Bahayanya?
Celah keamanan ini memungkinkan penyerang jarak jauh (remote attacker) untuk melakukan Remote Code Execution (RCE) dengan hak akses root tanpa perlu mengetahui username atau password server. Penyerang hanya perlu mengirimkan paket jaringan yang dimanipulasi secara khusus ke port 22.

Siapa yang Terdampak?
Hampir semua distro Linux populer termasuk Ubuntu 22.04 LTS, Debian 11, dan CentOS Stream 9 yang menjalankan konfigurasi default OpenSSH terdampak oleh celah ini.

Solusi (Patching):
Para pengembang OpenSSH telah merilis versi patch. Sysadmin disarankan untuk menjalankan perintah update berikut segera:

- Ubuntu/Debian: `sudo apt update && sudo apt upgrade openssh-server`
- CentOS/RHEL: `sudo yum update openssh-server`

Workaround Sementara:
Jika Anda tidak bisa melakukan reboot atau update saat ini, Anda bisa membatasi akses SSH hanya untuk IP Address terpercaya menggunakan IPTables atau Firewall Cloud Provider.",
        ]);

        // ... kode artikel sebelumnya ...

        // --- DATA DUMMY UNTUK FORUM (type = 'topic') ---

        // 5. Topik Diskusi 1: Pertanyaan CTF
        Thread::create([
            'user_id' => $user->id,
            'type' => 'topic', // <--- PENTING: tipe topic
            'title' => '[ASK] Ada yang bisa bantu decode payload base64 ini untuk CTF HackTheBox?',
            'content' => 'Saya sedang mengerjakan challenge "Easy Peasy" di HTB. Saya menemukan string aneh di cookie session: "VFZSSlBRPT0...". Sudah coba decode base64 biasa tapi keluarnya gibberish. Apakah ini double encoded atau pakai XOR? Mohon petunjuknya master.',
            'category_id' => 'CTF Help',
            'image' => null, 
            'created_at' => now()->subHours(1),
        ]);

        // 6. Topik Diskusi 2: Diskusi Karir
        Thread::create([
            'user_id' => $user->id,
            'type' => 'topic',
            'title' => 'Sertifikasi mana yang lebih worth it untuk pemula: CEH atau eJPT?',
            'content' => 'Halo agan-agan, saya baru mau terjun ke dunia pentest. Budget terbatas. Banyak yang bilang CEH terlalu teoritis, tapi HRD suka. Sedangkan eJPT lebih hands-on. Ada saran path belajar yang efektif?',
            'category_id' => 'Career',
            'image' => null,
            'created_at' => now()->subHours(5),
        ]);

        // 7. Topik Diskusi 3: Berita/Diskusi Linux
        Thread::create([
            'user_id' => $user->id,
            'type' => 'topic',
            'title' => 'Kali Linux 2024.1 Rilis! Fitur apa yang paling kalian tunggu?',
            'content' => 'Baru aja update, tampilan Gnomensenya makin sleek. Tools barunya juga lumayan ngebantu buat recon. Gimana menurut kalian? Ada bug yang ditemuin?',
            'category_id' => 'Discussion',
            'image' => null, // Nanti bisa dikasih gambar screenshot
            'created_at' => now()->subDays(1),
        ]);
    }
}