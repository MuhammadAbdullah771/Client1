<?php

namespace App\Helpers;

class StockImage
{
    /**
     * Resolve a local stock image URL from a photo id or legacy Unsplash URL.
     */
    public static function url(string $id): string
    {
        $photoId = self::normalizeId($id);

        return asset('images/'.$photoId.'.jpg');
    }

    /**
     * @return list<string>
     */
    public static function allPhotoIds(): array
    {
        return [
            'photo-1450101215322-bf5cd27642fc',
            'photo-1450101499163-c8848c66ca85',
            'photo-1451187580459-43490279c0fa',
            'photo-1454165804606-c3d57bc86b40',
            'photo-1460925895917-afdab827c52f',
            'photo-1486312338219-ce68d2c6f44d',
            'photo-1487058792275-0ad4aaf24ca7',
            'photo-1492724441997-5dc865305da7',
            'photo-1497366216548-37526070297c',
            'photo-1498050108023-c5249f4df085',
            'photo-1504384308090-c894fdcc538d',
            'photo-1504639725590-34d0984388bd',
            'photo-1507679799987-c73779587ccf',
            'photo-1508385082359-f38ae991e8f2',
            'photo-1512941937669-90a1b58e7e9c',
            'photo-1518186285589-2f7649de83e0',
            'photo-1519389950473-47ba0277781c',
            'photo-1520607162513-77705c0f0d4a',
            'photo-1521737604893-d14cc237f11d',
            'photo-1522071820081-009f0129c71c',
            'photo-1526378722484-bd91ca387e72',
            'photo-1526628953301-3e589a6a8b74',
            'photo-1543286386-713bdd548da4',
            'photo-1550751827-4bd374c3f58b',
            'photo-1551288049-bebda4e38f71',
            'photo-1551650975-87deedd944c3',
            'photo-1552664730-d307ca884978',
            'photo-1553729459-efe14ef6055d',
            'photo-1554224154-26032fced8bd',
            'photo-1554224154-26032ffc0d07',
            'photo-1554224155-1696413565d3',
            'photo-1554224155-6726b3ff858f',
            'photo-1554224155-8d04cb21cd6c',
            'photo-1554224156-6726b3ff858f',
            'photo-1554224311-beee460201f0',
            'photo-1555066931-4365d14bab8c',
            'photo-1555774698-0b77e0d5fac6',
            'photo-1555949963-aa79dcee981c',
            'photo-1556155092-490a1ba16284',
            'photo-1556157382-97eda2d62296',
            'photo-1556740749-887f6717d7e4',
            'photo-1556742049-0cfed4f6a45d',
            'photo-1556761175-129418cb2dfe',
            'photo-1556761175-4b46a572b786',
            'photo-1556761175-5973dc0f32e7',
            'photo-1556761175-b41319ca44b6',
            'photo-1556761175-b413da4baf72',
            'photo-1557804506-669a67965ba0',
            'photo-1558494949-ef010cbdcc31',
            'photo-1563013544-824ae1b704d3',
            'photo-1565514020179-026b92b2d0c3',
            'photo-1565514020179-026b92b2d7c5',
            'photo-1579621970563-ebec7560ff3e',
            'photo-1579621970795-87facc2f976d',
            'photo-1581091012184-5c3a2f8d7b7a',
            'photo-1589652717521-10c0d092dea9',
            'photo-1589829545856-d10d557cf95f',
            'photo-1605902711622-cfb43c4437d3',
        ];
    }

    private static function normalizeId(string $id): string
    {
        $id = trim($id);

        if (preg_match('/photo-[0-9a-z-]+/', $id, $matches)) {
            return $matches[0];
        }

        if (! str_starts_with($id, 'photo-')) {
            return 'photo-'.$id;
        }

        return $id;
    }
}
