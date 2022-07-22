import 'reflect-metadata'
import { Container, interfaces } from 'inversify'
import { TYPES } from './Types'
import bindCommonDependencies from '../Inversify.config'
import ComponentServiceProvider from './Providers/ComponentServiceProvider'
import LoginButtonComponent from './Components/LoginButtonComponent'
import TokenBalanceComponent from './Components/Token/BalanceComponent'
import TokenItemCardComponent from './Components/Token/ItemCardComponent'
import TokenItemCardListComponent from './Components/Token/ItemCardListComponent'
import CreditBalanceComponent from './Components/Credit/BalanceComponent'
import CreditItemCardComponent from './Components/Credit/ItemCardComponent'
import CreditItemCardListComponent from './Components/Credit/ItemCardListComponent'
// import SliderGalleryComponent from './Components/SliderGalleryComponent'
import ComponentServiceProviderInterface from './Interfaces/Providers/ComponentServiceProviderInterface'
import LoginButtonComponentInterface from './Interfaces/Components/LoginButtonComponentInterface'
import TokenBalanceComponentInterface from './Interfaces/Components/Token/BalanceComponentInterface'
import TokenItemCardComponentInterface from './Interfaces/Components/Token/ItemCardComponentInterface'
import TokenItemCardListComponentInterface from './Interfaces/Components/Token/ItemCardListComponentInterface'
import CreditBalanceComponentInterface from './Interfaces/Components/Credit/BalanceComponentInterface'
import CreditItemCardComponentInterface from './Interfaces/Components/Credit/ItemCardComponentInterface'
import CreditItemCardListComponentInterface from './Interfaces/Components/Credit/ItemCardListComponentInterface'
// import SliderGalleryComponentInterface from './Interfaces/Components/SliderGalleryComponentInterface'

const container = new Container()
bindCommonDependencies( container )
container.bind<ComponentServiceProviderInterface>( TYPES.Providers.ComponentServiceProviderInterface ).to( ComponentServiceProvider )
container.bind<LoginButtonComponentInterface>( TYPES.Components.LoginButtonComponentInterface ).to( LoginButtonComponent )
container.bind<TokenBalanceComponentInterface>( TYPES.Components.Token.BalanceComponentInterface ).to( TokenBalanceComponent )
container.bind<TokenItemCardComponentInterface>( TYPES.Components.Token.ItemCardComponentInterface ).to( TokenItemCardComponent )
container.bind<TokenItemCardListComponentInterface>( TYPES.Components.Token.ItemCardListComponentInterface ).to( TokenItemCardListComponent )
container.bind<CreditBalanceComponentInterface>( TYPES.Components.Credit.BalanceComponentInterface ).to( CreditBalanceComponent )
container.bind<CreditItemCardComponentInterface>( TYPES.Components.Credit.ItemCardComponentInterface ).to( CreditItemCardComponent )
container.bind<CreditItemCardListComponentInterface>( TYPES.Components.Credit.ItemCardListComponentInterface ).to( CreditItemCardListComponent )
// container.bind<SliderGalleryComponentInterface>( TYPES.Components.SliderGalleryComponentInterface ).to( SliderGalleryComponent )

container.bind<interfaces.Factory<LoginButtonComponent>>( TYPES.Factories.LoginButtonComponentFactoryInterface )
		.toAutoFactory<LoginButtonComponent>( TYPES.Components.LoginButtonComponentInterface )
container.bind<interfaces.Factory<TokenBalanceComponent>>( TYPES.Factories.Token.BalanceComponentFactoryInterface )
		.toAutoFactory<TokenBalanceComponent>( TYPES.Components.Token.BalanceComponentInterface )
container.bind<interfaces.Factory<TokenItemCardComponent>>( TYPES.Factories.Token.ItemCardComponentFactoryInterface )
		.toAutoFactory<TokenItemCardComponent>( TYPES.Components.Token.ItemCardComponentInterface )
container.bind<interfaces.Factory<TokenItemCardListComponent>>( TYPES.Factories.Token.ItemCardListComponentFactoryInterface )
		.toAutoFactory<TokenItemCardListComponent>( TYPES.Components.Token.ItemCardListComponentInterface )
container.bind<interfaces.Factory<CreditBalanceComponent>>( TYPES.Factories.Credit.BalanceComponentFactoryInterface )
		.toAutoFactory<CreditBalanceComponent>( TYPES.Components.Credit.BalanceComponentInterface )
container.bind<interfaces.Factory<CreditItemCardComponent>>( TYPES.Factories.Credit.ItemCardComponentFactoryInterface )
		.toAutoFactory<CreditItemCardComponent>( TYPES.Components.Credit.ItemCardComponentInterface )
container.bind<interfaces.Factory<CreditItemCardListComponent>>( TYPES.Factories.Credit.ItemCardListComponentFactoryInterface )
		.toAutoFactory<CreditItemCardListComponent>( TYPES.Components.Credit.ItemCardListComponentInterface )
// container.bind<interfaces.Factory<SliderGalleryComponent>>( TYPES.Factories.SliderGalleryComponentInterface )
// 		.toAutoFactory<SliderGalleryComponent>( TYPES.Components.SliderGalleryComponentInterface )

export { container }
