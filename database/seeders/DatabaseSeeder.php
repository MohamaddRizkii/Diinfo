<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN ADMIN UTAMA
        $admin = User::create([
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 2. LOGIKA OTOMATISASI FOLDER IMAGE THUMBNAIL
        $uploadPath = public_path('uploads/news');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // 3. DATA BASE KATEGORI & ISI BERITANYA
        $dataBerita = [
            'Politik' => [
                [
                    'title' => 'Safari Politik Global: Presiden Prabowo Bertolak ke 4 Negara Besok, Bawa Misi Investasi Rp150 Triliun dan Ketahanan Pangan',
                    'content' => "Presiden Republik Indonesia, Prabowo Subianto, dijadwalkan bertolak dari Bandara Internasional Halim Perdanakusuma besok pagi untuk memulai rangkaian kunjungan kerja maraton ke empat negara sahabat. Lawatan diplomatik yang akan berlangsung selama sepuluh hari ini disebut-sebut sebagai salah satu agenda luar negeri paling krusial guna mengamankan target pertumbuhan ekonomi nasional. Menteri Luar Negeri bersama jajaran menteri koordinator melepas keberangkatan Kepala Negara yang juga didampingi oleh delegasi pengusaha kakap dari Kamar Dagang dan Industri (Kadin) Indonesia. Empat negara yang menjadi tujuan utama lawatan kali ini meliputi China, Jerman, Arab Saudi, dan berakhir di Australia.

Tujuan pertama Presiden Prabowo adalah Beijing, China, untuk bertemu dengan Presiden Xi Jinping. Fokus utama pemerintah dalam pertemuan bilateral tersebut adalah mengejar komitmen investasi lanjutan untuk proyek energi hijau dan hilirisasi nikel di Indonesia bagian timur. Menteri Koordinator Bidang Perekonomian yang ikut dalam rombongan mengungkapkan bahwa pemerintah menargetkan penandatanganan Nota Kesepahaman senilai total Rp150 triliun. Indonesia menegaskan tidak hanya bicara soal menjual bahan mentah, melainkan mewajibkan mitra asing membawa teknologi pemrosesan terbaik, membangun pabrik baterai dari hulu ke hilir, serta menyerap tenaga kerja lokal secara maksimal.

Dari Asia Timur, helat diplomasi bergeser ke Berlin, Jerman, untuk membahas kerja sama perdagangan Uni Eropa dan modernisasi alat utama sistem persenjataan TNI. Indonesia membidik transfer teknologi untuk sistem pertahanan udara jarak menengah dan pengadaan kapal selam mutakhir guna mengantisipasi dinamika geopolitik di kawasan regional. Setelah itu, Presiden Prabowo akan melanjutkan perjalanan ke Riyadh, Arab Saudi, demi menjajaki investasi besar di sektor ketahanan pangan nasional. Pemerintah berencana menawarkan konsep kemitraan proyek lumbung pangan berkelanjutan di Kalimantan dan Papua kepada investor Timur Tengah, sebelum akhirnya menutup rangkaian kunjungan di Australia untuk membahas kerja sama sektor agrikultur dan peternakan.

Meskipun safari luar negeri ini dinilai agresif dan bernilai strategis tinggi, langkah Presiden Prabowo tetap mendapat sorotan tajam dari para pengamat politik di dalam negeri. Beberapa pakar mengingatkan bahwa pemerintah memiliki tugas besar untuk membuktikan bahwa tumpukan kerja sama di luar negeri benar-benar bisa terealisasi menjadi lapangan kerja nyata bagi masyarakat. Menanggapi kekhawatiran tersebut, pihak Istana memastikan bahwa roda pemerintahan di dalam negeri tetap berjalan normal di bawah kendali Wakil Presiden selaku Pelaksana Tugas Presiden, dan rombongan dijadwalkan langsung menggelar rapat evaluasi kabinet setibanya di tanah air akhir pekan depan."
                ],
                [
                    'title' => 'Babak Baru Koalisi Parlemen: Tiga Partai Besar Sepakat Bentuk Blok Politik Baru Jelang Sidang Paripurna RUU Politik',
                    'content' => "Peta politik nasional kembali mengalami pergeseran dinamis setelah tiga pimpinan partai besar secara mengejutkan menggelar pertemuan tertutup di Jakarta Selatan semalam. Pertemuan yang berlangsung hingga dini hari tersebut menghasilkan kesepakatan politik yang cukup fundamental, yakni pembentukan blok koalisi parlemen baru yang diberi nama Fraksi Persatuan Nasional. Konsolidasi mendadak ini diprediksi akan mengubah peta kekuatan di Dewan Perwakilan Rakyat secara drastis, terutama dalam pengambilan keputusan strategis pada masa sidang pleno yang akan datang. Langkah ini diambil di tengah hangatnya pembahasan revisi Undang-Undang Politik yang tengah digodok oleh Badan Legislasi parlemen.

Agenda utama dari pembentukan blok baru ini berpusat pada penyamaan suara terkait ambang batas parlemen dan mekanisme pemilihan kepala daerah ke depan. Salah satu ketua umum partai yang hadir dalam pertemuan tersebut menyatakan bahwa koalisi ini dibentuk bukan untuk menjegal program-program pemerintah, melainkan untuk memastikan adanya keseimbangan checks and balances yang sehat di dalam parlemen. Mereka menilai perlunya penyederhanaan jumlah partai politik di parlemen agar pengambilan kebijakan publik tidak berlarut-larut dalam perdebatan yang tidak produktif, sekaligus tetap menjaga keterwakilan suara masyarakat daerah secara proporsional.

Di sisi lain, terbentuknya blok politik baru ini langsung memicu reaksi keras dari kelompok partai-partai menengah dan kecil yang berada di luar koalisi tersebut. Mereka menilai pergerakan tiga partai besar ini sebagai langkah sistematis untuk mempersempit ruang demokrasi dan membatasi munculnya kekuatan politik alternatif di tanah air. Juru bicara dari aliansi partai mandiri menyatakan bahwa aturan yang coba didorong oleh blok baru tersebut berpotensi memberangus keberagaman aspirasi politik dan membuat sistem parlemen menjadi terlalu oligarkis. Mereka berjanji akan menggalang kekuatan tandingan untuk melakukan lobi-lobi politik yang lebih ketat demi mempertahankan hak-hak keterwakilan partai kecil pada sidang paripurna mendatang.

Menanggapi dinamika yang kian memanas ini, pengamat komunikasi politik dari Universitas Indonesia menilai bahwa fenomena bongkar pasang koalisi adalah hal yang lumrah, namun momentum kali ini terbilang sangat krusial. Kehadiran blok baru ini akan menguji soliditas partai-partai pendukung pemerintah, mengingat anggota dari koalisi baru ini juga diisi oleh partai yang berada di dalam kabinet. Publik kini menanti apakah pembentukan blok ini murni demi perbaikan sistem legislasi nasional atau sekadar strategi taktis jangka pendek untuk mengamankan posisi masing-masing kelompok menjelang kontestasi politik di masa depan."
                ],
                [
                    'title' => 'Usulan Revisi UU Pemilu Masuk Prolegnas, Wacana Kembalinya Sistem Proporsional Tertutup Picu Debat Panas di DPR',
                    'content' => "Dewan Perwakilan Rakyat resmi memasukkan draf usulan revisi Undang-Undang Pemilihan Umum ke dalam Program Legislasi Nasional prioritas setelah disetujui oleh mayoritas fraksi dalam rapat harmonisasi di Badan Legislasi. Keputusan ini langsung menghidupkan kembali perdebatan lama yang sarat ketegangan, terutama terkait wacana pengembalian sistem pemilu dari proporsional terbuka menjadi proporsional tertutup. Sistem tertutup ini berarti pemilih hanya akan mencoblos logo partai politik, bukan nama calon legislatif secara langsung, di mana penentuan kursi parlemen nantinya sepenuhnya diatur oleh internal pengurus partai berdasarkan nomor urut.

Fraksi-fraksi besar yang mendukung revisi ini beralasan bahwa sistem proporsional tertutup akan jauh lebih menghemat biaya logistik pemilu yang selama ini membengkak akibat kerumitan surat suara. Selain itu, mereka menilai sistem ini mampu menekan maraknya praktik politik uang di masyarakat karena para calon legislatif tidak perlu lagi saling sikut memperebutkan suara individu secara ugal-ugalan di lapangan. Perubahan ini juga diklaim dapat memperkuat institusi partai politik dalam melakukan kaderisasi secara sehat, sehingga kader yang duduk di parlemen benar-benar merupakan sosok kompeten yang loyal pada garis perjuangan partai, bukan sekadar figur populer bermodal besar.

Sebaliknya, gelombang penolakan keras langsung disuarakan oleh aliansi fraksi partai menengah-kecil bersama sejumlah organisasi masyarakat sipil pengawal demokrasi. Mereka menilai sistem proporsional tertutup adalah sebuah kemunduran besar bagi demokrasi karena menjauhkan hubungan emosional antara rakyat dengan wakilnya di parlemen. Anggota dewan yang menolak berargumen bahwa sistem ini hanya akan menyuburkan praktik oligarki di dalam tubuh partai politik, di mana nasib para calon legislatif sepenuhnya digantungkan pada restu ketua umum dan elit partai semata, bukan pada rekam jejak kerja nyata mereka di hadapan konstituen.

Merespons polemik yang kian meruncing, para pakar hukum tata negara mengingatkan agar DPR tidak terburu-buru mengambil keputusan dalam merevisi aturan fundamental ini tanpa melibatkan partisipasi publik yang bermakna. Jika proses pembahasan dipaksakan berjalan secara tertutup dan minim transparansi, dikhawatirkan undang-undang baru ini nantinya justru memicu krisis legitimasi hasil pemilu dan digugat kembali ke Mahkamah Konstitusi. DPR diharapkan dapat membuka ruang dialog yang seluas-luasnya dengan akademisi, penyelenggara pemilu, dan masyarakat sipil demi melahirkan sistem pemilihan yang adil, efisien, dan tetap menempatkan kedaulatan tertinggi di tangan rakyat."
                ]
            ],
            'Teknologi' => [
                [
                    'title' => 'Laravel 12 Resmi Rilis: Bawa Fitur API Architecture Super Cepat',
                    'content' => "Dunia web development kembali diguncang dengan rilisnya Laravel 12 secara global. Versi terbaru framework PHP paling populer ini fokus pada peningkatan performa microservices dan optimasi pembuatan Backend API.\n\nTaylor Otwell, sang kreator, menyatakan bahwa Laravel 12 memotong waktu eksekusi query hingga 30% lebih cepat dibandingkan versi sebelumnya, menjadikannya pilihan utama untuk startup skala besar."
                ],
                [
                    'title' => 'Penerapan Kecerdasan Buatan (AI) di Sektor Pendidikan Makin Masif',
                    'content' => "Teknologi AI kini bukan lagi sekadar alat bantu, melainkan sudah masuk ke dalam kurikulum inti di berbagai sekolah dan universitas di Indonesia.\n\nSistem pembelajaran adaptif berbasis AI mampu menganalisis kelemahan siswa dalam belajar dan memberikan rekomendasi materi yang dipersonalisasi secara instan, membantu guru meningkatkan efektivitas mengajar."
                ],
                [
                    'title' => 'Mengenal IoT: Solusi Otomatisasi Lampu Jalan Pintar di Smart City',
                    'content' => "Teknologi Internet of Things (IoT) berbasis mikrokontroler seperti ESP32 kini mulai diterapkan untuk efisiensi energi fasilitas publik. Salah satunya adalah sistem tiang lampu jalan otomatis.\n\nDengan sensor cahaya LDR, lampu jalan hanya akan menyala saat kondisi sekitar benar-benar gelap dan mengirimkan laporan kerusakan secara real-time ke dashboard pusat kendali kota jika ada lampu yang mati."
                ]
            ],
            'Olahraga' => [
                [
                    'title' => 'Timnas Indonesia Lolos Babak Kualifikasi Piala Dunia Dunia Fictional',
                    'content' => "Sejarah baru tercipta! Tim Nasional Sepak Bola Indonesia berhasil memastikan satu tempat di putaran final kualifikasi setelah menumbangkan lawan berat di pertandingan pamungkas kemarin malam.\n\nGol tunggal di menit-menit akhir babak kedua memicu gemuruh sorak sorai jutaan suporter di Stadion Utama Gelora Bung Karno. Pelatih menyatakan ini adalah buah kerja keras seluruh tim selama bertahun-tahun."
                ],
                [
                    'title' => 'Atlet Lari Nasional Pecahkan Rekor Baru di Ajang Internasional',
                    'content' => "Sprinter andalan Indonesia kembali mengharumkan nama bangsa dengan menyabet medali emas sekaligus memecahkan rekor lari 100 meter putra tercepat di kompetisi atletik Asia.\n\nDengan catatan waktu yang menakjubkan, atlet muda ini berhasil mengalahkan juara bertahan. Pemerintah menjanjikan bonus apresiasi dan fasilitas pelatihan terbaik demi menyambut olimpiade mendatang."
                ],
                [
                    'title' => 'Kompetisi Basket Mahasiswa Nasional Musim Ini Resmi Bergulir',
                    'content' => "Liga bola basket antar mahasiswa terbesar di Indonesia resmi dibuka hari ini. Puluhan universitas dari Sabang sampai Merauke mengirimkan tim terbaiknya untuk memperebutkan piala bergilir.\n\nSelain menjadi ajang kompetisi yang kompetitif, ajang ini juga menjadi tempat pemandu bakat nasional untuk mencari bibit-bibit muda potensial yang akan didegradasikan ke tim nasional."
                ]
            ],
            'Hiburan' => [
                [
                    'title' => 'Film Animasi Karya Anak Bangsa Tembus Box Office Internasional',
                    'content' => "Industri perfilman animasi lokal mencetak prestasi gemilang di kancah dunia. Film animasi 3D terbaru garapan studio lokal berhasil masuk dalam jajaran box office pekan ini di Amerika Serikat dan Asia.\n\nKualitas visual yang memukau dipadukan dengan cerita rakyat yang dikemas modern menjadi daya tarik utama bagi penonton global."
                ],
                [
                    'title' => 'Konser Musik Akbar Musisi Lokal Siap Digelar Pekan Ini',
                    'content' => "Festival musik tahunan yang mengumpulkan ratusan musisi lintas genre siap diselenggarakan akhir pekan ini di Jakarta. Tiket konser dilaporkan sudah ludes terjual dalam waktu kurang dari 30 menit.\n\nPihak panitia memastikan protokol keamanan ekstra dan alur penonton yang ketat demi menjaga kenyamanan selama acara berlangsung."
                ],
                [
                    'title' => 'Tren Musik Pop Kreatif Kalangan Gen Z Mulai Dominasi Pasar',
                    'content' => "Gaya bermusik generasi muda saat ini mengalami pergeseran ke arah eksperimental dengan menggabungkan instrumen tradisional dan ketukan elektronik modern.\n\nLagu-lagu bergenre unik ini mendominasi tangga lagu di berbagai platform streaming digital seperti Spotify dan Apple Music, membuktikan kreativitas tanpa batas musisi muda zaman sekarang."
                ]
            ],
            'Ekonomi' => [
                [
                    'title' => 'Pertumbuhan Ekonomi Digital Indonesia Meningkat Tajam',
                    'content' => "Laporan terbaru dari Bank Sentral menunjukkan nilai transaksi ekonomi digital di Indonesia mengalami lonjakan drastis sebesar 25% dibandingkan tahun lalu.\n\nPendorong utama kenaikan ini adalah maraknya adopsi sistem pembayaran QRIS di pasar tradisional serta meningkatnya kepercayaan masyarakat terhadap transaksi e-commerce yang aman."
                ],
                [
                    'title' => 'UMKM Lokal Tembus Pasar Ekspor Berkat Pendampingan Digital',
                    'content' => "Ratusan pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) asal daerah sukses mengekspor produk kerajinan tangan mereka ke pasar Eropa dan Jepang.\n\nMelalui program digitalisasi dan pelatihan branding dari pemerintah, produk lokal kini mampu bersaing secara kualitas dan estetika kemasan di pasar internasional."
                ],
                [
                    'title' => 'Investasi Saham Syariah Makin Digandrungi Investor Muda',
                    'content' => "Kesadaran finansial anak muda generasi milenial dan Gen Z terus merangkak naik. Menariknya, instrumen pasar modal berbasis syariah menjadi primadona baru.\n\nKemudahan akses analisis lewat aplikasi smartphone dan prinsip investasi yang transparan dinilai menjadi alasan utama mengapa anak muda mulai berani menyisihkan uang sakunya untuk berinvestasi."
                ]
            ]
        ];

        // 4. PROSES PERULANGAN MENYUNTIKKAN DATA
        foreach ($dataBerita as $namaKategori => $daftarBerita) {
            $category = Category::create([
                'name' => $namaKategori,
                'slug' => Str::slug($namaKategori),
            ]);

            foreach ($daftarBerita as $index => $berita) {
                $fileName = Str::slug($namaKategori) . '-' . ($index + 1) . '.png';
                $fullPathFile = $uploadPath . '/' . $fileName;

                try {
                    $bgColors = ['003366', 'cc0000', '006633', '330033', 'ff6600'];
                    $color = $bgColors[array_rand($bgColors)];
                    $imageUrl = "https://placehold.co/600x400/{$color}/fff.png?text=" . urlencode($namaKategori);
                    
                    $imageContent = file_get_contents($imageUrl);
                    if ($imageContent) {
                        File::put($fullPathFile, $imageContent);
                    }
                } catch (\Exception $e) {
                    // Safe Fallback
                }

                News::create([
                    'category_id' => $category->id,
                    'user_id' => $admin->id,
                    'title' => $berita['title'],
                    'slug' => Str::slug($berita['title']),
                    'content' => $berita['content'],
                    'image' => $fileName,
                ]);
            }
        }
    }
}