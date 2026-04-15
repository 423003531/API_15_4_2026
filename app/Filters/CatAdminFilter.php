<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CatAdminFilter implements FilterInterface
{
  
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        // 1. Basic Auth check
        if (! str_starts_with($authHeader, 'Basic ')) {
            return $this->failUnauthorized();
        }

        $base64 = substr($authHeader, 6);
        $credentials = base64_decode($base64);

     
        $role = null;
        if ($credentials === 'admin:admin') {
            $role = 'admin';
        } elseif ($credentials === 'staff:staff') {
            $role = 'staff';
        } else {
            return $this->failUnauthorized();
        }

        $method = strtolower($request->getMethod());
        if ($role === 'staff' && $method !== 'get' && $method !== 'head') {
            return service('response')
                ->setStatusCode(403) 
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Restricted Access: Staff accounts can only view and search cats. Update, Add, and Delete are for Admins only.'
                ]);
        }

       
    }

    private function failUnauthorized()
    {
        return service('response')
            ->setStatusCode(401)
            ->setJSON([
                'status'  => 'error',
                'message' => 'Unauthorized. Please provide valid API credentials (admin/admin or staff/staff).'
            ]);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
      
    }
}
