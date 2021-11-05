<?php

use Tokenly\Wp\Repositories\SourceRepository;
use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\TokenpassClient\TokenpassAPIFake;

class SourceTest extends WP_UnitTestCase {
	public static $source_repository;

	public static function setUpBeforeClass(): void {
		$builder = new \DI\ContainerBuilder();
		$builder->addDefinitions( array(
			TokenpassAPIInterface::class => DI\autowire( TokenpassAPIFake::class ),
		) );
		$container = $builder->build();

		self::$source_repository = $container->get( SourceRepository::class );
	}

	public function test_source_show() {
		$source = self::$source_repository->show( 'LcvjKTC0nZ0MP5VQBH8irIfTUvCv2sYoTv' );
		$this->assertIsArray( $source );
	}

	public function test_source_index() {
		$sources = self::$source_repository->index();
		$this->assertIsArray( $sources );
	}


}
