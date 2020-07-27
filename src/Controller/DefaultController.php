<?php

namespace App\Controller;

use Chenos\V8JsModuleLoader\ModuleLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        $html = $this->renderView('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);

        $re = '/<ssr-renderer>(.*)<\/ssr-renderer>/ms';

        preg_match($re, $html, $matches);

        $renderer_source = file_get_contents(__DIR__ . '/../../node_modules/vue-server-renderer/basic.js');
        $runtime = file_get_contents(__DIR__ . '/../../dist/main.js');

        $moduleLoader = new ModuleLoader(__DIR__ . '/../../assets/vue');
        $moduleLoader->addVendorDir(__DIR__ . '/../../node_modules');
        $moduleLoader->addOverride('vue-instance', __DIR__ . '/../../dist/main.js');

        $v8 = new \V8Js();

        $v8->setModuleNormaliser([$moduleLoader, 'normaliseIdentifier']);
        $v8->setModuleLoader([$moduleLoader, 'loadModule']);

        $v8->html = '<div id="vue-app">' . $matches[1] . '</div>';

        $v8->executeString('var process = { env: { VUE_ENV: "server", NODE_ENV: "production" }}; this.global = { process: process };');

        $v8->executeString($renderer_source);

        ob_start();

        $v8->executeString($runtime);

        $content = ob_get_clean();

        // Template for vue instance
        dump($content);

        $start = strpos($html, '<ssr-renderer>');

        $html = substr_replace($html, $content, $start, (strrpos($html, '</ssr-renderer>') + 15) - $start);


        return new Response($html);
    }
}
