<?php

namespace App\Filament\Resources\ClientEnterpriseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BillingInfoClientEnterpriseRelationManager extends RelationManager
{
    protected static string $relationship = 'BillingInfoClientEnterprise';

    public function form(Form $form): Form
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
                Forms\Components\TextInput::make('package')
                    ->label('Pacote')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->default(true),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('billing_responsible')
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
