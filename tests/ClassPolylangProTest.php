<?php

namespace SLCA\PolylangPro;

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;
use Brain\Monkey\Actions;
use Brain\Monkey\Filters;
use Brain\Monkey\Functions;
use wpCloud\StatelessMedia\WPStatelessStub;

/**
 * Class ClassPolylangProTest
 */

class ClassPolylangProTest extends TestCase {
  // Adds Mockery expectations to the PHPUnit assertions count.
  use MockeryPHPUnitIntegration;

  public function setUp(): void {
		parent::setUp();
		Monkey\setUp();
  }
	
  public function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

  public function testShouldInitHooks() {
    $polylangPro = new PolylangPro();

    $polylangPro->module_init([]);

    self::assertNotFalse( has_action('pll_translate_media', [ $polylangPro, 'pll_translate_media' ]) );
  }

  public function testShouldCountHooks() {
    $polylangPro = new PolylangPro();

    Functions\expect('add_action')->times(1);
    Functions\expect('add_filter')->times(0);

    $polylangPro->module_init([]);
  }

  public function testShouldHookToTranslatedMedia() {
    $polylangPro = new PolylangPro();

    $polylangPro->pll_translate_media(10, 10, null);

    self::assertNotFalse( has_filter('wp_stateless_media_synced', 'function ($metadata, $attachment_id, $force, $args)') );
  }
}
