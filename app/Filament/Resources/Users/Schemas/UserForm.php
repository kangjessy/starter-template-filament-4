<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3) // Container Utama (3 Kolom)
                    ->schema([

                        // KOLOM KIRI (1/3) - Untuk Foto Profil
                        Section::make('Foto Profil')
                            ->schema([
                                FileUpload::make('profile_photo_path')
                                    ->label('Unggah Foto')
                                    ->image()
                                    ->avatar()
                                    ->disk('public')
                                    ->directory('profile-photos')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(['lg' => 1]), // Memakan 1 dari 3 kolom utama

                        // KOLOM KANAN (2/3) - Detail & Alamat
                        Section::make('Informasi Pengguna')
                            ->columns(2) // <-- PERBAIKAN: Set columns Section ini menjadi 2
                            ->schema([

                                // Baris 1: Name dan Email (akan otomatis 2 kolom)
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),

                                // Baris 2: Phone dan Email Verified (akan otomatis 2 kolom)
                                TextInput::make('phone_number')
                                    ->label('Nomor Telepon')
                                    ->tel()
                                    ->maxLength(255)
                                    ->nullable(),
                                DateTimePicker::make('email_verified_at')
                                    ->label('Waktu Verifikasi Email')
                                    ->default(now())
                                    ->hiddenOn('create'),

                                // Alamat (Mengambil semua lebar)
                                Textarea::make('address')
                                    ->rows(3)
                                    ->nullable()
                                    ->columnSpanFull(), // Mengambil 2 kolom penuh
                            ])
                            ->columnSpan(['lg' => 2]), // Memakan 2 dari 3 kolom utama

                        // SECTION KEAMANAN (Selalu Full Width di bawah)
                        Section::make('Keamanan & Status')
                            ->columns(3) // Tetap 3 kolom di dalamnya
                            ->schema([
                                TextInput::make('password')
                                    ->password()
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->dehydrated(fn (?string $state) => filled($state))
                                    ->label('Kata Sandi Baru')
                                    ->confirmed()
                                    ->columnSpan(1), // Tetap memakan 1 kolom
                                TextInput::make('password_confirmation')
                                    ->password()
                                    ->label('Konfirmasi Kata Sandi')
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->dehydrated(false)
                                    ->columnSpan(1), // Tetap memakan 1 kolom

                                // Status (Kolom terakhir)
                                Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true)
                                    ->helperText('Nonaktifkan untuk memblokir akses pengguna.')
                                    ->columnSpan(1),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
