<?php


namespace App\OpenApi;


use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;
final class RefreshTokenDecorator implements OpenApiFactoryInterface
{

    public function __construct(
        private OpenApiFactoryInterface $decorated
    ) {}

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();
        $schemas['RefreshToken'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ]);
        $schemas['Credentials'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'refresh_token' => [
                    'type' => 'string',
                    'example' => 'token',
                ],
            ],
        ]);

        $pathItem = new Model\PathItem(
            ref: 'JWT Token',
            post: new Model\Operation(
            operationId: 'postCredentialsItem',
            tags: ['RefreshToken'],
            responses: [
            '200' => [
                'description' => 'Get JWT token',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/Token',
                        ],
                    ],
                ],
            ],
        ],
            summary: 'Get JWT token to login.',
            requestBody: new Model\RequestBody(
            description: 'Generate new JWT Token',
            content: new \ArrayObject([
            'application/json' => [
                'schema' => [
                    '$ref' => '#/components/schemas/Credentials',
                ],
            ],
        ]),
        ),
        ),
        );
        $openApi->getPaths()->addPath('/api/token/refresh', $pathItem);

        return $openApi;
    }
}