<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\AppException;
use App\Manager\UriEntryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', ['title' => 'Генерация сокращенной ссылки', 'added' => '']);
    }

    /**
     * @Route(path="/create", methods={"POST"}, name="app.short-url.post_create")
     * @param UriEntryManager $manager
     * @param Request $request
     * @return Response
     * @throws AppException
     */
    public function createAction(Request $request, UriEntryManager $manager)
    {
        $url = $request->get('long');
        $result = null;

        if ($url !== null) {
            $result = $manager->create($url);
        }

        return $this->render(
            'main/index.html.twig',
            ['title' => 'Генерация сокращенной ссылки', 'added' => $result],
            new Response('', Response::HTTP_CREATED)
        );
    }

    /**
     * @Route(path="/redirect", methods={"POST"}, name="app.short-url.post_redirect")
     * @param UriEntryManager $manager
     * @param Request $request
     */
    public function redirectAction(Request $request, UriEntryManager $manager)
    {
        $url = $request->get('redirect');
        $result = null;

        if ($url !== null) {
            $result = $manager->findLongUriByShortUri($url);
        }
        return $this->redirect($result);
    }
}
