<?php

namespace App\Controllers\Api;

use App\Models\CatModel;
use CodeIgniter\HTTP\ResponseInterface;

class CatsController extends BaseApiController
{
    private CatModel $catModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
        $this->catModel = new CatModel();
    }

    
    public function index(): ResponseInterface
    {
       
        $searchId = $this->request->getGet('cat_id');
        
        if ($searchId) {
            $this->catModel->where('cat_id', $searchId);
        }

        $cats = $this->catModel->paginate(10);
        $pager = $this->catModel->pager;

      
        $requestedPage = (int) ($this->request->getGet('page') ?? 1);

        if ($requestedPage > $pager->getPageCount() && $pager->getPageCount() > 0) {
            return $this->notFound("Page #{$requestedPage} does not exist. Total pages: {$pager->getPageCount()}");
        }

        return $this->response->setStatusCode(200)->setJSON([
            'status'              => 'success',
            'message'             => 'OK',
            'Ilan ang Ating Pusa' => $pager->getDetails()['total'],
            'pagination'          => [
                'total_pages'  => $pager->getPageCount(),
                'current_page' => $pager->getCurrentPage(),
            ],
            'data'                => $cats
        ]);
    }

    /**
     * POST /api/v1/cats (Create)
     */
    public function create(): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        if ($this->catModel->insert($data)) {
            $data['id'] = $this->catModel->getInsertID();
            return $this->created($data, 'Pusakat Was ADDED.');
        } else {
            return $this->badRequest('Failed to add cat.', $this->catModel->errors());
        }
    }

    /**
     * GET /api/v1/cats/{cat_id} (Read One by Cat ID)
     */
    public function show($cat_id = null): ResponseInterface
    {
        $cat = $this->catModel->where('cat_id', $cat_id)->first();

        if (! $cat) {
            return $this->notFound("Pusakat with ID '{$cat_id}' was not found.");
        }

        return $this->ok($cat);
    }


    public function update($cat_id = null): ResponseInterface
    {
        $data = $this->request->getJSON(true);
        $cat = $this->catModel->where('cat_id', $cat_id)->first();

        if (! $cat) {
            return $this->notFound("Pusakat ID '{$cat_id}' cannot be updated because Hindi siya nag eexist.");
        }

        if ($this->catModel->update($cat['id'], $data)) {
            $updatedCat = $this->catModel->find($cat['id']);
            return $this->ok($updatedCat, 'Pusakat updated successfully!');
        } else {
            return $this->badRequest('Failed to update Pusakat.', $this->catModel->errors());
        }
    }

   
    public function delete($cat_id = null): ResponseInterface
    {
        $cat = $this->catModel->where('cat_id', $cat_id)->first();

        if (! $cat) {
            return $this->notFound("Pusakat ID '{$cat_id}' cannot be deleted because Hindi siya nag eexist.");
        }

        if ($this->catModel->delete($cat['id'])) {
            return $this->ok(null, "Pusakat with ID '{$cat_id}' has been removed from the database.");
        } else {
            return $this->badRequest('Failed to delete cat.');
        }
    }
}
