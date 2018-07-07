<?php

namespace App\Http\Controllers;

use App\Entities\Click;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\ClickService;
use App\Exceptions\ValidationException;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ClickController extends Controller
{
    /**
     * @var ClickService
     */
    private $clickService;

    /**
     * ClickController constructor.
     * @param ClickService $clickService
     */
    public function __construct(ClickService $clickService)
    {
        $this->clickService = $clickService;
    }

    /**
     * @return ViewFactory|View
     */
    public function index()
    {
        return view('clicks.index', [
            'clicks' => $this->clickService->all(),
        ]);
    }

    /**
     * @param Request $request
     * @return ViewFactory|View
     */
    public function store(Request $request)
    {
        try {
            $click = Click::createFromArray([
                'user_agent' => $request->userAgent(),
                'ip'         => $request->ip(),
                'referer'    => $request->headers->get('referer'),
                'param1'     => $request->input('param1'),
                'param2'     => $request->input('param2'),
            ]);

            $click = $this->clickService->handlerClick($click);
            $id = $click->getId();
            $return = redirect()->route('responses.success', $id);

            if ($click->getErrorsCount()) {
                $return = redirect()->route('responses.error', $id);
            }

            if ($click->isBadDomain()) {
                $return = redirect()
                    ->route('responses.error', $id)
                    ->with(ResponseController::IS_BAD_DOMAIN, true);
            }
        } catch (ValidationException $e) {
            $return = view('clicks.error');
        }

        return $return;
    }
}
