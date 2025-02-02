<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupResource\Pages;
use App\Filament\Resources\GroupResource\RelationManagers\UsersRelationManager;
use App\Models\Group;
use App\Utils\Helper;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Group Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\TextInput::make('name')->required()->rule(function (callable $get) {
                        return "unique:groups,name,{$get('id')}";
                    }),
                    Select::make('organization_id')
                        ->label('Organization')
                        ->relationship('activeOrganizations', 'name')
                        ->preload()
                        ->searchable(),
                    Select::make('leader_id')
                        ->label('Leader')
                        ->relationship('leader', 'name')
                        ->preload()
                        ->searchable(),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Is Active')
                        ->inline(false)
                        ->default(true),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('organization.name')
                    ->label('Organization')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('leader.name')
                    ->label('Leader')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Is Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d-M-y')->sortable()->searchable(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                if ($user->hasRole('admin')) {
                    return $query;
                }

                if ($user->hasRole('organization_leader')) {
                    return $query->whereIn('organization_id', $user->organizations->plucK('id'));
                }

                return $query->where('leader_id', $user->id);
            })
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->sendSuccessNotification(),
                Tables\Actions\EditAction::make()->successNotification(
                    Helper::setGenericNotification('Group', 'updated')
                ),
                Tables\Actions\DeleteAction::make()->successNotification(
                    Helper::setGenericNotification('Group', 'deleted')
                ),
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
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'view' => Pages\ViewGroup::route('/{record}'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
