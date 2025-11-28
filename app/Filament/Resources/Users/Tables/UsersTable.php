<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Foto Profil (Untuk identifikasi cepat)
            ImageColumn::make('profile_photo_path')
                ->label('Avatar')
                ->disk('public') // Pastikan sesuai dengan disk yang digunakan
                ->circular() // Tampilkan gambar bulat
                ->imageHeight(50),  // Atur ukuran ikon atau gambar

            // 2. Nama (Kolom utama, bisa di-search)
            TextColumn::make('name')
                ->label('Full Name')
                ->html() // Penting: Izinkan output HTM->label('Informasi Pengguna')
                ->searchable(['name', 'email', 'phone_number'])
                ->formatStateUsing(function ($state, $record) {
                    
                    // 1. Siapkan data Telepon
                    $rawPhoneNumber = preg_replace('/[^0-9+]/', '', $record->phone_number);
                    $displayPhoneNumber = $record->phone_number ?: '—';
                    
                    // 2. Siapkan HTML
                    return "
                        <strong>{$state}</strong> <br>
                        
                        <a href='mailto:{$record->email}' style='color: var(--primary-500); text-decoration: none;'>
                            {$record->email}
                        </a> <br>
                        
                        " . ($record->phone_number ? 
                            "<a href='tel:{$rawPhoneNumber}' style='text-decoration: none;'>
                                {$displayPhoneNumber}
                            </a>" 
                            : '—') . "
                    ";
                }),

            // 3. Email
            // TextColumn::make('email')
            //     ->label('Email')
            //     ->searchable()
            //     ->sortable(),
            
            // 4. Status Aktif (Wajib menggunakan IconColumn)
            IconColumn::make('is_active')
                ->label('Status')
                ->boolean() // Menampilkan ikon centang/silang
                ->toggleable() // Bisa disembunyikan/ditampilkan oleh pengguna
                ->sortable(),

            // 5. Nomor Telepon
            // TextColumn::make('phone_number')
            //     ->label('Telepon')
            //     ->searchable()
            //     ->placeholder('—'),
                
            // 6. Waktu Verifikasi Email
            TextColumn::make('email_verified_at')
                ->label('Verifikasi')
                ->dateTime('j M Y') // Tampilkan tanggal saja
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan secara default

            // 7. Created At (Metadata)
            TextColumn::make('created_at')
                ->label('Dibuat')
                ->dateTime('j M Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan secara default
        ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
                ->label('More actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->button()
                ->color('secondary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
