<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientEnterpriseResource\Pages;
use App\Filament\Resources;
use App\Models\BillingInfoClientEnterprise;
use App\Models\ClientEnterprise;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\TextInput\Mask;


class ClientEnterpriseResource extends Resource
{
    protected static ?string $model = ClientEnterprise::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Cliente Empresa')
                    ->schema([
                        TextInput::make('cnpj')
                            ->label('CNPJ')
                            ->required()
                            ->maxLength(18)
                            ->mask('99.999.999/9999-99')
                            ->placeholder('00.000.000/0000-00')
                            ->reactive()
                            ->suffixAction(
                                fn ($state, $set) => Forms\Components\Actions\Action::make('busca')
                                    ->icon('heroicon-m-magnifying-glass')
                                    ->action(function () use ($state, $set) {
                                        if (blank($state)) {
                                            Notification::make()
                                                ->title('Aviso')
                                                ->warning()
                                                ->body('Por favor, preencha o CNPJ antes de buscar.')
                                                ->send();
                                            return;
                                        }
                                        // Remove caracteres não numéricos do CNPJ
                                        $cnpj = preg_replace('/[^0-9]/', '', $state);
                                        $cacheKey = "cnpj_{$cnpj}";

                                        // Verifica se os dados estão em cache
                                        if (Cache::has($cacheKey)) {
                                            $dados = Cache::get($cacheKey);
                                        } else {
                                            // Faz a requisição para a API da ReceitaWS
                                            $response = Http::get("https://www.receitaws.com.br/v1/cnpj/{$cnpj}");
                                            $dados = $response->json();
                                            if ($dados['status'] != "ERROR") {
                                                // Armazena os dados no cache por 24 horas
                                                Cache::put($cacheKey, $dados, now()->addDay());
                                            } else {
                                                Notification::make()
                                                    ->title('Erro')
                                                    ->danger()
                                                    ->body('Não foi possível buscar as informações do CNPJ.')
                                                    ->send();

                                                $dados = null;
                                            }
                                        }
                                        if ($dados) {
                                            $set('name', $dados['nome'] ?? null);
                                            $set('fantasy_name', $dados['fantasia'] ?? null);
                                            $set('address', $dados['logradouro'] ?? null);
                                            $set('headquarters_unit', ($dados['tipo'] === 'MATRIZ' ? 'sede' : 'unidade') ?? null);
                                            $set('commercial_phone', $dados['telefone'] ?? null);
                                            $set('commercial_email', $dados['email'] ?? null);
                                        }
                                    })
                            ),
                        TextInput::make('name')
                            ->label('Nome da Empresa')
                            ->maxLength(255)
                            ->placeholder('Ex: Empresa S.A.')
                            ->required(),
                        TextInput::make('fantasy_name')
                            ->maxLength(255)
                            ->placeholder('Ex: Empresa S.A. Filial')
                            ->label('Nome Fantasia'),
                        TextInput::make('address')
                            ->label('Endereço')
                            ->placeholder('Ex: Avenida Paulista, 1000')
                            ->maxLength(255)
                            ->required(),
                        Select::make('headquarters_unit')
                            ->label('Tipo de Unidade')
                            ->options([
                                'sede' => 'Sede',
                                'unidade' => 'Unidade',
                            ])
                            ->required(),
                    ]),
                Section::make('Contatos Comerciais')
                    ->schema([
                        TextInput::make('commercial_phone')
                            ->label('Telefone')
                            ->maxLength(18)
                            ->placeholder('Ex: +55 11 99999-9999')
                            ->mask('+99 99 9 9999-9999'),
                        TextInput::make('commercial_email')
                            ->label('Email')
                            ->placeholder('Ex: empresa@example.com'),
                    ]),
                Section::make('Detalhes da Empresa')
                    ->schema([
                        Select::make('employee_count')
                            ->label('Quantidade de Funcionários')
                            ->options([
                                '0-10' => '0-10',
                                '11-50' => '11-50',
                                '51-150' => '51-150',
                                '151-300' => '151-300',
                                '300+' => '300+',
                            ]),
                        Select::make('company_size')
                            ->label('Porte da Empresa')
                            ->options([
                                'Micro' => 'Micro',
                                'Pequeno' => 'Pequeno',
                                'Médio' => 'Médio',
                                'Grande' => 'Grande',
                            ]),
                        Select::make('business_segment')
                            ->label('Segmento de Atuação')
                            ->options([
                                'Indústria' => 'Indústria',
                                'Comércio/Serviço' => 'Comércio/Serviço',
                            ]),
                        Textarea::make('company_profile')
                            ->label('Perfil da Empresa'),
                        Select::make('structured_hr_department')
                            ->label('Departamento de RH Estruturado')
                            ->options([
                                1 => 'SIM',
                                0 => 'NÃO',
                            ]),
                    ]),
                Section::make('Responsável da Empresa')
                    ->schema([
                        TextInput::make('responsible_name')
                            ->label('Nome')
                            ->placeholder('Ex: João Silva'),
                        TextInput::make('responsible_email')
                            ->label('Email')
                            ->placeholder('Ex: joao.silva@example.com'),
                        TextInput::make('responsible_whatsapp')
                            ->label('Telefone')
                            ->maxLength(18)
                            ->placeholder('Ex: +55 11 99999-9999')
                            ->mask('+99 99 9 9999-9999'),
                        TextInput::make('responsible_phone')
                            ->label('WhatsApp')
                            ->maxLength(18)
                            ->placeholder('Ex: +55 11 99999-9999')
                            ->mask('+99 99 9 9999-9999'),
                    ]),
                Section::make('Mais Detalhes sobre a Empresa (Opcional)')
                    ->schema([
                        Textarea::make('mission')
                            ->label('Missão'),
                        Textarea::make('values')
                            ->label('Valores'),
                        Select::make('pdi_program')
                            ->label('A empresa possui programa de PDI')
                            ->options([
                                1 => 'SIM',
                                0 => 'NÃO',
                            ]),
                        Select::make('work_regimes')
                            ->label('Quais regimes de trabalho interessam à empresa')
                            ->options([
                                'CLT' => 'CLT',
                                'Autônomo' => 'Autônomo',
                                'Trainee' => 'Trainee',
                                'Estagiário' => 'Estagiário',
                                'Jovem Aprendiz' => 'Jovem Aprendiz',
                                'Menor Aprendiz' => 'Menor Aprendiz',
                            ])
                            ->multiple(),
                        FileUpload::make('profile_image_path')
                            ->label('Foto para Perfil da Empresa/Logomarca')
                            ->directory('public')
                            ->acceptedFileTypes(['image/*'])
                            ->maxSize(1024 * 1024)
                            ->image(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cnpj')
                    ->label('CNPJ')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome da Empresa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('commercial_email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fantasy_name')
                    ->label('Nome Fantasia')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Endereço'),
                Tables\Columns\TextColumn::make('headquarters_unit')
                    ->label('Tipo de Unidade'),
                Tables\Columns\TextColumn::make('commercial_phone')
                    ->label('Telefone'),
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
            ClientEnterpriseResource\RelationManagers\BillingInfoClientEnterpriseRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientEnterprises::route('/'),
            'create' => Pages\CreateClientEnterprise::route('/create'),
            'edit' => Pages\EditClientEnterprise::route('/{record}/edit'),
        ];
    }
}
