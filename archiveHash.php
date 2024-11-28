<?php

// Fungsi buat kasih warna di teks
function color_text($text, $color_code) {
    return "\033[" . $color_code . "m" . $text . "\033[0m";
}

// Fungsi buat ngetengahin teks biar pas di tengah
function center_text($text, $max_length) {
    return str_pad($text, $max_length, " ", STR_PAD_BOTH);
}

// Fungsi buat animasi titik biar kelihatan lagi loading
function process_animation($message, $duration) {
    $max_dots = 3;  // Jumlah maksimal titik
    $dot_delay = 0.5;  // Delay antar titik
    $dots = 0;  // Hitungan titik

    // Nampilin pesan awal
    echo $message;
    flush();

    // Mengulang selama durasi yang diinginkan
    for ($i = 0; $i < $duration; $i++) {
        // Reset tampilan setiap kali titik baru muncul
        echo "\r";  // Kembali ke awal baris
        echo $message . str_repeat('.', $dots);  // Tampilkan pesan dan titik
        flush();
        usleep($dot_delay * 1000000);  // Delay tiap titik

        // Tambah hitungan titik
        $dots = ($dots + 1) % ($max_dots + 1); // Reset ke 0 setelah 3 titik

    }
    echo "\n"; // Pindah baris setelah animasi selesai
}




// Fungsi buat muter suara intro
function play_intro_sound() {
    try {
        exec("powershell -c (New-Object Media.SoundPlayer 'src/sound.wav').PlaySync();");
    } catch (Exception $e) {
        echo "Error playing sound: " . $e->getMessage() . "\n";
    }
}

// Fungsi buat nampilin banner keren pake warna-warni
function display_banner() {
    // ASCII art baru untuk Project Storm
    $figlet = [
        "  ██████ ▄▄▄█████▓ ▒█████   ██▀███   ███▄ ▄███▓",
        "▒██    ▒ ▓  ██▒ ▓▒▒██▒  ██▒▓██ ▒ ██▒▓██▒▀█▀ ██▒",
        "░ ▓██▄   ▒ ▓██░ ▒░▒██░  ██▒▓██ ░▄█ ▒▓██    ▓██░",
        "  ▒   ██▒░ ▓██▓ ░ ▒██   ██░▒██▀▀█▄  ▒██    ▒██ ",
        "▒██████▒▒  ▒██▒ ░ ░ ████▓▒░░██▓ ▒██▒▒██▒   ░██▒",
        "▒ ▒▓▒ ▒ ░  ▒ ░░   ░ ▒░▒░▒░ ░ ▒▓ ░▒▓░░ ▒░   ░  ░",
        "░ ░▒  ░ ░    ░      ░ ▒ ▒░   ░▒ ░ ▒░░  ░      ░",
        "░  ░  ░    ░      ░ ░ ░ ▒    ░░   ░ ░      ░   ",
        "      ░               ░ ░     ░            ░   "
    ];

    // Array warna untuk tiap baris agar warna berputar
    $colors = [31];

    // Tampilkan setiap baris dengan warna bergantian
    foreach ($figlet as $index => $line) {
        echo color_text($line, $colors[$index % count($colors)]) . "\n";
    }
}

// Fungsi buat nampilin nama anggota kelompok
function display_group_members() {
    $group_members = [
        "\nProgram ini di peruntukkan menyimpan kunci Enkripsi sementara.\n",
        "Kelompok-3",
        "Sultan Faiz Ar-Rasyid",
        "Fadhil Faiz",
        "Muhammad Haidar",
        "Salman Hafiz Mubarok",
        "Rezky Aditya"
    ];
    echo color_text(str_repeat("═", 70), '31') . "\n"; // Border merah
    foreach ($group_members as $member) {
        echo color_text(center_text($member, 68), '34') . "\n";
    }
}

// Fungsi buat nampilin menu pilihan
function show_menu($menu) {
    $max_length = 20;
    $menu_color = '36';
    $padding_left = center_text("", $max_length + 4);
    echo color_text($padding_left . "╔" . str_repeat("═", $max_length) . "╗", $menu_color) . "\n";
    foreach ($menu as $index => $item) {
        echo color_text($padding_left . "║ " . str_pad($item, $max_length - 2) . " ║", $menu_color) . "\n";
    }
    echo color_text($padding_left . "╚" . str_repeat("═", $max_length) . "╝", $menu_color) . "\n";
}

// Fungsi buat nambahin data ke array
function add_data(&$data) {
    $new_data = readline("Masukkan encrypt key: ");
    array_push($data, $new_data);
    echo color_text("Key berhasil ditambahkan!\n", '32');
}

// Fungsi buat ngapus data
function delete_data(&$data) {
    if (count($data) === 0) {
        echo color_text("Tidak ada Key yang dapat dihapus!\n", '31');
        return;
    }
    echo "Pilih data yang ingin dihapus:\n";
    foreach ($data as $index => $item) {
        echo ($index + 1) . ". $item\n";
    }
    $choice = readline("Masukkan nomor data yang ingin dihapus: ");
    if (is_numeric($choice) && $choice > 0 && $choice <= count($data)) {
        unset($data[$choice - 1]);
        $data = array_values($data);
        echo color_text("Data key berhasil dihapus!\n", '32');
    } else {
        echo color_text("Nomor tidak valid!\n", '31');
    }
}

// Fungsi buat nampilin data
function display_data($data) {
    if (count($data) === 0) {
        echo color_text("Tidak ada data key untuk ditampilkan.\n", '31');
        return;
    }
    echo color_text("Data key yang tersedia:\n", '34');
    foreach ($data as $index => $item) {
        echo ($index + 1) . ". $item\n";
    }
}

// Program utama
$data = [];
$menu = [
    "1 - Tambah Data Key",
    "2 - Hapus Data Key",
    "3 - Lihat Data Key",
    "0 - Keluar"
];

echo "Selamat datang di Project Storm!\n\n";
process_animation("Memulai program", 5);
echo color_text("\nProject Storm Activated\n\n", '32');
display_banner();
display_group_members();
play_intro_sound();

while (true) {
    show_menu($menu);
    $choice = readline("Masukkan pilihan Anda: ");
    switch ($choice) {
        case 1:
            add_data($data);
            break;
        case 2:
            delete_data($data);
            break;
        case 3:
            display_data($data);
            break;
        case 0:
            echo "Keluar dari program...\n";
            exit;
        default:
            echo color_text("Pilihan tidak valid, coba lagi.\n", '31');
            break;
    }
}
?>
