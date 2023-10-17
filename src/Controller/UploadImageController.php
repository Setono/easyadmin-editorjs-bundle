<?php

declare(strict_types=1);

namespace Setono\EasyadminEditorjsBundle\Controller;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\MimeTypesInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

final class UploadImageController
{
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly Filesystem $filesystem,
        private readonly MimeTypesInterface $mimeTypes,
        private readonly string $uploadDirectory,
        private readonly string $uploadPath,
    ) {
    }

    public function uploadImageByFile(Request $request): JsonResponse
    {
        $uploadedFile = $request->files->get('image');
        if (!$uploadedFile instanceof UploadedFile) {
            return self::createFailedResponse('The image file is not present');
        }

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), \PATHINFO_FILENAME);
        $newFilename = sprintf(
            '%s-%s.%s',
            (string) $this->slugger->slug($originalFilename),
            bin2hex(random_bytes(4)),
            (string) $uploadedFile->guessExtension(),
        );

        $uploadedFile->move($this->uploadDirectory, $newFilename);

        $url = sprintf('%s/%s', $this->uploadPath, $newFilename);

        return self::createSuccessfulResponse($url);
    }

    public function uploadImageByUrl(Request $request): JsonResponse
    {
        $json = $request->getContent();

        try {
            $data = json_decode($json, true, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return self::createFailedResponse('The given data could not be decoded');
        }

        if (!is_array($data) || !isset($data['url']) || !is_string($data['url'])) {
            return self::createFailedResponse('The data did not include an URL');
        }

        $image = file_get_contents($data['url']);
        $temporaryFilename = $this->filesystem->tempnam($this->uploadDirectory, 'image');
        $this->filesystem->dumpFile($temporaryFilename, $image);

        $mimeType = $this->mimeTypes->guessMimeType($temporaryFilename);
        if (null === $mimeType) {
            return self::createFailedResponse('Could not guess the mime type of the image');
        }

        $extensions = $this->mimeTypes->getExtensions($mimeType);
        if (count($extensions) === 0) {
            return self::createFailedResponse('Could not guess the extension of the image');
        }

        $extension = $extensions[0];

        $pathInfo = pathinfo(basename($data['url']));

        $filename = sprintf(
            '%s-%s.%s',
            (string) $this->slugger->slug($pathInfo['filename']),
            bin2hex(random_bytes(4)),
            $extension,
        );

        $this->filesystem->rename($temporaryFilename, sprintf('%s/%s', $this->uploadDirectory, $filename));

        return self::createSuccessfulResponse(sprintf('%s/%s', $this->uploadPath, $filename));
    }

    private static function createSuccessfulResponse(string $url): JsonResponse
    {
        return new JsonResponse([
            'success' => 1,
            'file' => [
                'url' => $url,
            ],
        ]);
    }

    private static function createFailedResponse(string $message): JsonResponse
    {
        return new JsonResponse([
            'success' => 0,
            'message' => $message,
        ], 400);
    }
}
