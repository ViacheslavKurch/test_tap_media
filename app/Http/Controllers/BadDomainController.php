<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Entities\BadDomain;
use Illuminate\Http\Request;
use App\ValueObjects\Domain;
use App\ValueObjects\BadDomainId;
use App\Services\BadDomainService;
use Illuminate\Http\RedirectResponse;
use App\Exceptions\BadDomainExistsException;
use App\Exceptions\BadDomainNotFoundException;
use Illuminate\Contracts\View\Factory as ViewFactory;
use App\Exceptions\ValueObjects\InvalidDomainException;
use App\Exceptions\ValueObjects\InvalidBadDomainIdException;

class BadDomainController extends Controller
{
    /**
     * @var BadDomainService
     */
    private $badDomainService;

    /**
     * BadDomainController constructor.
     * @param BadDomainService $badDomainService
     */
    public function __construct(BadDomainService $badDomainService)
    {
        $this->badDomainService = $badDomainService;
    }

    /**
     * @return ViewFactory|View
     */
    public function index()
    {
        return view('bad_domains.index', [
            'badDomains' => $this->badDomainService->all(),
        ]);
    }

    /**
     * @return ViewFactory|View
     */
    public function create()
    {
        return view('bad_domains.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws InvalidBadDomainIdException
     */
    public function store(Request $request)
    {
        return $this->save('Bad domain was successfully created', $request);
    }

    /**
     * @param $id
     * @return ViewFactory|View
     * @throws InvalidBadDomainIdException
     */
    public function edit($id)
    {
        try {
            $badDomain = $this->badDomainService->getBadDomain(new BadDomainId($id));

            return view('bad_domains.edit', [
                'badDomain' => $badDomain,
            ]);
        } catch (BadDomainNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     * @throws InvalidBadDomainIdException
     */
    public function update(Request $request, string $id)
    {
        return $this->save('Bad domain was successfully updated', $request, $id);
    }

    /**
     * @param Request $request
     * @param string $successMessage
     * @param string|null $id
     * @return RedirectResponse
     * @throws InvalidBadDomainIdException
     */
    private function save(string $successMessage, Request $request, string $id = null)
    {
        $request->flash();

        try {
            $badDomain = new BadDomain(
                new BadDomainId($id),
                new Domain($request->input('name'))
            );

            $this->badDomainService->save($badDomain);

            $redirect = redirect()
                ->route('bad-domains.edit', $badDomain->getId())
                ->with('success', $successMessage);

        } catch (InvalidDomainException | BadDomainExistsException $e) {
            $redirect = redirect()
                ->back()
                ->withErrors(['name' => $e->getMessage()]);
        }

        return $redirect;
    }
}
