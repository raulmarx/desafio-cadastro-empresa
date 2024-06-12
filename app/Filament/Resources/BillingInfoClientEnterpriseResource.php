<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillingInfoClientEnterpriseResource\Pages;
use App\Filament\Resources\BillingInfoClientEnterpriseResource\RelationManagers;
use App\Models\BillingInfoClientEnterprise;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BillingInfoClientEnterpriseResource extends Resource
{
    protected static ?string $model = BillingInfoClientEnterprise::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('billing_address')
                    ->label('Endereço de cobrança')
                    ->placeholder('Ex: Rua das Flores, 123')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('billing_email')
                    ->required()
                    ->email()
                    ->label('E-mail de cobrança')
                    ->placeholder('Ex: jose@mail.com')
                    ->maxLength(255),
                Forms\Components\TextInput::make('billing_responsible')
                    ->label('Responsável pela cobrança')
                    ->placeholder('Ex: João Silva')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('update_billing_info')
                    ->label('Atualizar informações de cobrança')
                    ->default(false),
                Forms\Components\Select::make('payment_methods')->multiple()
                    ->label('Métodos de pagamento')
                    ->required()

                    ->options([
                        'Boleto' => 'Boleto',
                        'Contrato Faturado' => 'Contrato Faturado',
                        'Pix' => 'Pix',
                        'Cartão' => 'Cartão',
                    ]),
                Forms\Components\DatePicker::make('payment_date')
                    ->label('Data de vencimento')
                    ->format('d/m')
                    ->placeholder('dd/mm')
                    ->required(),
                Forms\Components\Select::make('contract_type')
                    ->label('Tipo de contrato')
                    ->required()
                    ->options([
                        'Recorrente' => 'Recorrente',
                        'Por uso' => 'Por uso',
                    ]),
                Forms\Components\Select::make('package')
                    ->label('Pacote')
                    ->nullable()
                    ->options([
                        'A' => 'Recorrente (Pacote A)',
                        'B' => 'Recorrente (Pacote B)',
                        'C' => 'Recorrente (Pacote C)'
                    ]),
                Forms\Components\Toggle::make('status')
                    ->default(true),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('billing_responsible')
                    ->label('Responsável pela cobrança')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('billing_email')
                    ->searchable()
                    ->sortable()
                    ->label('E-mail de cobrança'),
                Tables\Columns\TextColumn::make('billing_address')
                    ->searchable()
                    ->sortable()
                    ->label('Endereço de cobrança'),
                Tables\Columns\ToggleColumn::make('update_billing_info')
                    ->label('Atualizar informações de cobrança'),
                Tables\Columns\TextColumn::make('payment_methods')
                    ->label('Métodos de pagamento'),
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Data de vencimento'),
                Tables\Columns\TextColumn::make('contract_type')
                    ->label('Tipo de contrato'),
                Tables\Columns\TextColumn::make('package')
                    ->label('Pacote'),
                Tables\Columns\ToggleColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBillingInfoClientEnterprises::route('/'),
            'create' => Pages\CreateBillingInfoClientEnterprise::route('/create'),
            'edit' => Pages\EditBillingInfoClientEnterprise::route('/{record}/edit'),
        ];
    }
}
