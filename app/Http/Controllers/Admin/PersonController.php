<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Person\PersonIndexRequest;
use App\Models\Person;
use App\Http\Requests\Admin\Person\PersonStoreRequest;
use App\Http\Requests\Admin\Person\PersonUpdateRequest;
use App\Http\Resources\Admin\PersonResource;
use App\Services\Admin\PersonService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PersonController extends Controller
{
    /**
     * @var PersonService
     */
    protected PersonService $personService;

    /**
     * @param PersonService $personService
     */
    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    /**
     * @param PersonIndexRequest $request
     * @return Response
     */
    public function index(PersonIndexRequest $request): Response
    {
        $people = $this->personService->index(
            $request->filters(),
            $request->rowsPerPage(),
            $request->orderBy('name'),
            $request->sort()
        );

        return Inertia::render('Admin/Person/Index', [
            'people' => PersonResource::collection($people),
            'query' => $request->dataQuery(),
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Person/Create');
    }

    /**
     * @param PersonStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PersonStoreRequest $request): RedirectResponse
    {
        $person = $this->personService->store($request->validated());

        return redirect()->route('admin.person.edit', $person);
    }

    /**
     * @param Person $person
     * @return Response
     */
    public function edit(Person $person): Response
    {
        return Inertia::render('Admin/Person/Edit', [
            'person' => new PersonResource($person)
        ]);
    }

    /**
     * @param PersonUpdateRequest $request
     * @param Person $person
     * @return RedirectResponse
     */
    public function update(PersonUpdateRequest $request, Person $person): RedirectResponse
    {
        $person = $this->personService->update($person, $request->validated());

        return redirect()->route('admin.person.edit', $person);
    }

    /**
     * @param Person $person
     * @return RedirectResponse
     */
    public function destroy(Person $person): RedirectResponse
    {
        $this->personService->delete($person);

        return redirect()->route('admin.person.index');
    }
}
