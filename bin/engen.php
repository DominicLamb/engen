<?php
include __DIR__ . '/../vendor/autoload.php';
$basePath = __DIR__ . '/../tests';
$parser = new \DominicLamb\EntityGenerator\Parser\FileParser();
$dir = new RecursiveDirectoryIterator($basePath, RecursiveDirectoryIterator::SKIP_DOTS);

/** @var SplFileInfo $file */
foreach($dir as $file) {
    $instructionList = $parser->parse($file);
    $generator = new \DominicLamb\EntityGenerator\Parser\Generator();
    $entity = $generator->generate($instructionList->getIterator());
    $formatter = new \DominicLamb\EntityGenerator\Formatter\Php\Object\EntityFormatter();
    file_put_contents(__DIR__ . '/../out/' . $file->getBasename('.md') . '.php', $formatter->format($entity));
}