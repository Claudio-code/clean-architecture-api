<?php

namespace App\Domain\Common;

use App\Domain\Exception\IncorrectFileExtensionException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFile
{
    private string $directory = '/uploads';
    private array $allowedFiles = [];

    public function __construct(private readonly ParameterBagInterface $parameterBag)
    {
    }

    /** @throws IncorrectFileExtensionException */
    public function save(UploadedFile $file): string
    {
        $productDir = $this->parameterBag->get($this->directory);
        if (!in_array($file->guessExtension(), $this->allowedFiles)) {
            throw new IncorrectFileExtensionException();
        }
        $newFileName = $this->makeHashFileName($file);
        $file->move($productDir, $newFileName);
        return $newFileName;
    }

    public function delete(string $imageName): bool
    {
        $productDir = $this->parameterBag->get($this->directory);
        $imageWithFullPath = "$productDir/$imageName";
        if (!file_exists($imageWithFullPath)) {
            return false;
        }
        return unlink($imageWithFullPath);
    }

    public function makeHashFileName(UploadedFile $file): string
    {
        return sha1($file->getClientOriginalName()).uniqid().'.'.$file->guessExtension();
    }

    public function setAllowedFiles(array $allowedFiles): self
    {
        $this->allowedFiles = $allowedFiles;
        return $this;
    }

    public function setDirectory(string $directory): self
    {
        $this->directory = $directory;
        return $this;
    }
}
