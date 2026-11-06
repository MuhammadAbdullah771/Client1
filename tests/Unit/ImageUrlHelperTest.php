<?php

namespace Tests\Unit;

use App\Helpers\ImageHelper;
use App\Support\ImageUrlHelper;
use PHPUnit\Framework\TestCase;

class ImageUrlHelperTest extends TestCase
{
    public function test_it_normalizes_google_drive_share_links(): void
    {
        $url = 'https://drive.google.com/file/d/abc_123-XYZ/view?usp=sharing';

        $this->assertSame(
            'https://drive.google.com/uc?export=view&id=abc_123-XYZ',
            ImageUrlHelper::normalize($url)
        );
    }

    public function test_it_keeps_direct_image_links_unchanged(): void
    {
        $url = 'https://example.com/images/service.jpg';

        $this->assertSame($url, ImageUrlHelper::normalize($url));
        $this->assertSame($url, ImageHelper::url($url));
    }

    public function test_it_converts_empty_links_to_null(): void
    {
        $this->assertNull(ImageUrlHelper::normalize('  '));
    }
}
