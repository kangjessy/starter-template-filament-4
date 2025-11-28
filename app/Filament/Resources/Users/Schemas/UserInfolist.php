<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Components\Section as ComponentsSection;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsGrid::make(2) // Container Utama (3 Kolom)
                ->schema([


                    // KOLOM KANAN (2/3) - Detail Dasar
                    ComponentsSection::make('Informasi Dasar')
                        ->columns(2) // Atur 2 kolom di dalam Section ini
                        ->schema([
                            ImageEntry::make('profile_photo_path')
                                ->label(false) // Tidak perlu label karena judul Section sudah jelas
                                ->disk('public') // Pastikan sesuai dengan disk yang digunakan
                                ->imageHeight(150)
                                ->circular(), // Atur ukuran gambar agar tidak terlalu besar
                            TextEntry::make('name')
                                ->label('Nama Lengkap'),
                            TextEntry::make('email')
                                ->label('Alamat Email'),
                            TextEntry::make('phone_number')
                                ->label('Nomor Telepon')
                                ->placeholder('—'),
                            TextEntry::make('email_verified_at')
                                ->label('Verifikasi Email')
                                ->dateTime('j M Y, H:i') // Format tanggal/waktu yang rapi
                                ->placeholder('Belum Diverifikasi'),
                        ])
                        ->columnSpan(['lg' => 2]),
                ]),

            // BARIS BAWAH (Full Width) - Alamat dan Status
            ComponentsSection::make('Alamat, Status & Metadata')
                ->columns(3) // Mengatur 3 kolom di Section ini
                ->schema([
                    // Alamat (Memakan lebar penuh di baris pertama Section ini)
                    TextEntry::make('address')
                        ->label('Alamat Lengkap')
                        ->placeholder('Alamat belum diisi')
                        ->columnSpanFull(),

                    // Status Aktif
                    IconEntry::make('is_active')
                        ->label('Status Akun')
                        ->boolean()
                        ->columnSpan(1), // Memakan 1 kolom

                    // Created At
                    TextEntry::make('created_at')
                        ->label('Dibuat Pada')
                        ->dateTime('j M Y, H:i')
                        ->placeholder('—')
                        ->columnSpan(1), // Memakan 1 kolom
                    
                    // Updated At
                    TextEntry::make('updated_at')
                        ->label('Diperbarui Pada')
                        ->dateTime('j M Y, H:i')
                        ->placeholder('—')
                        ->columnSpan(1), // Memakan 1 kolom
                ]),
            ]);
    }
}
