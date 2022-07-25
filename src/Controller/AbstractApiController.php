<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AbstractApiController extends AbstractController
{
    protected function buildForm(string $type, $data = null, array $options = [])
    {
        $options = array_merge($options, [
            'csrf_protection' => false,
        ]);

        return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
    }
}
