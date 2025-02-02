<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use App\Models\Organization;
use App\Traits\HasConnection;
use App\Utils\Helper;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;

class EventResource extends Resource
{
    use HasConnection;
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Event Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\TextInput::make('name')->required(),
                    Select::make('organization_id')
                        ->label('Organization')
                        ->relationship('organization', 'name', function ($query) {
                            $user = auth()->user();
                            if ($user->hasRole('admin')) {
                                return $query;
                            }

                            if ($user->hasRole('organization_leader')) {
                                return $query->where('organization_id', $user->organization->pluck('id'));
                            }

                            if ($user->hasRole('group_leader')) {
                                return $query;
                            }

                        })
                        ->preload()
                        ->searchable(),
                    Forms\Components\DateTimePicker::make('started_at')
                       ->seconds(false)
                       ->required(),
                    Forms\Components\DateTimePicker::make('ended_at')
                        ->seconds(false)
                        ->required(),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Is Active')
                        ->inline(false)
                        ->default(true),
                ])->columns()
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
                Tables\Columns\TextColumn::make('started_at')
                    ->label('Started At')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ended_at')
                    ->label('Ended At')
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
                Tables\Columns\TextColumn::make('users_count')
                    ->label('Total Present')
                    ->counts('users')
                    ->sortable(),
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
            })
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->sendSuccessNotification(),
                Tables\Actions\EditAction::make()->successNotification(
                    Helper::setGenericNotification('Event', 'updated')
                ),
                Tables\Actions\DeleteAction::make()->successNotification(
                    Helper::setGenericNotification('Event', 'deleted')
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
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'view' => Pages\ViewEvent::route('/{record}'),
        ];
    }
}
