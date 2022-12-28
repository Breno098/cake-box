<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\PostIndexRequest;
use App\Models\Post;
use App\Http\Requests\Admin\Post\PostStoreRequest;
use App\Http\Requests\Admin\Post\PostUpdateRequest;
use App\Http\Resources\Admin\Post\PostResourse;
use App\Services\Admin\PostService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * @var PostService
     */
    protected PostService $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @param PostIndexRequest $request
     * @return Response
     */
    public function index(PostIndexRequest $request): Response
    {
        $posts = $this->postService->index(
            $request->filters(),
            $request->rowsPerPage(),
            $request->orderBy('id'),
            $request->sort()
        );

        return Inertia::render('Admin/Post/Index', [
            'posts' => PostResourse::collection($posts),
            'query' => $request->dataQuery(),
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Post/Create');
    }

    /**
     * @param PostStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PostStoreRequest $request): RedirectResponse
    {
        $post = $this->postService->store($request->validated());

        return redirect()->route('admin.post.edit', $post);
    }

    /**
     * @param Post $post
     * @return Response
     */
    public function edit(Post $post): Response
    {
        return Inertia::render('Admin/Post/Edit', [
            'post' => new PostResourse($post)
        ]);
    }

    /**
     * @param PostUpdateRequest $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function update(PostUpdateRequest $request, Post $post): RedirectResponse
    {
        $post = $this->postService->update($post, $request->validated());

        return redirect()->route('admin.post.edit', $post);
    }

    /**
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->postService->delete($post);

        return redirect()->route('admin.post.index');
    }
}
