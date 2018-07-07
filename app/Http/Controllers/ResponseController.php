<?php

namespace App\Http\Controllers;

use App\Entities\Click;
use Illuminate\View\View;
use App\ValueObjects\ClickId;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Session;
use App\Exceptions\ClickNotFoundException;
use App\Exceptions\MethodNotAllowedException;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ResponseController extends Controller
{
    const IS_BAD_DOMAIN = 'bad_domain';

    private const REDIRECT_URL = 'http://www.google.com';

    private const REDIRECT_TIMEOUT = 5;

    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * ResponseController constructor.
     * @param ResponseService $responseService
     */
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    /**
     * @param string $id
     * @return ViewFactory|View
     */
    public function success(string $id)
    {
        $click = $this->processing(function() use ($id) {
            return $this->responseService->getSuccessData(new ClickId($id));
        });

        return view('responses.success', [
            'click' => $click,
        ]);
    }

    /**
     * @param string $id
     * @return ViewFactory|View
     */
    public function error(string $id)
    {
        $this->redirectIfBadDomain();

        $click = $this->processing(function() use ($id) {
            return $this->responseService->getErrorData(new ClickId($id));
        });

        return view('responses.error', [
            'click' => $click,
        ]);
    }

    /**
     * @param $callback
     * @return Click
     */
    private function processing($callback) : Click
    {
        try {
            return $callback();
        } catch (ClickNotFoundException | MethodNotAllowedException $e) {
            abort(404);
        }
    }

    private function redirectIfBadDomain()
    {
        if (null !== Session::get(static::IS_BAD_DOMAIN)) {
            Session::forget(static::IS_BAD_DOMAIN);

            header('Refresh: '. static::REDIRECT_TIMEOUT .'; URL=' . static::REDIRECT_URL);
        }
    }
}
