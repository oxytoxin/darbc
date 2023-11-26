<?php

namespace App\Http\Livewire\Shared;

use Livewire\Component;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Relations\Relation;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\Cluster;
use App\Models\Occupation;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;

class MemberInformationQuery extends Component implements HasTable
{

    use InteractsWithTable;

    protected function getTableQuery(): Builder|Relation
    {
        return MemberInformation::query();
    }

    protected function getTableHeaderActions(): array
    {
        return [
            FilamentExportHeaderAction::make('Export')
                ->fileNamePrefix('Member Information')
                ->directDownload(),
            Action::make('checkAll')
                ->button()
                ->color('success')
                ->label('Check All')
                ->action(function () {
                    foreach ($this->tableFilters as $key => $filter) {
                        $this->tableFilters[$key]['isActive'] = true;
                    }
                }),
            Action::make('uncheckAll')
                ->button()
                ->color('danger')
                ->label('Uncheck All')
                ->action(function () {
                    foreach ($this->tableFilters as $key => $filter) {
                        $this->tableFilters[$key]['isActive'] = false;
                    }
                }),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5, 10, 25, 50];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('darbc_id')
                ->visible(fn () => $this->tableFilters['darbc_id']['isActive'])
                ->label('DARBC ID')
                ->sortable(),
            BadgeColumn::make('status')
                ->visible(fn () => $this->tableFilters['status']['isActive'])
                ->label('Status')
                ->enum([
                    MemberInformation::STATUS_ACTIVE => 'Active',
                    MemberInformation::STATUS_INACTIVE => 'Inactive',
                    MemberInformation::STATUS_DECEASED => 'Deceased',
                ])
                ->colors([
                    'success' => MemberInformation::STATUS_ACTIVE,
                    'warning' => MemberInformation::STATUS_INACTIVE,
                    'danger' => MemberInformation::STATUS_DECEASED,
                ]),
            TextColumn::make('percentage')
                ->visible(fn () => $this->tableFilters['percentage']['isActive'])
                ->label('Percentage')
                ->sortable(),
            TextColumn::make('user.surname')
                ->visible(fn () => $this->tableFilters['user_surname']['isActive'])
                ->label('Last Name')
                ->sortable(),
            TextColumn::make('user.first_name')
                ->visible(fn () => $this->tableFilters['user_first_name']['isActive'])
                ->label('First Name'),
            TextColumn::make('cluster.name')
                ->visible(fn () => $this->tableFilters['cluster']['isActive'])
                ->label('Cluster'),
            BadgeColumn::make('succession_number')
                ->colors([
                    'success'
                ])
                ->sortable()
                ->formatStateUsing(fn ($state) => $state == 0 ? 'Original' : ordinal($state) . ' Successor')
                ->visible(fn () => $this->tableFilters['succession_number']['isActive'])
                ->label('Ownership'),
            TextColumn::make('date_of_birth')
                ->visible(fn () => $this->tableFilters['date_of_birth']['isActive'])
                ->label('Date of Birth')
                ->date('F d, Y'),
            TextColumn::make('deceased_at')
                ->visible(fn () => $this->tableFilters['deceased_at']['isActive'])
                ->label('Date of Death')
                ->date('F d, Y'),
            TextColumn::make('place_of_birth')
                ->visible(fn () => $this->tableFilters['place_of_birth']['isActive'])
                ->label('Place of Birth'),
            TextColumn::make('gender.name')
                ->visible(fn () => $this->tableFilters['gender_name']['isActive'])
                ->label('Gender'),
            TextColumn::make('blood_type')
                ->visible(fn () => $this->tableFilters['blood_type']['isActive'])
                ->label('Blood Type'),
            TextColumn::make('religion')
                ->visible(fn () => $this->tableFilters['religion']['isActive'])
                ->label('Religion'),
            TextColumn::make('membership_status.name')
                ->visible(fn () => $this->tableFilters['membership_status_name']['isActive'])
                ->label('Membership'),
            TextColumn::make('occupation.name')
                ->visible(fn () => $this->tableFilters['occupation_name']['isActive'])
                ->label('Occupation'),
            TextColumn::make('occupation_details')
                ->visible(fn () => $this->tableFilters['occupation_details']['isActive'])
                ->label('Occupation Details'),
            TextColumn::make('address_line')
                ->visible(fn () => $this->tableFilters['address_line']['isActive'])
                ->label('Address'),
            BadgeColumn::make('civil_status')
                ->enum([
                    MemberInformation::CS_SINGLE => 'Single',
                    MemberInformation::CS_MARRIED => 'Married',
                    MemberInformation::CS_LEGALLY_SEPARATED => 'Legally Separated',
                    MemberInformation::CS_WIDOW => 'Widow',
                    MemberInformation::CS_UNKNOWN => 'Unknown',
                ])
                ->visible(fn () => $this->tableFilters['civil_status']['isActive'])
                ->label('Civil Status'),
            TextColumn::make('mother_maiden_name')
                ->visible(fn () => $this->tableFilters['mother_maiden_name']['isActive'])
                ->label("Mother's Maiden Name"),
            TextColumn::make('spouse')
                ->visible(fn () => $this->tableFilters['spouse']['isActive'])
                ->label('Name of Spouse'),
            TextColumn::make('children_list')
                ->formatStateUsing(fn ($record) => implode(', ', collect($record->children)->pluck('name')->toArray()))
                ->visible(fn () => $this->tableFilters['children_list']['isActive'])
                ->label('Children'),
            TextColumn::make('dependents_count')
                ->visible(fn () => $this->tableFilters['dependents_count']['isActive'])
                ->label('No. of Dependents')
                ->sortable()
                ->alignCenter(),
            TextColumn::make('spa_list')
                ->formatStateUsing(fn ($record) => implode(', ', $record->spa))
                ->visible(fn () => $this->tableFilters['spa_list']['isActive'])
                ->label('SPA/Representatives'),
            TextColumn::make('sss_number')
                ->visible(fn () => $this->tableFilters['sss_number']['isActive'])
                ->label('SSS'),
            TextColumn::make('tin_number')
                ->visible(fn () => $this->tableFilters['tin_number']['isActive'])
                ->label('TIN'),
            TextColumn::make('philhealth_number')
                ->visible(fn () => $this->tableFilters['philhealth_number']['isActive'])
                ->label('PhilHealth'),
            TextColumn::make('contact_number')
                ->visible(fn () => $this->tableFilters['contact_number']['isActive'])
                ->label('Contact Number'),
            TextColumn::make('application_date')
                ->date('F d, Y')
                ->visible(fn () => $this->tableFilters['application_date']['isActive'])
                ->label('Date of Application')
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('darbc_id')
                ->default()
                ->label('DARBC ID'),
            Filter::make('cluster'),
            Filter::make('status')
                ->default()
                ->label('Status'),
            Filter::make('percentage')
                ->label('Percentage'),
            Filter::make('user_surname')
                ->default()
                ->label('Last Name'),
            Filter::make('user_first_name')
                ->default()
                ->label('First Name'),
            Filter::make('succession_number')
                ->default()
                ->label('Ownership'),
            Filter::make('date_of_birth')
                ->label('Date of Birth'),
            Filter::make('deceased_at')
                ->label('Date of Death'),
            Filter::make('place_of_birth')
                ->label('Place of Birth'),
            Filter::make('gender_name')
                ->label('Gender'),
            Filter::make('blood_type')
                ->label('Blood Type'),
            Filter::make('religion')
                ->label('Religion'),
            Filter::make('membership_status_name')
                ->label('Membership'),
            Filter::make('occupation_name')
                ->label('Occupation'),
            Filter::make('occupation_details')
                ->label('Occupation Details'),
            Filter::make('region_description')
                ->label('Region'),
            Filter::make('address_line')
                ->label('Address'),
            Filter::make('civil_status')
                ->label('Civil Status'),
            Filter::make('mother_maiden_name')
                ->label("Mother's Maiden Name"),
            Filter::make('spouse')
                ->label('Name of Spouse'),
            Filter::make('children_list')
                ->label('Children'),
            Filter::make('dependents_count')
                ->label('No. of Dependents'),
            Filter::make('spa_list')
                ->label('SPA/Representatives'),
            Filter::make('sss_number')
                ->label('SSS'),
            Filter::make('tin_number')
                ->label('TIN'),
            Filter::make('philhealth_number')
                ->label('PhilHealth'),
            Filter::make('contact_number')
                ->label('Contact Number'),
            Filter::make('application_date')
                ->label('Date of Application'),
            Filter::make('lot_text')
                ->columns(5)
                ->columnSpan(5)->form([
                    TextInput::make('darbc_id')
                        ->label('DARBC ID'),
                    Select::make('status')
                        ->options([
                            MemberInformation::STATUS_ACTIVE => 'ACTIVE',
                            MemberInformation::STATUS_INACTIVE => 'INACTIVE',
                            MemberInformation::STATUS_DECEASED => 'DECEASED',
                        ])
                        ->placeholder('ALL'),
                    TextInput::make('first_name')
                        ->label('First Name'),
                    TextInput::make('last_name')
                        ->label('Last Name'),
                    Select::make('ownership')
                        ->options(MembershipStatus::pluck('name', 'id'))
                        ->placeholder('ALL'),
                    Select::make('civil_status')
                        ->options([
                            MemberInformation::CS_SINGLE => 'Single',
                            MemberInformation::CS_MARRIED => 'Married',
                            MemberInformation::CS_WIDOW => 'Widow',
                            MemberInformation::CS_LEGALLY_SEPARATED => 'Legally Separated',
                            MemberInformation::CS_UNKNOWN => 'Unknown',
                        ])
                        ->label('Civil Status')
                        ->placeholder('ALL'),
                    Select::make('occupation')
                        ->options(Occupation::pluck('name', 'id'))
                        ->placeholder('ALL'),
                    Select::make('blood_type')->options([
                        'A' => 'A',
                        'B' => 'B',
                        'AB' => 'AB',
                        'O' => 'O',
                    ])->placeholder('ALL'),
                    Select::make('cluster_id')
                        ->label('Cluster')
                        ->columnSpan(2)
                        ->options(Cluster::orderByName()->selectRaw("id, concat(name, ' - ', address) as name")->pluck('name', 'id'))
                        ->placeholder('ALL'),
                    DatePicker::make('from')
                        ->withoutTime(),
                    DatePicker::make('to')
                        ->withoutTime(),

                ])->query(function ($query, $data) {
                    info($data);
                    $query->when($data['darbc_id'], fn ($q) => $q->where('darbc_id', $data['darbc_id']));
                    $query->when($data['status'], fn ($q) => $q->where('status', $data['status']));
                    $query->when($data['first_name'], fn ($q) => $q->whereRelation('user', 'first_name', 'like', "%{$data['first_name']}%"));
                    $query->when($data['last_name'], fn ($q) => $q->whereRelation('user', 'surname', 'like', "%{$data['last_name']}%"));
                    $query->when($data['ownership'], fn ($q) => $q->where('membership_status_id', $data['ownership']));
                    $query->when($data['civil_status'], fn ($q) => $q->where('civil_status', $data['civil_status']));
                    $query->when($data['occupation'], fn ($q) => $q->where('occupation_id', $data['occupation']));
                    $query->when($data['blood_type'], fn ($q) => $q->where('blood_type', $data['blood_type']));
                    $query->when($data['cluster_id'], fn ($q) => $q->whereClusterId($data['cluster_id']));
                    $query->when($data['from'], fn ($q) => $q->whereDate('application_date', '>=', $data['from']));
                    $query->when($data['to'], fn ($q) => $q->whereDate('application_date', '<=', $data['to']));
                }),
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->url(fn ($record) => route('release-admin.member-profile', ['member' => $record])),
        ];
    }

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }

    public function render()
    {
        return view('livewire.shared.member-information-query');
    }
}
