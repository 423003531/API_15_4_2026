<?php

// app/Filters/AuthFilter.php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AuthFilter
 *
 * Gate 1 — Is the user logged in at all?
 * This filter runs first for ALL protected routes.
 * It only checks whether a session exists; role checking
 * is handled by the three role-specific filters below.
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->has('user')) {
            session()->setFlashdata('error', 'Please log in to continue.');
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
