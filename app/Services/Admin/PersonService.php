<?php

namespace App\Services\Admin;

use App\Models\Person;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class  PersonService
{
    /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Person[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        return Person::when(Arr::get($filters, 'name'), function(Builder $builder, $name) {
                return $builder->where('name', 'like', "%{$name}%");
            })->when($orderBy, function(Builder $query) use ($orderBy, $sort){
                return $query->orderBy($orderBy, $sort);
            })
            ->paginate($rowsPerPage);
    }

    /**
     * @param array $requestData
     * @return Person
     */
    public function store(array $requestData = []): Person
    {
        $person = Person::create(array_merge($this->transformData($requestData), [
            'created_by' => auth()->user()->id
        ]));

        $this->uploadPhoto($person, Arr::get($requestData, 'photo'));

        return $person;
    }

   /**
     * @param Person $person
     * @param array $requestData
     * @return Person
     */
    public function update(Person $person, array $requestData = []): Person
    {
        $person->update($this->transformData($requestData));

        $this->uploadPhoto($person, Arr::get($requestData, 'photo'));

        return $person;
    }

    /**
     * @param Person $person
     * @return boolean|null
     */
    public function delete(Person $person): ?bool
    {
        return $person->delete();
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        return Arr::except($requestData, ['photo']);
    }

    /**
     * @param UploadedFile|null $photo
     * @param array $images
     * @return void
     */
    public function uploadPhoto(Person $person, UploadedFile|null $photo): void
    {
        if ($photo instanceof UploadedFile) {
            if ($person->photo) {
                Storage::disk('public')->delete($person->photo);
            }

            $person->update(['photo' => Storage::disk('public')->put('person', $photo)]);
        }
    }
}
