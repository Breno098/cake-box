<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\Customer\FeedService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * @var FeedService
     */
    protected FeedService $feedService;

    /**
     * @param FeedService $feedService
     */
    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Customer/Dashboard', [
            'feed' => $this->feedService->index()
        ]);
    }
}
