<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Traits\HasConnection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;

class UsersRelationManager extends RelationManager
{
    use HasConnection;

    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()->recordSelectOptionsQuery(function (Builder $query) {
                    $user = auth()->user();

                    if ($user->hasRole('admin')) {
                        return $query;
                    }

                    if ($user->hasRole(['organization_leader', 'attendance_checker'])) {
                        $userUnderMyGroups = $this->groupsUnderMyCare($user);
                        return $query->whereIn('users.id', $userUnderMyGroups->plucK('user_id'));
                    }
                })
                ->preloadRecordSelect()
                ->multiple()
                ->label('Add Present')
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
