import { TYPES as CommonTypes } from '../Types';

const TYPES = Object.assign( {
	Components: {
		LoginButtonComponentInterface       : Symbol.for( 'LoginButtonComponentInterface' ),
		SliderGalleryComponentInterface     : Symbol.for( 'SliderGalleryComponentInterface' ),
		Token: {
			ItemCardComponentInterface      : Symbol.for( 'TokenItemCardComponentInterface' ),
			ItemCardListComponentInterface  : Symbol.for( 'TokenItemCardListComponentInterface' ),
			BalanceComponentInterface       : Symbol.for( 'TokenBalanceComponentInterface' ),
		},
		Credit: {
			ItemCardComponentInterface      : Symbol.for( 'CreditItemCardComponentInterface' ),
			ItemCardListComponentInterface  : Symbol.for( 'CreditItemCardListComponentInterface' ),
			BalanceComponentInterface       : Symbol.for( 'CreditBalanceComponentInterface' ),
		},
	},
	Providers: {
		ComponentServiceProviderInterface    : Symbol.for( 'ComponentServiceProviderInterface' ),
	},
	Factories: {
		LoginButtonComponentFactoryInterface      : Symbol.for( 'LoginButtonComponentFactoryInterface' ),
		SliderGalleryComponentFactoryInterface    : Symbol.for( 'SliderGalleryComponentFactoryInterface' ),
		Token: {
			ItemCardComponentFactoryInterface     : Symbol.for( 'TokenItemCardComponentFactoryInterface' ),
			ItemCardListComponentFactoryInterface : Symbol.for( 'TokenItemCardListComponentFactoryInterface' ),
			BalanceComponentFactoryInterface      : Symbol.for( 'TokenBalanceComponentFactoryInterface' ),
		},
		Credit: {
			ItemCardComponentFactoryInterface     : Symbol.for( 'CreditItemCardComponentFactoryInterface' ),
			ItemCardListComponentFactoryInterface : Symbol.for( 'CreditItemCardListComponentFactoryInterface' ),
			BalanceComponentFactoryInterface      : Symbol.for( 'CreditBalanceComponentFactoryInterface' ),
		},
	},
}, CommonTypes );

export { TYPES };
